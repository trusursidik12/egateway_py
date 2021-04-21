<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\m_labjack_value;
use App\Models\m_measurement_log;
use App\Models\m_parameter;

class FormulaMeasurementLogs extends BaseCommand
{
	/**
	 * The Command's Group
	 *
	 * @var string
	 */
	protected $group = 'CodeIgniter';

	protected $parameters;
	protected $labjack_values;
	protected $measurement_logs;

	public function __construct()
	{
		$this->parameters =  new m_parameter();
		$this->labjack_values =  new m_labjack_value();
		$this->measurement_logs =  new m_measurement_log();
	}

	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'command:formula_measurement_logs';

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
		foreach ($this->labjack_values->findAll() as $labjack_value) {
			$labjack[$labjack_value->labjack_id][$labjack_value->ain_id] = $labjack_value->data;
		}

		foreach ($this->parameters->findAll() as $parameter) {
			@eval("\$data[$parameter->id] = $parameter->formula;");
			$measurement_logs = [
				"instrument_id" => $parameter->instrument_id,
				"parameter_id" => $parameter->id,
				"value" => ($data[$parameter->id] < 0) ? 0 : $data[$parameter->id],
				"unit_id" => $parameter->unit_id,
				"is_averaged" => 0
			];
			$this->measurement_logs->save($measurement_logs);
		}

		// echo json_encode($data);
	}
}
