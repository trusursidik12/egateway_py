<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_instrument;
use App\Models\m_labjack_value;
use App\Models\m_parameter;
use App\Models\m_unit;

class Parameter extends BaseController
{
	protected $parameters;
	protected $instruments;
	protected $units;
	protected $labjack_values;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "parameters";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		// $this->validation = \Config\Services::validation();
		$this->parameters = new m_parameter();
		$this->instruments = new m_instrument();
		$this->units = new m_unit();
		$this->labjack_values = new m_labjack_value();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Parameters";
		$data = $data + $this->common();
		$data['parameters'] = $this->parameters->select('instruments.name as instrument_name,units.name as unit,labjack_values.data as labjack_value,parameters.*')
			->join('labjack_values', 'labjack_values.id=parameters.labjack_value_id')
			->join('instruments', 'instruments.id=parameters.instrument_id')
			->join('units', 'units.id=parameters.unit_id')->findAll();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('parameters/v_list');
		echo view('v_footer');
		echo view('parameters/v_js');
	}
	public function saving_add($id = null)
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
			if (is_null($id)) {
				return redirect()->to(base_url('stack/add'))->withInput();
			}
			return redirect()->to(base_url("stack/edit/{$id}"))->withInput();
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
		$data['__modulename'] = "Add Parameter";
		$data['instruments'] = $this->instruments->select('id,name')->where(['is_deleted' => 0])->findAll();
		$data['units'] = $this->units->select('id,name')->where(['is_deleted' => 0])->findAll();
		$data['labjack_values'] = $this->labjack_values->select('labjacks.labjack_code as code,labjack_values.*')
			->join('labjacks', 'labjacks.id=labjack_values.labjack_id')->findAll();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('parameters/v_edit');
		echo view('v_footer');
		echo view('parameters/v_js');
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
		$data['parameter_ids'] = explode(',', $data['stack']->parameter_ids);
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
