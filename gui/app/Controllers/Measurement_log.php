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

	public function get($parameter_id = 0)
	{
		if ($parameter_id > 0)
			return json_encode($this->measurement_logs->where("parameter_id", $parameter_id)->orderBy("xtimestamp DESC")->findAll(1)[0]);
		else {
			$data = [];
			foreach ($this->parameters->findAll() as $parameter) {
				array_push($data, $this->measurement_logs->where("parameter_id", $parameter->id)->orderBy("xtimestamp DESC")->findAll(1)[0]);
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
