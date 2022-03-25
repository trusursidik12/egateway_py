<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
class ConcentrationApi extends ResourceController
{
    public function getValue($webId)
    {
        return $this->response->setStatusCode(200)->setJSON([
            'Timestamp' => date("Y-m-d\TH:i:s"),
            'Value' => round(rand(-4,100)*0.11203901,8),
            'UnitsAbbreviation' => '',
            'Questionable' => false,
            'Subtituted' => false,
            'webId' => $webId
        ]);
    }
    public function updateValue($webId)
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Accepted!',
            'webId' => $webId
        ]);
    }
}
