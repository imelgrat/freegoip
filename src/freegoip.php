<?php
	/**
	 * A PHP wrapper for FreeGoIP reverse geocoding API.
	 *
	 * @package FreeGoIP
	 * @author    Ivan Melgrati
	 * @version   v1.0.0 stable 
	 */

	if (!class_exists('FreeGoIP'))
	{
		/**
		 * A PHP wrapper for FreeGoIP reverse geocoding API.
		 * 
		 * @author    Ivan Melgrati
		 * @copyright Copyright 2016 by Ivan Melgrati
		 * @link      https://github.com/imelgrat/freegoip/blob/master/LICENSE
		 * @link      http://www.freegeoip.net/
		 * @version   v1.0.0 stable 
		 */
		class FreeGoIP
		{
			/**
			 * URL_DOMAIN Domain portion of the freeGoIP API URL.
			 */
			const URL_DOMAIN = "www.freegeoip.net";

			/**
			 * URL_PATH Path portion of the freeGoIP API URL.
			 */
			const URL_PATH = "/";

			/**
			 * HTTP URL of the freeGoIP API.
			 */
			const URL_HTTP = "http://www.freegeoip.net";

			/**
			 * HTTPS URL of the freeGoIP API.
			 */
			const URL_HTTPS = "https://www.freegeoip.net";

			/**
			 * FORMAT_JSON JSON response format.
			 */
			const FORMAT_JSON = "json";

			/**
			 * FORMAT_XML XML response format.
			 */
			const FORMAT_XML = "xml";

			/**
			 * FORMAT_CSV CSV response format.
			 */
			const FORMAT_CSV = "csv";

			/**
			 * Response format (csv,xml,json,jsonp).
			 * 
			 * @access protected
			 * @var string $format
			 */
			protected $format = 'json';

			/**
			 * URL scheme to use (https or http).
			 * 
			 * @access protected
			 * @var string $scheme
			 */
			protected $scheme = 'https';

			/**
			 * IP address to reverse geocode.
			 * 
			 * @access protected
			 * @var string $ipaddress
			 */
			protected $ipaddress = '';

			/**
			 * Domain to reverse geocode.
			 * 
			 * @access protected
			 * @var string $domain
			 */
			protected $domain = '';

			/**
			 * Constructor. The request is not executed until `queryLocation()` is called. 
			 * If neither IP address nor domain is provided, the visitor's IP address is used to reverse geocoding  
			 *
			 * @param  string $ipaddress IP address to reverse geocode. 
			 * @param  string $domain Domain to reverse geocode (ignored if an IP address is provided).
			 * @param  string $format optional response format (default: JSON)
			 * @return FreeGoIP
			 */
			public function __construct($ipaddress = '', $domain = '', $format = self::FORMAT_JSON)
			{
				$this->setIPaddress($ipaddress)->setDomain($domain)->setFormat($format);
			}

			/**
			 * Set the response format to use for reverse geocoding.
			 *
			 * @param  string $format response format
			 * @return FreeGoIP
			 */
			public function setFormat($format)
			{
				$format = strtolower(trim($format));

				if (in_array($format, array(
					self::FORMAT_JSON,
					self::FORMAT_XML,
					self::FORMAT_CSV)))
				{
					$this->format = $format;
				}
				else
				{
					$this->format = self::FORMAT_JSON;
				}

				return $this;
			}

			/**
			 * Get the response format to use for reverse geocoding.
			 *
			 * @return string response format
			 */
			public function getFormat()
			{
				return $this->format;
			}


			/**
			 * Whether the response format is JSON.
			 *
			 * @return bool 
			 */
			public function isFormatJSON()
			{
				return $this->getFormat() == self::FORMAT_JSON;
			}

			/**
			 * Whether the response format is XML.
			 *
			 * @return bool 
			 */
			public function isFormatXML()
			{
				return $this->getFormat() == self::FORMAT_XML;
			}

			/**
			 * Whether the response format is CSV.
			 *
			 * @return bool 
			 */
			public function isFormatCSV()
			{
				return $this->getFormat() == self::FORMAT_CSV;
			}

			/**
			 * Set the IP address to reverse geocode.
			 *
			 * @param  string $ipaddress IP address to reverse geocode
			 * @return FreeGoIP
			 */
			public function setIPAddress($ipaddress)
			{
				if (!filter_var($ipaddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE))
				{
					$this->ipaddress = '';
				}
				else
				{
					$this->ipaddress = filter_var($ipaddress, FILTER_VALIDATE_IP);
				}

				return $this;
			}

			/**
			 * Get the IP address to reverse geocode.
			 *
			 * @return string IP address to reverse geocode
			 */
			public function getIPAddress()
			{
				return $this->ipaddress;
			}

			/**
			 * Set the domain to reverse geocode.
			 *
			 * @param  string $domain Domain to reverse geocode
			 * @return FreeGoIP
			 */
			public function setDomain($domain)
			{
                $parse = parse_url($domain);
                $domain = $parse['host'];
				if (preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $domain))
				{
					$this->domain = $domain;
				}
				else
				{
					$this->domain = '';
				}

				return $this;
			}

			/**
			 * Get the domain to reverse geocode.
			 *
			 * @return string domain to reverse geocode
			 */
			public function getDomain()
			{
				return $this->domain;
			}

			/**
			 * Set the URL scheme to use.
			 *
			 * @param  string $scheme URL scheme to use (https or http)
			 * @return FreeGoIP
			 */
			public function setScheme($scheme)
			{
				$scheme = strtolower(trim($scheme));

				if (in_array($scheme, array('http', 'https')))
				{
					$this->scheme = $scheme;
				}
				else
				{
					$this->scheme = 'https';
				}

				return $this;
			}

			/**
			 * Get the URL scheme to use.
			 *
			 * @return string  URL scheme to use (https or http)
			 */
			public function getScheme()
			{
				return $this->scheme;
			}

			/**
			 * Build the query URL path with all set parameters geocoding request.
			 *
			 * @link   http://www.freegeoip.net
			 * @return string encoded query string of the timezone request
			 */
			protected function getURLPath()
			{
				$urlParameters = array();

				// Get IPAddress to reverse geocode.
				$ipaddress = $this->getIPAddress();

				// Get domain to reverse geocode.
				$domain = $this->getDomain();

				if ($ipaddress == '' && $domain == '')
				{
					$location = $_SERVER["REMOTE_ADDR"];
				}
				elseif ($ipaddress != '')
				{
					$location = $ipaddress;
				}
				else
				{
					$location = $domain;
				}

				$format = $this->getFormat();

				return trim($format . '/' . $location);
			}

			/**
			 * Build the URL (with query string) of the timezone request.
			 *
			 * @link   http://www.freegeoip.net
			 * @return string URL of the timezone request
			 */
			protected function geocodeURL()
			{
				$scheme = $this->getScheme();

				$pathurlParameters = self::URL_PATH . $this->getURLPath();

				return $scheme . "://" . self::URL_DOMAIN . '/' . $pathurlParameters;
			}

			/**
			 * Execute the reverse geocoding request. The return type is based on the requested
			 * format: associative array if JSON or CSV, SimpleXMLElement object if XML.
			 *
			 * @link   http://www.freegeoip.net/
			 * @param  bool $raw whether to return the raw (string) response
			 * @param  resource $context stream context from `stream_context_create()`
			 * @return string|array|SimpleXMLElement response in requested format
			 */
			public function queryReverseGeocoding($raw = false, $context = null)
			{
				$response = file_get_contents($this->geocodeURL(), false, $context);

				if ($raw)
				{
					return $response;
				}
				elseif ($this->isFormatJson())
				{
					return json_decode($response, true);
				}
				elseif ($this->isFormatCSV())
				{
					return explode(',', $response);
				}
				elseif ($this->isFormatXml())
				{
					return new SimpleXMLElement($response);
				}
				else
				{
					return $response;
				}
			}
		}
	}
?>