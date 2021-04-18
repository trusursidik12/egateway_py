<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Labjacks extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'				=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'labjack_code'		=> ['type' => 'VARCHAR', 'constraint' => 30],
			'instrument_id'		=> ['type' => 'INT', 'default' => '0'],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('labjack_code');
		$this->forge->addKey('instrument_id');
		$this->forge->createTable('labjacks', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('labjacks');
	}
}
