<?php

namespace App\Controllers;

use App\Models\m_a_group;
use App\Models\m_a_menu;

class A_menu extends BaseController
{
    protected $menu_ids;
    protected $route_name;
    protected $menus;
    protected $groups;

    public function __construct()
    {
        parent::__construct();
        $this->route_name = "menu";
        $this->menu_ids = $this->get_menu_ids($this->route_name);
        $this->menus =  new m_a_menu();
        $this->groups =  new m_a_group();
    }

    public function index()
    {
        $this->privilege_check($this->menu_ids);
        if (isset($_GET["move"])) {
            $menu_id = $_GET["menu_id"];
            $menu = @$this->menus->where(["is_deleted" => 0, "id" => $menu_id])->findAll()[0];
            $parent_id = $menu->parent_id;
            $seqno = $menu->seqno;
            if ($_GET["move"] == "up" && $seqno > 1) {
                $this->menus->update($menu_id, ["seqno" => $seqno - 1]);
                if ($menu2 = @$this->menus->where(["is_deleted" => 0, "parent_id" => $parent_id, "seqno < " => $seqno])->orderBy('seqno', 'desc')->findAll()[0])
                    $this->menus->update($menu2->id, ["seqno" => $seqno]);
            }
            if ($_GET["move"] == "down") {
                $this->menus->update($menu_id, ["seqno" => $seqno + 1]);
                if ($menu2 = @$this->menus->where(["is_deleted" => 0, "parent_id" => $parent_id, "seqno > " => $seqno])->orderBy('seqno', 'asc')->findAll()[0])
                    $this->menus->update($menu2->id, ["seqno" => $seqno]);
            }
            return redirect()->to(base_url() . '/menu');
        }
        $page = isset($_GET["page"]) ? $_GET["page"] - 1 : 0;
        $data["__modulename"] = "Menu";
        $startrow = $page * MAX_ROW;

        $wherclause = "is_deleted = '0'";

        if (isset($_GET["parent_id"]) && $_GET["parent_id"] != "")
            $wherclause .= "AND parent_id = '" . $_GET["parent_id"] . "'";

        if (isset($_GET["name"]) && $_GET["name"] != "")
            $wherclause .= "AND name LIKE '%" . $_GET["name"] . "%'";

        if (isset($_GET["url"]) && $_GET["url"] != "")
            $wherclause .= "AND url LIKE '%" . $_GET["url"] . "%'";

        if ($menus = $this->menus->where($wherclause)->orderBy('parent_id,seqno')->findAll(MAX_ROW, $startrow)) {
            $numrow = count($this->menus->where($wherclause)->findAll());
            foreach ($menus as $menu) {
                $menu_detail[$menu->id]["parent"] = @$this->menus->where("id", $menu->parent_id)->get()->getResult()[0];
                $menu_detail[$menu->id]["childs"] = @$this->menus->where(["is_deleted" => "0", "parent_id" => $menu->id])->orderBy('seqno', 'asc')->findAll();
            }
        } else {
            $numrow = 0;
        }

        $data["startrow"] = $startrow;
        $data["numrow"] = $numrow;
        $data["maxpage"] = ceil($numrow / MAX_ROW);
        $data["_menus"] = $this->menus->where(["parent_id" => 0])->orderBy('seqno', 'asc')->findAll();
        $data["menus"] = $menus;
        $data["menu_detail"] = @$menu_detail;
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_menus/v_list');
        echo view('v_footer');
    }

    public function add()
    {
        $this->privilege_check($this->menu_ids, 1, $this->route_name);
        if (isset($_POST["Save"])) {
            $seqno = @$this->menus->where(["is_deleted" => 0, "parent_id" => @$_POST["parent_id"]])->orderBy('seqno', 'desc')->findAll()[0]->seqno;
            $seqno++;
            $menu = [
                "seqno" => $seqno,
                "parent_id" => @$_POST["parent_id"],
                "name" => @$_POST["name"],
                "url" => @$_POST["url"],
                "icon" => @$_POST["icon"],
            ];
            $menu = $menu + $this->created_values() + $this->updated_values();
            if ($this->menus->save($menu)) {
                $id = $this->menus->insertID();
                foreach ($_POST["group"] as $group_id => $value) {
                    $group = @$this->groups->where(["is_deleted" => 0, "id" => $group_id])->findAll()[0];
                    $menu_ids = $group->menu_ids . $id . ",";
                    $previlage = @$_POST["priv_a"][$group_id] + @$_POST["priv_e"][$group_id] + @$_POST["priv_v"][$group_id] + @$_POST["priv_d"][$group_id];
                    $privileges = $group->privileges . $previlage . ",";
                    $this->groups->update($group_id, ["menu_ids" => $menu_ids, "privileges" => $privileges]);
                }
                $this->session->setFlashdata("flash_message", ["success", "Success create Menu"]);
            } else
                $this->session->setFlashdata("flash_message", ["error", "Failed create Menu"]);
            return redirect()->to(base_url() . '/menu');
        }

        $data["__modulename"] = "Add Menu";
        $data["__mode"] = "add";
        $data["groups"] = $this->groups->where(["is_deleted" => 0])->findAll();
        $data["parents"] = $this->menus->where(["is_deleted" => 0, "parent_id" => 0])->findAll();


        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_menus/v_edit');
        echo view('v_footer');
        echo view('_menus/v_js');
    }

    public function edit($id)
    {
        $this->privilege_check($this->menu_ids, 2, $this->route_name);
        if (isset($_POST["Save"])) {
            $menu = [
                "parent_id" => @$_POST["parent_id"],
                "name" => @$_POST["name"],
                "url" => @$_POST["url"],
                "icon" => @$_POST["icon"],
            ];

            $menu = $menu + $this->updated_values();
            if ($this->menus->update($id, $menu))
                $this->session->setFlashdata("flash_message", ["success", "Success editing Menu"]);
            else
                $this->session->setFlashdata("flash_message", ["error", "Failed editing Menu"]);
            return redirect()->to(base_url() . '/menu');
        }

        $data["__modulename"] = "Edit Menu";
        $data["__mode"] = "edit";
        $data["parents"] = $this->menus->where(["is_deleted" => 0, "parent_id" => 0])->findAll();
        $data["menu"] = $this->menus->where("is_deleted", 0)->find([$id])[0];
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('_menus/v_edit');
        echo view('v_footer');
        echo view('_menus/v_js');
    }

    public function delete($id)
    {
        $this->privilege_check($this->menu_ids, 8, $this->route_name);
        if ($this->menus->update($id, ["is_deleted" => 1] + $this->deleted_values()))
            $this->session->setFlashdata("flash_message", ["success", "Success deleting Menu"]);
        else
            $this->session->setFlashdata("flash_message", ["error", "Success deleting Menu"]);
        return redirect()->to(base_url() . '/menu');
    }
}
