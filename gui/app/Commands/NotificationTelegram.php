<?php

namespace App\Commands;

use App\Models\m_das_log;
use App\Models\m_instrument;
use App\Models\m_parameter;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class NotificationTelegram extends BaseCommand
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
	protected $name = 'command:notification_telegram';

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
	protected $usage = 'command:notification_telegram';

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

	public function sentToTelegram()
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
				$bakumutu[] =  $log->time_group." | ".@$instrument->name." | ".@$param->name ." : ". $log->value_correction ." ".strip_tags(@$param->unit_name). " | Baku Mutu : ". $param->max_value . " ".strip_tags(@$param->unit_name);
			}
			if ($log->notification == 2) {
				$nol[] = $log->time_group." | ".@$instrument->name." | ".@$param->name ." : ". $log->value_correction ." ".strip_tags(@$param->unit_name);
			}
			if ($log->notification == 3) {
				$tidakterkirim[] = $log->time_group." | ".@$instrument->name." | ".@$param->name ." : ". $log->value_correction ." ".strip_tags(@$param->unit_name) . "* Tidak terkirim *";
			}
			if ($log->notification == 4) {
				$bakumututidakterkirim[] =  $log->time_group." | ".@$instrument->name." | ".@$param->name ." : ". $log->value_correction ." ".strip_tags(@$param->unit_name). " | Baku Mutu : ". $param->max_value . " ".strip_tags(@$param->unit_name) . "* Tidak terkirim *";
			}
			if ($log->notification == 5) {
				$nolidakterkirim[] = $log->time_group." | ".@$instrument->name." | ".@$param->name ." : ". $log->value_correction ." ".strip_tags(@$param->unit_name) . "* Tidak terkirim *";
			}
		}

		$body = "* eGateway Notification System Failure * \n";
		$bodyCheck = false; // Initialize
		if(count($bakumutu) > 0){
			$bodyCheck = true;
			$body.="Melebihi Baku Mutu : \n";
			foreach ($bakumutu as $value) {
				$body.=$value."\n";
			}
		}
		if(count($nol) > 0){
			$bodyCheck = true;
			$body.="Parameter Nilai 0 / Minus : \n";
			foreach ($nol as $value) {
				$body.=$value."\n";
			}
		}
		if(count($tidakterkirim) > 0){
			$bodyCheck = true;
			$body.="Data tidak terkirim : \n";
			foreach ($tidakterkirim as $value) {
				$body.=$value."\n";
			}
		}
		if(count($bakumututidakterkirim) > 0){
			$bodyCheck = true;
			$body.="Parameter melebihi Baku Mutu yang tidak terkirim : \n";
			foreach ($bakumututidakterkirim as $value) {
				$body.=$value."\n";
			}
		}
		if(count($nolidakterkirim) > 0){
			$bodyCheck = true;
			$body.="Parameter nilai 0 / minus yang tidak terkirim : \n";
			foreach ($nolidakterkirim as $value) {
				$body.=$value."\n";
			}
		}

		if ($bodyCheck) { // Check if bodycheck true
			$token = '5105332646:AAEopPAOiaEEn_QkolgXPb-1MiVo9Dae0rQ';
			$chatId = '@smi_egateway_notification';
			if ($this->requestTelegram($token, $chatId, $body)) {
				$this->dasLog->set(['notification' => 6])->where("notification >= 1 AND notification <= 5 AND time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")->update();
				$this->dasLog->set(['notification' => 7])->where("notification = 0 AND time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")->update();
				echo 'berhasil kirim data notifikasi';
			}
		} else {
			$this->dasLog->set(['notification' => 7])->where("notification = 0 AND time_group >= '{$range['start']}' AND time_group <= '{$range['end']}'")->update();
			echo 'tidak ada data notifikasi';
		}
	}

	/**
	 * request to Telegram
	 *
	 * @param [type] $token
	 * @param [type] $chatId
	 * @param [type] $message
	 * @return void
	 */
	public function requestTelegram($token, $chatId, $message){
		$length = strlen($message);
		$maxAccepted = 4000;
		$maxSending = $length > $maxAccepted ? ceil($length / $maxAccepted) : 1;
		$maxSubstr = $length / $maxSending;
		for ($i=1; $i <= $maxSending; $i++) { 
			$init = $i == 1 ? 0 : ($maxSubstr * $i + 1);
			$text = substr($message, $init, ($maxSubstr * $i + 2));
			$text = str_replace('-','\\-',$text);
			$text = str_replace('|','\\|',$text);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.telegram.org/bot{$token}/sendMessage",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_POSTFIELDS => array('chat_id' => $chatId,'text' => $text, 'parse_mode' => 'MarkdownV2'),
			));
			$response = curl_exec($curl);
			$json = json_decode($response,1);
			curl_close($curl);
		}
		return $json['ok'];
		
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
			->select('id, parameter_id,instrument_id, value_correction, notification,data_status_id,is_sent_sispek,time_group')
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
			if(true){ // Check menit ke 30
				// check value correction
				$this->bakumutu();
				$this->zero();
				$this->failedToSend();
				$this->bakumutu_failedToSend();
				$this->zero_failedToSend();
				// sending notification
				// $this->sentToEmail();
				$this->sentToTelegram();
				exit();
			}
			sleep(60); // Delay per 1 menit
		}
	}
}
