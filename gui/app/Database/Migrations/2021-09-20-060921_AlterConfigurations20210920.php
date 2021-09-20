<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterConfigurations20210920 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('configurations', ["main_path varchar(255) not null default '' AFTER delay_sending;"]);
		$this->forge->addColumn('configurations', ["mysql_path varchar(255) not null default '' AFTER main_path;"]);
		$this->db->query("UPDATE configurations SET main_path='C:/WORKSPACE/eGateway_py/', mysql_path='D:/xampp/mysql/bin/' WHERE id='1'");
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('configurations', 'main_path');
		$this->forge->dropColumn('configurations', 'mysql_path');
	}
}
