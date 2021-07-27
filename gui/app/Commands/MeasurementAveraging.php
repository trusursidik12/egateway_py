<?php

namespace App\Commands;

use App\Models\m_configuration;
use App\Models\m_instrument;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\m_labjack_value;
use App\Models\m_measurement;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use App\Models\m_stack;
use App\Models\m_system_check;

class MeasurementAveraging extends BaseCommand
{
	/**
	 * The Command's Group
	 *
	 * @var string
	 */
	protected $group = 'CodeIgniter';

	protected $parameters;
	protected $instruments;
	protected $labjack_values;
	protected $measurement_logs;
	protected $configurations;
	protected $system_checks;
	protected $stacks;
	// protected $file;

	public function __construct()
	{
		$this->parameters =  new m_parameter();
		$this->instruments = new m_instrument();
		$this->labjack_values =  new m_labjack_value();
		$this->measurement_logs =  new m_measurement_log();
		$this->configurations =  new m_configuration();
		$this->measurements =  new m_measurement();
		$this->system_checks = new m_system_check();
		$this->stacks = new m_stack();
		// $file = new \CodeIgniter\Files\File("../../measurement_averaging_log.txt");
		// $this->file = $file->openFile('w');
	}
	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'command:measurement_averaging';

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
		$lasttime = date("Y-m-d H:i", mktime(date("H"), date("i") - $minute));
		$mm = date("i") * 1;
		$current_time = date("Y-m-d H:i") . ":00";
		$lastPutData = @$this->measurements->orderBy("time_group DESC")->findAll()[0]->time_group;
		if ($mm % $minute == 0 && $lastPutData != $current_time) {
			$id_start = @$this->measurement_logs->where("xtimestamp >= '" . $lasttime . ":00'")->where("is_averaged", 0)->orderBy("id")->findAll()[0]->id;
			if ($id_start > 0) {
				$measurement_logs = $this->measurement_logs->where("id BETWEEN '" . $id_start . "' AND '" . $id_end . "'")->where("is_averaged", 0)->findAll();
				$return["id_start"] = $id_start;
				$return["id_end"] = $id_end;
				$return["waktu"] = $current_time;
				$return["data"] = $measurement_logs;
				return $return;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function get_oxygen_value($parameter_id, $time_group)
	{
		$parameter = @$this->parameters->where("id", $parameter_id)->findAll()[0];
		$oxygen_parameter_id = @$this->parameters->where(["stack_id" => $parameter->stack_id, "p_type" => "o2"])->findAll()[0]->id;
		return @$this->measurements->where(["time_group" => $time_group, "parameter_id" => $oxygen_parameter_id])->findAll()[0]->value;
	}

	public function measurements_value_correction($time_group)
	{
		foreach ($this->parameters->findAll() as $parameter) {
			$measurement = @$this->measurements->where(["time_group" => $time_group, "parameter_id" => $parameter->id])->findAll()[0];
			$correction = @$measurement->value;
			if ($parameter->p_type == 'main') {
				if (!isset($oxygen_value[$parameter->stack_id]))
					$oxygen_value[$parameter->stack_id] = @$this->get_oxygen_value($parameter->id, $time_group);
				if (!isset($oxygen_reference[$parameter->stack_id]))
					$oxygen_reference[$parameter->stack_id] = @$this->stacks->where("id", $parameter->stack_id)->findAll()[0]->oxygen_reference * 1;

				try {
					$correction = @$measurement->value * (21 - $oxygen_reference[$parameter->stack_id]) / (21 - $oxygen_value[$parameter->stack_id]);
				} catch (\Exception $e) {
					$correction = 0;
				}
			}

			if (@$measurement->id > 0)
				$this->measurements->update($measurement->id, ["value_correction" => round($correction)]);
		}
	}

	public function measurements_averaging()
	{
		$correcting = false;
		$configuration = $this->configurations->where("id", 1)->findAll()[0];
		$measurement_logs = $this->get_measurement_logs_range($configuration->interval_average);
		if ($measurement_logs != 0) {
			foreach ($measurement_logs["data"] as $measurement_log) {
				@$instrument_id[$measurement_log->parameter_id] = $measurement_log->instrument_id;
				@$total[$measurement_log->parameter_id] += $measurement_log->value;
				@$numdata[$measurement_log->parameter_id]++;
			}
			foreach ($this->parameters->findAll() as $parameter) {
				$correcting = true;
				if (@$numdata[$parameter->id] > 0) {
					$measurements = [
						"instrument_id" => $instrument_id[$parameter->id],
						"time_group" => $measurement_logs["waktu"],
						"measured_at" => $measurement_logs["waktu"],
						"parameter_id" => $parameter->id,
						"value" => round($total[$parameter->id] / $numdata[$parameter->id], 2),
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
			if ($correcting)
				$this->measurements_value_correction($measurement_logs["waktu"]);
		}
	}

	public function run(array $params)
	{
		$system_name = "measurement_averaging";
		$system_checks_id = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->id * 1;
		if ($system_checks_id <= 0) {
			$this->system_checks->save(["system" => $system_name, "status" => "1"]);
			$system_checks_id = $this->system_checks->insertID();
		} else
			$this->system_checks->update($system_checks_id, ["status" => "1"]);

		$is_looping = 1;

		while ($is_looping) {
			$this->measurements_averaging();
			sleep(1);
			$is_looping = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->status;
		}
	}
}
