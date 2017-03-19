<?php

namespace FuelGeoLocation;

class Distance
{
	/**
	 * @var int Earths radius in either miles or kilometres
	 */
	protected $earth_radius;

	/**
	 * @var int distance The distance radius to search
	 */
	protected $distance;

	/**
	 * @var Interface_GeoLocation_LatLon
	 */
	protected $interface;

	public function __construct($earth_radius, $distance, Interface_GeoLocation_LatLon $interface)
	{
		if ($earth_radius == "miles") {
			$this->earth_radius = 3959;
		} else {
			$this->earth_radius = 6371;
		}

		$this->distance = (int) $distance;
		$this->interface = $interface;
	}

	/**
	 * @return Interface_GeoLocation_LatLon
	 */
	protected function get_interface()
	{
		return $this->interface;
	}

	/**
	 * @return int
	 */
	protected function get_earth_radius()
	{
		return $this->earth_radius;
	}

	/**
	 * @return int
	 */
	protected function get_distance()
	{
		return $this->distance;
	}

	/**
	 * @return mixed
	 */
	protected function get_latitude()
	{
		return $this->get_interface()->get_latitude();
	}

	/**
	 * @return mixed
	 */
	protected function get_longitude()
	{
		return $this->get_interface()->get_longitude();
	}

	/**
	 * @return mixed
	 */
	private function get_max_latitude()
	{
		return $this->get_latitude() + rad2deg($this->get_distance()/$this->get_earth_radius());
	}

	/**
	 * @return mixed
	 */
	private function get_min_latitude()
	{
		return $this->get_latitude() - rad2deg($this->get_distance()/$this->get_earth_radius());
	}

	/**
	 * @return mixed
	 */
	private function get_max_longitude()
	{
		return $this->get_longitude() + rad2deg(asin($this->get_distance()/$this->get_earth_radius()) / cos(deg2rad($this->get_latitude())));
	}

	/**
	 * @return mixed
	 */
	private function get_min_longitude()
	{
		return $this->get_longitude() - rad2deg(asin($this->get_distance()/$this->get_earth_radius()) / cos(deg2rad($this->get_latitude())));
	}

	/**
	 * Calculate distance radius of a given longitude and latitude
	 *
	 * @return mixed
	 */
	public function calculate_distance()
	{
		$query = "Select id, postcode, latitude, longitude,
                   acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R As D
            From (
                Select id, postcode, latitude, longitude
                From location
                Where latitude Between :minLat And :maxLat
                  And longitude Between :minLon And :maxLon
            ) As FirstCut
            Where acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R < :rad
            Order by D";

		$parameters = array(
			"lat" => deg2rad($this->get_latitude()),
			"lon" => deg2rad($this->get_longitude()),
			"minLat" => $this->get_min_latitude(),
			"minLon" => $this->get_min_longitude(),
			"maxLat" => $this->get_max_latitude(),
			"maxLon" => $this->get_max_longitude(),
			"rad" => $this->get_distance(),
			"R" => $this->get_earth_radius(),
		);

		return \DB::query($query)->parameters($parameters)->execute();
	}
}