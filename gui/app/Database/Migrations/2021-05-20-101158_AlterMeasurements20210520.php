<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterMeasurements20210520 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('measurements', ["value_correction DOUBLE not null default '0' AFTER value;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('measurements', 'value_correction');
	}
}
