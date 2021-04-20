<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_labjack_value;
use App\Models\m_measurement_log;

class Labjack_value extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $labjack_values;
	protected $measurement_logs;

	public function __construct()
	{
		parent::__construct();
		$this->labjack_values =  new m_labjack_value();
		$this->measurement_logs =  new m_measurement_log();
	}

	public function index()
	{
	}

	public function get()
	{
		$return = [];
		foreach ($this->labjack_values->findAll() as $labjack_value) {
			$return["labjack_" . $labjack_value->labjack_id . "_AIN" . $labjack_value->ain_id] = $labjack_value->data;
		}
		echo json_encode($return);
	}

	public function get_measurement_logs()
	{
	}
}
