<?php

namespace App\Database\Seeds;

class facilities extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Ruang Meeting', 'description' => 'Ruang meeting'],
            ['name' => 'Kendaraan', 'description' => 'Kendaraan berupa motor maupun mobil'],
        ];
        $this->db->table('facility_types')->insertBatch($data);

        $data = [
            ['facility_type_id' => '1', 'name' => 'Ruang Meeting Workshop', 'description' => 'Ruang meeting di gedung workshop lt.2'],
            ['facility_type_id' => '1', 'name' => 'Ruang Meeting Laboratory', 'description' => 'Ruang meeting di gedung laboratory lt.1'],
            ['facility_type_id' => '2', 'name' => 'Panther B 1234 TRX', 'description' => 'Kendaraan operasional Panther'],
        ];
        $this->db->table('facilities')->insertBatch($data);
    }
}
