<?php

namespace app\utils\consultas;


use Yii;
use yii\base\Model;
use LSS\XML2Array;
//use app\models\auditoria\AuditoriaScore;
use app\models\logs\LogApi;


/**
 * @category   Facturación electrónica
 * @package    ADVANS
 * @version    0.1.0, 2015-01-25
 */
class ScoreAlterno extends Model
{

    private $user = 'PQaMh9ku1Yn4tO26izi4o4wSYlz8gNMImPsla5I6LE8=';
    private $pwd = 'goCx85I730DT1ioyWZp5ixpriHErZpoAfbGE4Iz0QA8=';
    private $pModelId = 'SCORE_BLUE_DIAMOND';
    private $post = [];
    private $is_productivo = false;
    private $numero = "";
    private $code = "";

    public function __construct($is_productivo)
    {
        $this->is_productivo = $is_productivo;
    }

    private $response;


    public function response()
    {
        return $this->response;
    }


    public  function soapRequestConsultaScore($tel, $code)
    {
        $this->numero = $tel;
        $this->code = $code;
        //$this->is_productivo = !$this->is_productivo;

        $post = [
            'data' => '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/" xmlns:app="http://schemas.datacontract.org/2004/07/Apptividad.CrediQuick.DataContracts">
              <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing" xmlns:wsrm="http://docs.oasis-open.org/ws-rx/wsrm/200702">
                  <wsa:Action>http://tempuri.org/IBusinessOrchestrationService/EnqueueCustomerAnalysisV2</wsa:Action>
                  <wsa:MessageID>uuid:cd9f1851-e3e9-4aa6-875f-9b95326c1551</wsa:MessageID>
                  <wsa:To>https://st.apptividad.net/APPTIVIDAD_TELCO/Apptividad.TimeToYes.BusinessProxy/BusinessOrchestrationService.svc</wsa:To>
                  <o:Security soap:mustUnderstand="1" xmlns:o="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                      <o:UsernameToken>
                          <o:Username>' . ($this->is_productivo ? $this->user : '3+AcobjrCjrmI3Ts4jbr/w==') . '</o:Username>
                          <o:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">' . ($this->is_productivo ? $this->pwd : 'wxwYt0r7skqLztkC9wavog==') . '</o:Password>
                      </o:UsernameToken>
                  </o:Security>
              </soap:Header>
              <soap:Body>
                  <tem:EnqueueCustomerAnalysisV2>
                      <tem:pCustomerId>' . ($this->is_productivo ? $tel : '5555555555') . '</tem:pCustomerId>
                      <tem:pTypeId>tel</tem:pTypeId>
                      <tem:pModelId>' . ($this->is_productivo ? $this->pModelId : 'PRIV_CONSULTA_SCORE') . '</tem:pModelId>
                      <tem:pCustomerListParams>
                          <app:KeyValueParam>
                              <app:_x003C_Key_x003E_k__BackingField>NUMERO_TELEFONICO</app:_x003C_Key_x003E_k__BackingField>
                              <app:_x003C_Value_x003E_k__BackingField>' . ($this->is_productivo ? $tel : '5555555555') . '</app:_x003C_Value_x003E_k__BackingField>
                          </app:KeyValueParam>
                      </tem:pCustomerListParams>
                      <tem:pUser>Usuario.Conexion</tem:pUser>
                      <tem:pWaitingInterval>1</tem:pWaitingInterval>
                      <tem:pPriority>1</tem:pPriority>
                  </tem:EnqueueCustomerAnalysisV2>
              </soap:Body>
          </soap:Envelope>'
        ];

        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_URL => ($this->is_productivo ? "https://services.apptividad.net/APPTIVIDAD_TELCO/Apptividad.TimeToYes.BusinessProxy/BusinessOrchestrationService.svc" : 'https://st.apptividad.net/APPTIVIDAD_TELCO/Apptividad.TimeToYes.BusinessProxy/BusinessOrchestrationService.svc'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post['data'],
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/soap+xml;charset=UTF-8;',
                'SOAPAction: http://tempuri.org/IBusinessOrchestrationService/EnqueueCustomerAnalysisV2'
            ),
        ));
        set_time_limit(0);
        $soap = curl_exec($curl);

        $err = curl_error($curl);


        curl_close($curl);

        if ($err) {
            $log = LogApi::save_log(LogApi::SCORE_ALTERNO, 'ALTERNO', $this->numero, $post['data']);
            #$log = $this->saveLog($tel, 1, 1, $post['data'], json_encode($err), 'SCORE ALTERNO con error', 'SCORE ALTERNO');;
            return  [
                "code"   => 10,
                "result" => "Ocurrio un error, intenta nuevamente ",
            ];
        } else {
            $log = LogApi::save_log(LogApi::SCORE_ALTERNO, 'ALTERNO', $post['data'], $soap);
            $array = self::xmlToArray($soap);
            //AuditoriaScore::saveAuditoria($tel, $code, $array['result'] . "");
            return $array;
        }
    }

    public static function xmlToArray($xml)
    {
        $cfdi_array = XML2Array::createArray($xml);
        $score = 0;
        $debug_info = [];

        try {
            $base_path = $cfdi_array['s:Envelope']['s:Body']['EnqueueCustomerAnalysisV2Response']['EnqueueCustomerAnalysisV2Result'] ?? null;

            if (!$base_path) {
                $debug_info[] = "No se encontró la estructura base de respuesta";
                error_log("ScoreAlterno Debug: " . json_encode($debug_info));
                return ["code" => 202, "result" => 0];
            }

            $extractScore = function ($value) {
                if (is_array($value)) {
                    if (isset($value['@attributes']['nil']) && $value['@attributes']['nil'] === 'true') {
                        return 0;
                    }
                    return isset($value['@value']) ? (int)$value['@value'] : 0;
                }
                return is_numeric($value) ? (int)$value : 0;
            };

            // Intentar SUPER_FINALSCORE
            $super_final = $base_path['b:_x003C_Customer_x003E_k__BackingField']['c:SUPER_FINALSCORE'] ?? null;
            $score = $extractScore($super_final);
            $debug_info[] = "Score obtenido de SUPER_FINALSCORE: $score";

            // Si no hay, intentar FINALSCORE
            if ($score === 0) {
                $final_score = $base_path['b:_x003C_Customer_x003E_k__BackingField']['c:FINALSCORE'] ?? null;
                $score = $extractScore($final_score);
                $debug_info[] = "Score obtenido de FINALSCORE: $score";
            }

            // Si todavía no hay score, usar score_wcredito de XMLRESPONSE
            if ($score === 0) {
                $xml_response = $base_path['b:_x003C_BurXmlDatasource_x003E_k__BackingField']['c:BUR_XML_DATASOURCE_GET_BY_CUSTOMERResult']['c:XMLRESPONSE'] ?? '';
                if (!empty($xml_response)) {
                    // Verifica si es array o string
                    if (is_array($xml_response)) {
                        $inner_xml = $xml_response; // ya es un array
                    } else {
                        $inner_xml = XML2Array::createArray(html_entity_decode($xml_response));
                    }

                    $score_wcredito = $inner_xml['export']['scoreResponse']['result']['score_wcredito'] ?? 0;
                    $score = is_numeric($score_wcredito) ? (int)$score_wcredito : 0;

                    $debug_info[] = "Score obtenido de XMLRESPONSE: $score";
                }
            }
        } catch (\Exception $e) {
            $debug_info[] = "Error general: " . $e->getMessage();
            error_log("ScoreAlterno Error: " . $e->getMessage());
        }

        error_log("ScoreAlterno Debug: " . json_encode($debug_info));

        return [
            "code" => 202,
            "result" => $score,
        ];
    }
    //private function saveLog($id, $sucursal, $empresa, $postFields, $data, $nombre, $tipo = 'API HUP')
    //{
    //    $log = new LogApis();
    //    $log->data_id = $id;
    //    $log->sucursal_id = $sucursal;
    //    $log->tipo_solicitud = $tipo;
    //    $log->nombre_api = $nombre;
    //    $log->body = $postFields;
    //    $log->response = json_encode($data);
    //    return $log->save();
    //}
}
