<?php

namespace App\Models;

use CodeIgniter\Model;

class m_sispek extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'sispek';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
