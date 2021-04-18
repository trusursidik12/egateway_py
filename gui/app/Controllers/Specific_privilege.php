<?php

namespace App\Controllers;

use App\Models\m_specific_privilege;

class specific_privilege extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $specific_privileges;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "specific_privileges";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->specific_privileges =  new m_specific_privilege();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Specific Privileges";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($specific_privileges = $this->specific_privileges->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->specific_privileges->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["specific_privileges"] = $specific_privileges;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('specific_privileges/v_list');
        echo view('v_footer');
    }

    public function get_reference_data()
    {
        $data["users"] = $this->users->where(["is_deleted" => 0])->findAll();
        return $data;
    }

    public function get_saved_data($id)
    {
        $data["specific_privilege"] = $this->specific_privileges->where("is_deleted", 0)->find([$id])[0];
        return $data;
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $user_ids = "";
            foreach ($_POST["users"] as $user_id => $value) {
                $user_ids .= "|" . $user_id . "|";
            }

            $specific_privilege = [
                "name" => @$_POST["name"],
                "denied_message" => @$_POST["denied_message"],
                "user_ids" => $user_ids,
            ];

            $specific_privilege = $specific_privilege + $this->created_values() + $this->updated_values();
            if ($this->specific_privileges->save($specific_privilege))
                $this->session->setFlashdata("flash_message", ["success", "Success create specific privilege"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed create specific privilege"]);
            return redirect()->to(base_url() . '/specific_privileges');
        }

        $data["__modulename"] = "Add Specific Privilege";
        $data["menu_ids"] = [];
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('specific_privileges/v_edit');
        echo view('v_footer');
        echo view('specific_privileges/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $user_ids = "";
            foreach ($_POST["users"] as $user_id => $value) {
                $user_ids .= "|" . $user_id . "|";
            }

            $specific_privilege = [
                "name" => @$_POST["name"],
                "denied_message" => @$_POST["denied_message"],
                "user_ids" => $user_ids,
            ];

            $specific_privilege = $specific_privilege + $this->updated_values();
            if ($this->specific_privileges->update($id, $specific_privilege))
                $this->session->setFlashdata("flash_message", ["success", "Success editing specific privilege"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing specific privilege"]);
            return redirect()->to(base_url() . '/specific_privileges');
        }

        $data["__modulename"] = "Edit Specific Privilege";
        $data["specific_privilege"] = $this->specific_privileges->where("is_deleted", 0)->find([$id])[0];

        $data = $data + $this->get_reference_data();
        $data = $data + $this->get_saved_data($id);
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('specific_privileges/v_edit');
        echo view('v_footer');
        echo view('specific_privileges/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->specific_privileges->update($id, ["is_deleted" => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting specific privilege"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting specific privilege"]);
        return redirect()->to(base_url() . '/specific_privileges');
    }
}
