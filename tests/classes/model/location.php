<?php

namespace FuelGeoLocation;

require_once __DIR__ . '/../../fuelgeolocationtestcase.php';

class Test_Model_Location extends FuelGeoLocationTestCase
{
	/**
	 * @var \Orm\Model
	 */
	protected $model;

	public function setUp()
	{
		parent::setUp();

		$this->model = new Model_Location();
	}

	public function tearDown()
	{
		parent::tearDown();

		unset($this->model);
	}

	/**
	 * @group Postcode
	 * @group PostcodeModel
	 */
	public function test_save_location()
	{
		$result = $this->model->save_location($this->create_location_data());

		$this->assertTrue($result);
	}

	/**
	 * @group Postcode
	 * @group PostcodeModel
	 *
	 * @expectedException Database_Exception
	 */
	public function test_unsuccessful_save_location()
	{
		$data = $this->create_location_data();
		unset($data->postcode);

		$this->model->save_location($data);
	}
}

