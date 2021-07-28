<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParameters20210728 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('parameters', ["sispek_code varchar(255) not null default '' AFTER instrument_id;"]);
	}

	public function down()
	{
		$this->forge->dropColumn('parameters', 'sispek_code');
	}
}
