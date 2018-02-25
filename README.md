FreeGoIP
==================

[![GitHub license](https://img.shields.io/github/license/imelgrat/freegoip.svg?style=flat-square)](https://github.com/imelgrat/freegoip/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/imelgrat/freegoip.svg?style=flat-square)](https://github.com/imelgrat/freegoip/releases)
[![Total Downloads](https://poser.pugx.org/imelgrat/freegoip/downloads)](https://packagist.org/packages/imelgrat/freegoip)
[![GitHub issues](https://img.shields.io/github/issues/imelgrat/freegoip.svg?style=flat-square)](https://github.com/imelgrat/freegoip/issues)
[![GitHub stars](https://img.shields.io/github/stars/imelgrat/freegoip.svg?style=flat-square)](https://github.com/imelgrat/freegoip/stargazers)

FreeGoIP - A PHP wrapper for FreeGoIP reverse geolocation API.

freegeoip.net is a service providing a public HTTP API for software developers to search the geolocation of IP addresses. 
It uses a database of IP addresses associated to cities along with other relevant information such as time zone, latitude and longitude.

The freegeoip web server is free and open source but the public service limit up to 10,000 queries per hour by default. Once this limit is reached, all requests from the IP will result in HTTP 403, forbidden, until the quota is cleared.

Developed by [Ivan Melgrati](https://twitter.com/imelgrat) 

Requirements
------------

*   PHP >= 5.3.0

Installation
------------

### Composer

The recommended installation method is through
[Composer](http://getcomposer.org/), a dependency manager for PHP. Just add
`imelgrat/freegoip` to your project's `composer.json` file:

```json
{
    "require": {
        "imelgrat/freegoip": "*"
    }
}
```

[More details](http://packagist.org/packages/imelgrat/freegoip) can
be found over at [Packagist](http://packagist.org).

### Manually

1.  Copy `src/freegoip.php` to your codebase, perhaps to the `vendor`
    directory.
2.  Add the `freegoip` class to your autoloader or `require` the file
    directly.

Feedback
--------

Please open an issue to request a feature or submit a bug report. Or even if
you just want to provide some feedback, I'd love to hear. I'm also available on
Twitter as [@imelgrat](https://twitter.com/imelgrat).

Contributing
------------

1.  Fork it.
2.  Create your feature branch (`git checkout -b my-new-feature`).
3.  Commit your changes (`git commit -am 'Added some feature'`).
4.  Push to the branch (`git push origin my-new-feature`).
5.  Create a new Pull Request.
