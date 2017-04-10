<?php

namespace FuelGeoLocation;

abstract class Model_GeoCode extends \Orm\Model
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