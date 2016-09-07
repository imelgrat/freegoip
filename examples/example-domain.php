<?php
	/**
     * This section includes a sample query that demonstrate features of the API.
     * The code below query performs a reverse geocoding request for Github's server
     * 
     * @author Ivan Melgrati
	 * @copyright 2016
	 * @package    FreeGoIP
	 * @author     Ivan Melgrati
	 * @version    v1.0.0 stable 
	 */

	require_once ('../src/freegoip.php');
        
    
    echo '<---------------> Reverse geocode github.com website <--------------->';
    echo '<br /><br /><br />';
    
	// Initialize FreeGoIP object
	$geocoding_object = new FreeGoIP('','http://github.com/test?test=3',FreeGoIP::FORMAT_JSON);
    
    // Perform query using JSON response format (returns an associative array if $raw parameter is set to false)
	$geocoding_data = $geocoding_object->queryReverseGeocoding(false);
    
    echo '--------------- JSON query -> Associative array ---------------';
	echo '<pre>';
	print_r($geocoding_data);
	echo '</pre>';
    
    // Perform query using JSON response format (returns raw JSON string)
	$geocoding_data = $geocoding_object->queryReverseGeocoding(true);
    
    echo '--------------- JSON query -> raw content output ---------------';
	echo '<pre>';
	print_r($geocoding_data);
	echo '</pre>';    
    
    // Perform query using XML response format
    $geocoding_object->setFormat(FreeGoIP::FORMAT_XML);
	$geocoding_data = $geocoding_object->queryReverseGeocoding(true);
    
    echo '--------------- XML query -> raw content output ---------------';
    echo '<pre>';
	print(htmlspecialchars($geocoding_data));
	echo '</pre>';    
?>