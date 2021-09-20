<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_configuration;

class Backup extends BaseController
{
	protected $configurations;
	public function __construct()
	{
		parent::__construct();
		$this->route_name = "backups";
		$this->menu_ids = $this->get_menu_ids($this->route_name);
		$this->configurations = new m_configuration();
	}

	public function index()
	{
		$data["__modulename"] = "Backup & Restore";
		$data = $data + $this->common();
		$data["backups"] = [];

		$d = dir(getcwd() . "\dist\upload\backups");

		while (($file = $d->read()) !== false) {
			if ($file != "." && $file != "..")
				$data["backups"][] = $file;
		}
		$d->close();

		echo view('v_header', $data);
		echo view('v_menu');
		echo view('backups/v_list');
		echo view('v_footer');
	}

	public function backup_exec()
	{
		$data["__modulename"] = "Backup & Restore";
		$data = $data + $this->common();

		exec("python " . $this->configurations->find(1)->main_path . "backup_execute.py");
		echo view('v_header', $data);
		echo view('v_menu');
		echo "Backup Done<br><a href='/backup'>Back</a>";
		echo view('v_footer');
	}

	public function restore_exec()
	{
		$data["__modulename"] = "Backup & Restore";
		$data = $data + $this->common();

		// exec("python " . $this->configurations->find(1)->main_path . "backup_execute.py");
		echo view('v_header', $data);
		echo view('v_menu');
		echo "Restore Done<br><a href='/backup'>Back</a>";
		echo view('v_footer');
	}
}
