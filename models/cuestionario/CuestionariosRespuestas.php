<?php

namespace app\models\cuestionario;

use Yii;
use app\models\user\User;
use app\models\solicitud\Solicitud;

/**
 * This is the model class for table "cuestionarios_respuestas".
 *
 * @property int $id
 * @property int $pregunta_id
 * @property int $solicitud_id
 * @property string $respuesta
 * @property int $estado
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property CuestionariosPreguntas $pregunta
 * @property Solicitud $solicitud
 * @property User $updatedBy
 */
class CuestionariosRespuestas extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuestionarios_respuestas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pregunta_id', 'solicitud_id', 'respuesta', 'created_at'], 'required'],
            [['pregunta_id', 'solicitud_id', 'estado', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['respuesta'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['pregunta_id'], 'exist', 'skipOnError' => true, 'targetClass' => CuestionariosPreguntas::className(), 'targetAttribute' => ['pregunta_id' => 'id']],
            [['solicitud_id'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitud::className(), 'targetAttribute' => ['solicitud_id' => 'id']],
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
            'pregunta_id' => 'Pregunta ID',
            'solicitud_id' => 'Solicitud ID',
            'respuesta' => 'Respuesta',
            'estado' => 'Estado',
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
     * Gets query for [[Pregunta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPregunta()
    {
        return $this->hasOne(CuestionariosPreguntas::className(), ['id' => 'pregunta_id']);
    }

    /**
     * Gets query for [[Solicitud]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::className(), ['id' => 'solicitud_id']);
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


    //------------------------------------------------------------------------------------------------//
    // ACTIVE RECORD
    //------------------------------------------------------------------------------------------------//
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {


            //normalizar campos
            $this->respuesta = trim($this->respuesta) !== "" ? trim($this->respuesta) : '';
            if ($insert) {
                $this->created_at   = time();
                //$this->created_by   = Yii::$app->user->identity ? Yii::$app->user->identity->id : null;
            } else {
                // Quién y cuando
                $this->updated_at = time();
                //$this->updated_by = Yii::$app->user->identity ? Yii::$app->user->identity->id : null;
            }
            //$this->name_id = str_replace(' ', '_', $this->nombre) . '_' . $this->created_at;
            return true;
        } else
            return false;
    }


    public static function guardarRespuestas($cliente_id, $lista, $user_id)
    {
        foreach ($lista as $key => $value) {
            $model = CuestionariosRespuestas::findOne([
                'pregunta_id' => $value['pregunta_id'],
                'solicitud_id' => $cliente_id,
                //'updated_by' => $user_id,
            ]) ?? new CuestionariosRespuestas([
                'pregunta_id' => $value['pregunta_id'],
                'solicitud_id' => $cliente_id,
                'created_by' => $user_id,
                'created_at' => time(),
            ]);
            $model->respuesta = $value['value']."" ?? '--';
            $model->estado = 1;
            if (!$model->save()) {
                # throw new \yii\base\Exception(json_encode($model->getErrors()));
            }
        }
    }
}
