<?php

namespace App\Commands;

use App\Models\m_configuration;
use App\Models\m_measurement;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Sentdata extends BaseCommand
{

	public function __construct()
	{
		$this->measurements = new m_measurement();
		$this->configurations = new m_configuration();
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
	protected $name = 'command:sentdata';

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
		//CURL
		$mData = @$this->measurements->where(["is_sent_cloud" => 0])->orderBy("id DESC")->findAll()[0];
		$cnfig = @$this->configurations->findAll()[0];

		if (!empty($mData)) {
			/* Data */
			$data =
				[
					'egateway_code' => $cnfig->egateway_code,
					'measured_at' => $mData->measured_at,
					'client_parameter_id' => $mData->parameter_id,
					'value' => $mData->value,
					'unit_id' => $mData->unit_id,
					'is_sent' => $mData->is_sent_klhk,
					'sent_type' => $mData->sent_klhk_type,
					'sent_by' => $mData->sent_klhk_by,
					'sent_at' => $mData->sent_klhk_at,
					'sent_tries' => $mData->sent_klhk_tries,
				];

			$dEncode = http_build_query($data);

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://ispumaps.id/egateway_server/public/api/send/measurement',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $dEncode,
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUSEVfQ0xBSU0iLCJhdWQiOiJUSEVfQVVESUVOQ0UiLCJpYXQiOjE2MTk0OTM0NDMsIm5iZiI6MTYxOTQ5MzQ1MywiZXhwIjozODU1Mjk2NTIzLCJkYXRhIjp7ImlkIjoiMSIsImNsaWVudG5hbWUiOiJSQVBQIiwiZW1haWwiOiJyYXBwQHRydXN1ci5jb20ifX0.AZxn_k5GxkiTjk3pXv-KJQcyCbjl-F570ldhWhNtDms',
					'Content-Type: application/x-www-form-urlencoded'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$result = json_decode($response, true);

			if ($result['status'] == 200) {
				$this->measurements->update($mData->id, ['is_sent_cloud' => 1]);
			}
			print_r($response);
		}
	}
}
