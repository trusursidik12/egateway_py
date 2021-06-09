<?php

namespace App\Controllers;

use App\Models\m_instrument;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use App\Models\m_stack;
use App\Models\m_unit;

class Home extends BaseController
{
	protected $menu_ids;
	protected $route_name;
	protected $stacks;
	protected $parameters;
	protected $measurement_logs;
	protected $instruments;
	protected $units;

	public function __construct()
	{
		parent::__construct();
		$this->stacks =  new m_stack();
		$this->parameters =  new m_parameter();
		$this->measurement_logs =  new m_measurement_log();
		$this->instruments =  new m_instrument();
		$this->units =  new m_unit();
	}

	public function index($stack_id = 1)
	{
		$data["__modulename"] = "";
		$data = $data + $this->common();

		$data["stack_id"] = $stack_id;
		$data["stacks"] = $this->stacks->findAll();
		$data["instruments"] = $this->instruments->where("stack_id", $stack_id)->findAll();
		foreach ($data["instruments"] as $instrument) {
			$data["parameters"][$instrument->stack_id][$instrument->id] = $this->parameters->where("instrument_id", $instrument->id)->findAll();
			foreach ($data["parameters"][$instrument->stack_id][$instrument->id] as $key => $parameter) {
				$data["parameters"][$instrument->stack_id][$instrument->id][$key]->unit = $this->units->where("id", $parameter->unit_id)->findAll()[0];
			}
		}

		echo view('v_header', $data);
		echo view('v_menu');
		echo view('v_home');
		echo view('v_footer');
		echo view('v_home_js');
	}

	public function get_measurement_log($parameter_id, $time)
	{
		return @$this->measurement_logs->where("parameter_id", $parameter_id)->where("xtimestamp = '" . $time . "'")->findAll()[0]->value;
		// $measurement_logs = @$this->measurement_logs->where("parameter_id", $parameter_id)->where("xtimestamp <= '" . $time . "'")->orderBy("xtimestamp DESC")->findAll(LOG_AVG_NUM);
		// $avg_value = 0;
		// foreach ($measurement_logs as $measurement_log) {
		// 	$avg_value += $measurement_log->value;
		// }
		// return round($avg_value / count($measurement_logs), DECIMAL_NUM);
		// return round(@$this->measurement_logs->select("avg(value) as avg_value")->where("parameter_id", $parameter_id)->where("xtimestamp <= '" . $time . "'")->orderBy("xtimestamp DESC")->findAll(LOG_AVG_NUM)[0]->avg_value, DECIMAL_NUM);
		// return round(@$this->measurement_logs->select("value as avg_value")->where("parameter_id", $parameter_id)->where("xtimestamp <= '" . $time . "'")->orderBy("xtimestamp DESC")->findAll()[0]->avg_value, DECIMAL_NUM);
	}

	public function graph($stack_id, $parameter_id = "")
	{
		if ($parameter_id != "")
			$parameters = $this->parameters->where("id IN (" . $parameter_id . ")")->where("instrument_id IN (SELECT id FROM instruments WHERE stack_id = '" . $stack_id . "')")->findAll();
		else
			$parameters = $this->parameters->where("instrument_id IN (SELECT id FROM instruments WHERE stack_id = '" . $stack_id . "')")->findAll();

		$graph_fields = "";
		foreach ($parameters as $parameter) {
			$graph_fields .= "'" . str_replace(["<sub>", "</sub>"], "", $parameter->caption) . "',";
			$measurement_logs[$parameter->id] = $this->measurement_logs->where("parameter_id='" . $parameter->id . "'")->orderBy("xtimestamp DESC")->findAll(30);
		}

		$graph_data = "";
		foreach ($measurement_logs[$parameters[0]->id] as $key => $measurement_log) {
			foreach ($parameters as $key2 => $parameter) {
				if ($key2 == 0) {
					$graph_data .= "{time: '" . $measurement_logs[$parameter->id][$key]->xtimestamp . "', ";
					$time = $measurement_logs[$parameter->id][$key]->xtimestamp;
				}
				//dengan  average:
				// $graph_data .= " " . str_replace(["<sub>", "</sub>"], "", $parameter->caption) . ": " . $this->get_measurement_log($parameter->id, $time) . " ,";

				//tanpa average:
				$graph_data .= " " . str_replace(["<sub>", "</sub>"], "", $parameter->caption) . ": " . $measurement_logs[$parameter->id][$key]->value . " ,";
			}
			$graph_data = substr($graph_data, 0, -1) . "},";
		}

		$data["graph_fields"] = substr($graph_fields, 0, -1);
		$data["graph_data"] = substr($graph_data, 0, -1);
		// print_r($data);
		echo view('v_graph', $data);
	}

	public function changepassword()
	{
		if (isset($_POST["changepassword"])) {
			$current_password = $this->users->where("id", $this->session->get("user_id"))->where("is_deleted", 0)->findAll()[0]->password;
			if (password_verify($_POST["old_password"], $current_password)) {
				if (preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/i", $_POST["new_password"])) {
					if ($_POST["new_password"] == $_POST["retype_password"]) {
						$this->users->update($this->session->get("user_id"), ["password" => password_hash($_POST["new_password"], PASSWORD_ARGON2I)] + $this->updated_values());
						$this->session->setFlashdata("flash_message", ["success", "Password changed successfully"]);
						return redirect()->to(base_url() . '/');
					} else {
						$this->session->setFlashdata("flash_message", ["error", "Retype new password not match"]);
						return redirect()->to(base_url() . '/changepassword');
					}
				} else {
					$this->session->setFlashdata("flash_message", ["error", "New password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"]);
					return redirect()->to(base_url() . '/changepassword');
				}
			} else {
				$this->session->setFlashdata("flash_message", ["error", "Wrong old password"]);
				return redirect()->to(base_url() . '/changepassword');
			}
		}
		$data["__modulename"] = "Change Password";
		$data = $data + $this->common();
		echo view('v_header', $data);
		echo view('v_menu');
		echo view('v_changepassword');
		echo view('v_footer');
	}

	function mime_type($path)
	{
		$ext = explode('.', $path);
		$ext = $ext[count($ext) - 1];
		if (in_array($ext, array('htm', 'html', 'php', 'phtml', 'php3', 'php4', 'php5', 'php5', 'php6'))) {
			return 'text/html';
		} else {
			if (in_array($ext, array('js', 'jscript'))) {
				return 'text/javascript';
			} else {
				if (in_array($ext, array('css', 'css3'))) {
					return 'text/css';
				} else {
					if (in_array($ext, array('sql'))) {
						return 'text/plain';
					} else {
						if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
							return 'image/' . str_replace('jpg', 'jpeg', $ext);
						} else {
							return "";
						}
					}
				}
			}
		}
	}

	public function downloads($fileName = NULL)
	{
		if ($fileName) {
			$path = WRITEPATH . 'uploads/' . $fileName;
			if (file_exists($path)) {
				$mime = $this->mime_type($path);
				header('Pragma: public');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
				header('Cache-Control: private', false);
				header('Content-Type: ' . $mime);
				header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');  // Add the file name
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . filesize($path));
				header('Connection: close');
				readfile($path);
			}
		}
		exit();
	}
}
