<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DasLogs extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'					=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'instrument_id'			=> ['type' => 'INT', 'default' => '0'],
			'instrument_status_id'	=> ['type' => 'INT', 'default' => '0'],
			'data_status_id'		=> ['type' => 'INT', 'default' => '0'],
			'time_group'			=> ['type' => 'datetime'],
			'measured_at'			=> ['type' => 'datetime'],
			'parameter_id'			=> ['type' => 'INT', 'default' => '0'],
			'value'					=> ['type' => 'DOUBLE', 'default' => '0'],
			'value_correction'		=> ['type' => 'DOUBLE', 'default' => '0'],
			'unit_id'				=> ['type' => 'INT', 'default' => '0'],
			'validation_id'			=> ['type' => 'INT', 'default' => '0'],
			'condition_id'			=> ['type' => 'INT', 'default' => '0'],
			'is_averaged'			=> ['type' => 'SMALLINT', 'default' => '0'],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('instrument_id');
		$this->forge->addKey('instrument_status_id');
		$this->forge->addKey('data_status_id');
		$this->forge->addKey('time_group');
		$this->forge->addKey('measured_at');
		$this->forge->addKey('parameter_id');
		$this->forge->addKey('validation_id');
		$this->forge->addKey('condition_id');
		$this->forge->addKey('is_averaged');
		$this->forge->createTable('das_logs', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('das_logs');
	}
}
