<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sispek extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'							=> ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'server'						=> ['type' => 'VARCHAR', 'constraint' => 100],
			'app_id'						=> ['type' => 'VARCHAR', 'constraint' => 100],
			'app_secret'					=> ['type' => 'VARCHAR', 'constraint' => 100],
			'api_get_token'					=> ['type' => 'VARCHAR', 'constraint' => 100],
			'api_get_kode_cerobong'			=> ['type' => 'VARCHAR', 'constraint' => 100],
			'api_get_parameter'				=> ['type' => 'VARCHAR', 'constraint' => 100],
			'api_post_data'					=> ['type' => 'VARCHAR', 'constraint' => 100],
			'api_response_kode_cerobong'	=> ['type' => 'TEXT'],
			'api_response_parameter'		=> ['type' => 'TEXT'],
			'token'							=> ['type' => 'VARCHAR', 'constraint' => 255],
			'token_expired'					=> ['type' => 'DATETIME'],
			'xtimestamp timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()'
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('sispek', TRUE);

		$this->db->query("INSERT INTO sispek (id,server,app_id,app_secret,api_get_token,api_get_kode_cerobong,api_get_parameter,api_post_data) VALUES (1,'https://ditppu.menlhk.go.id/sispekv2/','PT_RAPP','R2h2s12123','api/v2/token','api/v2/cerobong','api/v2/parameter','api/v2/submit');");
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('sispek');
	}
}
