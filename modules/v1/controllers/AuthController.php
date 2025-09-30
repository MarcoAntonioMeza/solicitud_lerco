<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Esys;
use yii\filters\auth\HttpBasicAuth;
use app\models\user\User;
use app\models\auth\AuthAssignment;

class AuthController extends DefaultController
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

    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        if (!isset($post["username"]) || !isset($post["password"]) ||   empty($post["username"]) || empty($post["password"]))
            return [
                "code"    => 10,
                "name"    => "Login",
                "message" => 'User and password are required, please try again.',
                "type"    => "Error",
            ];
        if ($cli = $this->auth($post["username"], $post["password"])) {

            return [
                "code"    => 202,
                "name"    => "User",
                "data"       =>  array(
                    'token'       => $cli->token,
                    'email'       => $cli->email,
                    'username'       => $cli->username,
                    'nombre'       => $cli->nombre,
                    'apellidos'   => $cli->apellidos,
                    'email'       => $cli->email,
                    'sexo'        => $cli->sexo,
                    'telefono'       => $cli->telefono,
                ),
                "type"    => "Success",
            ];
        }

        return [
            "code"    => 10,
            "name"    => "Login",
            "message" => 'Usuario ó contraseña incorrectos',
            "type"    => "Error",
        ];
    }

    public function actionLogout()
    {
        return (new \DateTime())->format('Y-m-d\TH\:i\:s');
    }
}
