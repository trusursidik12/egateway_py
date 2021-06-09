<?php

namespace App\Models;

use CodeIgniter\Model;

class m_labjack_value_history extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'labjack_value_histories';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $protectFields = false;
}
