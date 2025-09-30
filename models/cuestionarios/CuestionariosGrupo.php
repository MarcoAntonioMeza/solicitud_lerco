<?php

namespace app\models\cuestionarios;

use Yii;
use app\models\user\User;
use yii\db\Query;
use yii\web\Response;

/**
 * This is the model class for table "cuestionarios_grupo".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $estado
 * @property int $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property CuestionariosPreguntas[] $cuestionariosPreguntas
 */
class CuestionariosGrupo extends \yii\db\ActiveRecord
{

    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;

    public static $status_list = [
        self::ESTADO_ACTIVO => 'Activo',
        self::ESTADO_INACTIVO => 'Inactivo',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuestionarios_grupo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            [['estado', 'orden', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
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
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
            'orden' => 'Orden',
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
     * Gets query for [[CuestionariosPreguntas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPreguntas()
    {
        return $this->hasMany(CuestionariosPreguntas::className(), ['cuestionario_id' => 'id']);
    }


    public static function get_list_grupos()
    {
        $data = self::find()->where(['estado' => self::ESTADO_ACTIVO])
        ->orderBy(['orden' => SORT_ASC])
        ->all();
        $list = [];
        foreach ($data as $item) {
            $list[] = [
                'id' => $item->id,
                'nombre' => $item->nombre,
            ];
        }

        return $list;
    }


    public function  get_all_preguntas()
    {
        $preguntas = CuestionariosPreguntas::find()->where([
            'cuestionario_id' => $this->id,
            'estado' => self::ESTADO_ACTIVO
        ])
        ->orderBy(['orden' => SORT_ASC])
        ->all();


        $response = [];

        //$response = [];

        foreach ($preguntas as $key => $value) {
            $response[] = [
                'id' => $key + 1,
                'main_id' => $value->id,
                'pregunta' => $value->pregunta,
                'is_required' => (bool)$value->is_required,
                'tipo' => $value->tipo_respuesta,
                'estado' => self::$status_list[$value->estado] ?? '--',
                'errorPregunta' => null,
                'errorOpciones' => null,
                // 'selectes' => $value->cuestionariosRespuestasCatalogoSelectsActive,
            ];
            if ((int)$value->tipo_respuesta == CuestionariosPreguntas::TIPO_SELECT) {
                foreach ($value->cuestionariosRespuestasCatalogoSelectsActive as $item => $select) {
                    $response[$key]['selectes'][$item] = [
                        'id' => $select->id,
                        'texto' => $select->valor,
                        'estado' => self::$status_list[$select->estado] ?? '--',
                        'error' => null,
                    ];
                }
            } else {
                $response[$key]['selectes'] = [];
            }
        }

        $response_2[] = [
            'id' => 1,
            'main_id' => null,
            'pregunta' => '',
            'tipo' => 2,
            //'estado' => self::$status_list[$value->estado] ?? '--',
            'errorPregunta' => null,
            'errorOpciones' => null,
            'selectes' => [],
        ];
        return $response ? $response : $response_2;
    }

    public function get_all_preguntasV2($cliente_id = null)
    {
        $preguntas = CuestionariosPreguntas::find()
            ->where([
                'cuestionario_id' => $this->id,
                'estado' => self::ESTADO_ACTIVO
            ])
            ->orderBy(['orden' => SORT_ASC])
            ->all();

        $response = [];

        foreach ($preguntas as $pregunta) {
            $respuesta = '---';
            if ($cliente_id) {
                $clienteResp = CuestionariosRespuestas::find()
                    ->where([
                        'pregunta_id' => $pregunta->id,
                        'cliente_originacion_id' => $cliente_id
                    ])
                    ->one();
                $respuesta = $clienteResp ? $clienteResp->respuesta : '';
            }

            $selectes = [];
            if ((int)$pregunta->tipo_respuesta === CuestionariosPreguntas::TIPO_SELECT) {
                foreach ($pregunta->cuestionariosRespuestasCatalogoSelectsActive as $select) {
                    $selectes[] = ['value' => $select->valor];
                }
            }

            $response[] = [
                'id' => $pregunta->id,
                'pregunta' => $pregunta->pregunta,
                'tipo' => $pregunta->tipo_respuesta,
                'tipo_str' => CuestionariosPreguntas::$tipo_respuesta_list[$pregunta->tipo_respuesta],
                'respuesta' => $respuesta,
                'selectes' => $selectes,
            ];
        }

        // En caso de que no haya preguntas activas, retorna una estructura por defecto
        if (empty($response)) {
            return [[
                'id' => 1,
                'pregunta' => '',
                'tipo' => 2,
                'tipo_str' => CuestionariosPreguntas::$tipo_respuesta_list[2] ?? 'Texto',
                'respuesta' => '',
                'selectes' => [],
            ]];
        }

        return $response;
    }



    public static  function  get_all_preguntas_group($client_id = null)
    {
        $response = [];

        $grupos = self::find()->where(['estado' => self::ESTADO_ACTIVO])
        ->orderBy(['orden' => SORT_ASC])
        ->all();

        foreach ($grupos as $key => $grupo) {
            $response[$key] = [
                'grupo_id' => $grupo->id,
                'orden' => $grupo->id,
                'nombre' => $grupo->nombre,
                'preguntas' => $grupo->get_all_preguntasV2($client_id),
            ];
        }

        return $response;
    }















    //------------------------------------------------------------------------------------------------//
    // JSON Bootstrap Table
    //------------------------------------------------------------------------------------------------//
    public static function getJsonBtt($arr)
    {
        // La respuesta sera en Formato JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Preparamos las variables
        $sort    = isset($arr['sort']) ?   $arr['sort'] :   'id';
        $order   = isset($arr['order']) ?  $arr['order'] :  'asc';
        $orderBy = $sort . ' ' . $order;
        $offset  = isset($arr['offset']) ? $arr['offset'] : 0;
        $limit   = isset($arr['limit']) ?  $arr['limit'] :  50;

        $search = isset($arr['search']) ? $arr['search'] : false;
        parse_str($arr['filters'], $filters);


        /************************************
    / Preparamos consulta
    /***********************************/
        $query = (new Query())
            ->select([
                "SQL_CALC_FOUND_ROWS `id`",
                "orden",
                'nombre',
                'estado as status',
                'created_by',

                'created_at',
                'updated_by',

                'updated_at',
            ])
            ->from(self::tableName())
            ->orderBy($orderBy)
            ->orderBy(['orden' => SORT_ASC])
            ->where(['estado' => self::ESTADO_ACTIVO])
            ->offset($offset)
            ->limit($limit);



        if ($search)
            $query->andFilterWhere([
                'or',
                ['like', 'id', $search],
                ['like', 'nombre', $search],

            ]);

        // Imprime String de la consulta SQL
        //echo ($query->createCommand()->rawSql) . '<br/><br/>';

        return [
            'rows'  => $query->all(),
            'total' => \Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar(),
        ];
    }

    //------------------------------------------------------------------------------------------------//
    // ACTIVE RECORD
    //------------------------------------------------------------------------------------------------//
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            //NORMALIZAR CAMPOS
            $this->nombre = strtoupper(trim($this->nombre));

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
