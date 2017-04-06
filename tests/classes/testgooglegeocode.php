<?php

namespace FuelGeoLocation;

require_once __DIR__ . '/../fuelgeolocationtestcase.php';
require_once __DIR__ . '/../../classes/googlegeocode.php';

class Test_GoogleGeocode extends FuelGeoLocationTestCase
{
	/**
	 * @group Geo
	 * @group Google
	 */
	public function test_retrieving_api_key()
	{
		$geocode = new GoogleGeoCode();

		$key = $geocode->get_api_key();

		$this->assertInternalType('string', $key);
	}
}