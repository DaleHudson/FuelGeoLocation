<?php

namespace FuelGeoLocation;

class Model_GeoCode extends \Orm\Model implements Interface_GeoLocation_LatLon
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
	 * @param object $location_data
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function save_location($location_data)
	{
		foreach ($location_data as $key => $value) {
			call_user_func(array($this, 'set_' . $key), $value);
		}

		return $this->save();
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