<?php

namespace FuelGeoLocation;

abstract class Model_GeoCode extends \Orm\Model implements Interface_GeoLocation_LatLon
{
	protected static $_table_name = "geocode";

	protected static $_properties = array(
		'id' => array(
			'data_type' => 'int',
			'form' => array(
				'type' => false,
			),
		),
		'search_term' => array(
			'data_type' => 'text',
		),
		'longitude' => array(
			'data_type' => 'decimal',
		),
		'latitude' => array(
			'data_type' => 'decimal',
		),
		'search_result' => array(
			'data_type' => 'text',
		),
		'provider' => array(
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
	 * Find a model by search term, if it does not exist create model
	 *
	 * @param string $search_term
	 *
	 * @return static
	 *
	 * @throws \Exception
	 */
	public static function find_or_forge_by_search_term($search_term)
	{
		$model = static::find_by_search_term($search_term);

		if ( ! $model) {
			$google = new \FuelGeoLocation\Provider\GoogleGeoCode();
			$results = $google->curl_request(array("address" => $search_term));

			$model = static::forge();

			if ( ! $model->save_geocode_data($results['results'], $search_term)) {
				throw new \Exception("Could not save geocode data");
			}
		}

		return $model;
	}

	###################################
	# INSTANCE
	###################################

	/**
	 * Save the retrieved location data
	 *
	 * @param object|array $geocode_data
	 * @param string $search_term The search term to save
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	abstract public function save_geocode_data($geocode_data, $search_term);

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