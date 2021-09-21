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
		arsort($data["backups"]);
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
		echo "
		<div class='row mt-5'>
			<div class='col-12'>
				<h3 class='text-center'>
					<span class='text-success'>Backup Success</span>
				</h3>
				<h3 class='text-center'>
					<a class='btn btn-primary mt-2' href='/backup'>Back</a>
				</h3>
			</div>
		</div>";
		echo view('v_footer');
	}

	public function restore_exec()
	{
		$data["__modulename"] = "Backup & Restore";
		$data = $data + $this->common();

		if ($backupfile = @$this->request->getFiles()['filename'])
			if ($backupfile->isValid() && !$backupfile->hasMoved()) {
				$backupfilename = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . date("YmdHis") . "." . pathinfo($backupfile->getName(), PATHINFO_EXTENSION);
				$backupfile->move('dist/upload', $backupfilename);
				exec("python " . $this->configurations->find(1)->main_path . "restore_execute.py " . $backupfilename);
			}

		echo view('v_header', $data);
		echo view('v_menu');
		echo "
		<div class='row mt-5'>
			<div class='col-12'>
				<h3 class='text-center'>
					<span class='text-success'>Restore Success</span>
				</h3>
				<h3 class='text-center'>
					<a class='btn btn-primary mt-2' href='/backup'>Back</a>
				</h3>
			</div>
		</div>";
		echo view('v_footer');
	}
}
