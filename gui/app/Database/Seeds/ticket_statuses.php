<?php

namespace App\Database\Seeds;

class ticket_statuses extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['id' => '1','name' => 'Client -> Operator'],
            ['id' => '2','name' => 'Operator -> Dispatcher'],
            ['id' => '3','name' => 'Dispatcher -> PIC'],
            ['id' => '4','name' => 'Dispatcher -> Backoffice IT'],
            ['id' => '5','name' => 'Dispatcher -> Backoffice Maintenance'],
            ['id' => '6','name' => 'PIC -> Dispatcher'],
            ['id' => '7','name' => 'Backoffice IT -> Dispatcher'],
            ['id' => '8','name' => 'Backoffice Maintenance -> Dispatcher'],
            ['id' => '9','name' => 'Dispatcher -> Close'],
        ];
        $this->db->table('ticket_statuses')->insertBatch($data);
    }
}
