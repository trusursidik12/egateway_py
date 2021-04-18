<?php

namespace App\Database\Seeds;

class s_20210217_menu_employees extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $builder = $this->db->table('a_menu');
        $builder->set('url', 'employees');
        $builder->set('icon', 'fa fa-id-card-alt');
        $builder->where('id', 38);
        $builder->update();
    }
}