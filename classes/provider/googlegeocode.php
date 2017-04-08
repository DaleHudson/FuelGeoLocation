<?php

namespace FuelGeoLocation;

class GoogleGeoCode
{
	/**
	 * Api url
	 */
	const API_URL = "https://maps.googleapis.com/maps/api/geocode/json?";

	/**
	 * @var string Api key to use within requests
	 */
	protected $api_key;

	/**
	 * @var string Region to filter by with requests
	 */
	protected $region;

	/**
	 * @var array Array of parameters to use within request
	 */
	protected $parameters = array();

	/**
	 * GoogleGeoCode constructor.
	 *
	 * On instantiation get the api key from config and set to the class
	 */
	public function __construct()
	{
		\Config::load('googlegeocode', 'geocode');

		$this->api_key = \Config::get('geocode.api_key');
		$this->region = \Config::get('geocode.region');
	}

	/**
	 * Perform the curl request to retrieve results
	 *
	 * @param array $params
	 *
	 * @return null
	 */
	public function curl_request(array $params)
	{
		$curl = \Request::forge(static::API_URL, 'curl');

		$curl = $this->set_parameters($curl, $params);

		$curl->set_options(array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
		));

		$curl->execute();

		$result = json_decode($curl->response(), true);

		$response = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);
		return $response->handle_response();
	}

	/**
	 * Get the google geocode api key
	 *
	 * @return string
	 */
	protected function get_api_key()
	{
		return $this->api_key;
	}

	/**
	 * Get the region
	 *
	 * @return mixed string or null
	 */
	protected function get_region()
	{
		return $this->region;
	}

	/**
	 * Get the parameters to use within the request
	 *
	 * @return array
	 */
	protected function get_parameters()
	{
		return $this->parameters;
	}

	/**
	 * Set the parameters to use within request
	 *
	 * @param \Request_Curl $curl
	 * @param array $params Dynamic parameters to use within request
	 *
	 * @return \Request_Curl
	 */
	protected function set_parameters(\Request_Curl $curl, array $params)
	{
		foreach ($params as $key => $param) {
			$this->parameters[$key] = $param;
		}

		if ($this->get_region()) {
			$this->parameters['region'] = $this->get_region();
		}

		$this->parameters['key'] = $this->get_api_key();

		$curl->set_params($this->get_parameters());

		return $curl;
	}
}