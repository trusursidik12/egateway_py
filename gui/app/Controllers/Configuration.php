<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_configuration;

class Configuration extends BaseController
{
	protected $configurations;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "parameters";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->configurations = new m_configuration();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Parameters";
		$data = $data + $this->common();
		$data['configurations'] = $this->configurations->where(['is_deleted' => 0])->findAll();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('configurations/v_list');
		echo view('v_footer');
		echo view('configurations/v_js');
	}
	public function saving_add($id = null)
	{
		if (!$this->validate([
			'egateway_code' => ['rules' => 'required', 'errors' => ['required' => 'eGateway Code cant be empty!']],
			'customer_name' => ['rules' => 'required', 'errors' => ['required' => 'Customer Name cant be empty!']],
			'address' => ['rules' => 'required', 'errors' => ['required' => 'Address cant be empty!']],
			'city' => ['rules' => 'required', 'errors' => ['required' => 'City cant be empty!']],
			'province' => ['rules' => 'required', 'errors' => ['required' => 'Province Mass cant be empty!']],
			'lon' => ['rules' => 'required', 'errors' => ['required' => 'Longitude cant be empty!']],
			'lat' => ['rules' => 'required', 'errors' => ['required' => 'Latitude cant be empty!']],
			'interval_request' => ['rules' => 'required', 'errors' => ['required' => 'Interval Request cant be empty!']],
			'interval_sending' => ['rules' => 'required', 'errors' => ['required' => 'Interval Sending cant be empty!']],
			'interval_retry' => ['rules' => 'required', 'errors' => ['required' => 'Interval Retry cant be empty!']],
			'interval_average' => ['rules' => 'required', 'errors' => ['required' => 'Interval Average cant be empty!']],
			'delay_sending' => ['rules' => 'required', 'errors' => ['required' => 'Delay Sending cant be empty!']],
		])) {
			if (is_null($id)) {
				return redirect()->to(base_url('configuration/add'))->withInput();
			}
			return redirect()->to(base_url("configuration/edit/{$id}"))->withInput();
		}
		try {
			$data['egateway_code'] = $this->request->getPost('egateway_code');
			$data['customer_name'] = $this->request->getPost('customer_name');
			$data['address'] = $this->request->getPost('address');
			$data['city'] = $this->request->getPost('city');
			$data['province'] = $this->request->getPost('province');
			$data['lon'] = $this->request->getPost('lon');
			$data['lat'] = $this->request->getPost('lat');
			$data['interval_request'] = $this->request->getPost('interval_request');
			$data['interval_sending'] = $this->request->getPost('interval_sending');
			$data['interval_retry'] = $this->request->getPost('interval_retry');
			$data['interval_average'] = $this->request->getPost('interval_average');
			$data['delay_sending'] = $this->request->getPost('delay_sending');
			try {
				if (is_null($id)) {
					$this->configurations->insert($data + $this->created_values());
					session()->setFlashdata("flash_message", ["success", "Success insert data configuration"]);
				} else {
					$this->configurations->update($id, $data + $this->updated_values());
					session()->setFlashdata("flash_message", ["success", "Success update data configuration"]);
					return redirect()->to(base_url("configuration/edit/{$id}"));
				}
				return redirect()->to(base_url('configurations'));
			} catch (Exception $e) {
				session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
				if (is_null($id)) {
					return redirect()->to(base_url('configuration/add'))->withInput();
				}
				return redirect()->to(base_url("configuration/edit/{$id}"))->withInput();
			}
		} catch (Exception $e) {
			session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
			if (is_null($id)) {
				return redirect()->to(base_url('configuration/add'))->withInput();
			}
			return redirect()->to(base_url("configuration/edit/{$id}"))->withInput();
		}
	}
	public function add()
	{
		if (isset($_POST['Save'])) {
			return $this->saving_add();
		}
		$this->privilege_check($this->menu_ids);
		$data['validation']    = \Config\Services::validation();
		$data['__modulename'] = "Add Configuration";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('configurations/v_edit');
		echo view('v_footer');
		echo view('configurations/v_js');
	}
	public function edit($id)
	{
		$this->privilege_check($this->menu_ids);
		if (isset($_POST['Save'])) {
			return $this->saving_add($id);
		}
		$data['validation']    = \Config\Services::validation();
		$data['__modulename'] = "Edit Configuration";
		$data['configuration'] = $this->configurations->find($id);
		$data = $data + $this->common();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('configurations/v_edit');
		echo view('v_footer');
		echo view('configurations/v_js');
	}
	public function delete()
	{
		if (isset($_POST['Delete'])) {
			try {
				$this->configurations->update($this->request->getPost('id'), ['is_deleted' => 1] + $this->deleted_values());
			} catch (Exception $e) {
				session()->setFlashdata('flash_message', ['error', 'Error: ' . $e->getMessage()]);
				return redirect()->to('/configurations');
			}
			session()->setFlashdata('flash_message', ['success', 'Delete configuration succcesfully!']);
			return redirect()->to('/configurations');
		}
		session()->setFlashdata('flash_message', ['error', 'Something when wrong!']);
		return redirect()->to('/configurations');
	}
}
