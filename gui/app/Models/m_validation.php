<?php

namespace App\Models;

use CodeIgniter\Model;

class m_validation extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'validations';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
