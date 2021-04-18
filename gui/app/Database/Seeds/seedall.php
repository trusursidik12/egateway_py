<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class seedall extends Seeder
{
        public function run()
        {
                $this->call('s_20120217_job_titles');
                $this->call('s_20210217_menu_employees');
                $this->call('s_20210217_regionals');
                $this->call('s_20210217_provinces');
                $this->call('s_20210217_btr_allowances');
                $this->call('s_20210309_banks');
        }
}
