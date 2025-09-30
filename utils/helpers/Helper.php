<?php

namespace app\utils\helpers;

use Yii;

class Helper
{

    public static function rfc_nufi($data){
        $rfc = "";
        if ($data == null) {
            return '--';
        }
        if (isset($data['data']) && isset($data['data']['rfc'])) {
            $rfc = $data['data']['rfc'];
        }
        return $rfc;
    }

    public static function curp_nufi($response_nufi = null) {
        $curp = "";
        
        if ($response_nufi == null) {
            return '';
        }
        
        // Verificar si existe la estructura esperada
        if (isset($response_nufi['data']) && 
            isset($response_nufi['data']['curpdata']) && 
            is_array($response_nufi['data']['curpdata']) && 
            count($response_nufi['data']['curpdata']) > 0 &&
            isset($response_nufi['data']['curpdata'][0]['curp'])) {
            
            $curp = $response_nufi['data']['curpdata'][0]['curp'];
        }
        
        return $curp;
    }

    

    public static function is_valid_ine($response_nobarium = null)
    {
        if ($response_nobarium == null) {
            return [
                'success' => false,
                'code' => 10,
                'data' => null,
                'type' => 'EXCEPTION',
                'message' => 'No se ha podido validar el INE, intente nuevamente',
            ];
        }
        if (isset($response_nobarium['estatus'])) {
            $response_nobarium['estatus']  =  strtoupper(trim($response_nobarium['estatus']));
            if ($response_nobarium['estatus'] == 'ERROR') {
                return [
                    'success' => false,
                    'code' => 10,
                    'data' => null,
                    'type' => 'EXCEPTION',
                    'message' => $response_nobarium['mensaje'] . " (INE).",
                ];
            }
        }

        return [
            'success' => true,
            'code' => 202,
            'data' => $response_nobarium,
            'type' => 'EXITO',
            'message' => 'El INE es válido',
        ];
    }

    public static function valid_rfc($response)
    {
        //return $response;
        $rfc = "";
        if ($response == null) {
            return $rfc;
        }
        $status = $response['estatus'] ?? 'ERROR';
        if ($status == "OK") {
            $rfc = $response['rfcGenerado'] ?? "";
            //return $rfc;
        }

        return $rfc;
    }

    public static function valid_curp($response)
    {
        //return $response;
        $rfc = "";
        if ($response == null) {
            return $rfc;
        }
        $status = $response['estatus'] ?? 'ERROR';
        if ($status == "OK") {
            $rfc = $response['curp'] ?? "";
            //return $rfc;
        }

        return $rfc;
    }

    public static function is_valid_rfc_sat($response_nobarium = null)
    {
        if ($response_nobarium == null) {
            return false;
        }

        $status = $response_nobarium['estatus'] ?? 'ERROR';
        if ($status == "OK") {
            return true;
        }
        return false;
    }

    public static function is_valid_lista_nominal($response = null)
    {
        if ($response == null) {
            return [
                'success' => false,
                'message' => 'No se ha podido validar el INE, intente nuevamente',
            ];
        }

        $status = $response['estatus'] ?? 'ERROR';
        if ($status == "OK") {
            return [
                'success' => true,
                'message' => $response['mensaje'],
            ];
        }

        return [
            'success' => false,
            'message' => $response['mensaje'] ?? 'ERROR',
        ];
    }

    public static function prueba_vida($reponse)
    {
        if ($reponse == null) {
            return [
                'code' => 10,
                'similitude' => 0,
                'success' => false,
                'message' => 'No se ha podido validar el rostro, intente nuevamente',
            ];
        }

        $status = $reponse['estatus'] ?? 'ERROR';
        if ($status == "OK") {
            return [
                'code' => 202,
                'success' => true,
                'similitude' => $reponse['similitud'] ?? 0,
                #'data' => $reponse,
                'message' => $reponse['mensaje'],
            ];
        }

        return [
            'code' => 10,
            'similitude' => 0,
            'success' => false,
            'message' => $reponse['mensaje'] ?? 'ERROR',
        ];
    }
    public static function paso_listas_negras($response)
    {
        if ($response == null) {
            return false;
        }
        #si es OK esta en listas negras 
        $status = $response['estatus'] ?? 'ERROR';
        if ($status == "OK") {
            return false;
        }
        #caso contrario si pasa 
        return true;
    }

    public static function isValidBase64Image($base64_string)
    {
        return true;
        // Verificar si es una cadena base64 válida
        if (preg_match('/^data:image\/(jpeg|jpg|png|gif);base64,/', $base64_string)) {
            $data = explode(',', $base64_string);

            // Decodificar la parte de datos base64
            $decoded_data = base64_decode($data[1], true);


            // Verificar si la decodificación fue exitosa y si es una imagen válida
            if ($decoded_data !== false) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_buffer($finfo, $decoded_data);
                finfo_close($finfo);

                // Validar que sea una imagen válida (jpeg, png, gif)
                if (in_array($mime_type, ['image/jpeg', 'image/png', 'image/gif'])) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function generateToken($length = 6)
    {
        $numbers = '0123456789';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $numbers[random_int(0, 9)];
        }
        return $token;
    }


    public static function generateMensaje($number, $token = null)
    {
        if ($token === null) {
            $token = self::generateToken();
        }
        $message = "Su token de validacion es: **" . $token . "**";
        $message_utf8 = utf8_encode($message);
        return [
            "to" => ["52" . $number],
            "message" => $message_utf8,
            "from" => "ORIGINACION"
        ];
    }


    /**
     * ===========================================================================
     *                              SAVE IMG
     * ===========================================================================
     */
    public static function saveBase64Image_($base64Image, $imageType)
    {
        ini_set('memory_limit', '-1');
        // Decodificar la imagen de base64

        $decodedImage = base64_decode($base64Image);

        $extension = 'jpg';

        // Generar un nombre único para la imagen
        $fileName = uniqid() . '.' . $extension;
        $filePath = Yii::getAlias('@webroot/uploads/' . $imageType . '/') . $fileName;

        // Asegurarse de que el directorio exista
        if (!is_dir(Yii::getAlias('@webroot/uploads/' . $imageType))) {
            mkdir(Yii::getAlias('@webroot/uploads/' . $imageType), 0777, true);
        }
        // Guardar la imagen en el servidor
        if (file_put_contents($filePath, $decodedImage)) {
            return '/uploads/' . $imageType . '/' . $fileName;
        } else {
            return false;
        }
    }

    public static function saveBase64Image($base64Image, $imageType)
    {
        // Validar y extraer datos base64
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $extension = strtolower($type[1]);
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return false; // Tipo de imagen no permitido
            }
        } else {
            $extension = 'jpg'; // Por defecto
        }

        $decodedImage = base64_decode($base64Image, true);
        if ($decodedImage === false) {
            return false; // Base64 inválido
        }

        $fileName = uniqid() . '.' . $extension;
        $dirPath = Yii::getAlias('@webroot/uploads/' . $imageType . '/');
        $filePath = $dirPath . $fileName;

        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        if (file_put_contents($filePath, $decodedImage)) {
            return '/uploads/' . $imageType . '/' . $fileName;
        } else {
            return false;
        }
    }



    public static function reglasFechaCorte()
    {
        $day = (int)date('j');
        return ($day <= 15 || $day == 31) ? 15 : 30;
    }
}
