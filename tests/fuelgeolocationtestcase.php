<?php

namespace FuelGeoLocation;

require_once __DIR__ . '/../../../vendor/fzaninotto/faker/src/autoload.php';

use Fuel\Core\TestCase;

abstract class FuelGeoLocationTestCase extends TestCase
{
	/**
	 * @var string
	 */
	protected $postcode = "B77 1JR";

	/**
	 * @var string
	 */
	protected $invalid_postcode = "CV215 6GHT";

	/**
	 * @var object
	 */
	protected $faker;

	public function setUp()
	{
		parent::setUp();

		\Migrate::latest('FuelGeoLocation', 'package');

		\DBUtil::truncate_table('location');

		// Set up faker
		$this->faker = \Faker\Factory::create("en_GB");
	}

	public function tearDown()
	{
		parent::tearDown();

		unset($this->faker);
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
		$data->longitude = -1.447619;
		$data->latitude = 52.526225;
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