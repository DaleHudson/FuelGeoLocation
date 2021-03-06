<?php

namespace FuelGeoLocation;

/**
 * Class Distance
 *
 * Class calculates distances from selected points within a bounding circle
 *
 * @package FuelGeoLocation
 *
 * @author Dale Hudson dalehudson26@gmail.com
 *
 * @see http://www.movable-type.co.uk/scripts/latlong-db.html Documentation for bounding box query
 */
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

	/**
	 * @param string $metric_value
	 * @param string $distance
	 * @param Interface_GeoLocation_LatLon $interface
	 */
	public function __construct($metric_value, $distance, Interface_GeoLocation_LatLon $interface)
	{
		if ($metric_value == "miles") {
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
	protected function get_max_latitude()
	{
		return $this->get_latitude() + rad2deg($this->get_distance()/$this->get_earth_radius());
	}

	/**
	 * @return mixed
	 */
	protected function get_min_latitude()
	{
		return $this->get_latitude() - rad2deg($this->get_distance()/$this->get_earth_radius());
	}

	/**
	 * @return mixed
	 */
	protected function get_max_longitude()
	{
		return $this->get_longitude() + rad2deg(asin($this->get_distance()/$this->get_earth_radius()) / cos(deg2rad($this->get_latitude())));
	}

	/**
	 * @return mixed
	 */
	protected function get_min_longitude()
	{
		return $this->get_longitude() - rad2deg(asin($this->get_distance()/$this->get_earth_radius()) / cos(deg2rad($this->get_latitude())));
	}

	/**
	 * Calculate whether two circles from lat/lon intersect or not
	 * 
	 * @param  string $table
	 * @param  array  $columns
	 * @return mixed
	 */
	public function calculate_distance_intersect($table, $distance_column, $columns = array())
	{
		$this->check_for_lat_lon_columns($columns);

		$columns[] = [\DB::expr($this->distance_algorithm_sql()), 'distance'];

		return \DB::select_array($columns)
			->from($table)
			->having('distance', '<=', \DB::expr("({$this->get_distance()} + {$distance_column})"));
	}

	/**
	 * Calculate distance radius of a given longitude and latitude
	 *
	 * @param string $table
	 * @param array $columns;
	 *
	 * @return mixed
	 */
	public function calculate_distance($table, $columns = array())
	{
		$this->check_for_lat_lon_columns($columns);

		$sub_query = \DB::select_array($columns)
			->from($table)
			->where('latitude', 'between', [$this->get_min_latitude(), $this->get_max_latitude()])
			->where('longitude', 'between', [$this->get_min_longitude(), $this->get_max_longitude()]);

		$distance_algorithm_sql = \DB::expr($this->distance_algorithm_sql());

		$columns[] = [$distance_algorithm_sql, 'distance'];

		return \DB::select_array($columns)
			->from([$sub_query, "FirstCut"])
			->where($distance_algorithm_sql, '<', $this->get_distance());
	}

	/**
	 * Check that columns array has latitude and longitude columns, if not add them to array
	 *
	 * @param array $columns
	 */
	protected function check_for_lat_lon_columns(&$columns = array())
	{
		if ( ! $columns) {
			$columns[] = "*";
			return;
		}

		if (is_string($columns) && $columns == "*") {
			$columns = ["*"];
			return;
		}

		if ( ! in_array('latitude', $columns)) {
			$columns[] = 'latitude';
		}

		if ( ! in_array('longitude', $columns)) {
			$columns[] = 'longitude';
		}
	}

	/**
	 * Algorithm that calculates distance
	 *
	 * @return mixed
	 */
	protected function distance_algorithm_sql()
	{
		$sql = "ROUND(acos(sin(:lat)*sin(radians(latitude)) + cos(:lat)*cos(radians(latitude))*cos(radians(longitude)-:lon)) * :R, 2)";
		return \DB::query($sql)->parameters([
			"lat" => deg2rad($this->get_latitude()),
			"lon" => deg2rad($this->get_longitude()),
			"R" => $this->get_earth_radius()
		])->compile();
	}
}