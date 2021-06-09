<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LabjackValueHistories extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=> ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
			'labjack_value_id'	=> ['type' => 'BIGINT', 'default' => '0'],
			'data'				=> ['type' => 'DOUBLE', 'default' => '0'],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('labjack_value_id');
		$this->forge->createTable('labjack_value_histories', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('labjack_value_histories');
	}
}
