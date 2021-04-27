<?php

namespace App\Controllers;

use App\Models\m_configuration;
use App\Models\m_measurement;

class Test extends BaseController
{
    public function __construct()
    {
        $this->measurements = new m_measurement();
        $this->configurations = new m_configuration();
    }

    public function sent()
    {
        //CURL
        $mData = $this->measurements->where(["is_sent_klhk" => 0])->orderBy("id DESC")->findAll()[0];
        $cnfig = $this->configurations->findAll()[0];
        /* Endpoint */
        $url = 'http://localhost/egateway_server/public/api/send/measurement';

        /* eCurl */
        $curl = ($url);

        /* Data */
        $data = [
            'egateway_code' => $cnfig->egateway_code,
            'measured_at' => $mData->measured_at,
            'client_parameter_id' => $mData->parameter_id,
            'value' => $mData->value,
            'unit_id' => $mData->unit_id,
            'is_sent' => $mData->is_sent_klhk,
            'sent_type' => $mData->sent_klhk_type,
            'sent_by' => $mData->sent_klhk_by,
            'sent_at' => $mData->sent_klhk_at,
            'sent_tries' => $mData->sent_klhk_tries,
        ];
        $dEncode = json_encode($data);
        /* Set JSON data to POST */
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dEncode);

        /* Define content type */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'cache-control: no-cache',
            'content-type: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUSEVfQ0xBSU0iLCJhdWQiOiJUSEVfQVVESUVOQ0UiLCJpYXQiOjE2MTk0NzY4MDYsIm5iZiI6MTYxOTQ3NjgxNiwiZXhwIjozODU1Mjc5ODg2LCJkYXRhIjp7ImlkIjoiNCIsImNsaWVudG5hbWUiOiJSQVBQLVNLRDQiLCJlbWFpbCI6InJhcHAtc2RrNEB0cnVzdXIuY29tIn19.hjVKD2tAKV5Y_46d4kxDTzt21i5u7TYKoyAtiUSOC5M',
        ));

        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /* make request */
        $result = curl_exec($curl);

        print_r($result);
        print_r($dEncode);

        /* close curl */
        curl_close($curl);
    }
}
