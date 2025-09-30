<?php

namespace app\modules\v1\controllers;

use app\models\cliente\Persona;
use Yii;
use app\utils\consultas\Nobarium;
use app\utils\consultas\ListasRojas;
use app\utils\helpers\Helper;
use app\utils\helpers\ClientesHelper;
use app\utils\helpers\SolicitudHelper;


use app\models\cuestionario\CuestionariosGrupo;
use app\models\cuestionario\CuestionariosRespuestas;
use app\models\logs\LogApi;
use app\models\solicitud\Solicitud;

use app\models\sucursal\Sucursal;

use app\models\sms\SmsVerificacion;


//use app\models\sat\ListasNegrasSat;
use app\utils\helpers\Cdc;
use app\utils\consultas\Wallet;
use app\utils\consultas\Gdc;
use app\utils\helpers\CurpRfc;
use app\utils\consultas\Nufi;

class OriginacionController extends DefaultController
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



    #======================================================================================================
    #                                              SOLICITUD INICIAL
    #======================================================================================================

    public function actionSolicitud()
    {
        $transaction = Yii::$app->db->beginTransaction();
        #try {
            $post = Yii::$app->request->post();
            $persona = $post['persona'] ?? null;

            $dirs = $post['direccion'] ?? [];

            // Validar campos requeridos DE la dirección
            $requiredDirFields = [
                'codigo_postal',
                'estado_id',
                'municipio_id',
                'codigo_postal_id',
                //'direccion',
                //'num_ext',
                //'num_int'
            ];
            foreach ($requiredDirFields as $field) {
                if (empty($dirs[$field])) {
                    return [
                        'code' => 10,
                        'mensaje' => 'Faltan campos requeridos: ' . implode(', ', $requiredDirFields),
                    ];
                }
            }

            if (empty($persona)) {
                return [
                    'code' => 10,
                    'mensaje' => 'Los campos persona y cuestionarios son requeridos',
                ];
            }

            // CREA O ACTUALIZA LA PERSONA
            $personaResult = ClientesHelper::crear_o_actualizar_persona($persona, $dirs);
            if (empty($personaResult['success'])) {
                return [
                    'code' => 10,
                    'error' => $personaResult,
                    'mensaje' => $personaResult['message'] ?? 'Error al crear o actualizar persona',
                ];
            }


            $transaction->commit();

            return [
                'code' => 202,
                'id' => $personaResult['persona_id'],
                'folio' => $personaResult['persona_id'] ?? null,
                'mensaje' => 'Solicitud creada correctamente',
            ];
        #} catch (\Throwable $e) {
        #    if (isset($transaction) && $transaction->isActive) {
        #        #$transaction->rollBack();
        #    }
        #    return [
        #        'code' => 10,
        #        'mensaje' => 'Error en la solicitud: ' . $e->getMessage(),
        #    ];
        #}
    }
}
