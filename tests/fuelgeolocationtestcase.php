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
}