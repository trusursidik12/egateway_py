<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_condition;
use App\Models\m_instrument;
use App\Models\m_das_log;
use App\Models\m_parameter;
use App\Models\m_status;
use App\Models\m_unit;
use App\Models\m_validation;
use App\Models\m_das_data;

class Das_log extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $das_logs;
	protected $instruments;
	protected $statuses;
	protected $parameters;
	protected $units;
	protected $validations;
	protected $conditions;

	public function __construct()
	{
		parent::__construct();
		$this->route_name = "das_logs";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->das_logs = new m_das_log();
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
		$data["__modulename"] = "Das logs";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('das_logs/v_list');
		echo view('v_footer');
		echo view('das_logs/v_js');
	}

	public function getList($type="dis")
	{
		$Model = $type == "dis" ? new m_das_log() : new m_das_data();
		$instrument_id 			= @$this->request->getPost('instrument_id');
		$instrument_status_id 	= @$this->request->getPost('instrument_status_id');
		$data_status_id 		= @$this->request->getPost('data_status_id');
		$date_start 			= @$this->request->getPost('date_start');
		$date_end 			= @$this->request->getPost('date_end');
		$length = @$this->request->getPost('length') ? (int) $this->request->getPost('length') : -1;
		$start = @$this->request->getPost('start') ? (int) $this->request->getPost('start') : 0;
		$where					= "1=1 ";
		if ($instrument_id != '') $where .= "AND instrument_id = '{$instrument_id}'";
		if ($instrument_status_id != '') $where .= "AND instrument_status_id = '{$instrument_status_id}'";
		if ($data_status_id != '') $where .= "AND data_status_id = '{$data_status_id}'";
		if ($date_start != '') $where .= "AND DATE_FORMAT(measured_at, '%Y-%m-%d') >= '{$date_start}'";
		if ($date_end != '') $where .= "AND DATE_FORMAT(measured_at, '%Y-%m-%d') <= '{$date_end}'";
		$das_logs		= [];
		$numrow				= $Model->where($where)->countAllResults();
		if ($length == -1) {
			$das_loglist	= $Model->where($where)->orderBy("id", "DESC")->findALL();
		} else {
			$das_loglist	= $Model->where($where)->orderBy("id", "DESC")->findALL($length, $start);
		}
		$no = @$this->request->getPost('start');
		foreach ($das_loglist as $key => $mlist) {
			$instrument 		= @$this->instruments->where('id', $mlist->instrument_id)->first();
			// $instrument_status 	= @$this->statuses->where("id", $mlist->instrument_status_id)->first();
			$data_status	 	= @$this->statuses->where("id", $mlist->data_status_id)->first();
			$parameter	 		= @$this->parameters->where("id", $mlist->parameter_id)->first();
			$unit	 			= @$this->units->where("id", $mlist->unit_id)->first();
			// $validation	 		= @$this->validations->where("id", $mlist->validation_id)->first();
			// $conditionn	 		= @$this->conditions->where("id", $mlist->condition_id)->first();
			$no++;
			$das_logs[$key] = [
				$no,
				@$instrument->name,
				// @$instrument_status->name,
				@$data_status->name,
				date('d-m-Y H:i', strtotime($mlist->time_group)),
				$mlist->value,
				$mlist->value_correction,
				@$parameter->name,
				@$unit->name,
				// (@$mlist->is_sent_cloud == 1 ? '<span class="badge badge-success">SENT</span>' : '<span class="badge badge-danger">NOT YET</span>'),
				(@$mlist->is_sent_sispek == 1 ? '<span class="badge badge-success">SENT</span>' : '<span class="badge badge-danger">NOT YET</span>'),
				// @$validation->name,
				// @$conditionn->name,
			];
		}

		$results = [
			'draw'				=> @$this->request->getPost('draw'),
			'recordsTotal'		=> $numrow,
			'recordsFiltered'	=> $numrow,
			'data'				=> $das_logs
		];
		return $this->response->setJSON($results);
	}

	public function get_last_das_logs(){
		$last = $this->das_logs->select('date_format(time_group,"%Y-%m-%d") as last_time')->orderBy('time_group','desc')->first();
		$strtimeLastWeek = strtotime('-1 week');
		$lastWeek = date('Y-m-d',$strtimeLastWeek);
		return $this->response->setJSON([
			'success'=>true,
			'last_time' => $last->last_time,
			'last_week' => $lastWeek,
		]);
	}
}
