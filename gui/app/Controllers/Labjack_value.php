<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_labjack_value;
use App\Models\m_measurement_log;
use App\Models\m_parameter;

class Labjack_value extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $parameters;
	protected $labjack_values;
	protected $measurement_logs;

	public function __construct()
	{
		parent::__construct();
		$this->parameters =  new m_parameter();
		$this->labjack_values =  new m_labjack_value();
		$this->measurement_logs =  new m_measurement_log();
	}

	public function get()
	{
		$return = [];
		foreach ($this->labjack_values->findAll() as $labjack_value) {
			$return["labjack_" . $labjack_value->labjack_id . "_AIN" . $labjack_value->ain_id] = $labjack_value->data;
		}
		echo json_encode($return);
	}

	public function formula_measurement_logs()
	{
		foreach ($this->labjack_values->findAll() as $labjack_value) {
			$labjack[$labjack_value->labjack_id][$labjack_value->ain_id] = $labjack_value->data;
		}

		foreach ($this->parameters->findAll() as $parameter) {
			@eval("\$data[$parameter->id] = $parameter->formula;");
			$measurement_logs = [
				"instrument_id" => $parameter->instrument_id,
				"parameter_id" => $parameter->id,
				"value" => $data[$parameter->id],
				"unit_id" => $parameter->unit_id,
				"is_averaged" => 0
			];
			$this->measurement_logs->save($measurement_logs);
		}

		echo json_encode($data);
	}
}
