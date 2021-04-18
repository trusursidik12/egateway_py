<?php

namespace App\Database\Seeds;

class s_20210217_provinces extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->db->query("TRUNCATE provinces");
        $data = [
            ['regional_id' => 1, 'name' => 'DKI Jakarta'],
            ['regional_id' => 1, 'name' => 'Bogor'],
            ['regional_id' => 1, 'name' => 'Tanggerang'],
            ['regional_id' => 1, 'name' => 'Depok'],
            ['regional_id' => 1, 'name' => 'Bekasi'],
            ['regional_id' => 2, 'name' => 'Banten'],
            ['regional_id' => 2, 'name' => 'Jawa Barat'],
            ['regional_id' => 2, 'name' => 'Jawa Tengah'],
            ['regional_id' => 2, 'name' => 'Jawa Timur'],
            ['regional_id' => 2, 'name' => 'DI Yogyakarta'],
            ['regional_id' => 3, 'name' => 'Bali'],
            ['regional_id' => 3, 'name' => 'DI Aceh'],
            ['regional_id' => 3, 'name' => 'Bengkulu'],
            ['regional_id' => 3, 'name' => 'Gorontalo'],
            ['regional_id' => 3, 'name' => 'Jambi'],
            ['regional_id' => 3, 'name' => 'Sumatera Barat'],
            ['regional_id' => 3, 'name' => 'Sumatera Selatan'],
            ['regional_id' => 3, 'name' => 'Sumatera Utara'],
            ['regional_id' => 3, 'name' => 'Riau'],
            ['regional_id' => 3, 'name' => 'Lampung'],
            ['regional_id' => 3, 'name' => 'Kalimantan Barat'],
            ['regional_id' => 3, 'name' => 'Kalimantan Selatan'],
            ['regional_id' => 3, 'name' => 'Kalimantan Tengah'],
            ['regional_id' => 3, 'name' => 'Kalimanta Timur'],
            ['regional_id' => 4, 'name' => 'Kepulauan Bangka Belitung'],
            ['regional_id' => 4, 'name' => 'Kepulauan Riau'],
            ['regional_id' => 4, 'name' => 'Maluku'],
            ['regional_id' => 4, 'name' => 'Maluku Utara'],
            ['regional_id' => 4, 'name' => 'Sulawesi Barat'],
            ['regional_id' => 4, 'name' => 'Sulawesi Selatan'],
            ['regional_id' => 4, 'name' => 'Sulawesi Tengah'],
            ['regional_id' => 4, 'name' => 'Sulawesi Tenggara'],
            ['regional_id' => 4, 'name' => 'Sulawesi Utara'],
            ['regional_id' => 4, 'name' => 'Nusa Tenggara Barat'],
            ['regional_id' => 4, 'name' => 'Nusa Tenggara Timur'],
            ['regional_id' => 5, 'name' => 'Papua'],
            ['regional_id' => 5, 'name' => 'Kalimantan Utara'],
            ['regional_id' => 5, 'name' => 'Papua Barat'],
        ];
        $this->db->table('provinces')->insertBatch($data);
    }
}
