<?php

namespace App\Database\Seeds;

class employee_statuses extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'PKWTT'],
            ['name' => 'PKWT'],
            ['name' => 'Freelance'],
            ['name' => 'Magang'],
        ];
        $this->db->table('employee_statuses')->insertBatch($data);
    }
}
