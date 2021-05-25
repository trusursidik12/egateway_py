<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterConfigurations20210525 extends Migration
{
	public function up()
	{
		$this->forge->dropColumn('configurations', 'oxygen_reference');
	}

	public function down()
	{
		$this->forge->addColumn('configurations', ["oxygen_reference double not null default '0' AFTER delay_sending;"]);
	}
}
