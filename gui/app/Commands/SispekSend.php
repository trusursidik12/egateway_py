<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\m_configuration;
use App\Models\m_sispek;
use App\Models\m_measurement;
use App\Models\m_das_log;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use App\Models\m_stack;
use App\Models\m_system_check;

class SispekSend extends BaseCommand
{
	protected $configurations;
	protected $sispek;
	protected $measurements;
	protected $das_logs;
	protected $measurement_logs;
	protected $parameters;
	protected $stacks;
	protected $system_checks;

	public function __construct()
	{
		$this->configurations =  new m_configuration();
		$this->measurements = new m_measurement();
		$this->das_logs = new m_das_log();
		$this->measurement_logs = new m_measurement_log();
		$this->parameters = new m_parameter();
		$this->stacks = new m_stack();
		$this->sispek = new m_sispek();
		$this->system_checks = new m_system_check();
	}
	/**
	 * The Command's Group
	 *
	 * @var string
	 */
	protected $group = 'CodeIgniter';

	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'command:sispeksend';

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

	/**
	 * Actually execute a command.
	 *
	 * @param array $params
	 */


	public function getToken()
	{
		$sispek = $this->sispek->find(1);
		$sispek_server = $sispek->server;
		$url = $sispek->api_get_token;
		$app_id = $sispek->app_id;
		$app_secret = $sispek->app_secret;
		$data = json_encode(["app_id" => $app_id, "app_pwd_hash" => md5($app_secret . $app_id)]);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $sispek_server . $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));

		$response = curl_exec($curl);
		// $token = json_decode($response, true)["response"]["token"];
		$token = json_decode($response, true)["token"];

		$token_expired = date("Y-m-d H:i:s", mktime(date("H"), date("i") + 60));
		$this->sispek->update("1", ["token" => $token, "token_expired" => $token_expired]);
		return $response;
	}

	public function getKodeCerobong()
	{

		$sispek = $this->sispek->find(1);
		$token = $sispek->token;
		$sispek_server = $sispek->server;
		$url = $sispek->api_get_kode_cerobong;
		$data = json_encode(["Key" => "Bearer " . $token]);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $sispek_server . $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $token,
				"Api-Key: Bearer " . $token,
				"key: Bearer " . $token,
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));

		return curl_exec($curl);
	}

	public function getParameter($code_cerobong)
	{
		$sispek = $this->sispek->find(1);
		$token = $sispek->token;
		$sispek_server = $sispek->server;
		$url = $sispek->api_get_parameter;
		$data = json_encode(["Key" => "Bearer " . $token, "cerobong_kode" => $code_cerobong]);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $sispek_server . $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $token,
				"Api-Key: Bearer " . $token,
				"key: Bearer " . $token,
				"cache-control: no-cache",
				"content-type: application/json"
			),
		));

		return curl_exec($curl);
	}

	public function postSispek()
	{
		$sispek = $this->sispek->find(1);
		$token = $sispek->token;
		$sispek_server = $sispek->server;
		$url = $sispek->api_post_data;

		try {
			$data = $this->getdata();
			$das_log_ids = $data["das_log_ids"];
			$data = $data["data"];
			// $data = json_encode($data);
			$data = json_encode(["data" => $data]);

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $sispek_server . $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_HTTPHEADER => array(
					"Authorization: Bearer " . $token,
					"Api-Key: Bearer " . $token,
					"key: Bearer " . $token,
					"cache-control: no-cache",
					"content-type: application/json"
				),
			));


			$response = curl_exec($curl);
			// $message = json_decode($response, true)["response"]["message"];
			$message = json_decode($response, true)["message"];

			if (strtolower($message) == "sukses")
				$this->das_logs->update(array_values($das_log_ids), ["is_sent_sispek" => 1, "sent_sispek_at" => date("Y-m-d H:i:s")]);

			return $response;
		} catch (\Exception $e) {
			return "";
		}
	}

	public function getdata()
	{
		$nowhour = date("Y-m-d H:00:00");
		$interval = @$this->configurations->find(1)->interval_das_logs * 1;
		$data = [];
		$das_log_ids = [];
		try {
			$time_group = $this->das_logs->where(["is_sent_sispek" => 0, "time_group < " => $nowhour])->orderBy("time_group")->limit(1)->findAll()[0]->time_group;
			$time_group_like = substr($time_group, 0, 14);
			// CLI::write($time_group);
			// CLI::write($time_group_like);
			$timegroups = [];
			foreach ($this->das_logs->like("time_group", $time_group_like, 'after')->groupBy("time_group")->orderBy("time_group")->findAll() as $das_log) {
				$timegroups[] = $das_log->time_group;
			}

			foreach ($this->stacks->findAll() as $stack) {
				$parameters = $this->parameters->where(["stack_id" => $stack->id])->findAll();
				$_parameter = array();
				foreach ($timegroups as $timegroup) {
					$data_time_group = array();
					$data_time_group["waktu"] = $timegroup;
					foreach ($parameters as $parameter) {
						$das_log = @$this->das_logs->where(["time_group" => $timegroup, "parameter_id" => $parameter->id])->findAll();
						array_push($das_log_ids, @$das_log[0]->id);
						$value_correction = @$das_log[0]->value_correction * 1;
						if ($value_correction < 0) $value_correction = 0;
						$data_time_group[$parameter->sispek_code] = $value_correction;
					}
					$_parameter[] = $data_time_group;
				}
				$data[] = [
					"kode_cerobong" => $stack->sispek_code,
					"interval" => $interval,
					"parameter" => $_parameter
				];
			}
			return ["data" => $data, "das_log_ids" => $das_log_ids];
		} catch (\Exception $e) {
			return [];
		}
	}



	public function run(array $params)
	{
		// CLI::write($this->getToken());
		// CLI::write($this->getKodeCerobong());
		// CLI::write($this->getParameter("Kode Cerobong 1"));
		// exit();

		// CLI::write($this->getToken());
		// CLI::write($this->postSispek());
		// exit();

		$system_name = "sispeksend";
		$system_checks_id = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->id * 1;
		if ($system_checks_id <= 0) {
			$this->system_checks->save(["system" => $system_name, "status" => "1"]);
			$system_checks_id = $this->system_checks->insertID();
		} else
			$this->system_checks->update($system_checks_id, ["status" => "1"]);

		$is_looping = 1;

		while ($is_looping) {
			$this->getToken();
			$this->postSispek();
			sleep(60);
			$is_looping = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->status;
		}
	}
}
