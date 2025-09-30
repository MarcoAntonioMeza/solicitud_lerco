<?php

namespace app\models\cuestionarios;

use Yii;
use app\models\user\User;


/**
 * This is the model class for table "cuestionarios_orden_grupo".
 *
 * @property int $id
 * @property int $grupo_id
 * @property int $orden
 */
class CuestionariosOrdenGrupo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuestionarios_orden_grupo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grupo_id', 'orden'], 'required'],
            [['grupo_id', 'orden'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grupo_id' => 'Grupo ID',
            'orden' => 'Orden',
        ];
    }
}
