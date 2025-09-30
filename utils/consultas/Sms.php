<?php

namespace app\utils\consultas;
use Yii;
use app\models\logs\LogApi;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Sms
{

    private $url = 'https://dashboard.360nrs.com/api/rest/sms';
    #private $token = $_ENV['TOKEN_SMS'];
    /**
     * ================================================
     *             SEND SMS NOTIFICACION
     * ================================================
     */
    public function send_sms($params)
    {
        $params = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
            'Authorization: Basic TGVyY29teDpFSXphMTY/Pw==',
            "Content-type: application/json;charset=\"utf-8\"",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Content-length: " . strlen($params),
        ));
        set_time_limit(0);
        $curl_request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        $err = curl_error($ch);
        curl_close($ch);

        //$log = $this->saveLog($params,$this->sucursal_id,$params,json_encode($curl_request),"SMS",'SMS');


        if ($err) {
            //throw new Exception("cURL Error #:" . $err);
            return false;
        } else {
            LogApi::save_log(
                LogApi::SMS,
                'ENVIO SMS',
                $params,
                $curl_request
            );
            #$log = $this->saveLog($params, $this->sucursal_id, $params, json_encode($curl_request), "SMS", 'SMS');
            return  $curl_request;
            
        }
    }
}
