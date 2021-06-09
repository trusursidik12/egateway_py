<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStacks20210525 extends Migration
{
	public function up()
	{
		$this->forge->dropColumn('stacks', 'parameter_ids');
	}

	public function down()
	{
		$this->forge->addColumn('stacks', ["parameter_ids varchar(255) not null default '' AFTER code;"]);
	}
}
