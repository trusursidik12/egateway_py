<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParameters20210525 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('parameters', ["stack_id" => ["type" => "int", 'null' => true, 'default' => '0', 'after' => 'id']]);
		$this->db->query("ALTER TABLE parameters ADD INDEX stack_id (stack_id)");
	}

	public function down()
	{
		$this->forge->dropColumn('parameters', 'stack_id');
	}
}
