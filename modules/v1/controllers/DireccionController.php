<?php

namespace app\modules\v1\controllers;
use Yii;
use app\models\esys\EsysDireccionCodigoPostal;
use app\models\esys\EsysListaDesplegable;



class DireccionController extends DefaultController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Allow-Origin' => ['*'],
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];

        return $behaviors;
    }


    public function actionGetEstados()
    {
        $post = Yii::$app->request->post();

        $token = $post['token'] ?? null;
        //$promotor  = $this->authTokenPromotor($token);

        $estados_list = EsysListaDesplegable::getEstados();
        $estados = [];

        foreach ($estados_list as $key => $value) {
            $estados[] = [
                'id' => $key,
                'nombre' => $value,
            ];
        }

        $response = [
            "code"    => 202,
            "name"    => "Estados",
            'estados' => $estados,
            "message" => 'Verica tu información, intenta nuevamente',
            "type"    => "Error",
        ];

        return $response;
    }


    public function actionCodigoPostal()
    {
        $post = Yii::$app->request->post();
        //$token = $post['token'] ?? null;
        //$promotor  = $this->authToken($token);
        $codigo_postal = $post['codigo_postal'] ?? '';
        $codigo_postal = trim($codigo_postal);
        $codigo_postal = str_replace(' ', '', $codigo_postal);
        if(strlen($codigo_postal) != 5){
            return [
                "code"    => 10,
                "name"    => "Codigo Postal",
                'data' => [],
                "message" => 'FORMATO DE CÓDIGO INCORRECTO',
                "type"    => "Error",
            ];
        }


        if (!$codigo_postal) {
            return [
                "code"    => 10,
                "name"    => "Codigo Postal",
                'data' => [],
                "message" => 'Verica tu información, intenta nuevamente',
                "type"    => "Error",
            ];
        }

        $response = [
            "code"    => 202,
            "name"    => "Codigo Postal",
            'data' =>  EsysDireccionCodigoPostal::getEstadoMunicipiosColonia(['codigo_postal' => $codigo_postal]),
            "message" => 'Listado',
            "type"    => "Success",
        ];



        return $response;
    }
}
