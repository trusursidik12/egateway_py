<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_condition;
use App\Models\m_instrument;
use App\Models\m_measurement;
use App\Models\m_parameter;
use App\Models\m_status;
use App\Models\m_unit;
use App\Models\m_validation;

class Measurement extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $measurements;
	protected $instruments;
	protected $statuses;
	protected $parameters;
	protected $units;
	protected $validations;
	protected $conditions;

	public function __construct()
	{
		parent::__construct();
		$this->route_name = "dis_data";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->measurements = new m_measurement();
		$this->instruments = new m_instrument();
		$this->statuses = new m_status();
		$this->parameters = new m_parameter();
		$this->units = new m_unit();
		$this->validations = new m_validation();
		$this->conditions = new m_condition();
	}

	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data =
			[
				'instruments' 			=> $this->instruments->where("is_deleted", 0)->findAll(),
				'instrument_statuses' 	=> $this->statuses->where("is_deleted", 0)->findAll(),
				'data_statuses' 		=> $this->statuses->where("is_deleted", 0)->findAll(),
			];
		$data["__modulename"] = "DIS Data";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('measurements/v_list');
		echo view('v_footer');
		echo view('measurements/v_js');
	}

	public function getList()
	{
		$instrument_id 			= @$this->request->getPost('instrument_id');
		$instrument_status_id 	= @$this->request->getPost('instrument_status_id');
		$data_status_id 		= @$this->request->getPost('data_status_id');
		$is_sent_cloud 			= @$this->request->getPost('is_sent_cloud');
		$is_sent_klhk 			= @$this->request->getPost('is_sent_klhk');
		$date_start 			= @$this->request->getPost('date_start');
		$date_end 			= @$this->request->getPost('date_end');
		$length = @$this->request->getPost('length') ? (int) $this->request->getPost('length') : -1;
		$start = @$this->request->getPost('start') ? (int) $this->request->getPost('start') : 0;
		$where					= "is_deleted = '0'";
		if ($instrument_id != '') $where .= "AND instrument_id = '{$instrument_id}'";
		if ($instrument_status_id != '') $where .= "AND instrument_status_id = '{$instrument_status_id}'";
		if ($data_status_id != '') $where .= "AND data_status_id = '{$data_status_id}'";
		if ($is_sent_cloud != '') $where .= "AND is_sent_cloud = '{$is_sent_cloud}'";
		if ($is_sent_klhk != '') $where .= "AND is_sent_klhk = '{$is_sent_klhk}'";
		if ($date_start != '') $where .= "AND DATE_FORMAT(measured_at, '%Y-%m-%d') >= '{$date_start}'";
		if ($date_end != '') $where .= "AND DATE_FORMAT(measured_at, '%Y-%m-%d') <= '{$date_end}'";
		$measurements		= [];
		$numrow				= $this->measurements->where($where)->countAllResults();
		if ($length == -1) {
			$measurementlist	= $this->measurements->where($where)->orderBy("id", "DESC")->findALL();
		} else {
			$measurementlist	= $this->measurements->where($where)->orderBy("id", "DESC")->findALL($length, $start);
		}
		$no = @$this->request->getPost('start');
		foreach ($measurementlist as $key => $mlist) {
			$instrument 		= @$this->instruments->where('id', $mlist->instrument_id)->findAll()[0];
			$instrument_status 	= @$this->statuses->where("id", $mlist->instrument_status_id)->findAll()[0];
			$data_status	 	= @$this->statuses->where("id", $mlist->data_status_id)->findAll()[0];
			$parameter	 		= @$this->parameters->where("id", $mlist->parameter_id)->findAll()[0];
			$unit	 			= @$this->units->where("id", $mlist->unit_id)->findAll()[0];
			$validation	 		= @$this->validations->where("id", $mlist->validation_id)->findAll()[0];
			$conditionn	 		= @$this->conditions->where("id", $mlist->condition_id)->findAll()[0];
			$no++;
			$measurements[$key] = [
				$no,
				@$instrument->name,
				// @$instrument_status->name,
				// @$data_status->name,
				date('d-m-Y H:i', strtotime($mlist->time_group)),
				$mlist->value,
				$mlist->value_correction,
				@$parameter->name,
				@$unit->name,
				// @$validation->name,
				// @$conditionn->name,
				$mlist->is_sent_cloud == 1 ? '<span class="mx-1 badge badge-success">SENT</span>' : '<span class="mx-1 badge badge-danger">NOT YET</span>',
				// $mlist->is_sent_klhk == 1 ? '<span class="mx-1 badge badge-success">SENT</span>' : '<span class="mx-1 badge badge-danger">NOT YET</span>',
			];
		}

		$results = [
			'draw'				=> @$this->request->getPost('draw'),
			'recordsTotal'		=> $numrow,
			'recordsFiltered'	=> $numrow,
			'data'				=> $measurements
		];
		echo json_encode($results);
	}
}
