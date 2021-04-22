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

	public function get($labjack_id, $ain_id)
	{
		return @$this->labjack_values->where(["labjack_id" => $labjack_id, "ain_id" => $ain_id])->findAll()[0]->data;
	}

	public function get_labjack_id_ain_id($id)
	{
		return json_encode($this->labjack_values->where(["id" => $id])->findAll()[0]);
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
