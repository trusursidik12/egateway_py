<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParameters20210418 extends Migration
{
	public function up()
	{
		$this->forge->dropTable('parameters');
		$this->forge->addField([
			'id'				=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'instrument_id'		=> ['type' => 'INT', 'default' => '0'],
			'name'				=> ['type' => 'VARCHAR', 'constraint' => 100],
			'caption'			=> ['type' => 'VARCHAR', 'constraint' => 100],
			'p_type'			=> ['type' => 'VARCHAR', 'constraint' => 20],
			'unit_id'			=> ['type' => 'INT', 'default' => '0'],
			'molecular_mass'	=> ['type' => 'DOUBLE', 'default' => '0'],
			'formula'			=> ['type' => 'VARCHAR', 'constraint' => 255],
			'is_view'			=> ['type' => 'SMALLINT', 'default' => '0'],
			'is_graph'			=> ['type' => 'SMALLINT', 'default' => '0'],
			'labjack_value_id'	=> ['type' => 'INT', 'default' => '0'],
			'voltage1'			=> ['type' => 'DOUBLE', 'default' => '0'],
			'voltage2'			=> ['type' => 'DOUBLE', 'default' => '0'],
			'concentration1'	=> ['type' => 'DOUBLE', 'default' => '0'],
			'concentration2'	=> ['type' => 'DOUBLE', 'default' => '0'],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('instrument_id');
		$this->forge->createTable('parameters', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('parameters');
	}
}
