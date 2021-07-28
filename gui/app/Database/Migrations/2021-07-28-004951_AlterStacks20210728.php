<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStacks20210728 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('stacks', ["sispek_code varchar(255) not null default '' AFTER code;"]);
	}

	public function down()
	{
		$this->forge->dropColumn('stacks', 'sispek_code');
	}
}
