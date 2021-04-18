<?php

namespace App\Database\Seeds;

class noc_operators extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['maintenance_item_ids' => '|30||32||39|', 'name' => 'BOSS ENJI', 'email' => 'bossenji@klhk.go.id', 'address' => 'klhk', 'city' => 'jakarta', 'province' => 'DKI-Jakarta', 'country' => 'Indonesia', 'phone' => '08999999', 'mobile_phone' => '08119100182'],
            ['maintenance_item_ids' => '|30|', 'name' => 'Miftah', 'email' => 'miftah@gmail.com', 'address' => 'dlh kota depok', 'city' => 'jakarta', 'province' => 'DKI-Jakarta', 'country' => 'Indonesia', 'phone' => '08999999', 'mobile_phone' => '988888888'],
        ];
        $this->db->table('noc_operators')->insertBatch($data);
    }
}
