<?php

namespace App\Database\Seeds;

class ticket_severities extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['id' => '1','name' => 'Minor'],
            ['id' => '2','name' => 'Major'],
            ['id' => '3','name' => 'Critical'],
        ];
        $this->db->table('ticket_severities')->insertBatch($data);
    }
}
