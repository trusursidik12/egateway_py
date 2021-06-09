<?php

namespace App\Models;

use CodeIgniter\Model;

class m_system_check extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'system_checks';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
