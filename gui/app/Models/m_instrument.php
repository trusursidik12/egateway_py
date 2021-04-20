<?php

namespace App\Models;

use CodeIgniter\Model;

class m_instrument extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'instruments';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
