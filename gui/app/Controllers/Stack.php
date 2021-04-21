<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_parameter;
use App\Models\m_stack;
use Exception;

class Stack extends BaseController
{
	protected $parameters;
	protected $stacks;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "stacks";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		// $this->validation = \Config\Services::validation();
		$this->parameters = new m_parameter();
		$this->stacks = new m_stack();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Stacks";
		$data = $data + $this->common();
		$data['stacks'] = $this->stacks->where(['is_deleted'=>0])->findAll();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('stacks/v_list');
		echo view('v_footer');
		echo view('stacks/v_js');
	}
	public function saving_add()
	{
		if (!$this->validate([
			'code' => ['rules' => 'required', 'errors' => ['required' => 'Stack code cant be empty!']],
			'parameter_id' => ['rules' => 'required', 'errors' => ['required' => 'Parameter cant be empty!']],
			'height' => ['rules' => 'required', 'errors' => ['required' => 'Height cant be empty!']],
			'diameter' => ['rules' => 'required', 'errors' => ['required' => 'Diameter cant be empty!']],
			'flow' => ['rules' => 'required', 'errors' => ['required' => 'Flow cant be empty!']],
			'lon' => ['rules' => 'required', 'errors' => ['required' => 'Longitude cant be empty!']],
			'lat' => ['rules' => 'required', 'errors' => ['required' => 'Latitude cant be empty!']],
		])) {
			return redirect()->to(base_url('stack/add'))->withInput();
		}
		try {
			$data['code'] = $this->request->getPost('code');
			$data['parameter_id'] = $this->request->getPost('parameter_id');
			$data['height'] = $this->request->getPost('height');
			$data['diameter'] = $this->request->getPost('diameter');
			$data['flow'] = $this->request->getPost('flow');
			$data['lon'] = $this->request->getPost('lon');
			$data['lat'] = $this->request->getPost('lat');
			foreach ($data['parameter_id'] as $param) {
				@$data['parameter_ids'] .= "{$param},";
			}
			$data['parameter_ids'] = rtrim($data['parameter_ids'], ','); /* Remove , in last param */
			unset($data['parameter_id']);
			try {
				$this->stacks->insert($data + $this->created_values());
				session()->setFlashdata("flash_message", ["success", "Success insert data stack"]);
				return redirect()->to(base_url('stacks'));
			} catch (Exception $e) {
				session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
				return redirect()->to(base_url('stack/add'))->withInput();
			}
		} catch (Exception $e) {
			session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
			return redirect()->to(base_url('stack/add'))->withInput();
		}
	}
	public function add()
	{
		if (isset($_POST['Save'])) {
			return $this->saving_add();
		}
		$this->privilege_check($this->menu_ids);
		$data['validation']    = \Config\Services::validation();
		$data['__modulename'] = "Add Stack";
		$data['parameters'] = $this->parameters->select('id,name')->findAll();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('stacks/v_edit');
		echo view('v_footer');
		echo view('stacks/v_js');
	}
	public function get_parameter($stack_id)
	{
		$data = [];
		try {
			$data = [];
			$instrument = $this->stacks->find($stack_id);
			$parameter_id = explode(',', $instrument->parameter_ids);
			foreach ($parameter_id as $key => $id) {
				$data[$key] = $this->parameters->select('name')->find($id);
			}
		} catch (Exception $e) {
		}
		return json_encode($data, JSON_PRETTY_PRINT);
	}
}
