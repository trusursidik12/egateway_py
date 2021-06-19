<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_das_log;
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
		$this->das_logs = new m_das_log();
	}
	public function index($id = 1)
	{
		$param_id = $this->request->getGet("parameter");
		if (!empty($param_id) && !$this->validate([
			'parameter' => 'integer'
		], [
			'parameter' => ['integer' => 'Error!']
		])) {
			return redirect()->back()->with("flash_message", ['error', 'Error!']);
		}
		$data["parameter"] = $this->parameters->find($param_id);
		$data["stacks"] = $this->stacks->where(["is_deleted" => 0])->findAll();
		$data["_stack"] = $this->stacks->find($id);
		$data["parameters"] = $this->parameters->where(["stack_id" => $id])->findAll();
		$data["id"] = $id;
		$data["__modulename"] = "Graphic";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('graphic/v_list');
		echo view('v_footer');
		echo view('graphic/v_js');
	}
	/**
	 * API DIS Data
	 *
	 * @param [int] $stack_id
	 * @return void
	 */
	public function api($stack_id, $param_id = null)
	{
		try {
			$date_start = $this->request->getPost('date_start');
			$date_end = $this->request->getPost('date_end');
			if ($param_id == null) {
				$parameters[0] = $this->parameters->where(['stack_id' => $stack_id])->get()->getFirstRow();
			} else {
				$parameters = $this->parameters->where(['id' => $param_id, 'stack_id' => $stack_id])->findAll();
			}
			$data = array();
			$where = "1=1";
			if (empty($date_start) && empty($date_end)) {
				$date = date('Y-m-d');
				$where .= " AND DATE_FORMAT(time_group,'%Y-%m-%d') >= '$date'";
			} else {
				if (!empty($date_start)) {
					$where .= " AND DATE_FORMAT(time_group,'%Y-%m-%d') >= '$date_start'";
				}
				if (!empty($date_end)) {
					$where .= " AND DATE_FORMAT(time_group,'%Y-%m-%d') <= '$date_end'";
				}
			}

			foreach ($parameters as $key => $param) {
				$disLogs = $this->measurements
					->select("id,time_group,value,value_correction")
					->where($where)
					->where(['parameter_id' => $param->id])
					->orderBy('time_group', 'asc')->findAll();
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
	// public function api($stack_id)
	// {
	// 	try {
	// 		$date_start = $this->request->getPost('date_start');
	// 		$date_end = $this->request->getPost('date_end');
	// 		$parameters = $this->parameters->where(['stack_id' => $stack_id])->findAll();
	// 		$data = array();
	// 		$where = "1=1";
	// 		if (!empty($date_start)) {
	// 			$where .= " AND DATE_FORMAT(time_group,'%Y-%m-%d') >= '$date_start'";
	// 		}
	// 		if (!empty($date_end)) {
	// 			$where .= " AND DATE_FORMAT(time_group,'%Y-%m-%d') <= '$date_end'";
	// 		}
	// 		foreach ($parameters as $key => $param) {
	// 			$disLogs = $this->measurements
	// 				->select("id,time_group,value,value_correction")
	// 				->where($where)
	// 				->where(['parameter_id' => $param->id])
	// 				->orderBy('id', 'desc')->findAll();
	// 			if (!count($disLogs) > 0) {
	// 				continue;
	// 			}
	// 			$data[$key]['data'] = $disLogs;
	// 			$data[$key]['label'] = $param->name;
	// 			if (empty($data[$key]['data'])) unset($data[$key]['data']);
	// 			if (empty($data[$key]['label'])) unset($data[$key]['label']);
	// 		}
	// 		return $this->response->setJson(['success' => true, 'data' => $data]);
	// 	} catch (Exception $e) {
	// 		return $this->response->setJson(['success' => false, 'message' => $e->getMessage()]);
	// 	}
	// }
}
