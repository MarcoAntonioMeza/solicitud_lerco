<?php
namespace app\utils\consultas;

use Yii;
use app\models\logs\LogApi;
use app\models\auditoria\Auditoria;
class ApiHub
{
    
    const AUTEX_PAY   = 2; //"AUTEX";
    const FERRETERIA  = 3; //"FERRETERIA";
    const MAPCO       = 4; //"MAPCO";
    const SANIMEX     = 5; //"SANIMEX";

    private $users = [];

    private $url = '';


    /**
     * ===========================================
     *   CREDENCIALES DE ACCESO ENTORNO PRODUCTIVO
     * ===========================================
     */
    private $user = "";


    private $is_productivo = false;



    private $sucursal;
    private $empresa;
    private $hora_solicitud;

    public function __construct($is_productivo )
    {
        $this->is_productivo = $is_productivo;
        //Validamos que se haya especificado la empresa y la sucursal
        //if (!$empresa) {
        //    throw new \Exception("No se ha especificado la empresa");
        //}
        
        //Listado de usuarios para cada empresa
        $this->users = [
            self::AUTEX_PAY       => 'YGJ0706AUT',
            self::MAPCO           => 'JMD1232ACR',
            self::FERRETERIA      => 'JMD1232ACR',
            self::SANIMEX         => 'JMD1232ACR',
        ];
        //Asignamos el usuario para la empresa
        $this->user = $this->users[self::AUTEX_PAY];
        //Asignamos la empresa
        $this->empresa = self::AUTEX_PAY;
        //$this->sucursal = $sucursal;
        //Asignamos la url
        $this->url =  $is_productivo ? Yii::$app->params['url_cdc_prod'] :  $this->url = Yii::$app->params['url_cdc_dev'];

        $this->hora_solicitud = date('H:i:s');
    }




    public function reporteCreditoScore($data)
    {
        $data['empresa'] = $this->empresa;
        $data_json = json_encode($data);

        $response =  $this->consulata2($data_json);
        LogApi::save_log(
            LogApi::CIRCULO_CREDITO,
            'CONSULTA SCORE CDC',
            $data,
            $response
        );
        //throw new \yii\web\HttpException(202, json_encode($response), 10);
       // $this->saveLog($data_json, $this->sucursal, $this->empresa, $data_json, $response, 'Reporte de credito CDC');

        $code = intval($response['code']);

        switch ($code) {
            case 202:
                $respuesta =  $response['data'];
                #if ($this->is_productivo) {
                    Auditoria::saveAuditoria(json_decode($data_json, 1), $respuesta, $this->user,$this->hora_solicitud, date('H:i:s'));
               #}
                if (!empty($respuesta['scores'])) {
                    $score = $respuesta['scores'][0]['valor'];
                    return [
                        'code' => $code,
                        'score' => $score,
                        'response' => true,
                        'data' => $respuesta,
                    ];
                } else {
                    return [
                        'response' => false,
                        'score' => null,
                        'data' => null,
                    ];
                }
                break;

            default:
                return [
                    'code' => $code,
                    'score' => 0,
                    'response' => false,
                    'mensaje' => "OCURRIO UN ERROR EN CDC (MSG INTERNO)", //$response['data']['errores'][0]['mensaje'],
                    'data' => $data,
                ];
                break;
        }

        return [
            'code' => $code,
            'score' => 0,
            'response' => false,
            'mensaje' => "OCURRIO UN ERROR EN CDC (MSG INTERNO)", //$response['data']['errores'][0]['mensaje'],
            'data' => $data,
        ];
    }


    private function consulata2($postFields)
    {
        $curl = curl_init();

        // Convertir los datos del cuerpo de la solicitud a JSON si es necesario
        $postData = json_encode($postFields);  // Asegúrate de que $postFields esté correctamente formateado

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        //$response = [
        //    'code' => $httpCode,
        //    'data' => json_decode($response, true),  // Decodifica la respuesta JSON
        //];

        return json_decode($response, true);
    }

   
}
