<?php

namespace FuelGeoLocation;

class Model_Provider_PostcodeIO extends Model_GeoCode
{
	/**
	 * Find the model by search term, if it doesn't exist - create it
	 *
	 * @param string $search_term
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function find_or_forge_by_search_term(string $search_term)
	{
		$model = static::find_by_search_term($search_term);

		if ( ! $model) {
			$postcodeIO = new \FuelGeoLocation\Provider\PostcodeIO;
			$result = $postcodeIO->lookup($search_term);

			$model = static::forge();

			if ( ! $model->save_geocode_data($result['result'], $search_term)) {
				throw new \Exception("Could not save geocode data");
			}
		}

		return $model;
	}

	/**
	 * Save the retrieved location data
	 *
	 * @param array $geocode_data
	 * @param string $search_term The search term (postcode) to save
	 *
	 * @return bool
	 */
	public function save_geocode_data(array $geocode_data, $search_term)
	{
		$this->set_search_term($search_term);
		$this->set_latitude($geocode_data['latitude']);
		$this->set_longitude($geocode_data['longitude']);
		$this->set_search_result($geocode_data);
		$this->set_provider("postcodeIO");

		return $this->save();
	}
}