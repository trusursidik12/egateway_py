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
	public function run(array $params)
	{
		$curl = service('curlrequest'); // Curl CI4 Service
		$paramModel = new m_parameter();
		$configModel = new m_configuration();
		$measurementLogModel = new m_measurement_log();
		$parameters = $paramModel->select("id,name, web_id")->findAll();
		$i=0;
		// $baseUrl = "http://localhost:8080";
		$baseUrl = "https://sorpimappp01/piwebapi";
		// Interval Request
		$interval = $configModel->select("interval_request")->find(1)->interval_request;
		$interval = 1;
		while(true){
			$dateI = date('i') * 1;
			if($dateI % ($interval != 0 ? $interval : 1) == 0){ // Check Error ModuloByZero
				foreach ($parameters as $param) {
					$webId = $param->web_id;
					$req = $curl->request('get', "{$baseUrl}/streams/{$webId}/value",[
						'headers' => [
							'Accept' => 'application/json'
						]
					]);
					if($req->getStatusCode()==200){
						$data = json_decode($req->getBody(),1);
						$measurement = [
							'instrument_id' => 1,
							'parameter_id' => $param->id,
							'value' => $data['Value'],
							'unit_id' => 1,
						];
						try{
							$measurementLogModel->save($measurement);
						}catch(Exception $e){
							echo $e->getMessage();
						}
					}
					sleep(1);
				}
			}
		}	
	}
}
