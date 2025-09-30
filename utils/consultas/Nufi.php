<?php

namespace app\utils\consultas;

use Yii;
use app\models\logs\LogApi;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();




class Nufi
{

    public $key = null;

    private $base_url = 'https://nufi.azure-api.net/';
    private $url = '';

    public function __construct()
    {
        $this->key       = $_ENV['NUFI_KEY'];
    }


    public static $states = [
        1 => 'AS',  // Aguascalientes
        2 => 'BC',  // Baja California
        3 => 'BS',  // Baja California Sur
        4 => 'CC',  // Campeche
        5 => 'CL',  // Coahuila de Zaragoza
        6 => 'CM',  // Colima
        7 => 'CS',  // Chiapas
        8 => 'CH',  // Chihuahua
        9 => 'DF',  // Ciudad de México
        10 => 'DG', // Durango
        11 => 'GT', // Guanajuato
        12 => 'GR', // Guerrero
        13 => 'HG', // Hidalgo
        14 => 'JC', // Jalisco
        15 => 'MC', // México
        16 => 'MN', // Michoacán de Ocampo
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
        30 => 'VZ', // Veracruz de Ignacio de la Llave
        31 => 'YN', // Yucatán
        32 => 'ZS'  // Zacatecas
    ];

    public function consultaRfc($nombres, $apeP, $apeM, $fechaNac)
    {
        $this->url = $this->base_url . 'api/v1/calcular_rfc';
        $postFields = [
            "nombres" => $nombres,
            "apellido_paterno" => $apeP,
            "apellido_materno" => $apeM,
            "fecha_nacimiento" => $fechaNac // Formato: DD/MM/YYYY 28/02/1980
        ];
        $data = $this->consulta($postFields);
        LogApi::save_log(
            LogApi::NUFI,
            'GENERAR RFC',
            $postFields,
            $data
        );
        return $data;
    }
    public  function consultaCurp($nombres, $apeP, $apeM, $fechaNac, $entidad, $sexo)
    {
        #return self::$states[$entidad];
        $entidad_val = self::$states[$entidad] ?? null;
        if ($entidad_val === null) {
            return "";
        }

        /*
          
         
  "tipo_busqueda": "datos",
  "clave_entidad": "MN",
  "dia_nacimiento": "07",
  "mes_nacimiento": "01",
  "nombres": "ALBERTO",
  "primer_apellido": "AGUILERA",
  "segundo_apellido": "VALADEZ",
  "anio_nacimiento": "1950",
  "sexo": "H"

         */
        $this->url = $this->base_url . 'curp/v1/consulta';
        $DIA = substr($fechaNac, 0, 2);
        $MES = substr($fechaNac, 3, 2);
        $ANIO = substr($fechaNac, 6, 4);
        $params = [
            "tipo_busqueda" => "datos",
            "clave_entidad" => $entidad_val,
            "dia_nacimiento" => $DIA,
            "mes_nacimiento" => $MES,
            "nombres" => $nombres,
            "primer_apellido" => $apeP,
            "segundo_apellido" => $apeM,
            "anio_nacimiento" => $ANIO,
            "sexo" => $sexo // H o M
        ];

        $data = $this->consulta($params);
        LogApi::save_log(
            LogApi::NUFI,
            'GENERAR CURP',
            $params,
            $data
        );

        return $data;
    }



    private function consulta($postFields)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
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
                    #"Content-Type: application/json; charset=utf-8",
                    #"Accept: application/json",
                    #'Content-Type: application/json',
                    'Ocp-Apim-Subscription-Key: ' . $this->key
                )
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, 1);
    }
}
