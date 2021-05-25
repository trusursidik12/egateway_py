<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMeasurementLogs20210525 extends Migration
{
	public function up()
	{
		$this->db->query("ALTER TABLE measurement_logs ADD INDEX is_das_log (is_das_log)");
	}

	public function down()
	{
		//
	}
}
