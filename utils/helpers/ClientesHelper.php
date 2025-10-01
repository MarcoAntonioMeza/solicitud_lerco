<?php

namespace app\utils\helpers;

use Yii;
use app\models\persona\Persona;
use app\models\solicitud\Solicitud;
use app\models\esys\EsysDireccion;


class ClientesHelper
{


    public static function validarRangoEdad($fechaNacimiento = '', $edadMinimaAnios = 21, $edadMinimaMeses = 0, $edadMaximaAnios = 71, $edadMaximaMeses = 11)
    {
        $fechaNacimiento = self::invertirFecha($fechaNacimiento);
        // Convertir la fecha de nacimiento a un objeto DateTime
        $fechaNacimiento = new \DateTime($fechaNacimiento);
        // Obtener la fecha actual
        $fechaActual = new \DateTime();

        // Calcular la fecha mínima permitida (fecha actual - edad mínima)
        $fechaMinima = clone $fechaActual;
        $fechaMinima->sub(new \DateInterval('P' . $edadMinimaAnios . 'Y' . $edadMinimaMeses . 'M'));

        // Calcular la fecha máxima permitida (fecha actual - edad máxima)
        $fechaMaxima = clone $fechaActual;
        $fechaMaxima->sub(new \DateInterval('P' . $edadMaximaAnios . 'Y' . $edadMaximaMeses . 'M'));

        // Calcular la edad de la persona
        $edadIntervalo = $fechaActual->diff($fechaNacimiento);
        $edadAnios = $edadIntervalo->y;
        $edadMeses = $edadIntervalo->m;
        $edadDias = $edadIntervalo->d;

        // Verificar si la fecha de nacimiento está dentro del rango permitido
        $dentroDelRango = ($fechaNacimiento <= $fechaMinima && $fechaNacimiento >= $fechaMaxima);

        // Retornar la validación y la edad como un array
        return [
            'dentroDelRango' => $dentroDelRango,
            'edad' => [
                'anios' => $edadAnios,
                'meses' => $edadMeses,
                'dias' => $edadDias
            ]
        ];
    }

    public static function invertirFecha($fecha)
    {
        // Dividir la fecha en partes usando el guion como delimitador
        $partes = explode('/', $fecha);

        // Si la fecha tiene tres partes (dd-mm-yyyy)
        if (count($partes) == 3) {
            // Invertir las partes para formar yyyy-mm-dd
            $fechaInvertida = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
            return $fechaInvertida;
        } else {
            // Si la fecha no tiene el formato esperado, devolver la misma fecha
            return $fecha;
        }
    }



    public static function crear_o_actualizar_persona($persona_post, $dirs)
    {
        $persona = new Persona();
        $persona->tipo = Persona::PERSONA_CLIENTE;

        #$fecha_na = $persona_post['fecha_nacimiento'] ?? null;
        #$nacimiento = null;
        #try {
        #    $fechaFormateada = \DateTime::createFromFormat('d/m/Y', $fecha_na);
        #    if ($fechaFormateada === false) {
        #        #return [
        #        #    'code' => 10,
        #        #    'mensaje' => 'Formato de fecha inválido. Use DD/MM/YYYY',
        #        #];
        #    }
        #    $nacimiento = $fechaFormateada->format('Y/m/d');
        #} catch (\Exception $e) {
        #    #return [
        #    #    'code' => 10,
        #    #    'mensaje' => 'Error al procesar la fecha: ' . $e->getMessage(),
        #    #];
        #    $nacimiento = null;
        #}

        $persona->nombres = $persona_post['nombres'] ?? '';
        //$persona->segundo_nombre = $persona_post['segundo_nombre'] ?? '';
        $persona->apellido_paterno = $persona_post['apellido_paterno'] ?? '';
        $persona->apellido_materno = $persona_post['apellido_materno'] ?? '';
        #$persona->fecha_nacimiento = $nacimiento ?? null;
        $persona->genero = $persona_post['sexo'] ?? null;
        $persona->curp = $persona_post['curp'] ?? null;
        $persona->rfc = $persona_post['rfc'] ?? null;
        $persona->created_by = 1; // Considerar obtener el usuario actual
        $persona->email = $persona_post['email'] ?? null;
        $persona->telefono = $persona_post['numero'] ?? null;
        $persona->cargo = $persona_post['cargo'] ?? null;
        $persona->empresa = $persona_post['empresa'] ?? null;

        // Dirección
        $persona->dir_obj = new EsysDireccion([
            'cuenta' => EsysDireccion::CUENTA_PROSPECTO,
            'tipo'   => EsysDireccion::TIPO_PERSONAL,
        ]);
        $persona->dir_obj->codigo_search = $dirs['codigo_postal'] ?? null;
        $persona->dir_obj->estado_id = $dirs['estado_id'] ?? null;
        $persona->dir_obj->municipio_id = $dirs['municipio_id'] ?? null;
        $persona->dir_obj->codigo_postal_id = $dirs['codigo_postal_id'] ?? null;
        $persona->dir_obj->direccion = $dirs['direccion'] ?? "";
        $persona->dir_obj->num_ext = $dirs['num_ext'] . "" ?? "";
        $persona->dir_obj->num_int = $dirs['num_int'] . "" ?? "";

        $saved = $persona->save();

        return [
            'success' => $saved,
            'errors' => $persona->errors,
            'message' => $saved ? 'Persona guardada correctamente.' : 'Ocurrió un error, intente más tarde o contáctenos.',
            'id' => $persona->id,
            'persona_nombre' => $persona->getFullName(),
            'mail' => $persona->email,
        ];
    }
}
