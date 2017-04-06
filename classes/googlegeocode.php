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
	 * GoogleGeoCode constructor.
	 *
	 * On instantiation get the api key from config and set to the class
	 */
	public function __construct()
	{
		\Config::load('googlegeocode', 'geocode');

		$this->api_key = \Config::get('geocode.api_key');
	}

	public function curl_request(array $params)
	{
		$curl = \Request::forge(static::API_URL, 'curl');

		$params['key'] = $this->get_api_key();

		$curl->set_params($params);

		$curl->set_options(array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
		));

		$curl->execute();

		$result = json_decode($curl->response(), true);

		if ($result['status'] !== "OK") {
			throw new \Exception("Bad result");
		}

		return $result;
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
}