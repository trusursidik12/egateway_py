<?php

namespace App\Controllers;

class A_login extends BaseController
{
    public function index()
    {

        if ($this->session->get("loggedin")) {
            return redirect()->to(base_url() . '/');
        }

        $data["__HTTP_REFERER"] = (@$_POST["HTTP_REFERER"] != "") ? @$_POST["HTTP_REFERER"] : @$_SERVER["HTTP_REFERER"];
        if (isset($_POST["login"])) {
            if ($userlogin = @$this->users->where("email", $_POST["email"])->where("is_deleted", 0)->findAll()[0]) {
                if (password_verify($_POST["password"], $userlogin->password)) {
                    $logindata = [
                        "loggedin" => true,
                        "user_id" => $userlogin->id,
                        "username" => $userlogin->email,
                        "user" => $userlogin,
                    ];
                    $this->session->set($logindata);
                    $this->session->setFlashdata("flash_message", ["success", "Login Success"]);
                    if ($_POST["HTTP_REFERER"] != "")
                        return redirect()->to($_POST["HTTP_REFERER"]);
                    else
                        return redirect()->to(base_url() . '/');
                } else {
                    $this->session->setFlashdata("flash_message", ["error", "Wrong Password"]);
                    return redirect()->to($_POST["HTTP_REFERER"]);
                }
            } else {
                $this->session->setFlashdata("flash_message", ["error", "Unknown Email/Username"]);
                return redirect()->to($_POST["HTTP_REFERER"]);
            }
        }
        $data["__modulename"] = "";
        $data = $data + $this->common();
        echo view('v_header', $data);
        echo view('v_menu');
        echo view('v_login');
        echo view('v_footer');
    }

    public function logout()
    {
        $this->session->destroy();
        $this->session->setFlashdata("flash_message", ["success", "Logout Success"]);
        return redirect()->to(base_url() . '/login');
    }

    public function login_as($username)
    {
        if ($this->session->get("user_id") == 1) {
            if ($userlogin = @$this->users->where("email", $username)->where("is_deleted", 0)->findAll()[0]) {
                $logindata = [
                    "loggedin" => true,
                    "user_id" => $userlogin->id,
                    "username" => $userlogin->email,
                    "user" => $userlogin,
                ];
                $this->session->set($logindata);
                $this->session->setFlashdata("flash_message", ["success", "Login Success"]);
                return redirect()->to(base_url() . '/');
            } else {
                print_r($userlogin);
                $this->session->setFlashdata("flash_message", ["error", "Unknown Email/Username"]);
                return redirect()->to(base_url() . '/login');
            }
        }
    }
}
