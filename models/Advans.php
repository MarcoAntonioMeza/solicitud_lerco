<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Utils;


/**
 * @category   Blue Diamond
 * @package    ADVANS
 * @version    0.1.0
 */


class Advans extends Model
{


    public  function apiRequestGet($actionEndPoint)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.condusef.gob.mx/' . $actionEndPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($ch, CURLOPT_PROXY, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
             "Content-type: application/json;charset=\"utf-8\"",
             "Accept: application/json",
             "Cache-Control: no-cache",
             "origin" => "*/*",
         ));

        set_time_limit(0);
        $curl_request = curl_exec($ch);
        $err = curl_error($ch);

        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
            return false;
        } else{
            return self::response($curl_request);
        }
    }

    public  function apiRequestGetParams($params,$actionEndPoint)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.condusef.gob.mx/' . $actionEndPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($ch, CURLOPT_PROXY, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
             "Content-type: application/json;charset=\"utf-8\"",
             "Accept: application/json",
             "Cache-Control: no-cache",
             "origin" => "*/*",
         ));

        set_time_limit(0);
        $curl_request = curl_exec($ch);
        $err = curl_error($ch);

        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
            return false;
        } else{

            
            return self::response($curl_request);
        }
    }
    public  function apiRequestAuthGet( $actionEndPoint)
    {
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.condusef.gob.mx/' . $actionEndPoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 50000);

            curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
             "Content-type: application/json;charset=\"utf-8\"",
             'Authorization:' . User::getUserToken(),
             "Accept: application/json",
             "Cache-Control: no-cache",

         ));

            set_time_limit(0);
            $curl_request = curl_exec($ch);
            $err = curl_error($ch);

            $err = curl_error($ch);

            curl_close($ch);


        if ($err) {
            return false;
        } else{
            return self::response($curl_request);
        }
    }


    public  function apiRequestAuthPost($params, $actionEndPoint)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.condusef.gob.mx/' . $actionEndPoint);
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
             "Content-type: application/json;charset=\"utf-8\"",
             'Authorization:' . User::getUserToken(),
             "Accept: application/json",
             "Cache-Control: no-cache",
             "Content-length: ".strlen($params),
         ));

            set_time_limit(0);
            $curl_request = curl_exec($ch);
            $err = curl_error($ch);

            $err = curl_error($ch);

            curl_close($ch);


            
        if ($err) {
            return false;
        } else{
            return self::response($curl_request);
        }
    }


    public static function response($data)
    {
        return json_decode($data);
    }
}
