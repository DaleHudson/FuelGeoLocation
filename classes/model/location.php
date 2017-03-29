<?php

namespace FuelGeoLocation;

class Model_Location extends \Orm\Model implements Interface_GeoLocation_LatLon
{
	protected static $_table_name = "location";

	protected static $_properties = array(
		'id' => array(
			'data_type' => 'int',
			'form' => array(
				'type' => false,
			),
		),
		'postcode' => array(
			'data_type' => 'varchar',
		),
		'quality' => array(
			'data_type' => 'int',
		),
		'eastings' => array(
			'data_type' => 'varchar',
		),
		'northings' => array(
			'data_type' => 'varchar',
		),
		'country' => array(
			'data_type' => 'varchar',
		),
		'nhs_ha' => array(
			'data_type' => 'varchar',
		),
		'longitude' => array(
			'data_type' => 'decimal',
		),
		'latitude' => array(
			'data_type' => 'decimal',
		),
		'parliamentary_constituency' => array(
			'data_type' => 'varchar',
		),
		'european_electoral_region' => array(
			'data_type' => 'varchar',
		),
		'primary_care_trust' => array(
			'data_type' => 'varchar',
		),
		'region' => array(
			'data_type' => 'varchar',
		),
		'lsoa' => array(
			'data_type' => 'varchar',
 		),
		'msoa' => array(
			'data_type' => 'varchar',
		),
		'incode' => array(
			'data_type' => 'varchar',
		),
		'outcode' => array(
			'data_type' => 'varchar',
		),
		'admin_district' => array(
			'data_type' => 'varchar',
		),
		'parish' => array(
			'data_type' => 'varchar',
		),
		'admin_county' => array(
			'data_type' => 'varchar',
		),
		'admin_ward' => array(
			'data_type' => 'varchar',
		),
		'ccg' => array(
			'data_type' => 'varchar',
		),
		'nuts' => array(
			'data_type' => 'varchar',
		),
		'code_admin_district' => array(
			'data_type' => 'varchar',
		),
		'code_admin_county' => array(
			'data_type' => 'varchar',
		),
		'code_admin_ward' => array(
			'data_type' => 'varchar',
		),
		'code_parish' => array(
			'data_type' => 'varchar',
		),
		'code_ccg' => array(
			'data_type' => 'varchar',
		),
		'code_nuts' => array(
			'data_type' => 'varchar',
		),
		'created_at' => array(
			'data_type' => 'int',
			'form' => array(
				'type' => false,
			),
		),
		'updated_at' => array(
			'data_type' => 'int',
			'form' => array(
				'type' => false,
			),
		),
	);

	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_Typing' => array(
			'events' => array('before_save', 'after_save', 'after_load'),
		),
	);

	/**
	 * If cannot find a location model with given postcode, create one.
	 *
	 * @param $postcode
	 *
	 * @return \FuelGeoLocation\Model_Location|static
	 */
	public static function find_or_forge_from_postcode(string $postcode)
	{
		if ( ! $location_model = \FuelGeoLocation\Model_Location::find_by_postcode($postcode)) {
			$location_model = \FuelGeoLocation\Model_Location::forge();

			$postcodeIO = new \FuelGeoLocation\PostcodeIO();
			$result = $postcodeIO->lookup($postcode);

			$location_model->save_location($result->result);
		}

		return $location_model;
	}

	/**
	 * Normalise postcodes by removing the space and uppercasing them
	 *
	 * @param $postcode
	 *
	 * @return mixed
	 */
	public static function normalise_postcode(string $postcode)
	{
		return str_replace(' ', '', strtoupper($postcode));
	}

	/**
	 * Find location record by postcode
	 *
	 * @param $postcode
	 *
	 * @return Model_Location
	 */
	public static function find_by_postcode(string $postcode)
	{
		return static::query()
			->where('postcode', static::normalise_postcode($postcode))
			->get_one();
	}

	/**
	 * Get the latitude longitude values from postcodes
	 *
	 * @param $postcode
	 *
	 * @return mixed
	 */
	public static function get_lat_lon_by_postcode(string $postcode)
	{
		return \DB::select('latitude', 'longitude')
			->from(static::table())
			->where('postcode', '=', static::normalise_postcode($postcode))
			->limit(1)
			->execute()
			->current();
	}

	###################################
	# INSTANCE
	###################################

	/**
	 * Save the retrieved location data
	 *
	 * @param object $location_data
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function save_location($location_data)
	{
		foreach ($location_data as $key => $value) {

			if ($key == "codes") {
				$this->set_codes($value);
			}

			call_user_func(array($this, 'set_' . $key), $value);
		}

		return $this->save();

	}

	/**
	 * Set the codes data to the model
	 *
	 * Foreach through the code data, and set the values to the model. All code fields have been
	 * prefixed with "code".
	 *
	 * @param $code_data
	 *
	 * @return void
	 */
	private function set_codes($code_data)
	{
		foreach ($code_data as $key => $data) {
			call_user_func(array($this, 'set_code_' . $key), $data);
		}
	}

	/**
	 * When setting postcode, use normalise postcode
	 *
	 * @param $postcode
	 */
	public function set_postcode($postcode)
	{
		$this->postcode = static::normalise_postcode($postcode);
	}

	/**
	 * Get the latitude value
	 *
	 * @return mixed
	 */
	public function get_latitude()
	{
		return $this->latitude;
	}

	/**
	 * Get the longitude value
	 *
	 * @return mixed
	 */
	public function get_longitude()
	{
		return $this->longitude;
	}
}