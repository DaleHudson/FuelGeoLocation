<?php

namespace FuelGeoLocation;

require_once __DIR__ . '/../fuelgeolocationtestcase.php';
require_once __DIR__ . '/../../classes/provider/googlegeocode.php';

class Test_GoogleGeocode extends FuelGeoLocationTestCase
{
	/**
	 * @group GoogleGeo
	 */
	public function test_successful_request()
	{
		$geocode = new \FuelGeoLocation\GoogleGeoCode();
		$result = $geocode->curl_request(array("address" => "CV21 3BH"));

		$this->assertInternalType('array', $result);
		$this->assertInternalType('string', $result['status']);
		$this->assertInternalType('array', $result['results']);
		$this->assertArrayHasKey('geometry', $result['results'][0]);
		$this->assertArrayHasKey('location', $result['results'][0]['geometry']);
		$this->assertArrayHasKey('lat', $result['results'][0]['geometry']['location']);
		$this->assertArrayHasKey('lng', $result['results'][0]['geometry']['location']);
		$this->assertInternalType('float', $result['results'][0]['geometry']['location']['lat']);
		$this->assertInternalType('float', $result['results'][0]['geometry']['location']['lng']);
	}
}