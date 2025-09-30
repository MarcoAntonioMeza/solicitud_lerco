<?php

namespace app\models\persona;

use Yii;
use yii\db\Query;
use yii\web\Response;

/**
 * This is the model class for table "view_solicitante".
 *
 * @property int $id
 * @property string $nombres
 * @property string|null $apellido_paterno
 * @property string|null $apellido_materno
 * @property string|null $nombre_completo
 * @property string|null $email
 * @property string|null $telefono
 * @property string|null $cargo
 * @property string|null $empresa
 * @property string|null $fecha_creacion
 * @property string|null $direccion
 * @property string|null $num_ext  interior
 * @property string|null $num_int  exterior
 * @property string|null $estado Singular
 * @property string|null $municipio Singular
 * @property int|null $codigo_postal Codigo postal
 * @property string|null $colonia_cp Colonia
 */
class ViewSolicitante extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'view_solicitante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido_paterno', 'apellido_materno', 'nombre_completo', 'email', 'telefono', 'cargo', 'empresa', 'fecha_creacion', 'direccion', 'num_ext', 'num_int', 'estado', 'municipio', 'codigo_postal', 'colonia_cp'], 'default', 'value' => null],
            [['id'], 'default', 'value' => 0],
            [['id', 'codigo_postal'], 'integer'],
            [['nombres'], 'required'],
            [['fecha_creacion'], 'safe'],
            [['nombres', 'apellido_paterno', 'apellido_materno', 'email'], 'string', 'max' => 100],
            [['nombre_completo'], 'string', 'max' => 302],
            [['telefono'], 'string', 'max' => 15],
            [['cargo', 'empresa'], 'string', 'max' => 200],
            [['direccion'], 'string', 'max' => 256],
            [['num_ext', 'num_int'], 'string', 'max' => 16],
            [['estado', 'municipio'], 'string', 'max' => 128],
            [['colonia_cp'], 'string', 'max' => 150],
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
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'nombre_completo' => 'Nombre Completo',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'cargo' => 'Cargo',
            'empresa' => 'Empresa',
            'fecha_creacion' => 'Fecha Creacion',
            'direccion' => 'Direccion',
            'num_ext' => 'Num Ext',
            'num_int' => 'Num Int',
            'estado' => 'Estado',
            'municipio' => 'Municipio',
            'codigo_postal' => 'Codigo Postal',
            'colonia_cp' => 'Colonia Cp',
        ];
    }

    public static function getJsonBtt($arr)
    {
        // La respuesta sera en Formato JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Preparamos las variables
        $sort    = isset($arr['sort'])?   $arr['sort']:   'id';
        $order   = isset($arr['order'])?  $arr['order']:  'asc';
        $orderBy = $sort . ' ' . $order;
        $offset  = isset($arr['offset'])? $arr['offset']: 0;
        $limit   = isset($arr['limit'])?  $arr['limit']:  50;

        $search = isset($arr['search'])? $arr['search']: false;
        parse_str($arr['filters'], $filters);

        /************************************
        / Preparamos consulta
        /***********************************/
        $query = (new Query())
            ->select([
                "SQL_CALC_FOUND_ROWS `id`",
                'id',
                'nombres',
                'apellido_paterno',
                'apellido_materno',
                'nombre_completo',
                'email',
                'telefono',
                'cargo',
                'empresa',
                'fecha_creacion',
                'direccion',
                'num_ext',
                'num_int',
                'estado',
                'municipio',
                'codigo_postal',
                'colonia_cp',
            ])
            ->from(self::tableName())
            ->orderBy($orderBy)
            ->offset($offset)
            ->limit($limit);

        /************************************
        / Filtramos la consulta
        /***********************************/
        if(isset($filters['cargo']))
            $query->andFilterWhere(['like', 'cargo', $filters['cargo']]);

        if(isset($filters['empresa']))
            $query->andFilterWhere(['like', 'empresa', $filters['empresa']]);

        if(isset($filters['estado']))
            $query->andFilterWhere(['like', 'estado', $filters['estado']]);

        if(isset($filters['municipio']))
            $query->andFilterWhere(['like', 'municipio', $filters['municipio']]);

        if(isset($filters['date_range']) && $filters['date_range']){
            $date_ini = substr($filters['date_range'], 0, 10) . ' 00:00:00';
            $date_fin = substr($filters['date_range'], 13, 10) . ' 23:59:59';

            $query->andWhere(['between','fecha_creacion', $date_ini, $date_fin]);
        }

        if($search)
            $query->andFilterWhere([
                'or',
                ['like', 'nombres', $search],
                ['like', 'apellido_paterno', $search],
                ['like', 'apellido_materno', $search],
                ['like', 'nombre_completo', $search],
                ['like', 'email', $search],
                ['like', 'telefono', $search],
                ['like', 'cargo', $search],
                ['like', 'empresa', $search],
                ['like', 'direccion', $search],
            ]);

        // Imprime String de la consulta SQL
        //echo ($query->createCommand()->rawSql) . '<br/><br/>';

        $rows = $query->all();

        return [
            'total' => \Yii::$app->db->createCommand('SELECT FOUND_ROWS()')->queryScalar(),
            'rows'  => $rows
        ];
    }
}