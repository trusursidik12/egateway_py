<?php

namespace App\Commands;

use App\Models\m_configuration;
use App\Models\m_instrument;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\m_labjack_value;
use App\Models\m_das_log;
use App\Models\m_measurement_log;
use App\Models\m_parameter;
use App\Models\m_stack;
use App\Models\m_system_check;

class MeasurementDasLog extends BaseCommand
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
	protected $das_logs;
	protected $system_checks;
	protected $stacks;

	public function __construct()
	{
		$this->parameters =  new m_parameter();
		$this->instruments = new m_instrument();
		$this->labjack_values =  new m_labjack_value();
		$this->measurement_logs =  new m_measurement_log();
		$this->configurations =  new m_configuration();
		$this->das_logs =  new m_das_log();
		$this->system_checks = new m_system_check();
		$this->stacks = new m_stack();
	}

	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'command:measurement_das_log';

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
		$lastPutData = @$this->das_logs->orderBy("time_group DESC")->findAll()[0]->time_group;
		if ($mm % $minute == 0 && $lastPutData != $current_time) {
			$id_start = @$this->measurement_logs->where("xtimestamp >= '" . $lasttime . ":00'")->where("is_das_log", 0)->orderBy("id")->findAll()[0]->id;
			if ($id_start > 0) {
				$measurement_logs = $this->measurement_logs->where("id BETWEEN '" . $id_start . "' AND '" . $id_end . "'")->where("is_das_log", 0)->findAll();
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
		return @$this->das_logs->where(["time_group" => $time_group, "parameter_id" => $oxygen_parameter_id])->findAll()[0]->value;
	}

	public function das_log_value_correction($time_group)
	{
		foreach ($this->parameters->findAll() as $parameter) {
			$das_log = @$this->das_logs->where(["time_group" => $time_group, "parameter_id" => $parameter->id])->findAll()[0];
			$correction = @$das_log->value;
			if ($parameter->p_type == 'main') {
				if (!isset($oxygen_value[$parameter->stack_id]))
					$oxygen_value[$parameter->stack_id] = @$this->get_oxygen_value($parameter->id, $time_group);
				if (!isset($oxygen_reference[$parameter->stack_id]))
					$oxygen_reference[$parameter->stack_id] = @$this->stacks->where("id", $parameter->stack_id)->findAll()[0]->oxygen_reference * 1;

				try {
					$correction = @$das_log->value * (21 - $oxygen_reference[$parameter->stack_id]) / (21 - $oxygen_value[$parameter->stack_id]);
				} catch (\Exception $e) {
					$correction = 0;
				}
			}

			if (@$das_log->id > 0)
				$this->das_logs->update($das_log->id, ["value_correction" => round($correction)]);
		}
	}

	public function measurements_das_log()
	{
		$correcting = false;
		$configuration = $this->configurations->where("id", 1)->findAll()[0];
		$measurement_logs = $this->get_measurement_logs_range($configuration->interval_das_logs);
		if ($measurement_logs != 0) {
			foreach ($measurement_logs["data"] as $measurement_log) {
				@$instrument_id[$measurement_log->parameter_id] = $measurement_log->instrument_id;
				@$total[$measurement_log->parameter_id] += $measurement_log->value;
				@$numdata[$measurement_log->parameter_id]++;
			}
			foreach ($this->parameters->findAll() as $parameter) {
				$correcting = true;
				if (@$numdata[$parameter->id] > 0) {
					$das_logs = [
						"instrument_id" => $instrument_id[$parameter->id],
						"instrument_status_id" => @$this->instruments->find($instrument_id[$parameter->id])->instrument_status_id * 1,
						"data_status_id" => @$this->parameters->find($parameter->id)->status_id * 1,
						"time_group" => $measurement_logs["waktu"],
						"measured_at" => $measurement_logs["waktu"],
						"parameter_id" => $parameter->id,
						"value" => round($total[$parameter->id] / $numdata[$parameter->id], 2),
						"unit_id" => $parameter->unit_id,
					];
					$this->das_logs->save($das_logs);
				}
			}
			$this->measurement_logs->set(["is_das_log" => 1])->where("id BETWEEN '" . $measurement_logs["id_start"] . "' AND '" . $measurement_logs["id_end"] . "'")->update();
			if ($correcting)
				$this->das_log_value_correction($measurement_logs["waktu"]);
		}
	}

	public function run(array $params)
	{
		$system_name = "measurement_das_log";
		$system_checks_id = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->id * 1;
		if ($system_checks_id <= 0) {
			$this->system_checks->save(["system" => $system_name, "status" => "1"]);
			$system_checks_id = $this->system_checks->insertID();
		} else
			$this->system_checks->update($system_checks_id, ["status" => "1"]);

		$is_looping = 1;

		while ($is_looping) {
			$this->measurements_das_log();
			sleep(1);
			$is_looping = @$this->system_checks->where(["system" => $system_name])->findAll()[0]->status;
		}
	}
}
