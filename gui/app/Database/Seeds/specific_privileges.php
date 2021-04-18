<?php

namespace App\Database\Seeds;

class specific_privileges extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'request_review_edit_after_approved', 'denied_message' => ''],
            ['name' => 'request_review_lab_staff_only', 'denied_message' => ''],
            ['name' => 'calibration_form_edit_after_approved', 'denied_message' => ''],
            ['name' => 'calibration_form_lab_leader_only', 'denied_message' => ''],
        ];
        $this->db->table('specific_privileges')->insertBatch($data);
    }
}
