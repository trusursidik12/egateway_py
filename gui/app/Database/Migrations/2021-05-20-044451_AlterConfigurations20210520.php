<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterConfigurations20210520 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('configurations', ["interval_das_logs int not null default '0' AFTER interval_retry;"]);
		$this->forge->addColumn('configurations', ["oxygen_reference double not null default '0' AFTER delay_sending;"]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('configurations', 'interval_das_logs');
		$this->forge->dropColumn('configurations', 'oxygen_reference');
	}
}
