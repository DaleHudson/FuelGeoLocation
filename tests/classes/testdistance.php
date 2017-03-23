<?php

namespace FuelGeoLocation;

require_once __DIR__ . '/../fuelgeolocationtestcase.php';

class Test_Distance extends FuelGeoLocationTestCase
{
	/**
	 * @var Model_Location
	 */
	protected $location_model;

	public function setUp()
	{
		parent::setUp();

		$this->set_location_model();
	}

	public function tearDown()
	{
		parent::tearDown();

		unset($this->location_model);
	}

	/**
	 * @group Distance
	 */
	public function test_calculate_distance()
	{
		$distance = new Distance("miles", "25", $this->location_model);
		$result = $distance->calculate_distance("location", array('id'));

		$this->assertInternalType("array", $result);
		$this->assertInternalType("array", $result[0]);
		$this->assertArrayHasKey("latitude", $result[0]);
		$this->assertArrayHasKey("longitude", $result[0]);
		$this->assertArrayHasKey("distance", $result[0]);
	}

	/**
	 * Create a new location model and set data to it
	 */
	protected function set_location_model()
	{
		$location_model = new Model_Location();
		$location_model->save_location($this->create_location_data());

		$this->location_model = $location_model;
	}
}