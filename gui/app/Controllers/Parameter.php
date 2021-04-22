<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_instrument;
use App\Models\m_labjack_value;
use App\Models\m_parameter;
use App\Models\m_unit;
use Exception;

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
			'instrument_id' => ['rules' => 'required', 'errors' => ['required' => 'Instrument cant be empty!']],
			'name' => ['rules' => 'required', 'errors' => ['required' => 'Name cant be empty!']],
			'caption' => ['rules' => 'required', 'errors' => ['required' => 'Caption cant be empty!']],
			'unit_id' => ['rules' => 'required', 'errors' => ['required' => 'Unit cant be empty!']],
			'molecular_mass' => ['rules' => 'required', 'errors' => ['required' => 'Molecular Mass cant be empty!']],
			'formula' => ['rules' => 'required', 'errors' => ['required' => 'Formula cant be empty!']],
			'is_view' => ['rules' => 'required', 'errors' => ['required' => 'View cant be empty!']],
			'is_graph' => ['rules' => 'required', 'errors' => ['required' => 'Graph cant be empty!']],
			'labjack_value_id' => ['rules' => 'required', 'errors' => ['required' => 'Labjack Value cant be empty!']],
			'voltage1' => ['rules' => 'required', 'errors' => ['required' => 'Voltage 1 cant be empty!']],
			'voltage2' => ['rules' => 'required', 'errors' => ['required' => 'Voltage 2 cant be empty!']],
			'concentration1' => ['rules' => 'required', 'errors' => ['required' => 'Concentration 1 cant be empty!']],
			'concentration2' => ['rules' => 'required', 'errors' => ['required' => 'Concentration 2 cant be empty!']],
		])) {
			if (is_null($id)) {
				return redirect()->to(base_url('parameter/add'))->withInput();
			}
			return redirect()->to(base_url("parameter/edit/{$id}"))->withInput();
		}
		try {
			$data['instrument_id'] = $this->request->getPost('instrument_id');
			$data['name'] = $this->request->getPost('name');
			$data['caption'] = $this->request->getPost('caption');
			$data['unit_id'] = $this->request->getPost('unit_id');
			$data['molecular_mass'] = $this->request->getPost('molecular_mass');
			$data['formula'] = $this->request->getPost('formula');
			$data['is_view'] = $this->request->getPost('is_view');
			$data['is_graph'] = $this->request->getPost('is_graph');
			$data['labjack_value_id'] = $this->request->getPost('labjack_value_id');
			$data['voltage1'] = $this->request->getPost('voltage1');
			$data['voltage2'] = $this->request->getPost('voltage2');
			$data['concentration1'] = $this->request->getPost('concentration1');
			$data['concentration2'] = $this->request->getPost('concentration2');
			try {
				if (is_null($id)) {
					$this->parameters->insert($data);
					session()->setFlashdata("flash_message", ["success", "Success insert data parameter"]);
				} else {
					$this->parameters->update($id, $data);
					session()->setFlashdata("flash_message", ["success", "Success update data parameter"]);
					return redirect()->to(base_url("parameter/edit/{$id}"));
				}
				return redirect()->to(base_url('parameters'));
			} catch (Exception $e) {
				session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
				if (is_null($id)) {
					return redirect()->to(base_url('parameter/add'))->withInput();
				}
				return redirect()->to(base_url("parameter/edit/{$id}"))->withInput();
			}
		} catch (Exception $e) {
			session()->setFlashdata("flash_message", ["error", "Error: {$e->getMessage()}"]);
			if (is_null($id)) {
				return redirect()->to(base_url('parameter/add'))->withInput();
			}
			return redirect()->to(base_url("parameter/edit/{$id}"))->withInput();
		}
	}
	public function get_reference()
	{
		$data = [];
		try {
			$data['instruments'] = $this->instruments->select('id,name')->where(['is_deleted' => 0])->findAll();
			$data['units'] = $this->units->select('id,name')->where(['is_deleted' => 0])->findAll();
			$data['labjack_values'] = $this->labjack_values->select('labjacks.labjack_code as code,labjack_values.*')
				->join('labjacks', 'labjacks.id=labjack_values.labjack_id')->findAll();
		} catch (Exception $e) {
		}
		return $data;
	}
	public function add()
	{
		if (isset($_POST['Save'])) {
			return $this->saving_add();
		}
		$this->privilege_check($this->menu_ids);
		$data['validation']    = \Config\Services::validation();
		$data['__modulename'] = "Add Parameter";
		$data = $data + $this->get_reference() + $this->common();
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
		$data['__modulename'] = "Edit Parameter";
		$data['parameter'] = $this->parameters->find($id);
		$data = $data + $this->get_reference() + $this->common();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('parameters/v_edit');
		echo view('v_footer');
		echo view('parameters/v_js');
	}
	public function delete()
	{
		if (isset($_POST['Delete'])) {
			try {
				$this->parameters->delete($this->request->getPost('id'));
			} catch (Exception $e) {
				session()->setFlashdata('flash_message', ['error', 'Error: ' . $e->getMessage()]);
				return redirect()->to('/parameters');
			}
			session()->setFlashdata('flash_message', ['success', 'Delete parameter succcesfully!']);
			return redirect()->to('/parameters');
		}
		session()->setFlashdata('flash_message', ['error', 'Something when wrong!']);
		return redirect()->to('/parameters');
	}
}
