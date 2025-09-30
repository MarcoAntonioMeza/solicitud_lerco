<?php

namespace app\models\cliente;


use Yii;

use app\models\user\User;
use app\models\solicitud\Solicitud;
use app\models\esys\EsysDireccion;

/**
 * This is the model class for table "persona".
 *
 * @property int $id
 * @property string $nombres
 * @property string|null $segundo_nombre
 * @property string|null $apellido_materno
 * @property string|null $apellido_paterno
 * @property string|null $fecha_nacimiento
 * @property string|null $genero
 * @property int|null $tipo
 * @property string|null $curp
 * @property string|null $rfc
 * @property string|null $estado_civil
 * @property string|null $email
 * @property string|null $telefono
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Solicitud[] $solicituds
 */
class Persona extends \yii\db\ActiveRecord
{

    const GENERO_MASCULINO = 'M';
    const GENERO_FEMENINO = 'F';


    const PERSONA_CLIENTE        = 1;
    const PERSONA_PROVEEDOR      = 2;
    const PERSONA_EMPLEADO       = 3;
    const PERSONA_ADMINISTRADOR  = 4;

    const TIPO_PERSONA_FISICA    = 10;
    const TIPO_PERSONA_MORAL      = 20;


    public $dir_obj;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombres'], 'required'],
            [['fecha_nacimiento', 'created_at', 'updated_at'], 'safe'],
            [['tipo', 'created_by', 'updated_by'], 'integer'],
            [['nombres','segundo_nombre', 'apellido_materno', 'apellido_paterno', 'email', 'cic', 'estado_mx', 'identificador_ciudadano'], 'string', 'max' => 100],
            [['genero'], 'string', 'max' => 1],
            [['curp', 'rfc', 'estado_civil'], 'string', 'max' => 50],
            [['telefono'], 'string', 'max' => 15],
            [['curp'], 'unique'],
            [['rfc'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombres' => 'Nombres',
            'segundo_nombre' => 'Segundo Nombre',
            'apellido_materno' => 'Apellido Materno',
            'apellido_paterno' => 'Apellido Paterno',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'genero' => 'Genero',
            'tipo' => 'Tipo',
            'curp' => 'Curp',
            'rfc' => 'Rfc',
            'estado_civil' => 'Estado Civil',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[Solicituds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['persona_id' => 'id'])
        ->orderBy(['id' => SORT_DESC]);
    }

    public function getFullName()
    {
        return $this->nombres . ' ' . $this->segundo_nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }


    public function getDireccion()
    {
        return $this->hasOne(EsysDireccion::className(), ['cuenta_id' => 'id'])
            ->where(['cuenta' => EsysDireccion::CUENTA_PROSPECTO, 'tipo' => EsysDireccion::TIPO_PERSONAL]);
    }

    public function getDirs(){
        $direccion = $this->direccion;
        $data = [
            'estado_id' => $direccion->estado_id ?? null,
            'estado' => $direccion->estado->singular ?? null,
            'municipio_id' => $direccion->municipio_id ?? null,
            'municipio' => $direccion->municipio->singular ?? null,
            //'colonia_id' => $direccion->colonia_id ?? null,
            'colonia' => $direccion->esysDireccionCodigoPostal->colonia ?? null,
            //'codigo_postal_id' => $direccion->codigo_postal_id ?? null,
            'direccion' => $direccion->direccion ?? null,
            'num_ext' => $direccion->num_ext ?? null,
            'num_int' => $direccion->num_int ?? null,
            'codigo_search' => $direccion->esysDireccionCodigoPostal->codigo_postal ?? null,
        ];

        return $data;
    }



    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        if ($insert) {
            $this->dir_obj->cuenta_id = $this->id;
        }
        // Guardar dirección
        if ($this->dir_obj != null) {
            if (!$this->dir_obj->save()) {
                throw new \Exception('Error al guardar la dirección' . json_encode($this->dir_obj->getErrors()));
            }
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            #$this->valor = strtoupper(trim($this->valor));
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
                #$this->fecha_solicitud = date('Y-m-d H:i:s');
                #$this->created_by = Yii::$app->user->identity ? Yii::$app->user->identity->id : null;
            } else {
                $this->updated_at = date('Y-m-d H:i:s');
                #$this->updated_by = Yii::$app->user->identity ? Yii::$app->user->identity->id : null;
            }
            //$this->name_id = str_replace(' ', '_', $this->nombre) . '_' . $this->created_at;
            return true;
        } else
            return false;
    }
}
