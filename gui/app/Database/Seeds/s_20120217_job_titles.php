<?php

namespace App\Database\Seeds;

class s_20120217_job_titles extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE job_titles");
        $data = [
            ['name' => 'Direktur Utama', 'management_level' => 'top'],
            ['name' => 'Direktur', 'management_level' => 'top'],
            ['name' => 'CEO', 'management_level' => 'top'],
            ['name' => 'CFO', 'management_level' => 'top'],
            ['name' => 'CMO', 'management_level' => 'top'],
            ['name' => 'CTO', 'management_level' => 'top'],
            ['name' => 'COO', 'management_level' => 'top'],
            ['name' => 'Manajer', 'management_level' => 'middle'],
            ['name' => 'Manager Maintenance', 'management_level' => 'middle'],
            ['name' => 'Manager Produksi', 'management_level' => 'middle'],
            ['name' => 'Project & IT Senior Manager', 'management_level' => 'middle'],
            ['name' => 'R&D Supervisor', 'management_level' => 'low'],
            ['name' => 'HCD Supervisor', 'management_level' => 'low'],
            ['name' => 'Supervisor Laboratorium Quality', 'management_level' => 'low'],
            ['name' => 'Supervisor Teknisi Kalibrasi', 'management_level' => 'low'],
            ['name' => 'Senior Supervisor Finance & Accounting', 'management_level' => 'low'],
            ['name' => 'Business Development Officer', 'management_level' => 'low'],
            ['name' => 'Procurement Officer', 'management_level' => 'low'],
            ['name' => 'Account Manager', 'management_level' => 'low'],
            ['name' => 'Teknisi Kalibrasi', 'management_level' => 'low'],
            ['name' => 'HC Administration', 'management_level' => 'low'],
            ['name' => 'R&D Staff', 'management_level' => 'low'],
            ['name' => 'Sales/Marketing Administration', 'management_level' => 'low'],
            ['name' => 'Sales/Marketing Supervisor', 'management_level' => 'low'],
            ['name' => 'Staff PPIC', 'management_level' => 'low'],
            ['name' => 'Staff Accounting & finance', 'management_level' => 'low'],
            ['name' => 'Staff GA', 'management_level' => 'low'],
            ['name' => 'Staff IT', 'management_level' => 'low'],
            ['name' => 'Staff Maintenance', 'management_level' => 'low'],
            ['name' => 'Customer Support', 'management_level' => 'low'],
            ['name' => 'Office Boy', 'management_level' => 'low'],
        ];
        $this->db->table('job_titles')->insertBatch($data);
    }
}
