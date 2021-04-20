<?php

namespace App\Models;

use CodeIgniter\Model;

class m_stack extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'stacks';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
