<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_a_group;
use App\Models\m_a_user;
use App\Models\m_instrument;

class Instrument extends BaseController
{
	protected $instruments;
	protected $menu_ids;
	protected $route_name;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "users";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->instruments = new m_instrument();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Instruments";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('instruments/v_list');
		echo view('v_footer');
	}
	public function get_reference()
	{
	}
	public function saving_add()
	{
	}
	public function add()
	{
		if (isset($_POST['Save'])) {
			print_r($_POST);
			return;
		}
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Instrument Add";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('instruments/v_edit');
		echo view('v_footer');
		echo view('instruments/v_js');
	}
}
