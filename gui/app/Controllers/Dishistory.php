<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_parameter;

class Dishistory extends BaseController
{
	public function __construct(){
		parent::__construct();
		$this->route_name = "dis_history";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->Parameter = new m_parameter();
	}
	public function index()
	{
		$data["__modulename"] = "DIS History Data";
		$data['parameters'] = $this->Parameter->select('id,name,caption')->where('is_view',1)->findAll();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('dis_history/v_list');
		echo view('v_footer');
		echo view('dis_history/v_js');
	}
	public function getList(){
		$baseUrl = "http://localhost:8080";
		$curl = service('curlrequest'); // Curl CI4 Service
		// $baseUrl = "https://sorpimappp01/piwebapi";

		$parameter_id = $this->request->getGet('parameter_id');
		$date_start = $this->request->getGet('date_start');
		$date_end = $this->request->getGet('date_end');
		if(!empty($date_start)){
			$date_start = $date_start."T00:00:00Z";
		}
		if(!empty($date_end)){
			$date_end = $date_end."T00:23:59Z";
		}
		$data = [];
		if(!empty($parameter_id)){
			$parameter = $this->Parameter->select('name, web_id')->find($parameter_id);
			$url = "{$baseUrl}/streams/{$parameter->web_id}/recorded?startTime={$date_start}&endTime={$date_end}&selectedFields=Items.Timestamp;Items.Value";
			$req = $curl->request('get', $url,[
				'headers' => [
					'Accept' => 'application/json'
				],
				'verify' => false
			]);
			$response = json_decode($req->getBody(),1);
			$items = @$response['Items'];
			foreach ($items as $item) {
				$data[] = $item + ['Parameter' => $parameter->name];
			}
		}else{
			$parameters = $this->Parameter->select('name, web_id')->where('is_view',1)->findAll();
			foreach ($parameters as $parameter) {
				$url = "{$baseUrl}/streams/{$parameter->web_id}/recorded?startTime={$date_start}&endTime={$date_end}&selectedFields=Items.Timestamp;Items.Value";
				$req = $curl->request('get', $url,[
					'headers' => [
						'Accept' => 'application/json'
					],
					'verify' => false
				]);
				$response = json_decode($req->getBody(),1);
				$items = @$response['Items'];
				foreach ($items as $item) {
					$data[] = $item + ['Parameter' => $parameter->name];
				}
			}
		}	

		$results = [
			'draw'				=> @$this->request->getGet('draw'),
			'recordsTotal'		=> count($data),
			'recordsFiltered'	=> count($data),
			'data'				=> $data
		];
		return $this->response->setJSON($results);
	}
}
