<?php

namespace App\Database\Seeds;

class s_20210217_regionals extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE regionals");
        $data = [
            ['name' => 'REGIONAL 1'],
            ['name' => 'REGIONAL 2'],
            ['name' => 'REGIONAL 3'],
            ['name' => 'REGIONAL 4'],
            ['name' => 'REGIONAL 5'],
        ];
        $this->db->table('regionals')->insertBatch($data);
    }
}
