<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DasLogs20210728 extends Migration
{
	public function up()
	{
		$this->forge->addColumn('das_logs', [
			'avg_time_group'	=> ['type' => 'datetime', 'null' => true, 'after' => 'is_averaged'],
			'is_sent_cloud'		=> ['type' => 'smallint', 'default' => '0', 'after' => 'avg_time_group'],
			'sent_cloud_at'		=> ['type' => 'datetime', 'null' => true, 'after' => 'is_sent_cloud'],
			'sent_cloud_by'		=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => '', 'after' => 'sent_cloud_at'],
			'is_sent_sispek'	=> ['type' => 'smallint', 'default' => '0', 'after' => 'sent_cloud_by'],
			'sent_sispek_at'	=> ['type' => 'datetime', 'null' => true, 'after' => 'is_sent_sispek'],
			'sent_sispek_by'	=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => '', 'after' => 'sent_sispek_at'],
		]);
		$this->db->query("ALTER TABLE das_logs ADD INDEX avg_time_group (avg_time_group)");
		$this->db->query("ALTER TABLE das_logs ADD INDEX is_sent_cloud (is_sent_cloud)");
		$this->db->query("ALTER TABLE das_logs ADD INDEX is_sent_sispek (is_sent_sispek)");
	}

	public function down()
	{
		$this->forge->dropColumn('das_logs', 'is_sent_cloud');
		$this->forge->dropColumn('das_logs', 'sent_cloud_at');
		$this->forge->dropColumn('das_logs', 'sent_cloud_by');
		$this->forge->dropColumn('das_logs', 'is_sent_sispek');
		$this->forge->dropColumn('das_logs', 'sent_sispek_at');
		$this->forge->dropColumn('das_logs', 'sent_sispek_by');
	}
}
