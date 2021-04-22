<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_instrument;
use App\Models\m_parameter;
use App\Models\m_stack;
use App\Models\m_status;
use Exception;

class Instrument extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $instruments;
	protected $stacks;
	protected $parameters;
	protected $statuses;
	protected $validation;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "instruments";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->instruments = new m_instrument();
		$this->stacks = new m_stack();
		$this->parameters = new m_parameter();
		$this->statuses = new m_status();

		$this->validation = \Config\Services::validation();
	}
	public function index()
	{
		$this->privilege_check($this->menu_ids);
		$data["__modulename"] = "Instruments";
		$data['instruments'] = $this->instruments->select('statuses.name as status,instruments.*')
			->join('statuses', 'instruments.status_id = statuses.id')->where(['instruments.is_deleted' => 0])->orderBy('instruments.id DESC')->findAll();
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('instruments/v_list');
		echo view('v_footer');
		echo view('instruments/v_js');
	}
	public function get_reference()
	{
		try {
			$data['stacks'] = $this->stacks->select('id,code')->where(['is_deleted' => 0])->findAll();
			$data['parameters'] = $this->parameters->select('id,name')->findAll();
			$data['statuses'] = $this->statuses->select('id,name')->where(['is_deleted' => 0])->findAll();
		} catch (Exception $e) {
			$data = [];
		}
		return $data;
	}
	public function saving_add($id = null)
	{
		/* Get value from request post */
		$data['name'] = $this->request->getPost('name');
		$data['stack_id'] = $this->request->getPost('stack_id');
		$data['parameter_id'] = $this->request->getPost('parameter_id');
		$data['i_type'] = $this->request->getPost('i_type');
		$data['status_id'] = $this->request->getPost('status_id');
		if ($this->validation->run($data, 'instrument') == false) {
			session()->setFlashdata('errors', $this->validation->getErrors());
			return redirect();
		}
		foreach ($data['parameter_id'] as $parameter) {
			@$data['parameter_ids'] .= $parameter . ',';
		}
		$data['parameter_ids'] = rtrim($data['parameter_ids'], ",");
		unset($data['parameter_id']);
		try {
			if ($id != null) {
				$this->instruments->update($id, $data + $this->updated_values());
			} else {
				$this->instruments->insert($data + $this->created_values());
			}
		} catch (Exception $e) {
			session()->setFlashdata('flash_message', ['error', 'Error : ' . $e->getMessage()]);
			if ($id != null) {
				return redirect()->to('/instrument/edit/' . $id);
			}
			return redirect()->to('/instrument/add');
		}
		if ($id != null) {
			session()->setFlashdata('flash_message', ['success', 'Instrument update succcesfully!']);
			return redirect()->to('/instrument/edit/' . $id);
		}
		session()->setFlashdata('flash_message', ['success', 'Instrument added succcesfully!']);
		return redirect()->to('/instruments');
	}
	public function add()
	{
		if (isset($_POST['Save'])) {
			return $this->saving_add();
		}
		$this->privilege_check($this->menu_ids);
		$data['__modulename'] = "Instrument Add";
		$data['errors'] =  $this->validation->getErrors();
		$data = $data + $this->get_reference() + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('instruments/v_edit');
		echo view('v_footer');
		echo view('instruments/v_js');
	}
	public function edit($id = null)
	{
		$this->privilege_check($this->menu_ids);
		if (isset($_POST['Save'])) {
			return $this->saving_add($id);
		}
		try {
			$data['__modulename'] = "Instrument Edit";
			$data['errors'] =  $this->validation->getErrors();
			$data['instrument'] = $this->instruments->find($id);
			$data['parameter_ids'] = explode(',', $data['instrument']->parameter_ids);
			$data = $data + $this->get_reference() + $this->common();
			echo view('v_header', $data);
			echo view('v_menu');
			echo view('instruments/v_edit');
			echo view('v_footer');
			echo view('instruments/v_js');
		} catch (Exception $e) {
			session()->setFlashdata('flash_message', ['error', 'Error : ' . $e->getMessage()]);
			return redirect()->to('/instruments');
		}
	}
	public function delete()
	{
		if (isset($_POST['Delete'])) {
			try {
				$this->instruments->update($this->request->getPost('id'), ['is_deleted' => 1] + $this->deleted_values());
			} catch (Exception $e) {
				session()->setFlashdata('flash_message', ['error', 'Error: ' . $e->getMessage()]);
				return redirect()->to('/instruments');
			}
			session()->setFlashdata('flash_message', ['success', 'Delete instrument succcesfully!']);
			return redirect()->to('/instruments');
		}
		session()->setFlashdata('flash_message', ['error', 'Something when wrong!']);
		return redirect()->to('/instruments');
	}

	public function get_parameter($instrument_id)
	{
		$data = [];
		try {
			$data = [];
			$instrument = $this->instruments->find($instrument_id);
			$parameter_id = explode(',', $instrument->parameter_ids);
			foreach ($parameter_id as $key => $id) {
				$data[$key] = $this->parameters->select('name')->find($id);
			}
		} catch (Exception $e) {
		}
		return json_encode($data, JSON_PRETTY_PRINT);
	}
}
