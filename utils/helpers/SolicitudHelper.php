<?php

namespace app\utils\helpers;

use Yii;
use app\models\cliente\Persona;
use app\models\solicitud\Solicitud;
use app\utils\consultas\Nobarium;

class SolicitudHelper{

    

    /**
     * ?===========================================================
     *                       LISTAS NOMINALESS
     * ============================================================
     */

    public static function paso_listas_nominales($persona_id){
        $model_persona = Persona::findOne($persona_id);
        // Lógica para el paso de listas nominales
        $lista_nominal = (new Nobarium())->ineListaNominal($model_persona->cic, $model_persona->identificador_ciudadano);
        $is_valid = Helper::is_valid_lista_nominal($lista_nominal);

        if (!$is_valid['success']) {
            return [
                'success' => false,
                'message' => $is_valid['message'] ?? 'Error desconocido en listas nominales',
            ];
        }   
        // Si la validación es exitosa, se puede continuar con el proceso
        return [
            'success' => true,
            'message' => 'Validación de listas nominales exitosa',
        ];     
    }

    public static function conside_data_ine($ocr, $persona_id){

        $model_persona = Persona::findOne($persona_id);
        $fecha_modelo = $model_persona->fecha_nacimiento; // formato SQL: Y-m-d
        $fecha_ocr = $ocr['fechaNacimiento'] ?? null; // formato: d/m/Y

        // Convertir fecha del OCR a formato SQL
        $fecha_ocr_sql = null;
        if ($fecha_ocr) {
            $fecha = \DateTime::createFromFormat('d/m/Y', $fecha_ocr);
            if ($fecha) {
                $fecha_ocr_sql = $fecha->format('Y-m-d');
            }
        }

        $son_iguales = ($fecha_modelo === $fecha_ocr_sql);

        $curp_modelo = strtoupper(str_replace(' ', '', $model_persona->curp));
        $curp_ocr = strtoupper(str_replace(' ', '', $ocr['curp'] ?? ''));
        $curp_igual = $curp_modelo === $curp_ocr;

        return[
            'success' => true,
            'message' => 'La fecha de nacimiento y CURP coinciden.',
        ];

        if ($son_iguales && $curp_igual) {
            return [
                'success' => true,
                'message' => 'La fecha de nacimiento y CURP coinciden.',
            ];
        } elseif (!$son_iguales && !$curp_igual) {
            return [
                'success' => false,
                'message' => 'La fecha de nacimiento y CURP no coinciden.',
            ];
        } elseif (!$son_iguales) {
            return [
                'success' => false,
                'message' => 'La fecha de nacimiento no coincide.',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'La CURP no coincide.',
            ];
        }
    }

    public static function get_ocr($ine_frente, $ine_reverso,$persona_id){
         $consulta = new Nobarium();
        #$respuesta = $consulta->validateIne(preg_replace('/^data:image\/\w+;base64,/', '', $post['ine_frente']), preg_replace('/^data:image\/\w+;base64,/', '', $post['ine_reverso']));
        $respuesta = $consulta->validateIne(preg_replace('/^data:image\/\w+;base64,/', '', $ine_frente), preg_replace('/^data:image\/\w+;base64,/', '', $ine_reverso));
        $ine = Helper::is_valid_ine($respuesta);
        if (!$ine['success']) {
            return [
                'success' => false,
                'message' => $ine['message']??'Error desconocido en ocr',
            ];
        }

        $ocr = $ine['data'];
        //throw new \Exception('Error en OCR'.json_encode($ocr));
        $persona = Persona::findOne($persona_id);
        $persona->cic = $ocr['cic'] ?? '';
        $persona->identificador_ciudadano = $ocr['identificadorCiudadano'] ?? '';
        $persona->save();

        return $ine;
    }

    public static function valida_informacion($ine_frente, $ine_reverso, $persona_id){
        $ocr = self::get_ocr($ine_frente, $ine_reverso, $persona_id);
        //throw new \Exception('Error en OCR'.json_encode($ocr['data']));
        if (!$ocr['success']) {
            return [
                'success' => false,
                'message' => $ocr['message'] ?? 'Error al obtener OCR',
            ];
        }

        $validacion = self::conside_data_ine($ocr['data'], $persona_id);
        if (!$validacion['success']) {
            return [
                'success' => false,
                'message' => $validacion['message'],
            ];
        }

        $validacion = self::paso_listas_nominales($persona_id);
        if (!$validacion['success']) {
            return [
                'success' => false,
                'message' => $validacion['message'],
            ];
        }

        return [
            'success' => true,
            'message' => 'Validación exitosa',
            'data' => $ocr,
        ];
    }

    

}