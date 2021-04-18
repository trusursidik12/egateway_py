<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LabjackValues extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'labjack_id'		=> ['type' => 'INT', 'default' => '0'],
			'ain_id'			=> ['type' => 'INT', 'default' => '0'],
			'data'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('labjack_id');
		$this->forge->addKey('ain_id');
		$this->forge->createTable('labjack_values', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('labjack_values');
	}
}
