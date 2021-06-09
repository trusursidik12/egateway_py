<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_measurement_log;
use App\Models\m_parameter;

class Measurement_log extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $parameters;
	protected $measurement_logs;

	public function __construct()
	{
		parent::__construct();
		$this->parameters =  new m_parameter();
		$this->measurement_logs =  new m_measurement_log();
	}

	public function get_measurement_log($parameter_id, $time)
	{
		return @$this->measurement_logs->where("parameter_id", $parameter_id)->where("xtimestamp = '" . $time . "'")->findAll()[0]->value;

		// $measurement_logs = @$this->measurement_logs->where("parameter_id", $parameter_id)->where("xtimestamp <= '" . $time . "'")->orderBy("xtimestamp DESC")->findAll(LOG_AVG_NUM);
		// $avg_value = 0;
		// foreach ($measurement_logs as $measurement_log) {
		// 	$avg_value += $measurement_log->value;
		// }
		// return round($avg_value / count($measurement_logs), DECIMAL_NUM);

		// return round(@$this->measurement_logs->select("avg(value) as avg_value")->where("parameter_id", $parameter_id)->where("xtimestamp <= '" . $time . "'")->orderBy("xtimestamp DESC")->findAll(LOG_AVG_NUM)[0]->avg_value, DECIMAL_NUM);
		// return round(@$this->measurement_logs->select("value as avg_value")->where("parameter_id", $parameter_id)->where("xtimestamp <= '" . $time . "'")->orderBy("xtimestamp DESC")->findAll()[0]->avg_value, DECIMAL_NUM);
	}

	public function get($parameter_id = 0)
	{
		if ($parameter_id > 0) {
			$data = [];
			$measurement_logs = $this->measurement_logs->where("parameter_id", $parameter_id)->orderBy("xtimestamp DESC")->findAll(1)[0];
			$measurement_logs->avg_value = $this->get_measurement_log($measurement_logs->parameter_id, $measurement_logs->xtimestamp);
			array_push($data, $measurement_logs);
			return json_encode($data);
		} else {
			$data = [];
			foreach ($this->parameters->findAll() as $parameter) {
				$measurement_logs = $this->measurement_logs->where("parameter_id", $parameter->id)->orderBy("xtimestamp DESC")->findAll(1)[0];
				$measurement_logs->avg_value = $this->get_measurement_log($measurement_logs->parameter_id, $measurement_logs->xtimestamp);
				array_push($data, $measurement_logs);
			}
			return json_encode($data);
		}
	}

	public function get_by_instrument_id($instrument_id)
	{
		$data = [];
		foreach ($this->parameters->where("instrument_id", $instrument_id)->findAll() as $parameter) {
			array_push($data, $this->measurement_logs->where("parameter_id", $parameter->id)->orderBy("xtimestamp DESC")->findAll(1)[0]);
		}
		return json_encode($data);
	}
}
