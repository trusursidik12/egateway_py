<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_sispek;
use Exception;

class Sispek extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "sispek";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->sispeks = new m_sispek();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Sispeks";
		$data['sispeks'] = $this->sispeks->findAll();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('sispek/v_index');
		echo view('v_footer');
		echo view('sispek/v_js');
	}
	public function edit($id)
	{
		try {
			$this->privilege_check($this->menu_ids);
			$data["__modulename"] = "Edit Sispek";
			$data['sispek'] = $this->sispeks->find($id);
			if (empty($data['sispek'])) {
				return redirect()->to(base_url("sispeks"));
			}
			$data = $data + $this->common();
			echo view('v_header', $data);
			echo view('v_menu');
			echo view('sispek/v_edit');
			echo view('v_footer');
			echo view('sispek/v_js');
		} catch (Exception $e) {
		}
	}
	public function update($id)
	{
		$this->privilege_check($this->menu_ids);
		try {
			$data = $this->getData();
			if ($this->sispeks->update($id, $data)) {
				$response['success'] = true;
				$response['message'] = 'Sispek configuration was updated!';
				return $this->response->setJSON($response);
			}
			return $this->response->setJSON(['success' => false, 'message' => 'Something when wrong!']);
		} catch (Exception $e) {
			return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
		}
	}
	/**
	 * getData from REST Client POST 
	 *
	 * @return array
	 */
	public function getData()
	{
		try {
			$data['server']  = $this->request->getPost('server');
			$data['app_id']  = $this->request->getPost('app_id');
			$data['app_secret']  = $this->request->getPost('app_secret');
			$data['api_get_token']  = $this->request->getPost('api_get_token');
			$data['api_get_kode_cerobong']  = $this->request->getPost('api_get_kode_cerobong');
			$data['api_get_parameter']  = $this->request->getPost('api_get_parameter');
			$data['api_post_data']  = $this->request->getPost('api_post_data');
			$data['api_response_kode_cerobong']  = $this->request->getPost('api_response_kode_cerobong');
			$data['api_response_parameter']  = $this->request->getPost('api_response_parameter');
			$data['token']  = $this->request->getPost('token');
			$data['token_expired']  = $this->request->getPost('token_expired');
			return $data;
		} catch (Exception $e) {
			return array();
		}
	}
}
