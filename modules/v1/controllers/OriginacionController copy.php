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

    /*
        * ===============================================
        *           NOBARIOUM
        * ===============================================
    */

    public function actionOcrIne()
    {
        $post = Yii::$app->request->post();
        $ine_frente = $post['ine_frente'] ?? '';
        $ine_reverso = $post['ine_reverso'] ?? '';
        //return $post;

        if (!Helper::isValidBase64Image($ine_frente) || !Helper::isValidBase64Image($ine_reverso)) {
            return [
                'code' => 10,
                'mensaje' => 'La imagen del frente o reverso no es válida o no tiene un formato permitido.',
            ];
        }

        $consulta = new Nobarium();
        #$respuesta = $consulta->validateIne(preg_replace('/^data:image\/\w+;base64,/', '', $post['ine_frente']), preg_replace('/^data:image\/\w+;base64,/', '', $post['ine_reverso']));
        $respuesta = $consulta->validateIne(preg_replace('/^data:image\/\w+;base64,/', '', $ine_frente), preg_replace('/^data:image\/\w+;base64,/', '', $ine_reverso));
        $ine = Helper::is_valid_ine($respuesta);
        if (!$ine['success']) {
            return [
                'code' => $ine['code'],
                'mensaje' => strtoupper($ine['message'])
            ];
        }
        return $ine;
    }

    #$q =  (new Nobarium())->generarRfc(
    #    $nombre,
    #    $apPaterno,
    #    $apMaterno,
    #    $nacimiento,
    #    $state_id,
    #    $sexo
    #);
    #$rfc = Helper::valid_rfc($q);
    #$curp = Helper::valid_curp($q);


    public function actionRfc()
    {
        $post          =  Yii::$app->request->post();
        $nombre        = $post['nombre'] ?? null;
        $apPaterno     = $post['primerApellido'] ?? null;
        $apMaterno     = $post['segundoApellido'] ?? null;
        $nacimiento    = $post['fechaNacimiento'] ?? null;
        $entidad       = $post['entidad'] ?? null;
        $state_id      = Nobarium::$states[$entidad] ?? null;
        $sexo          = $post['sexo'] ?? null;

        // Normalizar el valor de sexo a 'H' (hombre) o 'M' (mujer)
        $sexo = ($sexo === 'F') ? 'M' : 'H';

        // Validar campos requeridos
        if (
            empty($nombre) ||
            empty($apPaterno) ||
            empty($apMaterno) ||
            empty($nacimiento) ||
            empty($state_id) ||
            empty($sexo)
        ) {
            return [
                'code' => 10,
                'mensaje' => 'Faltan campos requeridos: nombre, primerApellido, segundoApellido, fechaNacimiento, entidad, sexo',
            ];
        }
        #valida que la fe4cha sea DD/MM/YYYY
        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $nacimiento)) {
            return [
                'code' => 10,
                'mensaje' => 'El formato de fecha de nacimiento es inválido. Use DD/MM/YYYY',
            ];
        }
        #return;
        $nombre = trim($nombre);
        $apPaterno = trim($apPaterno);
        $apMaterno = trim($apMaterno);
        #quitar los dobles espacios
        $nombre = preg_replace('/\s+/', ' ', $nombre);
        $apPaterno = preg_replace('/\s+/', ' ', $apPaterno);
        $apMaterno = preg_replace('/\s+/', ' ', $apMaterno);
        $rfc = "";
        $curp = "";



        $NUFI = new Nufi();
        $curp_data = $NUFI->consultaCurp($nombre, $apPaterno, $apMaterno, $nacimiento, $entidad, $sexo);
        $rfc_data = $NUFI->consultaRfc($nombre, $apPaterno, $apMaterno, $nacimiento);

        $curp = Helper::curp_nufi($curp_data);
        $rfc = Helper::rfc_nufi($rfc_data);

/*
        if (strlen($rfc) <= 1 || strlen($curp) <= 1) {
            #// Convertir fecha de DD/MM/YYYY a YYYY-MM-DD
            $state_id = $entidad;
            try {
                $fechaFormateada = \DateTime::createFromFormat('d/m/Y', $nacimiento);
                if ($fechaFormateada === false) {
                    return [
                        'code' => 10,
                        'mensaje' => 'Formato de fecha inválido. Use DD/MM/YYYY',
                    ];
                }
                $nacimiento = $fechaFormateada->format('Y-m-d');
            } catch (\Exception $e) {
                return [
                    'code' => 10,
                    'mensaje' => 'Error al procesar la fecha: ' . $e->getMessage(),
                ];
            }

            $q = new CurpRfc();
            $curp = $q->calcularCURP($nombre, $apPaterno, $apMaterno, $nacimiento, $sexo, $state_id);
            $rfc = $q->calcularRFC($nombre, $apPaterno, $apMaterno, $nacimiento);
        }
*/




        return [
            'code' => 202,
            'rfc' => $rfc,
            'curp' => $curp,
            'mensaje' => 'OK',
        ];
    }

    public function actionPruebaVida()
    {
        ini_set('memory_limit', '-1');
        #$token = Yii::$app->request->post('token', '');
        #$user = $this->authToken($token);
        $post = Yii::$app->request->post();
        $ine_frente = $post['ine_frente'] ?? '';
        $rostro = $post['rostro'] ?? '';

        if (!Helper::isValidBase64Image($ine_frente) || !Helper::isValidBase64Image($rostro)) {
            return [
                'code' => 10,
                'mensaje' => 'La imagen del frente o rostro no es válida o no tiene un formato permitido.',
            ];
        }

        return Helper::prueba_vida((new Nobarium())
            ->pruebaVida($ine_frente, $rostro));
    }

    public function actionValidarRfc()
    {
        $post = Yii::$app->request->post();
        #$token = $post['token'] ?? null;
        #$user = $this->authToken($token);
        $rfc = $post['rfc'] ?? '';

        if (empty($rfc)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo rfc es requerido',
            ];
        }



        $is_valid = Helper::is_valid_rfc_sat((new Nobarium())->validarRfc($rfc));

        return [
            'code' => $is_valid ? 202 : 10,
            'valid' => $is_valid,
            'mensaje' => $is_valid ? 'RFC válido' : 'Existe un detalle con el RFC',
        ];
    }

    public function actionListasRojas()
    {
        $post = Yii::$app->request->post();
        $rfc = $post['rfc'] ?? '';

        if (empty($rfc)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo rfc es requerido',
            ];
        }

        $is_aceptable_blacklist = false;
        try {
            $autex = new ListasRojas();
            $autex->generateTokenLN();
            $result = $autex->getBlacklistStatus($rfc);
            $is_aceptable_blacklist = strtoupper($result['resultado']) == strtoupper('Aceptado');
        } catch (\Exception $e) {
            $is_aceptable_blacklist = false;
        }

        return [
            'code' => $is_aceptable_blacklist ? 202 : 10,
            'es_aceptado' => $is_aceptable_blacklist,
            'mensaje' => $is_aceptable_blacklist ? 'ok' : 'Rechazado por politicas de crédito',
        ];
    }


    private function validaListasRojas($rfc)
    {
        $is_aceptable_blacklist = false;
        try {
            $autex = new ListasRojas();
            $autex->generateTokenLN();
            $result = $autex->getBlacklistStatus($rfc);
            $is_aceptable_blacklist = strtoupper($result['resultado']) == strtoupper('Aceptado');
        } catch (\Exception $e) {
            $is_aceptable_blacklist = false;
        }

        return $is_aceptable_blacklist;
    }


    public function actionListasNegras()
    {
        $post = Yii::$app->request->post();
        $rfc = $post['rfc'] ?? '';

        if (empty($rfc)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo rfc es requerido',
            ];
        }

        $q = (new Nobarium())->listas_negras($rfc);


        $esta_en_listas_negras = !Helper::paso_listas_negras($q);

        return [
            'code' => $esta_en_listas_negras ? 10 : 202,
            'aceptado' => !$esta_en_listas_negras,
            'esta_en_listas_negras' => $esta_en_listas_negras,
            'mensaje' => $esta_en_listas_negras ? 'Rechazado por políticas de crédito' : 'ok',
        ];
    }


    public function actionValidarEdad()
    {
        $post = Yii::$app->request->post();
        $fecha_nacimiento = $post['fecha_nacimiento'] ?? null;

        if (empty($fecha_nacimiento)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo fecha_nacimiento es requerido',
            ];
        }

        $edad = ClientesHelper::validarRangoEdad($fecha_nacimiento);

        return [

            'code' => $edad['dentroDelRango'] ? 202 : 10,
            'esta_dentro_del_rango' => $edad['dentroDelRango'],
            'edad' => $edad['edad'],
            'mensaje' => $edad['dentroDelRango'] ? 'Edad dentro del rango permitido' : 'Rechazado por edad insuficiente',
        ];
    }

    public function actionValidaGenerales()
    {
        $post = Yii::$app->request->post();
        $rfc = $post['rfc'] ?? null;
        $curp = $post['curp'] ?? null;
        $fecha_nacimiento = $post['fecha_nacimiento'] ?? null;

        # Validar fecha de nacimiento
        if (empty($fecha_nacimiento)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo fecha_nacimiento es requerido',
            ];
        }
        if (empty($rfc)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo rfc es requerido',
            ];
        }
        if (empty($curp)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo curp es requerido',
            ];
        }

        #NO GENERA COSTO
        $edad = ClientesHelper::validarRangoEdad($fecha_nacimiento);
        if (!$edad['dentroDelRango']) {
            return [
                'code' => 10,
                'mensaje' => 'Rechazado por edad insuficiente',
            ];
        }



        ##GENERA COSTOS
        #$is_valid = Helper::is_valid_rfc_sat((new Nobarium())->validarRfc($rfc));
        #if(!$is_valid){
        #    return [
        #        'code' => 10,
        #        'mensaje' => 'Rechazado por políticas de crédito',
        #    ];
        #}

        #No gera costo
        if (!$this->validaListasRojas($rfc)) {
            return [
                'code' => 10,
                'mensaje' => 'Rechazado por políticas de crédito',
            ];
        }

        # VERIFICA SI PUEDE SOLICITAR #no genera costo
        $puedeSolicitar = ClientesHelper::puede_solicitar($curp, $rfc);
        //return $puedeSolicitar;
        if (!$puedeSolicitar['success']) {
            return [
                'code' => 10,
                'mensaje' => $puedeSolicitar['message'] ?? 'Rechazado por políticas de crédito',
            ];
        }

        $q = (new Nobarium())->listas_negras($rfc);
        $esta_en_listas_negras = !Helper::paso_listas_negras($q);
        if ($esta_en_listas_negras) {
            return [
                'code' => 10,
                'mensaje' => 'Rechazado por políticas de crédito',
            ];
        }


        return [
            'code' => 202,
            'data' => $rfc,
            'edad' => $edad,
            'mensaje' => 'OK',
        ];
    }


    #======================================================================================================
    #                                              CUESTIONARIOS
    #======================================================================================================


    public function actionGetCuestionarios()
    {
        $post  =  Yii::$app->request->post();
        #$token = $post['token'] ?? null;
        #$user  = $this->authToken($token);

        return [
            'code' => 202,
            'data' => CuestionariosGrupo::get_all_preguntas_group(),
            'message' => 'OK',
        ];
    }

    public function actionGetCuestionario()
    {
        $post  =  Yii::$app->request->post();
        #$token = $post['token'] ?? null;
        #$user  = $this->authToken($token);
        $id = $post['grupo_id'] ?? null;
        $model = CuestionariosGrupo::find()->where(['id' => $id, 'estado' => CuestionariosGrupo::ESTADO_ACTIVO])->one();
        if (!$model) {
            return [
                'code' => 10,
                'mensaje' => 'No se encontró el cuestionario',
            ];
        }

        return [
            'code' => 202,
            'data' => $model->get_grupo_preguntas(),
            'mensaje' => 'OK',
        ];
    }

    public function actionListaGrupos()
    {
        $post  =  Yii::$app->request->post();
        #$token = $post['token'] ?? null;
        #$user  = $this->authToken($token);

        return [
            'code' => 202,
            'data' => CuestionariosGrupo::get_list_grupos(),
            'mensaje' => 'OK',
        ];
    }




    #======================================================================================================
    #                                              SMS Y VALIDACIÓN
    #======================================================================================================

    public function actionSendSms()
    {
        $post = Yii::$app->request->post();
        #$token = $post['token'] ?? null;
        #$user = $this->authToken($token);
        $telefono = $post['telefono'] ?? '';

        $telefono = trim($telefono);
        if (empty($telefono)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo telefono es requerido',
            ];
        }


        if (!$telefono) {
            return [
                'code' => 10,
                'mensaje' => 'Faltan campos requeridos: telefono',
            ];
        }

        #valido los intento
        $intentos = (int) SmsVerificacion::find()->where(['key' => $telefono])->count();
        $numIntentos = SmsVerificacion::NUN_INT_TEST;

        if ($intentos >= $numIntentos) {
            return [
                "code"      => 10,
                "name"      => "DEMACIADOS INTENTOS",
                "type"      => "error",
                "mensaje"   => 'Demasiados intentos, maximo ' . $numIntentos . ' intentos.',
            ];
        }

        $sms = new \app\utils\consultas\Sms();
        $token = Helper::generateToken();
        $response = $sms->send_sms(Helper::generateMensaje($telefono, $token));
        $newSms = new SmsVerificacion();
        $newSms->codigo = $token;
        $newSms->key = $telefono;

        if ($newSms->save()) {
            return [
                'code' => 202,
                'token' => $token,
                'data' => $response,
                'mensaje' => 'SMS enviado correctamente',
            ];
        }

        return [
            'code' => 10,
            'mensaje' => 'Error al enviar el SMS',
        ];
    }

    public function actionValidateSms()
    {
        $post = Yii::$app->request->post();
        #$token = $post['token'] ?? null;
        #$user = $this->authToken($token);
        $codigo = $post['codigo'] ?? null;
        $telefono = $post['telefono'] ?? null;


        $telefono = trim($telefono);
        $codigo = trim($codigo);
        if (empty($telefono)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo telefono es requerido',
            ];
        }

        if (empty($codigo)) {
            return [
                'code' => 10,
                'mensaje' => 'El campo codigo es requerido',
            ];
        }

        return SmsVerificacion::verificar($codigo, $telefono);
    }



    #======================================================================================================
    #                                              sucursales
    #======================================================================================================
    public function actionGetSucursal()
    {
        $post = Yii::$app->request->post();

        $sucursales = Sucursal::get_sucursales();
        return [
            'code' => 200,
            'data' => $sucursales,
        ];
    }


    #======================================================================================================
    #                                              SOLICITUD INICIAL
    #======================================================================================================



    #?======================================================================================================
    #                                              SOLICITUD CrEDITO
    #======================================================================================================

    public function actionSolicitud()
    {
        ini_set('memory_limit', '-1');
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $post = Yii::$app->request->post();
            $persona = $post['persona'] ?? null;
            $cuestionarios = $post['cuestionarios'] ?? null;
            $dirs = $post['direccion'] ?? [];
            $persona_2 = $persona;
            $persona_2['ine_frente'] = "";
            $persona_2['ine_reverso'] = "";
            $persona_2['rostro'] = "";

            LogApi::save_log(
                LogApi::SOLICITUD,
                'SOLICITUD',
                [
                    'persona' => $persona_2,
                    'cuestionarios' => $cuestionarios,
                    'direccion' => $dirs,
                ],
                ''
            );
            $suc = Sucursal::find()
                ->select(['id'])
                ->where(['id' => $persona['sucursal_id'] ?? null])->one();
            // valida si la sucursal existe
            if (!$suc) {
                return [
                    'code' => 10,
                    'mensaje' => 'La sucursal no existe',
                ];
            }

            // Validar campos requeridos DE la dirección
            $requiredDirFields = [
                'codigo_postal',
                'estado_id',
                'municipio_id',
                'codigo_postal_id',
                'direccion',
                'num_ext',
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

            if (empty($persona) || empty($cuestionarios)) {
                return [
                    'code' => 10,
                    'mensaje' => 'Los campos persona y cuestionarios son requeridos',
                ];
            }
            // VERIFICA SI PUEDE SOLICITAR
            $puedeSolicitar = ClientesHelper::puede_solicitar($persona['curp'] ?? null, $persona['rfc'] ?? null);
            if (!$puedeSolicitar['success']) {
                return [
                    'code' => 10,
                    'mensaje' => $puedeSolicitar['message'] ?? 'No puede solicitar crédito',
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

            $valida_nobarium = SolicitudHelper::valida_informacion(
                $persona['ine_frente'] ?? null,
                $persona['ine_reverso'] ?? null,
                $personaResult['id'] ?? null
            );

            if (!$valida_nobarium['success']) {
                $SOLICITUD = new Solicitud();
                $SOLICITUD->estado = Solicitud::ESTADO_RECHAZADA;
                $SOLICITUD->ine_frontal = Helper::saveBase64Image($persona['ine_frente'], 'ine_frontal');
                $SOLICITUD->ine_reverso = Helper::saveBase64Image($persona['ine_reverso'], 'ine_reverso');
                $SOLICITUD->rostro = Helper::saveBase64Image($persona['rostro'], 'rostro');
                $SOLICITUD->persona_id = $personaResult['id'];

                $SOLICITUD->monto = 0;
                $SOLICITUD->score = 0;
                $SOLICITUD->risk = 0;
                $SOLICITUD->monto = 0;
                $SOLICITUD->dia = date('j');
                $SOLICITUD->corte = Helper::reglasFechaCorte();

                $SOLICITUD->ruta = '--';
                $SOLICITUD->folio_verificacion = $persona['folio_verificacion'];
                $SOLICITUD->rechazo = $valida_nobarium['message'] ?? '';
                $SOLICITUD->rechazo_user = $valida_nobarium['message'] ?? '';
                $SOLICITUD->fecha_solicitud = date('Y-m-d H:i:s');
                $SOLICITUD->sucursal_id = $persona['sucursal_id'];
                $SOLICITUD->fase = Solicitud::FASE_FINAL;
                $SAVE = $SOLICITUD->save();

                if ($SAVE) {
                    (new Wallet(Yii::$app->params['is_productivo'], true))
                        ->sendData($personaResult['id']);
                }



                $transaction->commit();
                return [
                    'code' => 10,
                    'mensaje' => $valida_nobarium['message'] ?? 'Rechazado por politicas de crédito',
                ];
            }

            $aceptado = Cdc::SOLICITUD_CONSULTAS($personaResult['id'], $persona['folio_verificacion']);

            $SOLICITUD = new Solicitud();
            $SOLICITUD->estado = $aceptado['success'] ? Solicitud::ESTADO_APROBADA : Solicitud::ESTADO_RECHAZADA;
            $SOLICITUD->ine_frontal = Helper::saveBase64Image($persona['ine_frente'], 'ine_frontal');
            $SOLICITUD->ine_reverso = Helper::saveBase64Image($persona['ine_reverso'], 'ine_reverso');
            $SOLICITUD->rostro = Helper::saveBase64Image($persona['rostro'], 'rostro');
            $SOLICITUD->persona_id = $personaResult['id'];

            $SOLICITUD->monto = $aceptado['monto'];
            $SOLICITUD->score = $aceptado['score'];
            $SOLICITUD->risk = $aceptado['riesgo'];
            $SOLICITUD->monto = $aceptado['monto'];
            $SOLICITUD->dia = date('j');
            $SOLICITUD->corte = Helper::reglasFechaCorte();

            $SOLICITUD->ruta = $aceptado['ruta'];
            $SOLICITUD->folio_verificacion = $persona['folio_verificacion'];
            $SOLICITUD->rechazo = $aceptado['message'] ?? '';
            $SOLICITUD->rechazo_user = $aceptado['message'] ?? '';
            $SOLICITUD->fecha_solicitud = date('Y-m-d H:i:s');
            $SOLICITUD->sucursal_id = $persona['sucursal_id'];
            $SOLICITUD->fase = Solicitud::FASE_FINAL;
            $SAVE = $SOLICITUD->save();
            if (!$SAVE) {
                throw new \Exception('Error al guardar la solicitud: ' . json_encode($SOLICITUD->getErrors()));
            }

            CuestionariosRespuestas::guardarRespuestas($SOLICITUD->id, $cuestionarios, 1);
            if (!$aceptado['success']) {
                (new Wallet(Yii::$app->params['is_productivo'], true))
                    ->sendData($personaResult['id']);
            } else {
                $gdc = new Gdc($personaResult['id']);
                $gdc->generateData();
                $gdc->processCustomer();
            }

            $transaction->commit();

            return [
                'code' => 202,
                'mensaje' => $aceptado['success'] ? 'Solicitud aceptada' : 'Rechazado por politicas de crédito',
                'is_aceptado' => $aceptado['success'],
                'monto' => floatval($aceptado['monto']),
            ];
        } catch (\Throwable $e) {
            if (isset($transaction) && $transaction->isActive) {
                #$transaction->rollBack();
            }
            return [
                'code' => 10,
                'mensaje' => 'Error en la solicitud: ' . $e->getMessage(),
            ];
        }
    }



    /**
     * 
     * 
     * ===================================================
     */
}
