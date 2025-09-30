<?php

namespace app\models\cuestionarios;

use Yii;

use app\models\user\User;


/**
 * This is the model class for table "cuestionarios_respuestas_catalogo_select".
 *
 * @property int $id
 * @property int $pregunta_id
 * @property int $estado
 * @property string $valor
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property CuestionariosPreguntas $pregunta
 * @property User $updatedBy
 */
class CuestionariosRespuestasCatalogoSelect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuestionarios_respuestas_catalogo_select';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pregunta_id', 'valor'], 'required'],
            [['pregunta_id', 'estado', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['valor'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['pregunta_id'], 'exist', 'skipOnError' => true, 'targetClass' => CuestionariosPreguntas::className(), 'targetAttribute' => ['pregunta_id' => 'id']],
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
            'estado' => 'Estado',
            'valor' => 'Valor',
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
           
            $this->valor = strtoupper(trim($this->valor));

            if ($insert) {
                $this->created_at   = time();
                $this->created_by   = Yii::$app->user->identity ? Yii::$app->user->identity->id : null;
            } else {
                // Quién y cuando
                $this->updated_at = time();
                $this->updated_by = Yii::$app->user->identity ? Yii::$app->user->identity->id : null;
            }
            //$this->name_id = str_replace(' ', '_', $this->nombre) . '_' . $this->created_at;
            return true;
        } else
            return false;
    }
}
