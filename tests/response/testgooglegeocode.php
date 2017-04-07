<?php

namespace FuelGeoLocation;

require_once __DIR__ . "/../../../../vendor/fzaninotto/faker/src/autoload.php";
require_once __DIR__ . "/../../response/googlegeocode.php";

class Test_Response_GoogleGeoCode extends \TestCase
{
	/**
	 * @group GeoResponse
	 */
	public function test_successful_handle_response()
	{
		$result = $this->dummy_response("ok");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$response = $handler->handle_response();
		$this->assertInternalType('array', $response);
		$this->assertArrayHasKey('results', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertInternalType('array', $response['results']);
		$this->assertEquals("OK", $response['status']);
	}

	/**
	 * @group GeoResponse
	 *
	 * @expectedException \FuelGeoLocation\Exception\Exceptions_ZeroResults
	 * @expectedExceptionMessage No results found
	 */
	public function test_zero_result_response()
	{
		$result = $this->dummy_response("zero_results");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$handler->handle_response();

	}

	/**
	 * @group GeoResponse
	 *
	 * @expectedException \FuelGeoLocation\Exception\Exceptions_QueryLimit
	 * @expectedExceptionMessage You have reached your query limit
	 */
	public function test_over_query_limit_response()
	{
		$result = $this->dummy_response("over query limit");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$handler->handle_response();
	}

	/**
	 * @group GeoResponse
	 *
	 * @expectedException \FuelGeoLocation\Exception\Exceptions_RequestDenied
	 * @expectedExceptionMessage Request was denied
	 */
	public function test_request_denied_response()
	{
		$result = $this->dummy_response("request denied");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$handler->handle_response();
	}

	/**
	 * @group GeoResponse
	 *
	 * @expectedException \FuelGeoLocation\Exception\Exceptions_InvalidRequest
	 * @expectedExceptionMessage The request was invalid
	 */
	public function test_invalid_request_response()
	{
		$result = $this->dummy_response("invalid request");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$handler->handle_response();
	}

	/**
	 * @group GeoResponse
	 *
	 * @expectedException \FuelGeoLocation\Exception\Exceptions_UnknownError
	 * @expectedExceptionMessage An unknown error has occurred. Try again.
	 */
	public function test_unknown_error_response()
	{
		$result = $this->dummy_response("unknown error");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$handler->handle_response();
	}

	/**
	 * @group GeoResponse
	 *
	 * @expectedException \Exception
	 * @expectedExceptionMessage Unfamiliar status code detected
	 */
	public function test_unfamiliar_response_code()
	{
		$result = $this->dummy_response("blah");
		$handler = new \FuelGeoLocation\Response\Response_GoogleGeoCode($result);

		$handler->handle_response();
	}

	/**
	 * Create a dummy response to use with tests
	 *
	 * @param string $status the response to test eg "OK", "ZERO_RESULTS"
	 *
	 * @return array
	 */
	private function dummy_response($status)
	{
		return array(
			"results" => array(),
			"status" => str_replace(" ", "_", strtoupper($status)),
		);
	}
}