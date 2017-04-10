<?php

\Autoloader::add_namespace('FuelGeoLocation', __DIR__ . '/classes/');

\Autoloader::add_classes(array(
	/*
	 * Classes
	 */
	'FuelGeoLocation\\Distance' => __DIR__ . '/classes/distance.php',

	/*
	 * Providers
	 */
	'FuelGeoLocation\\Provider\\PostcodeIO' => __DIR__ . '/classes/provider/postcodeio.php',
	'FuelGeoLocation\\Provider\\GoogleGeoCode' => __DIR__ . '/classes/provider/googlegeocode.php',

	/*
	 * Models
	 */
	'FuelGeoLocation\\Model_GeoCode' => __DIR__ . '/classes/model/geocode.php',
	'FuelGeoLocation\\Model_Provider_Google' => __DIR__ . '/classes/model/provider/google.php',

	/*
	 * Interfaces
	 */
	'FuelGeoLocation\\Interface_GeoLocation_LatLon' => __DIR__ . '/classes/interface/geolocation/latlon.php',

	/*
	 * Response Classes
	 */
	'FuelGeoLocation\\Response\\Response_GoogleGeoCode' => __DIR__ . '/response/googlegeocode.php',

	/*
	 * Exceptions
	 */
	'FuelGeoLocation\\Exception\\Exceptions_InvalidRequest' => __DIR__ . '/exceptions/invalidrequest.php',
	'FuelGeoLocation\\Exception\\Exceptions_QueryLimit' => __DIR__ . '/exceptions/querylimit.php',
	'FuelGeoLocation\\Exception\\Exceptions_RequestDenied' => __DIR__ . '/exceptions/requestdenied.php',
	'FuelGeoLocation\\Exception\\Exceptions_UnknownError' => __DIR__ . '/exceptions/unknownerror.php',
	'FuelGeoLocation\\Exception\\Exceptions_ZeroResults' => __DIR__ . '/exceptions/zeroresults.php',
));