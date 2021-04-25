<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class S20210425Menu extends Seeder
{
	public function run()
	{
		$this->db->query("TRUNCATE TABLE a_menu");
		$data = [
			['id' => '1', 'seqno' => '1', 'parent_id' => '0', 'name' => 'Home', 'url' => '', 'icon' => 'fas fa-home'],
			['id' => '2', 'seqno' => '2', 'parent_id' => '0', 'name' => 'Master', 'url' => '#', 'icon' => 'fa fa-database'],
			['id' => '3', 'seqno' => '3', 'parent_id' => '0', 'name' => 'Measurements', 'url' => 'measurements', 'icon' => 'fas fa-ruler'],
			['id' => '4', 'seqno' => '4', 'parent_id' => '0', 'name' => 'Stacks', 'url' => 'stacks', 'icon' => 'fa fa-industry'],
			['id' => '5', 'seqno' => '5', 'parent_id' => '0', 'name' => 'Instruments', 'url' => 'instruments', 'icon' => 'fas fa-vials'],
			['id' => '6', 'seqno' => '6', 'parent_id' => '0', 'name' => 'Parameters', 'url' => 'parameters', 'icon' => 'fas fa-prescription-bottle'],
			['id' => '7', 'seqno' => '7', 'parent_id' => '0', 'name' => 'Configurations', 'url' => 'configurations', 'icon' => 'fa fa-cog'],
			['id' => '8', 'seqno' => '8', 'parent_id' => '0', 'name' => 'Change Password', 'url' => 'changepassword', 'icon' => 'fas fa-key'],
			['id' => '9', 'seqno' => '1', 'parent_id' => '2', 'name' => 'Groups', 'url' => 'a_group', 'icon' => 'fas fa-users'],
			['id' => '10', 'seqno' => '2', 'parent_id' => '2', 'name' => 'Users', 'url' => 'a_user', 'icon' => 'far fa-user-circle'],
			['id' => '11', 'seqno' => '3', 'parent_id' => '2', 'name' => 'Labjacks', 'url' => 'labjacks', 'icon' => 'fas fa-key']
		];
		$this->db->table('a_menu')->insertBatch($data);
	}
}
