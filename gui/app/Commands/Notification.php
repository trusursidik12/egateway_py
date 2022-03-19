<?php

namespace App\Commands;

use App\Models\m_das_log;
use App\Models\m_instrument;
use App\Models\m_parameter;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Notification extends BaseCommand
{
	/**
	 * The Command's Group
	 *
	 * @var string
	 */
	protected $group = 'CodeIgniter';

	public function __construct()
	{
		// date_default_timezone_set('Asia/Jakarta');
		$this->dasLog =  new m_das_log();
		$this->param =  new m_parameter();
		$this->instrument =  new m_instrument();
	}

	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'command:notification';

	/**
	 * The Command's Description
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * The Command's Usage
	 *
	 * @var string
	 */
	protected $usage = 'command:name [arguments] [options]';

	/**
	 * The Command's Arguments
	 *
	 * @var array
	 */
	protected $arguments = [];

	/**
	 * The Command's Options
	 *
	 * @var array
	 */
	protected $options = [];

	public function bakumutu()
	{
		$params = $this->param->findAll();
		$dasLogs = $this->getDasLogs();
		foreach ($dasLogs as $data) {
			foreach ($params as $check) {
				if ($data->data_status_id == 1 && $data->notification == 0) {
					if ($data->parameter_id == $check->id) {
						if($check->max_value > 0){
							if ($data->value_correction >= $check->max_value) {
								$this->dasLog->set(['notification' => 1])->where('id', $data->id)->update();
							}
						}
					}
				}
			}
		}
	}

	public function zero()
	{
		$params = $this->param->findAll();
		$dasLogs = $this->getDasLogs();
		foreach ($dasLogs as $data) {
			foreach ($params as $check) {
				if ($data->data_status_id == 1 && $data->notification == 0) {
					if ($data->parameter_id == $check->id) {
						if ($data->value_correction <= 0) {
							$this->dasLog->set(['notification' => 2])->where('id', $data->id)->update();
						}
					}
				}
			}
		}
	}

	public function failedToSend()
	{
		$params = $this->param->findAll();
		$dasLogs = $this->getDasLogs();
		foreach ($dasLogs as $data) {
			foreach ($params as $check) {
				if ($data->data_status_id == 1 && $data->notification == 0) {
					if ($data->parameter_id == $check->id) {
						if ($data->is_sent_sispek == 0) {
							$this->dasLog->set(['notification' => 3])->where('id', $data->id)->update();
						}
					}
				}
			}
		}
	}

	public function bakumutu_failedToSend()
	{
		$params = $this->param->findAll();
		$dasLogs = $this->getDasLogs();
		foreach ($dasLogs as $data) {
			foreach ($params as $check) {
				if ($data->data_status_id == 1 && $data->notification == 1) {
					if ($data->parameter_id == $check->id) {
						if ($data->value_correction >= $check->max_value && $data->is_sent_sispek == 0) {
							$this->dasLog->set(['notification' => 4])->where('id', $data->id)->update();
						}
					}
				}
			}
		}
	}

	public function zero_failedToSend()
	{
		$params = $this->param->findAll();
		$dasLogs = $this->getDasLogs();
		foreach ($dasLogs as $data) {
			foreach ($params as $check) {
				if ($data->data_status_id == 1 && $data->notification == 2) {
					if ($data->parameter_id == $check->id) {
						if ($data->value_correction <= 0 && $data->is_sent_sispek == 0) {
							$this->dasLog->set(['notification' => 5])->where('id', $data->id)->update();
						}
					}
				}
			}
		}
	}

	/**
	 * STATUS NOTIFICATION
	 * 0 : Data Belum Dicek
	 * 1 : Melebihi Bakumutu
	 * 2 : Nol / Minus
	 * 3 : Data Tidak Terkirim
	 * 4 : Melebihi Bakumutu dan Data Tidak Terkirim
	 * 5 : Nol / Minus dan Data Tidak Terkirim
	 * 6 : Data Yang Masuk Kedalam Kategori Notifikasi dan Data Setelah Dikirim Melalui Notifikasi Email
	 * 7 : Data Yang Normal Setelah di lakukan Pengecekan
	 */

	/**
	 * Sent To Email
	 */

	public function sentToEmail()
	{
		$dasLogs = $this->getDasLogs();
		$range = $this->getDateRange();
		$bakumutu = [];
		$nol = [];
		$tidakterkirim = [];
		$bakumututidakterkirim = [];
		$nolidakterkirim = [];
		
		foreach ($dasLogs as $log) {
			$param = @$this->param->select('parameters.name as name,max_value, units.name as unit_name')
				->join('units','parameters.unit_id = units.id')
				->where('parameters.id', $log->parameter_id)
				->first();
			$instrument = @$this->instrument->select('name')
				->where('id', $log->instrument_id)
				->first();
			if ($log->notification == 1) {
				$bakumutu[] =  $log->time_group." | ".@$instrument->name." - ".@$param->name ." : ". $log->value_correction ." ".@$param->unit_name. " | Baku Mutu : ". $param->max_value . " ".@$param->unit_name;
			}
			if ($log->notification == 2) {
				$nol[] = $log->time_group." | ".@$instrument->name." - ".@$param->name ." : ". $log->value_correction ." ".@$param->unit_name;
			}
			if ($log->notification == 3) {
				$tidakterkirim[] = $log->time_group." | ".@$instrument->name." - ".@$param->name ." : ". $log->value_correction ." ".@$param->unit_name . " <p style='color: #cc3300'>Tidak terkirim</p>";
			}
			if ($log->notification == 4) {
				$bakumututidakterkirim[] =  $log->time_group." | ".@$instrument->name." - ".@$param->name ." : ". $log->value_correction ." ".@$param->unit_name. " | Baku Mutu : ". $param->max_value . " ".@$param->unit_name . " <p style='color: #cc3300'>Tidak terkirim</p>";
			}
			if ($log->notification == 5) {
				$nolidakterkirim[] = $log->time_group." | ".@$instrument->name." - ".@$param->name ." : ". $log->value_correction ." ".@$param->unit_name . " <p style='color: #cc3300'>Tidak terkirim</p>";
			}
		}

		$body = "<div style='margin:0; background-color: #f4f4f4; box-sizing: border-box; padding: 5px 20px;border-radius: 20px;'>";
		$body .= "<h1 style='color:#cc3300; text-align: center; font-size: 21x;'>eGateway Notification</h1>";
		$body .= "<p>Dear User, berikut adalah daftar system failure eGateway:</p>";
		$bodyCheck = false; // Initialize
		if(count($bakumutu) > 0){
			$bodyCheck = true;
			$body.="<h2 style='color: #cc3300; font-size: 14px;'>Melebihi Baku Mutu:</h2>";
			$body.="<ul>";
			foreach ($bakumutu as $value) {
				$body.="<li>".$value."</li>";
			}
			$body.="</ul>";
		}
		if(count($nol) > 0){
			$bodyCheck = true;
			$body.="<h2 style='color: #cc3300; font-size: 14px;'>Parameter Nilai 0 / Minus:</h2>";
			$body.="<ul>";
			foreach ($nol as $value) {
				$body.="<li>".$value."</li>";
			}
			$body.="</ul>";
		}
		if(count($tidakterkirim) > 0){
			$bodyCheck = true;
			$body.="<h2 style='color: #cc3300; font-size: 14px;'>Data tidak terkirim :</h2>";
			$body.="<ul>";
			foreach ($tidakterkirim as $value) {
				$body.="<li>".$value."</li>";
			}
			$body.="</ul>";
		}
		if(count($bakumututidakterkirim) > 0){
			$bodyCheck = true;
			$body.="<h2 style='color: #cc3300; font-size: 14px;'>Parameter melebihi Baku Mutu yang tidak terkirim :</h2>";
			$body.="<ul>";
			foreach ($bakumututidakterkirim as $value) {
				$body.="<li>".$value."</li>";
			}
			$body.="</ul>";
		}
		if(count($nolidakterkirim) > 0){
			$bodyCheck = true;
			$body.="<h2 style='color: #cc3300; font-size: 14px;'>Parameter nilai 0 / minus yang tidak terkirim :</h2>";
			$body.="<ul>";
			foreach ($nolidakterkirim as $value) {
				$body.="<li>".$value."</li>";
			}
			$body.="</ul>";
		}
		$body .= "<p style='color:gray;font-size: small;text-align: center; margin-top: 30px;'>Do not reply this email</p> </div>";

		if ($bodyCheck) { // Check if bodycheck true

			$range = $this->getDateRange();
			// verifikasi email lupa password
			$konfig_email = \Config\Services::email();

			// $konfig = $this->konfigurasi->first();
			$config["protocol"] = "smtp";

			//isi sesuai nama domain/mail server
			$config["SMTPHost"]  = "smtp.gmail.com";

			//alamat email SMTP
			$config["SMTPUser"]  = "it.trusur@gmail.com";

			//password email SMTP
			$config["SMTPPass"]  = "";

			$config["SMTPPort"]  = 465;
			$config["SMTPCrypto"] = "ssl";
			$config["SMTPTimeout"] = 30;
			$config["mailType"] = "html";

			$konfig_email->initialize($config);

			$konfig_email->setFrom("it.trusur@gmail.com", "eGateway Notification");
			$konfig_email->setTo(['sidik.permana12@gmail.com', 'irwanantonio2708@gmail.com']);

			$konfig_email->setSubject('Report eGateway System Failure '.$range['start'].' - '.$range['end']);
			$konfig_email->setMessage($body);

			if ($konfig_email->send()) {
				$this->dasLog->set(['notification' => 6])->where("notification >= 1 AND notification <= 5 AND time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")->update();
				$this->dasLog->set(['notification' => 7])->where("notification = 0 AND time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")->update();
				echo 'berhasil kirim data notifikasi';
			}
		} else {
			$this->dasLog->set(['notification' => 7])->where("notification = 0 AND time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")->update();
			echo 'tidak ada data notifikasi';
		}
	}

	public function getDateRange(){
		$hMin1 = strtotime('-1 hour');
		$hMin1 = date('Y-m-d H:00:00',$hMin1);
		$range['start'] = $hMin1;
		$range['end'] = date('Y-m-d H:i:s',strtotime('+55 minute',strtotime($hMin1)));
		return $range;
	}

	public function getDasLogs(){
		// ini_set("memory_limit","-1");
		$range = $this->getDateRange();
		$dasLogs = $this->dasLog
			->select('id, parameter_id, value_correction, notification,data_status_id,is_sent_sispek,time_group')
			->where("time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")
			->orderBy('time_group ASC')
			->findAll();
		return $dasLogs;
	}
	/**
	 * Actually execute a command.
	 *
	 * @param array $params
	 */
	public function run(array $params)
	{
		while(true){
			$nowI = (int) date('i');
			if($nowI == 30){ // Check menit ke 30
				// check value correction
				$this->bakumutu();
				$this->zero();
				$this->failedToSend();
				$this->bakumutu_failedToSend();
				$this->zero_failedToSend();
				// sending notification
				$this->sentToEmail();
			}
			sleep(60); // Delay per 1 menit
		}
	}
}
