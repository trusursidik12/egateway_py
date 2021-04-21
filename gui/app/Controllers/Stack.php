<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Stack extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		// helper('form');
		$this->route_name = "users";
		$this->menu_ids = $this->get_menu_ids($this->route_name);

		$this->validation = \Config\Services::validation();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Stacks";
		$data['instruments'] = $this->instruments->select('statuses.name as status,instruments.*')
			->join('statuses', 'instruments.status_id = statuses.id')->where(['instruments.is_deleted' => 0])->orderBy('instruments.id DESC')->findAll();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('instruments/v_list');
		echo view('v_footer');
		echo view('instruments/v_js');
	}
}
