<?php

namespace App\Models;

use CodeIgniter\Model;

class m_condition extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'conditions';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
