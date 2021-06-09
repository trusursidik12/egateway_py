<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMeasurementLogs20210425 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('measurement_logs', ["voltage double not null default '0' AFTER value;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('measurement_logs', 'voltage');
	}
}
