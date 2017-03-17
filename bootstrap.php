<?php

\Autoloader::add_namespace('FuelGeoLocation', __DIR__ . '/classes/');

\Autoloader::add_classes(array(
	'FuelGeoLocation\\PostcodeIO' => __DIR__ . '/classes/postcodeio.php',
	'FuelGeoLocation\\Model_Location' => __DIR__ . '/classes/model/location.php',
));