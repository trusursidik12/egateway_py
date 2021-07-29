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

class TestSispek extends BaseCommand
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
	protected $name = 'command:testsispek';

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
		try {
			// $token = json_decode($response, true)["response"]["token"];
			$token = json_decode($response, true)["token"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}

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


	public function run(array $params)
	{
		$response = $this->getToken();
		if ($params[0] == "token") {
			CLI::write($response);
			print_r(json_decode($response, true));
			// $sispek = $this->sispek->find(1);
			// CLI::write($sispek->token);
		}

		if ($params[0] == "cerobong") {
			$response = $this->getKodeCerobong();
			CLI::write($response);
			print_r(json_decode($response, true));
		}
		if ($params[0] == "parameter") {
			$response = CLI::write($this->getParameter($params[1]));
			CLI::write($response);
			print_r(json_decode($response, true));
		}
	}
}
