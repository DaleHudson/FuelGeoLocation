<?php

\Autoloader::add_namespace('FuelGeoLocation', __DIR__ . '/classes/');

\Autoloader::add_classes(array(
	'FuelGeoLocation\\PostcodeIO' => __DIR__ . '/classes/postcodeio.php',
	'FuelGeoLocation\\Distance' => __DIR__ . '/classes/distance.php',
	'FuelGeoLocation\\Model_Location' => __DIR__ . '/classes/model/location.php',
	'FuelGeoLocation\\Interface_GeoLocation_LatLon' => __DIR__ . '/classes/interface/geolocation/latlon.php',
));