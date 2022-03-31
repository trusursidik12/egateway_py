<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
class ConcentrationApi extends ResourceController
{
    public function getValue($webId)
    {
        $items = [];
        for ($i=1; $i <=10 ; $i++) { 
            $items[] = [
                'Timestamp' => date('Y-m-d\TH:i:s\Z'),
                'Value' => (float) round(rand(100,200) / rand(10,100),8)
            ];
        }
        return $this->response->setStatusCode(200)->setJSON([
            'Items' => $items
        ]);
    }
    public function updateValue($webId)
    {
        return $this->response->setStatusCode(202)->setJSON([
            'success' => true,
            'message' => 'Accepted!',
            'webId' => $webId
        ]);
    }
}
