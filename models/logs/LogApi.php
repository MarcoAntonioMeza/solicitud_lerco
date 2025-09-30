<?php

namespace app\models\logs;

use Yii;

/**
 * This is the model class for table "log_api".
 *
 * @property int $id
 * @property string|null $grupo
 * @property string|null $subgrupo
 * @property string $request
 * @property string $response
 * @property string $created_at
 */
class LogApi extends \yii\db\ActiveRecord
{

    CONST NOBARIUM = 'NOBARIUM';
    CONST SMS = 'SMS';
    const APYMSA = 'APYMSA';
    const CIRCULO_CREDITO = 'CIRCULO_CREDITO';
    const SCORE_ALTERNO = 'SCORE_ALTERNO';
    const SAT = 'SAT';
    const SOLICITUD = 'SOLICITUD';
    const WALLET = 'WALLET';
    const GDC = 'GDC';
    const NUFI = 'NUFI';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_api';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request', 'response'], 'required'],
            [['request', 'response'], 'string'],
            [['created_at'], 'safe'],
            [['grupo', 'subgrupo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grupo' => 'Grupo',
            'subgrupo' => 'Subgrupo',
            'request' => 'Request',
            'response' => 'Response',
            'created_at' => 'Created At',
        ];
    }


    public static function save_log($grupo= self::NOBARIUM, $subgrupo="--", $request=[], $response=[])
    {
        $log = new LogApi();
        $log->grupo = $grupo;
        $log->subgrupo = $subgrupo;
        $log->created_at = date('Y-m-d H:i:s');
        $log->request = json_encode($request);
        $log->response = json_encode($response);
        if ($log->save()) {
            return true;
        } else {
            return false;
            #throw new \Exception('Error al guardar el log: ' . json_encode($log->errors));
        }
    }
}
