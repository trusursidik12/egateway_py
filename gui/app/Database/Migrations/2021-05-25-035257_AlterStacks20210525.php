<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStacks20210525 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('stacks', ["oxygen_reference double not null default '0' AFTER lat;"]);
	}

	public function down()
	{
		$this->forge->dropColumn('stacks', 'oxygen_reference');
	}
}
