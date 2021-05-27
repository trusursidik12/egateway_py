<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class seedall extends Seeder
{
        public function run()
        {
                $this->call('S20210425Menu');
        }
}
