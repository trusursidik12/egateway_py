<?php

namespace App\Models;

use CodeIgniter\Model;

class m_das_data extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'das_data';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
