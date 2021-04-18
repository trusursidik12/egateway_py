<?php

namespace App\Controllers;

use App\Models\m_a_group;
use App\Models\m_a_menu;

class A_group extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $groups;
    protected $menus;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "groups";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->groups =  new m_a_group();
        $this->menus =  new m_a_menu();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);

        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Groups";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if ($groups = $this->groups->where($wherclause)->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->groups->where($wherclause)->findAll());
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["groups"] = $groups;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_groups/v_list');
        echo view('v_footer');
    }

    public function get_reference_data()
    {
        $main_menus = $this->menus->where(["is_deleted" => 0, "id>" => 1, "parent_id" => 0])->orderBy('seqno', 'asc')->findAll();
        foreach ($main_menus as $main_menu) {
            $menu_details[$main_menu->id] = @$this->menus->where(["is_deleted" => "0", "parent_id" => $main_menu->id])->orderBy('seqno', 'asc')->findAll();
        }
        $data["main_menus"] = $main_menus;
        $data["menu_details"] = $menu_details;
        return $data;
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $menu_ids = "";
            $privileges = "";
            foreach ($_POST["main_menu"] as $menu_id => $value) {
                $menu_ids .= $menu_id . ",";
                $privileges .= "15,";
            }
            foreach ($_POST["menu_detail"] as $menu_id => $value) {
                $menu_ids .= $menu_id . ",";
                $previlage = @$_POST["priv_a"][$menu_id] + @$_POST["priv_e"][$menu_id] + @$_POST["priv_v"][$menu_id] + @$_POST["priv_d"][$menu_id];
                $privileges .= $previlage . ",";
            }

            $group = [
                "name" => @$_POST["name"],
                "menu_ids" => $menu_ids,
                "privileges" => $privileges,
            ];
            $group = $group + $this->created_values() + $this->updated_values();
            if ($this->groups->save($group))
                $this->session->setFlashdata("flash_message", ["success", "Success create Group"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed create Group"]);
            return redirect()->to(base_url() . '/groups');
        }

        $data["__modulename"] = "Add Group";
        $data["menu_ids"] = [];
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_groups/v_edit');
        echo view('v_footer');
        echo view('_groups/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $menu_ids = "";
            $privileges = "";
            foreach ($_POST["main_menu"] as $menu_id => $value) {
                $menu_ids .= $menu_id . ",";
                $privileges .= "15,";
            }
            foreach ($_POST["menu_detail"] as $menu_id => $value) {
                $menu_ids .= $menu_id . ",";
                $previlage = @$_POST["priv_a"][$menu_id] + @$_POST["priv_e"][$menu_id] + @$_POST["priv_v"][$menu_id] + @$_POST["priv_d"][$menu_id];
                $privileges .= $previlage . ",";
            }

            $group = [
                "name" => @$_POST["name"],
                "menu_ids" => $menu_ids,
                "privileges" => $privileges,
            ];

            $group = $group + $this->updated_values();
            if ($this->groups->update($id, $group))
                $this->session->setFlashdata("flash_message", ["success", "Success editing Group"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing Group"]);
            return redirect()->to(base_url() . '/groups');
        }

        $data["__modulename"] = "Edit Group";
        $data["group"] = $this->groups->where("is_deleted", 0)->find([$id])[0];
        $data["menu_ids"] = explode(",", $data["group"]->menu_ids);

        $privileges = explode(",", $data["group"]->privileges);
        foreach ($privileges as $key => $privilege) {
            $data["privileges"][$data["menu_ids"][$key]] = $privilege;
        }
        $data = $data + $this->get_reference_data();
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_groups/v_edit');
        echo view('v_footer');
        echo view('_groups/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->groups->update($id, ["is_deleted" => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting Group"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting Group"]);
        return redirect()->to(base_url() . '/groups');
    }
}
