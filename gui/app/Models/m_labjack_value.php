<?php

namespace App\Models;

use CodeIgniter\Model;

class m_labjack_value extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'labjack_values';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
