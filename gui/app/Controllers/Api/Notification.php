<?php

namespace App\Controllers\Api;

use App\Models\m_das_log;
use CodeIgniter\RESTful\ResourceController;

class Notification extends ResourceController{
	public function index()
	{
		$DasLogs = new m_das_log();
		$range = $this->getDateRange();
		$countAllResult = $DasLogs->where("time_group >= '{$range['start']}' AND time_group <= '{$range['end']}' AND notification NOT IN (0,6,7)")
			->countAllResults();
		if($countAllResult > 0){
			return $this->response->setJSON(1);
		}
		return $this->response->setJSON(0);
	}

	public function getDateRange(){
		$hMin1 = strtotime('-1 hour');
		$hMin1 = date('Y-m-d H:00:00',$hMin1);
		$range['start'] = $hMin1;
		$range['end'] = date('Y-m-d H:i:s',strtotime('+55 minute',strtotime($hMin1)));
		return $range;
	}
}
