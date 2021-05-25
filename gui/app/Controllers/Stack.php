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
		$data['stacks'] = $this->stacks->where(['is_deleted' => 0])->findAll();
		foreach ($this->parameters->findAll() as $parameter) {
			@$parameters[$parameter->stack_id] .= $parameter->name . ", ";
		}
		$data['parameters'] = @$parameters;
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('stacks/v_list');
		echo view('v_footer');
		echo view('stacks/v_js');
	}
	public function saving_add($id = null)
	{
		if (!$this->validate([
			'code' => ['rules' => 'required', 'errors' => ['required' => 'Stack code cant be empty!']],
			'height' => ['rules' => 'required', 'errors' => ['required' => 'Height cant be empty!']],
			'diameter' => ['rules' => 'required', 'errors' => ['required' => 'Diameter cant be empty!']],
			'flow' => ['rules' => 'required', 'errors' => ['required' => 'Flow cant be empty!']],
			'lon' => ['rules' => 'required', 'errors' => ['required' => 'Longitude cant be empty!']],
			'lat' => ['rules' => 'required', 'errors' => ['required' => 'Latitude cant be empty!']],
		])) {
			if (is_null($id)) {
				return redirect()->to(base_url('stack/add'))->withInput();
			}
			return redirect()->to(base_url("stack/edit/{$id}"))->withInput();
		}
		try {
			$data['code'] = $this->request->getPost('code');
			$data['height'] = $this->request->getPost('height');
			$data['diameter'] = $this->request->getPost('diameter');
			$data['flow'] = $this->request->getPost('flow');
			$data['lon'] = $this->request->getPost('lon');
			$data['lat'] = $this->request->getPost('lat');
			$data['oxygen_reference'] = $this->request->getPost('oxygen_reference');
			try {
				if (is_null($id)) {
					$this->stacks->insert($data + $this->created_values());
					session()->setFlashdata("flash_message", ["success", "Success insert data stack"]);
				} else {
					$this->stacks->update($id, $data + $this->updated_values());
					session()->setFlashdata("flash_message", ["success", "Success update data stack"]);
				}
				return redirect()->to(base_url('stacks'));
			} catch (Exception $e) {
				session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
				if (is_null($id)) {
					return redirect()->to(base_url('stack/add'))->withInput();
				}
				return redirect()->to(base_url("stack/edit/{$id}"))->withInput();
			}
		} catch (Exception $e) {
			session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
			if (is_null($id)) {
				return redirect()->to(base_url('stack/add'))->withInput();
			}
			return redirect()->to(base_url("stack/edit/{$id}"))->withInput();
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
	public function edit($id)
	{
		$this->privilege_check($this->menu_ids);
		if (isset($_POST['Save'])) {
			return $this->saving_add($id);
		}
		$data['validation']    = \Config\Services::validation();
		$data['__modulename'] = "Edit Stack";
		$data['parameters'] = $this->parameters->select('id,name')->findAll();
		$data['stack'] = $this->stacks->where(['is_deleted' => 0])->find($id);
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('stacks/v_edit');
		echo view('v_footer');
		echo view('stacks/v_js');
	}
	public function delete()
	{
		if (isset($_POST['Delete'])) {
			try {
				$this->stacks->update($this->request->getPost('id'), ['is_deleted' => 1] + $this->deleted_values());
			} catch (Exception $e) {
				session()->setFlashdata('flash_message', ['error', 'Error: ' . $e->getMessage()]);
				return redirect()->to('/stacks');
			}
			session()->setFlashdata('flash_message', ['success', 'Delete stack succcesfully!']);
			return redirect()->to('/stacks');
		}
		session()->setFlashdata('flash_message', ['error', 'Something when wrong!']);
		return redirect()->to('/stacks');
	}
}
