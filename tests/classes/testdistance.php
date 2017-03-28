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

		// Insert location model
		$location_model = new Model_Location();
		$location_model->save_location($this->create_location_data());

		$this->location_model = \Mockery::mock('\FuelGeoLocation\Model_Location');
		$this->location_model->shouldReceive('get_latitude')
			->andReturn(52.526225)
			->shouldReceive('get_longitude')
			->andReturn(-1.447619)
			->shouldReceive('save_location')
			->andReturn($this->create_location_data());
	}

	public function tearDown()
	{
		parent::tearDown();

		\Mockery::close();
	}

	/**
	 * @group Distance
	 */
	public function test_calculate_distance()
	{
		$distance = new Distance("miles", "25", $this->location_model);
		$query = $distance->calculate_distance("location", array('id'));

		$result = $query->execute()->as_array();

		$this->assertInternalType("array", $result);
		$this->assertInternalType("array", $result[0]);
		$this->assertArrayHasKey("latitude", $result[0]);
		$this->assertArrayHasKey("longitude", $result[0]);
		$this->assertArrayHasKey("distance", $result[0]);
		$this->assertEquals(0.0018335559961407198, $result[0]['distance']);
	}
}