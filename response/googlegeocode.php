<?php

namespace FuelGeoLocation\Response;

class Response_GoogleGeoCode
{
	/**
	 * @var array The geocode result that has already been decoded and turned into array
	 */
	protected $result;

	/**
	 * Response_GoogleGeoCode constructor.
	 *
	 * @param array $result
	 */
	public function __construct($result)
	{
		$this->result = $result;
	}

	/**
	 * Determine how to handle the response from the resulting data
	 *
	 * @return array|null
	 *
	 * @throws \Exception
	 * @throws \FuelGeoLocation\Exception\Exceptions_InvalidRequest
	 * @throws \FuelGeoLocation\Exception\Exceptions_QueryLimit
	 * @throws \FuelGeoLocation\Exception\Exceptions_RequestDenied
	 * @throws \FuelGeoLocation\Exception\Exceptions_UnknownError
	 * @throws \FuelGeoLocation\Exception\Exceptions_ZeroResults
	 */
	public function handle_response()
	{
		$result = null;

		switch ($this->result['status']) {
			case "OK":
				$result = $this->result;
				break;
			case "ZERO_RESULTS":
				throw new \FuelGeoLocation\Exception\Exceptions_ZeroResults("No results found");
				break;
			case "OVER_QUERY_LIMIT":
				throw new \FuelGeoLocation\Exception\Exceptions_QueryLimit("You have reached your query limit");
				break;
			case "REQUEST_DENIED":
				throw new \FuelGeoLocation\Exception\Exceptions_RequestDenied("Request was denied");
				break;
			case "INVALID_REQUEST":
				throw new \FuelGeoLocation\Exception\Exceptions_InvalidRequest("The request was invalid");
				break;
			case "UNKNOWN_ERROR":
				throw new \FuelGeoLocation\Exception\Exceptions_UnknownError("An unknown error has occurred. Try again.");
				break;
			default:
				throw new \Exception("Unfamiliar status code detected");
		}

		return $result;
	}
}