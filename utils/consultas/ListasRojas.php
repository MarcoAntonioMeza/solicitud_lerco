<?php

namespace app\utils\consultas;

use Yii;
use app\models\logs\LogApi;
use Dotenv\Dotenv;
use \Exception;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();


class ListasRojas
{
    private $token;
    private $baseUrl = "https://erp-gateway.apymsa.com.mx";

    // Método para generar el token
    public function generateTokenLN()
    {
        $url = $this->baseUrl . "/identitysvr/connect/token";

        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => 'CreditAutex.client',
            'client_secret' => 'Cr3d1tAut3x',
            'scope' => 'CreditoBlueDiamond.API.read'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'User-Agent: PostmanRuntime/7.39.0',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
            'X-ExodusDev: BlueDiamond_'
        ]);

        $response = curl_exec($ch);
        #$response = curl_setopt($ch, CURLOPT_ENCODING, ''); // Permitir gzip/br

        if (curl_errno($ch)) {
            throw new Exception('Error in cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        LogApi::save_log(
            LogApi::APYMSA,
            'GENERACION DE TOKEN',
            $data,
            $responseData
        );

        #return $responseData;
        if (isset($responseData['access_token'])) {

            $this->token = $responseData['access_token'];
        } else {
            throw new Exception('Failed to retrieve access token. Response: ' . $response);
        }

        return $this->token;
    }

    // Método para realizar la consulta a la API
    public function getBlacklistStatus($rfc)
    {
        if (!$this->token) {
            throw new Exception('Token not generated. Call generateToken() first.');
        }

        $url = $this->baseUrl . "/bd/clientes/credito/api/v1/ListaNegra?rfc=" . urlencode($rfc);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, ''); // Descomprimir gzip/br automáticamente
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json',
            'User-Agent: PostmanRuntime/7.39.0',
            'X-ExodusDev: BlueDiamond_'

        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Error in cURL: ' . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        LogApi::save_log(
            LogApi::APYMSA,
            'CONSULTA LISTA ROJA',
            ['rfc' => $rfc, 'url' => $url],
            $responseData
        );

        if (isset($responseData['succeeded']) && $responseData['succeeded'] === true) {
            return $responseData['data'];
        } else {
            throw new Exception('API request failed. Response: ' . $response);
        }
    }
}
