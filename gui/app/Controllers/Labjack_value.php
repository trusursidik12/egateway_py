<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_labjack_value;

class Labjack_value extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $labjack_values;

	public function __construct()
	{
		parent::__construct();
		$this->labjack_values =  new m_labjack_value();
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
}
