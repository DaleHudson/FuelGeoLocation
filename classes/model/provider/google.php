<?php

namespace FuelGeoLocation;

class Model_Provider_Google extends Model_GeoCode
{
	public function save_geocode_data($geocode_data, $search_term)
	{
		$this->set_search_term($search_term);
		$this->set_latitude($geocode_data[0]['geometry']['location']['lat']);
		$this->set_longitude($geocode_data[0]['geometry']['location']['lng']);
		$this->set_search_result($geocode_data);
		$this->set_provider("Google");

		return $this->save();
	}

	/**
	 * Set the search results
	 *
	 * json encode the results for storing in DB
	 *
	 * @param array $results
	 */
	public function set_search_result(array $results)
	{
		$this->search_result = json_encode($results);
	}
}