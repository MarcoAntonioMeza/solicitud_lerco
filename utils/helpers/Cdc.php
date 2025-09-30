<?php

namespace app\utils\helpers;

use Yii;

use app\utils\consultas\ApiHub;

use app\models\cliente\Persona as Cliente;

use app\utils\consultas\ScoreAlterno;

class Cdc
{

    const RUTA_CDC = 'cdc';
    const RUTA_SCORE_ALTERNO = 'score_alterno';


    /**
     * RIESGOS 
     * 
     */
    const RIESGO_BAJO =  10;
    const RIESGO_MEDIO = 20;
    const RIESGO_ALTO = 30;


    public static $riesgos = [
        self::RIESGO_BAJO => 'RIESGO BAJO',
        self::RIESGO_MEDIO => 'RIESGO MEDIO',
        self::RIESGO_ALTO => 'RIESGO ALTO',
    ];

    public static $code_states = [
        1 => 'AGS', // Aguascalientes
        2 => 'BC', // Baja California
        3 => 'BCS', // Baja California Sur
        4 => 'CAMP', // Campeche
        5 => 'COAH', // Coahuila
        6 => 'COL', // Colima
        7 => 'CHIS', // Chiapas
        8 => 'CHIH', // Chihuahua
        9 => 'CDMX	', // Ciudad de México
        10 => 'DGO', // Durango
        11 => 'GTO', // Guanajuato
        12 => 'GRO', // Guerrero
        13 => 'HGO', // Hidalgo
        14 => 'JAL', // Jalisco
        15 => 'MEX', // Estado de México
        16 => 'MICH', // Michoacán
        17 => 'MOR', // Morelos
        18 => 'NAY', // Nayarit
        19 => 'NL', // Nuevo León
        20 => 'OAX', // Oaxaca
        21 => 'PUE', // Puebla
        22 => 'QRO', // Querétaro
        23 => 'QROO', // Quintana Roo
        24 => 'SLP', // San Luis Potosí
        25 => 'SIN', // Sinaloa
        26 => 'SON', // Sonora
        27 => 'TAB', // Tabasco
        28 => 'TAMP', // Tamaulipas
        29 => 'TLAX', // Tlaxcala
        30 => 'VER', // Veracruz
        31 => 'YUC', // Yucatán
        32 => 'ZAC', // Zacatecas
    ];
    /**
     * 
     * CARACTERES ESPECIALES DE CDC
     */
    public static $diccionarioCaracterers = [
        'Á' => 'A',
        'É' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ú' => 'U',
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'Ü' => 'U',
        'Ñ' => 'N',
        ',' => ' ',
        '`' => ' ',
        '-' => ' ',
        '/' => ' ',
        ';' => ' ',
        ':' => ' ',
        '!' => ' ',
        '?' => ' ',
    ];

    /**
     * ============================
     *      CLAVES DE PREVENCIÓN
     * ============================
     */

    public static $claves_prevencion = [
       // 'CA',
        'CV',
        'FD',
        'FR',
        'GP',
        'IM',
        'IS',
        'LC',
        'LO',
        'NV',
        'RF',
        'RN',
        'SG',
        'UP',
        'VR',
    ];


    /**
     * ============================
     *  TIPO DE NEGOCIO CON CLAVE DE RECHAZO
     * ============================
     */
    public static $tipo_negocio_con_clave_rechazo = ['17', '21', '41', '42', '44'];

    /**
     * ==================================
     *  CARGA DE INFORMACION Y CONSULTA CIRCULO
     * ==================================
     */
    public static function consultaCIRCULO($cliente_id)
    {
        $cliente = Cliente::findOne($cliente_id);
        $dir = $cliente->dirs;
        /**
         * ========================
         *  CIRCULO DE CREDITO
         * ========================
         */
        $apellidoPaterno =  self::replaceCharacters(strtoupper($cliente->apellido_paterno));
        $apellidoMaterno = self::replaceCharacters(strtoupper($cliente->apellido_materno));
        $primerNombre = self::replaceCharacters(strtoupper($cliente->nombres));
        $fechaNacimiento =   ClientesHelper::invertirFecha($cliente->fecha_nacimiento);
        #$fechaNacimiento =   $cliente->fecha_nacimiento;
        $RFC =  $cliente->rfc;
        $nacionalidad = 'MX';


        $direccion = self::replaceCharacters(strtoupper($dir['direccion']));
        $coloniaPoblacion = self::replaceCharacters(strtoupper($dir['colonia'] ?? ''));
        $delegacionMunicipio = self::replaceCharacters(strtoupper($dir['municipio'] ?? ''));
        $ciudad = self::replaceCharacters(strtoupper($dir['municipio'] ?? ''));
        $estado =  self::$code_states[$dir['estado_id']] ?? null;
        $CP =  $dir['codigo_search'];


        $data = array(
            "apellidoPaterno" => $apellidoPaterno,
            "apellidoMaterno" => $apellidoMaterno,
            "primerNombre" => $primerNombre,
            "fechaNacimiento" => $fechaNacimiento,
            "RFC" => $RFC,
            "nacionalidad" => $nacionalidad,
            "domicilio" => array(
                "direccion" => $direccion,
                "coloniaPoblacion" => $coloniaPoblacion,
                "delegacionMunicipio" => $delegacionMunicipio,
                "ciudad" => $ciudad,
                "estado" => $estado,
                "CP" => $CP,
            )
        );

        //return $data;

        //CONSULTA A CIRCULO DE CREDITO
        $api = new ApiHub(Yii::$app->params['is_productivo']);
        // Datos a enviar en el POST request
        return  $api->reporteCreditoScore($data);
    }

    public static function replaceCharacters($string)
    {
        $string = strtoupper($string);
        // Recorrer el diccionario y reemplazar cada clave por su valor en la cadena
        foreach (self::$diccionarioCaracterers as $searchChar => $replaceChar) {
            $string = str_replace($searchChar, $replaceChar, $string);
        }

        return strtoupper(trim($string));
    }


    /**
     * ============================
     *      SOLICITUD AUTEX PAY
     * ============================
     */
    public static function SOLICITUD_CONSULTAS($cliente_id = null, $folio = "")
    {
        $reporte_cdc = self::consultaCIRCULO($cliente_id);
        $EXISTE_SCORE = isset($reporte_cdc) && $reporte_cdc['response'] ? $reporte_cdc['score'] : false;
        $SCORE = $EXISTE_SCORE;
        #$EXISTE_SCORE = false;

        #========================================
        #              CDC  
        #========================================
        if ($EXISTE_SCORE) {

            #=====================================
            #              RECHAZOS
            #=====================================
            if ($SCORE < 400) {
                return [
                    'success' => false,
                    'message' => 'SCORE CDC INSUFICIENTE',
                    'score' => $SCORE,
                    'monto' => 0,
                    'riesgo' => self::RIESGO_ALTO,
                    'ruta' => self::RUTA_CDC,
                ];
            }
            #CLAVES DE PREVENCION
            $creditos = $reporte_cdc['data']['creditos'];
            if (self::reglasIsRechazoByClavePrevencion($creditos, self::$claves_prevencion)) {
                #self::mandar_wallet($cliente_id);
                return [
                    'success' => false,
                    'message' => 'HISTORICO DE PAGOS CON ATRAZOS EN CIRCULO DE CREDITO',
                    'score' => $SCORE,
                    'monto' => 0,
                    'riesgo' => self::RIESGO_ALTO,
                    'ruta' => self::RUTA_CDC,
                ];
            }

            if(self::reglasIsRrechazoByHistoricoPagos($creditos)){
                #self::mandar_wallet($cliente_id);
                return [
                    'success' => false,
                    'message' => 'HISTORICO DE PAGOS CON ATRAZOS EN CIRCULO DE CREDITO',
                    'score' => $SCORE,
                    'monto' => 0,
                    'riesgo' => self::RIESGO_ALTO,
                    'ruta' => self::RUTA_CDC,
                ];
            }



            #=====================================
            #   SCORE MAYOR O IGUAL A 400
            #=====================================
            $MONTO = self::define_monto($SCORE, self::RUTA_CDC)['monto'];
            $RIESGO = self::define_monto($SCORE, self::RUTA_CDC)['riesgo'];

            return [
                'success' => true,
                'message' => 'Consulta realizada con éxito',
                'score' => $SCORE,
                'monto' => $MONTO,
                'riesgo' => $RIESGO,
                'ruta' => self::RUTA_CDC,
            ];
        } else {
            #========================================
            #              SCORE ALTERNO
            #========================================
            //AQUI REALIZA LA CONSULTA A SCORE ALTERNO
            $cliente = Cliente::findOne($cliente_id);
            $tel = $cliente->telefono;
            $Advans          = new ScoreAlterno(Yii::$app->params['is_productivo']);
            $response        = $Advans->soapRequestConsultaScore($tel, $folio);


            $hit_score = $response['result'];

            #=====================================
            #              RECHAZOS
            #=====================================
            if ($hit_score < 400) {
                return [
                    'success' => false,
                    'message' => 'ESCORE ALTERNO INSUFICIENTE',
                    'score' => $hit_score,
                    'monto' => 0,
                    'riesgo' => self::RIESGO_ALTO,
                    'ruta' => self::RUTA_SCORE_ALTERNO,
                ];
            }


            $MONTO = self::define_monto($hit_score, self::RUTA_SCORE_ALTERNO)['monto'];
            $RIESGO = self::define_monto($hit_score, self::RUTA_SCORE_ALTERNO)['riesgo'];
            return [
                'success' => true,
                'message' => 'Consulta realizada con éxito',
                'score' => $hit_score,
                'monto' => $MONTO,
                'riesgo' => $RIESGO,
                'ruta' => self::RUTA_SCORE_ALTERNO,
            ];
        }
    }


    public static function define_monto($score, $ruta)
    {
        $monto = 0;
        $riesgo = '';

        switch ($ruta) {
            case self::RUTA_CDC:
                /**
                 * ====================
                 *      RIESGO ALTO
                 * ====================
                 */
                if ($score >= 400 && $score <= 610) {
                    //DEFINIR MONTO
                    if ($score >= 400 && $score <= 550) {
                        $monto = 4000;
                    } elseif ($score >= 551 && $score <= 610) {
                        $monto = 7000;
                    }
                    //$risk = self::RIESGO_ALTO;
                    $riesgo = self::RIESGO_ALTO;
                    /**
                     * ====================
                     *    RIESGO MEDIO
                     * =====================
                     */
                } else if ($score >= 611 && $score <= 690) {

                    if ($score >= 611 && $score <= 630) {
                        $monto = 10000;
                    } elseif ($score >= 631 && $score <= 650) {
                        $monto = 14000;
                    } elseif ($score >= 651 && $score <= 670) {
                        $monto = 21000;
                    } else if ($score >= 671 && $score <= 690) {
                        $monto = 30800;
                    }
                    //$risk = self::RIESGO_MEDIO;
                    $riesgo = self::RIESGO_MEDIO;
                    /**
                     * =====================
                     *  RIESGO BAJO
                     * =====================
                     */
                } elseif ($score >= 691) {
                    $monto = 40600;
                    //$risk = self::RIESGO_BAJO;
                    $riesgo = self::RIESGO_BAJO;
                }
                break;


            case self::RUTA_SCORE_ALTERNO:
                if ($score >= 400 && $score <= 650) {
                    $monto = 1400;
                } elseif ($score >= 651) {
                    $monto  = 2800;
                }
                //$risk = self::RIESGO_ALTO;
                $riesgo = self::RIESGO_ALTO;
                break;
            default:
                $monto = 0;
                //$risk = self::RIESGO_ALTO;
                $riesgo = self::RIESGO_ALTO;
                break;
        }


        return [
            'monto' => $monto,
            'riesgo' => $riesgo,
        ];
    }











    public static function reglasIsRechazoByClavePrevencion($arrayCreditos, $arrayClavePrevencion)
    {
        foreach ($arrayCreditos as $credito) {
            if (isset($credito['clavePrevencion'])) {
                $clave = strtoupper($credito['clavePrevencion']);
                foreach ($arrayClavePrevencion as $clavePrevencion) {
                    if ($clave == $clavePrevencion) {
                        return true;
                    }
                }
            }
        }
        return false;
    }


    public static function reglasIsRrechazoByHistoricoPagos($arrayCreditos, $num_input = 3)
    {
        foreach ($arrayCreditos as $credito) {
            if (isset($credito['historicoPagos'])) {
                $array = str_split($credito['historicoPagos']);
                foreach ($array as $char) {

                    if (ctype_digit($char) && intval($char) == $num_input) {  //AQI VERIFICA SI APARECE UN 3 EN LA RESPUESTA DE  HISTORICO DE PAGOS
                        //throw new \yii\web\HttpException(202, self::$tipo_negocio_con_clave_rechazo, 10);
                        return true;
                        //if (in_array($num, self::$tipo_negocio_con_clave_rechazo)) {
                        //    return false;
                        //} else {
                        //    return true;
                        //}
                    }
                }
            }
        }
        //throw new \yii\web\HttpException(202, json_encode($credito['historicoPagos']), 10);
        return false;
    }

    #public static function mandar_wallet($cliente_id){
    #    $cliente = Cliente::findOne($cliente_id);
    #    if (!$cliente) {
    #        throw new \yii\web\HttpException(404, "Cliente no encontrado");
    #    }
    #    //$connWallet = new ConectionWallet(Yii::$app->params['is_productivo']);
    #    //$connWallet->sendData($cliente->id);
    #}

}
