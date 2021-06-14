<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_measurement;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use App\Models\m_stack;
use Exception;

class Graphic extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "graphic";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->stacks = new m_stack();
		$this->parameters = new m_parameter();
		$this->measurements = new m_measurement();
	}
	public function index($id = 1)
	{
		$data['stacks'] = $this->stacks->where(['is_deleted' => 0])->findAll();
		$data["id"] = $id;
		$data["__modulename"] = "Graphic";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('graphic/v_list');
		echo view('v_footer');
		echo view('graphic/v_js');
	}
	public function api($stack_id)
	{
		/*
		- Check parameter ada berapa
		- Query per parameter 
		- Munculin
		*/
		try {
			$parameters = $this->parameters->where(['stack_id' => $stack_id])->findAll();
			$data = array();
			foreach ($parameters as $key => $param) {
				$disLogs = $this->measurements
					->select("id,time_group,value,value_correction")
					->where(['parameter_id' => $param->id])
					->orderBy('id', 'desc')->findAll();
				if (!count($disLogs) > 0) {
					continue;
				}
				$data[$key]['data'] = $disLogs;
				$data[$key]['label'] = $param->name;
				if (empty($data[$key]['data'])) unset($data[$key]['data']);
				if (empty($data[$key]['label'])) unset($data[$key]['label']);
			}
			return $this->response->setJson(['success' => true, 'data' => $data]);
		} catch (Exception $e) {
			return $this->response->setJson(['success' => false, 'message' => $e->getMessage()]);
		}
	}
}
