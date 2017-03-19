<?php

namespace FuelGeoLocation;

require_once __DIR__ . '/../fuelgeolocationtestcase.php';
require_once __DIR__ . '/../../classes/postcodeio.php';

class Test_PostcodeIO extends FuelGeoLocationTestCase
{
	/**
	 * @group Postcode
	 */
	public function test_successful_postcode_lookup()
	{
		$postcodeIO = new PostcodeIO();
		$result = $postcodeIO->lookup($this->postcode);

		$this->assertInstanceOf('stdClass', $result);
		$this->assertInternalType('object', $result);
		$this->assertObjectHasAttribute('result', $result);
		$this->assertEquals(200, $result->status);

		// Assertions for result->result object
		$this->assertObjectHasAttribute('postcode', $result->result);
		$this->assertObjectHasAttribute('longitude', $result->result);
		$this->assertObjectHasAttribute('latitude', $result->result);
	}

	/**
	 * @group Postcode
	 */
	public function test_successful_postcode_valid_lookup()
	{
		$postcodeIO = new PostcodeIO();
		$result = $postcodeIO->valid_lookup($this->postcode);

		$this->assertInstanceOf('stdClass', $result);
		$this->assertInternalType('object', $result);
		$this->assertObjectHasAttribute('result', $result);
		$this->assertEquals(200, $result->status);
		$this->assertTrue($result->result);
	}

	/**
	 * @group Postcode
	 *
	 * @expectedException RequestStatusException
	 */
	public function test_unsuccessful_postcode_lookup()
	{
		$postcodeIO = new PostcodeIO();
		$postcodeIO->lookup($this->invalid_postcode);
	}

	/**
	 * @group Postcode
	 */
	public function test_unsuccessful_postcode_valid_lookup()
	{
		$postcodeIO = new PostcodeIO();
		$result = $postcodeIO->valid_lookup($this->invalid_postcode);

		$this->assertInstanceOf('stdClass', $result);
		$this->assertInternalType('object', $result);
		$this->assertObjectHasAttribute('result', $result);
		$this->assertEquals(200, $result->status);
		$this->assertFalse($result->result);
	}
}