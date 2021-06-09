<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMeasurementLogs20210521 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('measurement_logs', ["is_das_log smallint not null default '0' AFTER is_averaged;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('measurement_logs', 'is_das_log');
	}
}
