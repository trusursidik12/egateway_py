<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class S20210428MenuVoltages extends Seeder
{
	public function run()
	{
		$this->db->query("DELETE FROM a_menu WHERE id = 12");

		$data = [
			['id' => '12', 'seqno' => '4', 'parent_id' => '2', 'name' => 'Voltages', 'url' => 'labjack/voltages', 'icon' => 'fa fa-bolt'],
		];
		$this->db->table('a_menu')->insertBatch($data);
	}
}
