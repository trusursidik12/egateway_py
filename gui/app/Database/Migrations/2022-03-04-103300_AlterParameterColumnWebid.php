<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParameterColumnWebid extends Migration
{
	public function up()
	{
		$this->forge->addColumn('parameters', ["web_id" => ["type" => "varchar(255)", 'null' => true, 'default' => null, 'after' => 'instrument_id']]);
	}

	public function down()
	{
		$this->forge->dropColumn('parameters','web_id');
	}
}
