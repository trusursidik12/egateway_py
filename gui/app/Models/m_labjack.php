<?php

namespace App\Models;

use CodeIgniter\Model;

class m_labjack extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'labjacks';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
