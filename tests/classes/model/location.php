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

	/**
	 * Build up a dummy location model that will replicate a successful response from
	 * postcodes.io api
	 *
	 * @return \stdClass
	 */
	protected function create_location_data()
	{
		$county = $this->faker->county;
		$city = $this->faker->city;
		
		$data = new \stdClass();
		$data->postcode = $this->faker->postcode;
		$data->quality = 1;
		$data->eastings = $this->faker->randomNumber(6);
		$data->northings = $this->faker->randomNumber(6);
		$data->country = $this->faker->country;
		$data->nhs_ha = $county;
		$data->longitude = $this->faker->longitude;
		$data->latitude = $this->faker->latitude;
		$data->parliamentary_constituency = $city;
		$data->european_electoral_region = $county;
		$data->primary_care_trust = $county;
		$data->region = $county;
		$data->lsoa = $this->faker->word;
		$data->msoa = $this->faker->word;
		$data->incode = "3BH";
		$data->outcode = "CV21";
		$data->admin_district = $city;
		$data->parish = $city . ', Unparished Area';
		$data->admin_county = $county;
		$data->admin_ward = $this->faker->word;
		$data->ccg = $city;
		$data->nuts = $county;
		$data->codes = new \stdClass();
		$data->codes->admin_district = $this->faker->word;
		$data->codes->admin_county = $this->faker->word;
		$data->codes->admin_ward = $this->faker->word;
		$data->codes->parish = $this->faker->word;
		$data->codes->ccg = $this->faker->word;
		$data->codes->nuts = $this->faker->word;

		return $data;
	}
}

