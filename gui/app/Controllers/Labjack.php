<?php

namespace App\Controllers;

use App\Models\m_instrument;
use App\Models\m_labjack;

class Labjack extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $labjacks;
    protected $instruments;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "labjacks";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->labjacks =  new m_labjack();
        $this->instruments =  new m_instrument();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        $data = $this->labjacks->select('labjacks.id,labjacks.labjack_code,instruments.name')
            ->join('instruments', 'labjacks.instrument_id=instruments.id')->findAll();
        $data["labjacks"] = $data;
        $data["__modulename"] = "labjacks";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('labjacks/v_list');
        echo view('v_footer');
        echo view('labjacks/v_js');
    }

    public function fields()
    {
        $fileds =
            [
                'labjack_code'  => $this->request->getPost('labjack_code'),
                'instrument_id' => $this->request->getPost('instrument_id')
            ];
        return $fileds;
    }

    public function add()
    {

        if (isset($_POST["Save"])) {
            if (!$this->validate([
                'labjack_code' => [
                    'rules'     => 'required|is_unique[labjacks.labjack_code]',
                    'errors'     => [
                        'required'    => 'Labjack Code Empty!. Please input ..',
                        'is_unique'    => 'Labjack Code Exist!. Please input another Labjack Code ..'
                    ]
                ],
                'instrument_id' => [
                    'rules'     => 'required',
                    'errors'     => [
                        'required'    => 'Instrument Empty!. Please select ..'
                    ]
                ],
            ])) {
                return redirect()->to('/labjack/add')->withInput();
            }

            $this->labjacks->save($this->fields());
            $this->session->setFlashdata("flash_message", ["success", "Success insert data labjack"]);
            return redirect()->to('/labjacks');
        }

        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        $data['instruments'] = $this->instruments->findAll();
        $data["__modulename"] = "Add Specific Privilege";
        $data["menu_ids"] = [];
        $data['validation']    = \Config\Services::validation();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('labjacks/v_edit');
        echo view('v_footer');
    }

    public function edit($id)
    {
        if (isset($_POST["Save"])) {
            if (!$this->validate([
                'labjack_code' => [
                    'rules'     => 'required',
                    'errors'     => [
                        'required'    => 'Labjack Code Empty!. Please input ..',
                    ]
                ],
                'instrument_id' => [
                    'rules'     => 'required',
                    'errors'     => [
                        'required'    => 'Instrument Empty!. Please input ..'
                    ]
                ],
            ])) {
                return redirect()->to('/labjack/edit/' . $id)->withInput();
            }

            $this->labjacks->update($id, $this->fields());
            $this->session->setFlashdata("flash_message", ["success", "Success edit data labjack"]);
            return redirect()->to('/labjacks');
        }

        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $data['instruments'] = $this->instruments->findAll();
        $data["labjack"] = $this->labjacks->find([$id])[0];
        $data["__modulename"] = "Labjack Edit";
        $data['validation']    = \Config\Services::validation();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('labjacks/v_edit');
        echo view('v_footer');
    }

    public function voltages()
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        $data["__modulename"] = "Labjack Voltages";
        $data = $data + $this->common();
        $data['labjacks'] = $this->labjacks->orderBy("id")->findAll();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('labjacks/v_voltages');
        echo view('v_footer');
        echo "<script> reload_voltages(); </script>";
    }

    public function delete()
    {
        $this->labjacks->delete($this->request->getPost('id'));
        $this->session->setFlashdata("flash_message", ["success", "Success delete data labjack"]);
        return redirect()->to('/labjacks');
    }
}
