<?php

namespace App\Database\Seeds;

class marriage_statuses extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'K0','description' => 'Kawin tidak menanggung anak'],
            ['name' => 'K1','description' => 'Kawin anak 1'],
            ['name' => 'K2','description' => 'Kawin anak 2'],
            ['name' => 'K3','description' => 'Kawin anak 3'],
            ['name' => 'TK0','description' => 'Tidak Kawin tidak menanggung anak'],
            ['name' => 'TK1','description' => 'Tidak Kawin anak 1'],
            ['name' => 'TK2','description' => 'Tidak Kawin anak 2'],
            ['name' => 'TK3','description' => 'Tidak Kawin anak 3'],
        ];
        $this->db->table('marriage_statuses')->insertBatch($data);
    }
}
