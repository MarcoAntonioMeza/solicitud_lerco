<?php

namespace app\models\cuestionario;

use Yii;
use app\models\user\User;

/**
 * This is the model class for table "cuestionarios_preguntas".
 *
 * @property int $id
 * @property int $cuestionario_id
 * @property string $pregunta
 * @property int $tipo_respuesta
 * @property int $estado
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property CuestionariosGrupo $cuestionario
 * @property User $updatedBy
 * @property CuestionariosRespuestas[] $cuestionariosRespuestas
 * @property CuestionariosRespuestasCatalogoSelect[] $cuestionariosRespuestasCatalogoSelects
 */
class CuestionariosPreguntas extends \yii\db\ActiveRecord
{

    const TIPO_NUMBER   = 1;
    const TIPO_TEXT     = 2;
    const TIPO_SELECT   = 3;
    const TIPO_DATE     = 4;

    public static $tipo_respuesta_list = [
        self::TIPO_TEXT => 'Texto',
        self::TIPO_NUMBER => 'Número',
        self::TIPO_SELECT => 'Selector',
        self::TIPO_DATE => 'Fecha',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuestionarios_preguntas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuestionario_id', 'pregunta', 'created_at'], 'required'],
            [['cuestionario_id', 'is_required', 'tipo_respuesta', 'estado', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['pregunta'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['cuestionario_id'], 'exist', 'skipOnError' => true, 'targetClass' => CuestionariosGrupo::className(), 'targetAttribute' => ['cuestionario_id' => 'id']],
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
            'cuestionario_id' => 'Cuestionario ID',
            'pregunta' => 'Pregunta',
            'tipo_respuesta' => 'Tipo Respuesta',
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
     * Gets query for [[Cuestionario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuestionario()
    {
        return $this->hasOne(CuestionariosGrupo::className(), ['id' => 'cuestionario_id']);
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
     * Gets query for [[CuestionariosRespuestas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuestionariosRespuestas()
    {
        return $this->hasMany(CuestionariosRespuestas::className(), ['pregunta_id' => 'id']);
    }

    /**
     * Gets query for [[CuestionariosRespuestasCatalogoSelects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuestionariosRespuestasCatalogoSelects()
    {
        return $this->hasMany(CuestionariosRespuestasCatalogoSelect::className(), ['pregunta_id' => 'id']);
    }

    public function getCuestionariosRespuestasCatalogoSelectsActive()
    {
        return $this->hasMany(CuestionariosRespuestasCatalogoSelect::className(), ['pregunta_id' => 'id'])
            ->where(['estado' => CuestionariosGrupo::ESTADO_ACTIVO]);
    }

    public static function get_tipo_lista()
    {
        $response = [];
        foreach (self::$tipo_respuesta_list as $key => $value) {
            $response[] = [
                'type' => $key,
                'name' => $value,
            ];
        }

        return $response;
        //return self::$tipo_respuesta_list;
    }

    public static function save_preguntas_($grupo_id, $preguntas, $preguntas_delete = [], $selects_delete = [])
    {
        $grupo = CuestionariosGrupo::findOne($grupo_id);
        if (!$grupo) {
            throw new \yii\web\BadRequestHttpException('Grupo no encontrado');
        }
        if (count($preguntas) == 0) {
            throw new \yii\web\BadRequestHttpException('No hay preguntas para guardar');
        }

        //dar de baja preguntas
        if (count($preguntas_delete) > 0) {
            foreach ($preguntas_delete as $key => $value) {
                $model = CuestionariosPreguntas::findOne($value ?? null);
                if ($model) {
                    $model->estado = CuestionariosGrupo::ESTADO_INACTIVO;
                    if ($model->tipo_respuesta == CuestionariosPreguntas::TIPO_SELECT) {
                        $selects = CuestionariosRespuestasCatalogoSelect::find()->where(['pregunta_id' => $model->id])->all();
                        foreach ($selects as $select) {
                            $select->estado = CuestionariosGrupo::ESTADO_INACTIVO;
                            $select->save();
                        }
                    }
                    $model->save();
                }
            }
        }

        //dar de baja selects
        if (count($selects_delete) > 0) {
            foreach ($selects_delete as $key => $value) {
                $model = CuestionariosRespuestasCatalogoSelect::findOne($value ?? null);
                if ($model) {
                    $model->estado = CuestionariosGrupo::ESTADO_INACTIVO;
                    $model->save();
                }
            }
        }

        foreach ($preguntas as $key => $obj) {
            $model = CuestionariosPreguntas::findOne($obj['main_id'] ?? null) ?? new CuestionariosPreguntas(
                [
                    'cuestionario_id' => $grupo_id,
                    'tipo_respuesta' => (int)$obj['tipo'],
                    'pregunta' => $obj['pregunta'],
                ]
            );

            #$model->cuestionario_id = $grupo_id;
            #$model->pregunta = $obj['pregunta'];
            #$model->tipo_respuesta = (int) $obj['tipo'];
            // $model->estado = CuestionariosGrupo::ESTADO_ACTIVO;
            $model->save();



            if ($model->tipo_respuesta == CuestionariosPreguntas::TIPO_SELECT) {
                $selects = $obj['selectes'] ?? [];
                if (count($selects) === 0) {
                    throw new \yii\web\BadRequestHttpException('No hay selects para guardar');
                }
                foreach ($selects as $pos => $select) {
                    $model_select = CuestionariosRespuestasCatalogoSelect::findOne($select['id'] ?? null) ?? new CuestionariosRespuestasCatalogoSelect();
                    $model_select->pregunta_id = $model->id;
                    $model_select->valor = $select['texto'];
                    //$model_select->estado = CuestionariosGrupo::ESTADO_ACTIVO;
                    if (!$model_select->save()) {
                        throw new \yii\web\BadRequestHttpException('Error al guardar el select' . json_encode($model_select->getErrors()));
                    }
                }
            }
        }
        return true;
    }

    public static function save_preguntas($grupo_id, $preguntas, $preguntas_delete = [], $selects_delete = [])
    {
        // Validación inicial
        $grupo = CuestionariosGrupo::findOne($grupo_id);
        if (!$grupo) {
            throw new \yii\web\BadRequestHttpException('Grupo no encontrado');
        }

        if (empty($preguntas)) {
            throw new \yii\web\BadRequestHttpException('No hay preguntas para guardar');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            // Desactivar preguntas eliminadas
            self::desactivarPreguntas($preguntas_delete);

            // Desactivar selects eliminados
            self::desactivarSelects($selects_delete);

            // Procesar preguntas
            foreach ($preguntas as $obj) {
                $model = self::procesarPregunta($grupo_id, $obj);

                // Procesar selects si es necesario
                if ($model->tipo_respuesta == CuestionariosPreguntas::TIPO_SELECT) {
                    self::procesarSelects($model, $obj['selectes'] ?? []);
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Desactiva preguntas marcadas para eliminación
     */
    protected static function desactivarPreguntas($preguntas_delete)
    {
        if (empty($preguntas_delete)) {
            return;
        }

        $models = CuestionariosPreguntas::find()
            ->where(['id' => $preguntas_delete])
            ->all();

        foreach ($models as $model) {
            $model->estado = CuestionariosGrupo::ESTADO_INACTIVO;
            if (!$model->save()) {
                throw new \yii\web\BadRequestHttpException('Error al desactivar pregunta: ' . json_encode($model->getErrors()));
            }

            // Si es de tipo SELECT, desactivar sus opciones
            if ($model->tipo_respuesta == CuestionariosPreguntas::TIPO_SELECT) {
                CuestionariosRespuestasCatalogoSelect::updateAll(
                    ['estado' => CuestionariosGrupo::ESTADO_INACTIVO],
                    ['pregunta_id' => $model->id]
                );
            }
        }
    }

    /**
     * Desactiva selects marcados para eliminación
     */
    protected static function desactivarSelects($selects_delete)
    {
        if (empty($selects_delete)) {
            return;
        }

        CuestionariosRespuestasCatalogoSelect::updateAll(
            ['estado' => CuestionariosGrupo::ESTADO_INACTIVO],
            ['id' => $selects_delete]
        );
    }

    /**
     * Procesa una pregunta individual
     */
    protected static function procesarPregunta($grupo_id, $obj)
    {
        $model = CuestionariosPreguntas::findOne($obj['main_id'] ?? null);

        if (!$model) {
            $model = new CuestionariosPreguntas([
                'cuestionario_id' => $grupo_id,
                'tipo_respuesta' => (int)$obj['tipo'],
                'pregunta' => $obj['pregunta'],
                'is_required' => (bool)($obj['is_required'] ?? false),
                //'estado' => CuestionariosGrupo::ESTADO_ACTIVO
            ]);
        } else {
            $model->tipo_respuesta = (int)$obj['tipo'];
            $model->pregunta = $obj['pregunta'];
            $model->is_required = (bool)($obj['is_required'] ?? false);
        }

        if (!$model->save()) {
            throw new \yii\web\BadRequestHttpException('Error al guardar pregunta: ' . json_encode($model->getErrors()));
        }

        return $model;
    }

    /**
     * Procesa los selects de una pregunta
     */
    protected static function procesarSelects($pregunta, $selects)
    {
        if (empty($selects)) {
            throw new \yii\web\BadRequestHttpException('No hay selects para guardar en pregunta: ' . $pregunta->id);
        }

        // Obtener IDs existentes para comparación
        $existingIds = array_filter(array_column($selects, 'id'));

        // Desactivar selects que no vienen en el array
        if (!empty($existingIds)) {
            CuestionariosRespuestasCatalogoSelect::updateAll(
                ['estado' => CuestionariosGrupo::ESTADO_INACTIVO],
                [
                    'and',
                    ['pregunta_id' => $pregunta->id],
                    ['not in', 'id', $existingIds]
                ]
            );
        }

        // Guardar/actualizar selects
        foreach ($selects as $select) {
            $model = CuestionariosRespuestasCatalogoSelect::findOne($select['id'] ?? null);

            if (!$model) {
                $model = new CuestionariosRespuestasCatalogoSelect([
                    'pregunta_id' => $pregunta->id,
                    'valor' => $select['texto'],
                    'estado' => CuestionariosGrupo::ESTADO_ACTIVO
                ]);
            } else {
                $model->valor = $select['texto'];
                $model->estado = CuestionariosGrupo::ESTADO_ACTIVO;
            }

            if (!$model->save()) {
                throw new \yii\web\BadRequestHttpException('Error al guardar select: ' . json_encode($model->getErrors()));
            }
        }
    }

    //------------------------------------------------------------------------------------------------//
    // ACTIVE RECORD
    //------------------------------------------------------------------------------------------------//
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->pregunta = strtoupper(trim($this->pregunta));

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
