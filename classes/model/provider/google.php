<?php

namespace FuelGeoLocation;

class Model_Provider_Google extends Model_GeoCode
{
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

	/**
	 * Save the retrieved location data
	 *
	 * @param array $geocode_data
	 * @param string $search_term The search term to save
	 *
	 * @return bool
	 *
	 * @throws \Exception
	 */
	public function save_geocode_data(array $geocode_data, $search_term)
	{
		$this->set_search_term($search_term);
		$this->set_latitude($geocode_data[0]['geometry']['location']['lat']);
		$this->set_longitude($geocode_data[0]['geometry']['location']['lng']);
		$this->set_search_result($geocode_data);
		$this->set_provider("Google");

		return $this->save();
	}
}