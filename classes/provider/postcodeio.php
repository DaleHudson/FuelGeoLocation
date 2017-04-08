<?php

namespace FuelGeoLocation;

class PostcodeIO
{
	/**
	 * @var string Main api url to connect to
	 */
	const API_URL = "https://api.postcodes.io";

	/**
	 * @var string The postcode enpoint
	 */
	const API_POSTCODE_ENDPOINT = "/postcodes";

	/**
	 * Curl request
	 *
	 * @param string $url The url endpoint to connect to
	 *
	 * @return mixed
	 */
	protected function curl_request($url)
	{
		$curl = \Request::forge($url, 'curl');

		$curl->set_options(array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CONNECTTIMEOUT => 10,
		));

		$curl->execute();

		$result = $curl->response();

		return json_decode($result);
	}

	/**
	 * Normal postcode lookup
	 *
	 * @param string $postcode
	 *
	 * @return mixed
	 */
	public function lookup($postcode)
	{
		$url = static::API_URL . static::API_POSTCODE_ENDPOINT . "/" . $postcode;

		return $this->curl_request($url);
	}

	/**
	 * Validate postcode
	 *
	 * @param string $postcode
	 * 
	 * @return mixed
	 */
	public function valid_lookup($postcode)
	{
		$url = static::API_URL . static::API_POSTCODE_ENDPOINT . "/" . $postcode . "/validate";

		return $this->curl_request($url);
	}
}