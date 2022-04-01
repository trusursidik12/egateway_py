<?php

namespace App\Commands;

use App\Models\m_das_log;
use App\Models\m_parameter;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Postvalueapi extends BaseCommand
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
	protected $name = 'command:post_value_api';

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
	protected $usage = 'command:post_value_api';

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
		// $curl = service('curlrequest'); // Curl CI4 Service
		$curl = \Config\Services::curlrequest([
			'verify' => false
		]);
		// $baseUrl = "http://localhost:8080";
		$baseUrl = "https://sorpimappp01/piwebapi";
		$Daslog = new m_das_log();
		while(true){
			$values = $Daslog
				->select('units.name as unit_name, parameters.web_id, parameters.max_value, das_logs.*')
				->join('parameters','parameter.id = das_logs.parameter_id')				
				->join('units','units.id = das_logs.unit_id')				
				->where(['das_logs.is_sent_cloud' => 1])
				->limit('100')->findAll();
			foreach ($values as  $value) {
				switch ($value->data_status_id) {
					case 2: // Abnormal
					case 3: // CAL_TEST
						$correction = 1;
						break;
					case 4: // BROKEN
						$correction = 0;
						break;
					
					default: // Normal
						$correction = $value->value_correction < 0 ? 0 : $value->value_correction;
						break;
				}
				$data['Timestamp'] = $this->getDateTime($value->xtimestamp, true);
				$data['UnitsAbbreviation'] = $value->unit_name;
				$data['Good'] = $this->isGood($value->max_value,$value->value_correction);
				$data['Questionable'] = !$data['Good'];
				$data['Value'] = $correction; 

				// Request
				$request = $curl->request('post', "{$baseUrl}/streams/{$value->web_id}/value",[
					'json' => $data
				]);
				if($request->getStatusCode == 202){ // is Accepted	
					$Daslog->find($value->id)->delete(); // Delete if success sent PI server
				}
			}
			sleep(60); // Sleep 1 minute
		}
	}

	public function isGood($maxValue, $valueCorrection){
		if($valueCorrection <= 0) {
			return false;
		}
		return ($valueCorrection > $maxValue) ? false : true;
	}
}
