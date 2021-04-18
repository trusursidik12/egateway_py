<?php

namespace App\Database\Seeds;

class ticket_categories extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Kelistrikan'],
            ['name' => 'Mini PC'],
            ['name' => 'Sensor'],
            ['name' => 'Labjack'],
            ['name' => 'Partikulat'],
            ['name' => 'Pompa'],
            ['name' => 'AC'],
            ['name' => 'UPS'],
            ['name' => 'Stabilizer'],
            ['name' => 'Grounding'],
            ['name' => 'USB Hub'],
            ['name' => 'USB Converter'],
            ['name' => 'Console Weather Station'],
            ['name' => 'Weather Sensor'],
            ['name' => 'Silica Gel'],
            ['name' => 'Software'],
            ['name' => 'Driver'],
            ['name' => 'Shelter'],
            ['name' => 'Penerangan'],
            ['name' => 'CCTV/DVR'],
        ];
        $this->db->table('ticket_categories')->insertBatch($data);
    }
}
