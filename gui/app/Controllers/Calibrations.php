<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_calibration;
use App\Models\m_instrument;
use App\Models\m_parameter;
use App\Models\m_stack;

class Calibration extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $instruments;
	protected $stacks;
	protected $parameters;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "calibrations";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->calibrations = new m_calibration();
		$this->instruments = new m_instrument();
		$this->stacks = new m_stack();
		$this->parameters = new m_parameter();

		$this->validation = \Config\Services::validation();
	}

	public function index()
	{
		// $this->privilege_check($this->menu_ids);
		// $data["__modulename"] = "Calibration";
		// $data = $data + $this->common();
		// echo view('v_header', $data);
		// echo view('v_menu');
		// echo view('calibrations/v_list');
		// echo view('v_footer');
		// echo view('calibrations/v_js');
	}
}
