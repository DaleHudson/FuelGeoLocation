<?php

namespace FuelGeoLocation\Response;

class Response_GoogleGeoCode
{
	protected $result;

	public function __construct($result)
	{
		$this->result = $result;
	}

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
				throw new \Exception("Unfamiliar status detected");
		}

		// If no result at this point throw exception, because there should be results
		if ( ! $result) {
			throw new \Exception("No results set to result variable");
		}

		return $result;
	}
}