<?php
namespace app\utils\helpers;

use DateTime;
use Exception;

class CurpRfc
{
    private $estadosMap = [
        1 => 'AS', 2 => 'BC', 3 => 'BS', 4 => 'CC', 5 => 'CS', 6 => 'CH', 7 => 'CL',
        8 => 'CM', 9 => 'DF', 10 => 'DG', 11 => 'GT', 12 => 'GR', 13 => 'HG', 14 => 'JC',
        15 => 'MC', 16 => 'MN', 17 => 'MS', 18 => 'NT', 19 => 'NL', 20 => 'OC', 21 => 'PL',
        22 => 'QT', 23 => 'QR', 24 => 'SP', 25 => 'SL', 26 => 'SR', 27 => 'TC', 28 => 'TS',
        29 => 'TL', 30 => 'VZ', 31 => 'YN', 32 => 'ZS', 33 => 'NE'
    ];

    private $vocales = ['A','E','I','O','U'];
    private $consonantes = ['B','C','D','F','G','H','J','K','L','M','N','Ñ','P','Q','R','S','T','V','W','X','Y','Z'];
    private $nombresComunes = ['JOSE','J','MARIA','MA'];
    private $palabrasInconvenientes = [
        'BACA','LOCO','BUEI','BUEY','CACA','CAGO','COGE','COJO','FETO','JOTO','KACA','KULO',
        'MAME','MEON','PENE','PUTA','PUTO','RATA','RUIN','VACA','VAGA','VUEY','WUEY'
    ];

    // =========================
    // CURP
    // =========================
    public function calcularCURP($nombres, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $sexo, $entidadNacimiento)
    {
        $nombres = $this->normalizarTexto($nombres);
        $apellidoPaterno = $this->normalizarTexto($apellidoPaterno);
        $apellidoMaterno = $this->normalizarTexto($apellidoMaterno);

        $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        if (!$fecha) throw new Exception("Formato de fecha inválido. Use YYYY-MM-DD");

        $nombreValido = $this->obtenerNombreValido($nombres);

        // Primera parte CURP
        $curp = substr($apellidoPaterno,0,1);
        $curp .= $this->obtenerPrimeraVocalInterna($apellidoPaterno);
        $curp .= $apellidoMaterno ? substr($apellidoMaterno,0,1) : 'X';
        $curp .= substr($nombreValido,0,1);
        $curp .= $fecha->format('ymd');
        $curp .= strtoupper($sexo);
        $curp .= $this->estadosMap[(int)$entidadNacimiento] ?? 'NE';
        $curp .= $this->obtenerPrimeraConsonanteInterna($apellidoPaterno);
        $curp .= $apellidoMaterno ? $this->obtenerPrimeraConsonanteInterna($apellidoMaterno) : 'X';
        $curp .= $this->obtenerPrimeraConsonanteInterna($nombreValido);

        // Homoclave simplificada (siempre genera algo)
        $curp .= $this->calcularHomoclaveCURP($curp);

        // Dígito verificador simplificado
        $curp .= $this->calcularDigitoVerificadorCURP($curp);

        // Evitar palabras inconvenientes
        if (in_array(substr($curp,0,4), $this->palabrasInconvenientes)) {
            $curp = substr_replace($curp,'X',1,1);
        }
        $str = '';
        for ($i=0; $i<((strlen($curp)-1)); $i++) {
            $str .= $curp[$i];
        }
        return $str;
    }

    // =========================
    // RFC
    // =========================
    public function calcularRFC($nombres, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento)
    {
        $nombres = $this->normalizarTexto($nombres);
        $apellidoPaterno = $this->normalizarTexto($apellidoPaterno);
        $apellidoMaterno = $this->normalizarTexto($apellidoMaterno);

        $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        if(!$fecha) throw new Exception("Formato de fecha inválido");

        $nombreValido = $this->obtenerNombreValido($nombres);

        // Primera parte RFC
        $rfc = substr($apellidoPaterno,0,1);
        $rfc .= $this->obtenerPrimeraVocalInterna($apellidoPaterno);
        $rfc .= $apellidoMaterno ? substr($apellidoMaterno,0,1) : 'X';
        $rfc .= substr($nombreValido,0,1);
        $rfc .= $fecha->format('ymd');

        if(in_array(substr($rfc,0,4), $this->palabrasInconvenientes)) {
            $rfc = substr_replace($rfc,'X',1,1);
        }

        // Homoclave simplificada (siempre genera algo)
        $rfc .= $this->calcularHomoclaveRFC($rfc);

        // Dígito verificador simplificado
        $rfc .= $this->calcularDigitoVerificadorRFC($rfc);

        return $rfc;
    }

    // =========================
    // Helpers
    // =========================
    private function normalizarTexto($txt)
    {
        $txt = strtoupper($txt);
        $txt = str_replace(['Á','É','Í','Ó','Ú','Ü','Ñ'], ['A','E','I','O','U','U','N'], $txt);
        $txt = preg_replace('/\b(DE(L)?|LA|LOS|LAS|Y|MC|MAC|VON|VAN)\b/u', '', $txt);
        $txt = preg_replace('/[^A-Z\s]/', '', $txt);
        return trim(preg_replace('/\s+/', ' ', $txt));
    }

    private function obtenerNombreValido($nombres)
    {
        $arr = explode(" ", $nombres);
        return (count($arr) > 1 && in_array($arr[0], $this->nombresComunes)) ? $arr[1] : $arr[0];
    }

    private function obtenerPrimeraVocalInterna($txt)
    {
        for($i=1;$i<strlen($txt);$i++){
            if(in_array($txt[$i], $this->vocales)) return $txt[$i];
        }
        return 'X';
    }

    private function obtenerPrimeraConsonanteInterna($txt)
    {
        for($i=1;$i<strlen($txt);$i++){
            if(in_array($txt[$i], $this->consonantes)) return $txt[$i];
        }
        return 'X';
    }

    // =========================
    // Homoclave y dígito verificador simplificados
    // =========================
    private function calcularHomoclaveCURP($curp)
    {
        // Genera dos letras/dígitos aleatorios
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return $chars[rand(0,35)] . $chars[rand(0,35)];
    }

    private function calcularHomoclaveRFC($rfc)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return $chars[rand(0,35)] . $chars[rand(0,35)];
    }

    private function calcularDigitoVerificadorCURP($curp)
    {
        // Dígito 0-9 aleatorio
        return rand(0,9);
    }

    private function calcularDigitoVerificadorRFC($rfc)
    {
        return rand(0,9);
    }
}
