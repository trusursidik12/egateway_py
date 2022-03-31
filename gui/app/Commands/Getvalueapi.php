<?php

namespace App\Commands;

use App\Controllers\Parameter;
use App\Models\m_configuration;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class Getvalueapi extends BaseCommand
{
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
	protected $name = 'command:get_value_api';

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
	protected $response;
	protected $statusCode;

	public function getBody(){
		return $this->response;
	}
	public function getStatusCode(){
		return $this->statusCode;
	}
	public function requestData($url){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$this->response = curl_exec($curl);
		$this->statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		return $this;
	}
	public function run(array $params)
	{
		$curl = service('curlrequest'); // Curl CI4 Service
		$paramModel = new m_parameter();
		$configModel = new m_configuration();
		$measurementLogModel = new m_measurement_log();
		$parameters = $paramModel->select("id,name,instrument_id, unit_id, web_id")->findAll();
		$baseUrl = "http://localhost:8080";
		// $baseUrl = "https://sorpimappp01/piwebapi";
		// Interval Request
		$interval = 10; //Second
		while(true){
			$dateNow = date('Y-m-d\TH:i:s');
			$date10secAgo = date('Y-m-d\TH:i:s',strtotime('-10 second'));
			foreach ($parameters as $param) {
				$webId = $param->web_id;
				$url = "{$baseUrl}/streams/{$webId}/interpolated?startTime={$date10secAgo}Z&endTime={$dateNow}Z&interval=10s&selectedFields=Items.Timestamp;Items.Value";
				$req = $curl->request('get', $url,[
					'headers' => [
						'Accept' => 'application/json'
					],
					'verify' => false
				]);
				// $req = $this->requestData($url);
				if($req->getStatusCode()==200){
					$data = json_decode($req->getBody(),1);
					if(!is_array($data['Value'])){
						$measurement = [
							'instrument_id' => $param->instrument_id,
							'parameter_id' => $param->id,
							'value' => $data['Value'],
							'unit_id' => $param->unit_id,
							'xtimestamp' => $data['Timestamp'],
						];
						try{
							$measurementLogModel->save($measurement);
						}catch(Exception $e){
							echo $e->getMessage();
						}
					}					
				}
			}
		}	
		sleep($interval);
	}
}
