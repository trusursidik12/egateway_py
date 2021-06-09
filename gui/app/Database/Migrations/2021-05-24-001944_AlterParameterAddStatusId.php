<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParameterAddStatusId extends Migration
{
	public function up()
	{
		$this->forge->addColumn('parameters', ["status_id int not null AFTER caption;"]);
	}

	public function down()
	{
		$this->forge->dropColumn('parameters', 'status_id');
	}
}
