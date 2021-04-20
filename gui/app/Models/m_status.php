<?php

namespace App\Models;

use CodeIgniter\Model;

class m_status extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'statuses';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
