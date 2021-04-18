<?php

namespace App\Database\Seeds;

class menu_tickets extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['seqno' => '1', 'parent_id' => '7', 'name' => 'Tickets', 'url' => 'tickets', 'icon' => 'fa fa-clipboard-list'],
            ['seqno' => '32', 'parent_id' => '2', 'name' => 'NOC Operators', 'url' => 'noc_operators', 'icon' => 'fa fa-user-tag'],
            ['seqno' => '33', 'parent_id' => '2', 'name' => 'Ticket Categories', 'url' => 'ticket_categories', 'icon' => 'fa fa-list-alt'],
            ['seqno' => '5', 'parent_id' => '7', 'name' => 'Ticket Followups', 'url' => 'ticket_followups', 'icon' => 'fa fa-clipboard-check'],
        ];
        $this->db->table('a_menu')->insertBatch($data);
    }
}
