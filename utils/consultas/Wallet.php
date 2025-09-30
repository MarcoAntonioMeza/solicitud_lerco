<?php

namespace app\utils\consultas;



use app\models\cliente\Persona;
use app\models\logs\LogApi;

class Wallet
{
    private $url = 'https://blue-diamond.lerco.agency/web/v1/cliente-originacion/customer-record-cosmo';
    private $applyPuntosWallet = true;



    private $token = "cm_priv4mybRcrKbzrI549wj3b3YTZAL20W7w47YUPTG1jmj35QFhwTxx1xEuUy6";

    private $is_productivo;



    public function __construct($is_productivo, $applyPuntosWallet = true)
    {

        $this->applyPuntosWallet = $applyPuntosWallet;
        $this->is_productivo = $is_productivo;
        #if ($is_productivo) {
        #    $this->url = 'https://blue-diamond.lerco.agency/web/v1/cliente-originacion/customer-record-cosmo';
        #} else {
        #    $this->url = 'https://dev.wallet-bds.lercomx.com/web/v1/cliente-originacion/customer-record-cosmo';
        #}
        $this->url = 'https://dev.wallet-bds.lercomx.com/web/v1/cliente-originacion/customer-record-cosmo';
        #$this->url = 'https://blue-diamond.lerco.agency/web/v1/cliente-originacion/customer-record-cosmo';

        
    }

    public function sendData($cliente_id)
    {
        if (!$this->applyPuntosWallet) {
            return [
                "code"      => 202,
                "name"      => "Customer - Record",
                "type"      => "success",
                'message'   => "Se realizo correctamente la operacion (DEMO)",
            ];
        }

        $data = $this->getInfoCliente($cliente_id);

        // Agregar el token al arreglo de datos
        $data['token'] = $this->token;

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        #$cliente = Cliente::findOne($cliente_id);
        #LogApis::saveLog('Conexion con Wallet', $cliente->sucursal_id, $cliente->empresa_id, json_encode($data), $response, 'Solicitud wallet', 'Wallet');
        LogApi::save_log(LogApi::WALLET, strtoupper('Solicitud wallet'), $data, json_decode($response, true));
        return [
            'response' => json_decode($response),
            'httpcode' => $httpcode
        ];
    }

    public  function getInfoCliente($cliente_id)
    {
        $cliente = Persona::findOne($cliente_id);

        $branch_id = $cliente->solicituds ? $cliente->solicituds[0]->sucursal_id : null;
        $companyId =  1; // APYMSA

        $email = $cliente->email;
        $fechaObjeto = \DateTime::createFromFormat('Y-m-d', $cliente->fecha_nacimiento);

        $dataSendWallet  = [
            'cp' => $cliente->dirs['codigo_search'],
            'cuidad' => $cliente->dirs['municipio'],
            'estado' => $cliente->dirs['estado'],
            'municipio' => $cliente->dirs['municipio'],
            'colonia' => $cliente->dirs['colonia'],
            'calle' => $cliente->dirs['direccion'],
            'Street' => $cliente->dirs['direccion'],
            'no_exterior' => $cliente->dirs['num_ext'],
            'no_interior' => $cliente->dirs['num_int'],
            'Email' => $email,
            'GivenName' => $cliente->nombres,
            'MiddleName' => $cliente->segundo_nombre,
            'LastName' => $cliente->apellido_paterno,
            'SecondLastName' => $cliente->apellido_materno,
            'Cellphone' => $cliente->telefono,
            'Rfc' => $cliente->rfc,
            'BirthDate' =>  $fechaObjeto->format('d/m/Y'),
            'BranchId' => $branch_id,
            'CompanyId' => $companyId
        ];
        return $dataSendWallet;
    }
}
