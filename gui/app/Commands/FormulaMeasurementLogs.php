<?php

namespace App\Commands;

use App\Models\m_configuration;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\m_labjack_value;
use App\Models\m_measurement;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use App\Models\m_system_check;

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
	protected $configurations;
	protected $lastPutData;
	protected $system_checks;

	public function __construct()
	{
		$this->parameters =  new m_parameter();
		$this->labjack_values =  new m_labjack_value();
		$this->measurement_logs =  new m_measurement_log();
		$this->configurations =  new m_configuration();
		$this->measurements =  new m_measurement();
		$this->lastPutData = "0000-00-00 00:00";
		$this->system_checks = new m_system_check();
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

	public function get_measurement_logs_range($minute)
	{
		$id_end = @$this->measurement_logs->orderBy("id DESC")->findAll()[0]->id;
		$lasttime = date("Y-m-d H:i:%", mktime(date("H"), date("i") - $minute));
		$mm = date("i") * 1;
		$current_time = date("Y-m-d H:i");
		if ($mm % $minute == 0 && $this->lastPutData != $current_time) {
			$id_start = @$this->measurement_logs->where("xtimestamp >= '" . $lasttime . ":00'")->where("is_averaged", 0)->orderBy("id")->findAll()[0]->id;
			if ($id_start > 0) {
				$measurement_logs = $this->measurement_logs->where("id BETWEEN '" . $id_start . "' AND '" . $id_end . "'")->where("is_averaged", 0)->findAll();
				$return["id_start"] = $id_start;
				$return["id_end"] = $id_end;
				$return["waktu"] = $current_time . ":00";
				$return["data"] = $measurement_logs;
				return $return;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function measurements_averaging()
	{
		$configuration = $this->configurations->where("id", 1)->findAll()[0];
		$measurement_logs = $this->get_measurement_logs_range($configuration->interval_average);
		if ($measurement_logs != 0) {
			foreach ($measurement_logs["data"] as $measurement_log) {
				@$instrument_id[$measurement_log->parameter_id] = $measurement_log->instrument_id;
				@$total[$measurement_log->parameter_id] += $measurement_log->value;
				@$numdata[$measurement_log->parameter_id]++;
			}
			foreach ($this->parameters->findAll() as $parameter) {
				if (@$numdata[$parameter->id] > 0) {
					$measurements = [
						"instrument_id" => $instrument_id[$parameter->id],
						"time_group" => $measurement_logs["waktu"],
						"measured_at" => $measurement_logs["waktu"],
						"parameter_id" => $parameter->id,
						"value" => $total[$parameter->id] / $numdata[$parameter->id],
						"unit_id" => $parameter->unit_id,
						"created_at" => date("Y-m-d H:i:s"),
						"created_by" => "",
						"created_ip" => "127.0.0.1",
						"updated_at" => date("Y-m-d H:i:s"),
						"updated_by" => "",
						"updated_ip" => "127.0.0.1",
					];
					$this->measurements->save($measurements);
				}
			}
			$this->measurement_logs->set(["is_averaged" => 1])->where("id BETWEEN '" . $measurement_logs["id_start"] . "' AND '" . $measurement_logs["id_end"] . "'")->update();
			$this->lastPutData = date("Y-m-d H:i");
		}
	}

	public function run(array $params)
	{
		$system_name = "formula_measurement_logs";
		$system_checks_id = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->id * 1;
		if ($system_checks_id <= 0) {
			$this->system_checks->save(["system" => $system_name, "status" => "1"]);
			$system_checks_id = $this->system_checks->insertID();
		} else
			$this->system_checks->update($system_checks_id, ["status" => "1"]);

		$is_looping = 1;

		while ($is_looping) {
			$this->measurement_logs->where("(is_averaged = 1 AND xtimestamp < ('" . date("Y-m-d H:i:s") . "' - INTERVAL 6 HOUR))")->delete();

			foreach ($this->labjack_values->findAll() as $labjack_value) {
				$labjack[$labjack_value->labjack_id][$labjack_value->ain_id] = $labjack_value->data;
			}

			foreach ($this->parameters->findAll() as $parameter) {
				@eval("\$data[$parameter->id] = $parameter->formula;");
				$labjack_value = @$this->labjack_values->where("id", $parameter->labjack_value_id)->findAll()[0];
				$voltage = @$labjack[@$labjack_value->labjack_id * 1][@$labjack_value->ain_id * 1] * 1;
				//"value" => ($data[$parameter->id] < 0) ? 0 : $data[$parameter->id],
				$measurement_logs = [
					"instrument_id" => $parameter->instrument_id,
					"parameter_id" => $parameter->id,
					"value" => $data[$parameter->id],
					"voltage" => $voltage,
					"unit_id" => $parameter->unit_id,
					"is_averaged" => 0
				];
				$this->measurement_logs->save($measurement_logs);
			}
			sleep(1);
			$is_looping = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->status;
		}
	}
}
