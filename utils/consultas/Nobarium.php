<?php

namespace app\utils\consultas;

use Yii;
use app\models\logs\LogApi;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();




class Nobarium
{

    public static $states = [
        1 => 'AS', // Aguascalientes
        2 => 'BC', // Baja California
        3 => 'BS', // Baja California Sur
        4 => 'CC', // Campeche
        5 => 'CL', // Coahuila
        6 => 'CM', // Colima
        7 => 'CS', // Chiapas
        8 => 'CH', // Chihuahua
        9 => 'DF', // Ciudad de México
        10 => 'DG', // Durango
        11 => 'GT', // Guanajuato
        12 => 'GR', // Guerrero
        13 => 'HG', // Hidalgo
        14 => 'JC', // Jalisco
        15 => 'MC', // Estado de México
        16 => 'MN', // Michoacán
        17 => 'MS', // Morelos
        18 => 'NT', // Nayarit
        19 => 'NL', // Nuevo León
        20 => 'OC', // Oaxaca
        21 => 'PL', // Puebla
        22 => 'QT', // Querétaro
        23 => 'QR', // Quintana Roo
        24 => 'SP', // San Luis Potosí
        25 => 'SL', // Sinaloa
        26 => 'SR', // Sonora
        27 => 'TC', // Tabasco
        28 => 'TS', // Tamaulipas
        29 => 'TL', // Tlaxcala
        30 => 'VZ', // Veracruz
        31 => 'YN', // Yucatán
        32 => 'ZS', // Zacatecas
    ];
    public $user = null;
    public $password = null;

    private $base_url = 'https://ocr.nubarium.com/';
    private $url = '';

    public function __construct()
    {
        $this->user       = $_ENV['NOBARIUM_USER'];
        $this->password   = $_ENV['NOBARIUM_PASSWORD'];
    }


    public function validateIne($ineFrontal, $ineReverso)
    {
        try {
            $this->url = $this->base_url . "ocr/v1/obtener_datos_id";
            $postFields = [
                'id' => $ineFrontal,
                'idReverso' => $ineReverso
            ];

            $data = $this->consultar($postFields);

            LogApi::save_log(
                LogApi::NOBARIUM,
                'INE FRONTAL Y REVERSO EN BASE 64',
                [
                    'id' => 'ineFrontal',
                    'idReverso' => 'ine Reverso'
                ],
                $data
            );

            #$log = LogApis::add('NOBARIUM VALIDA INE', 'INE FRONTAL Y REVERSO EN BASE 64', json_encode($data));
            //$log = LogApis::add('NOBARIUM VALIDA INE', json_encode($postFields), json_encode($data));
            //throw new \Exception('Error al guardar el log de la consulta a NOBARIUM: ' . json_encode($log));

            return $data;
        } catch (\Exception $e) {
            return [
                "code" => 10,
                'estatus' => 'ERROR',
                "type" => "EXCEPTION",
                "mensaje" => $e->getMessage(),
            ];
        }
    }



    /**
     * ===============================================
     *           GENERA RFC Y CURP
     * ===============================================
     */

    public  function generarRfc($nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $entida, $sexo)
    {
        $this->url = 'https://curp.nubarium.com:443/renapo/obtener_curp';
        $pyload = [
            "nombre"          => $nombre,
            "primerApellido"  => $apellidoPaterno,
            "segundoApellido" => $apellidoMaterno,
            "fechaNacimiento" => $fechaNacimiento,
            "entidad"         => $entida,
            "sexo"            => $sexo,
            "generarRFC"      => true
        ];

        $data = $this->consultar($pyload);
        LogApi::save_log(
            LogApi::NOBARIUM,
            'GENERAR RFC',
            $pyload,
            $data
        );
        return $data;
    }
    
    



    /**
     * ===============================================
     *           VALIDA RFC
     * ===============================================
     */
    public function validarRfc($rfc)
    {
        $this->url = 'https://sat.nubarium.com/sat/valida_rfc';
        $pyload = [
            "rfc" => $rfc
        ];
        $data = $this->consultar($pyload);

        LogApi::save_log(
            LogApi::NOBARIUM,
            'VALIDA RFC',
            $pyload,
            $data
        );

        return $data;
    }


    /**
     * ===============================================
     *         VALIDA INE CON LISTA NOMINAL
     * ================================================
     */
    public function ineListaNominal($cic, $identificadorCiudadano)
    {
        //$identificadorCiudadano = '125430041';
        //$cic = '199742463';
        $this->url = 'https://ine.nubarium.com/ine/v2/valida_ine';

        $postFields = [
            'cic' => $cic,
            'identificadorCiudadano' => $identificadorCiudadano
        ];
        $data = $this->consultar($postFields);
        LogApi::save_log(
            LogApi::NOBARIUM,
            'VALIDA INE CON LISTA NOMINAL',
            $postFields,
            $data
        );
        return $data;
    }


    /*
    * ===============================================
    *            PRUEBA DE VIDA
    * ================================================
    */
    public function pruebaVida($ineFrontalBase64, $rostroBase64)
    {
        ini_set('memory_limit', '-1');
        $this->url = 'https://biometrics.nubarium.com/antifraude/reconocimiento_facial';
        $postFields = [
            'credencial' => $ineFrontalBase64,
            'captura' => $rostroBase64,
            'tipo' => 'imagen'
        ];
        $data = $this->consultar($postFields, 10);
        LogApi::save_log(
            LogApi::NOBARIUM,
            'PRUEBA DE VIDA',
            [
                'credencial' => '',
                'captura' => '',
                'tipo' => 'imagen'
            ],
            $data
        );
        return $data;
    }


    /**
     * ===============================================
     *            LISTAS NEGRAS
     * ================================================
     */
    public  function listas_negras($rfc)
    {
        $this->url = 'https://api.nubarium.com/sat/consultar_69';
        $params = [
            'rfc' => $rfc
        ];
        $data = $this->consultar($params);
        LogApi::save_log(
            LogApi::NOBARIUM,
            'LISTAS NEGRAS',
            $params,
            $data
        );

        return $data;
    }


    /**
     * ===============================================
     *           EJECUTA LA CONSULTA
     * ===============================================
     */
    private function consultar($postFields, $aplytime = 0)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json; charset=utf-8",
                "Accept: application/json",
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode($this->user . ':' . $this->password) // Reemplaza con tus credenciales
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, 1);
    }
    
}
