<?php

namespace app\models\esys;

use Yii;
use app\models\Esys;
use app\models\user\User;
use app\models\system\SystemProcedureCierre;
use app\models\catalogo\CatalogoTiies;
use app\models\catalogo\CatalogoTermsofr;
use app\models\solicitud\Solicitud;
use app\models\solicitud\SolicitudSeguimiento;
/**
 * This is the model class for table "esys_setting".
 *
 * @property int $cliente_id Cliente
 * @property string $clave Clave
 * @property string $valor Valor
 * @property int $created_at Creado
 * @property int $created_by Creado por
 * @property int $updated_at Modificado
 * @property int $updated_by Modificado por
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class EsysSetting extends \yii\db\ActiveRecord
{

    public $esysSetting_list = [];

    const NOMBRE_SITIO                  = "NOMBRE_SITIO";
    const EMAIL_SITIO                   = "EMAIL_SITIO";
    const IVA_FRONTERISO                = "IVA_FRONTERISO";
    const IVA                           = "IVA";
    const FECHA_OPERACION               = "FECHA_OPERACION";
    const CANTIDAD_DIA_ANTICIPADO       = "CANTIDAD_DIA_ANTICIPADO";



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esys_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],

            [['clave'], 'string', 'max' => 40],
            [['param1','param2'], 'string', 'max' => 20],
            [['valor'], 'string', 'max' => 250],
            [['clave'], 'unique'],
            [['esysSetting_list'], 'safe'],
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
            'cliente_id' => 'Cliente ID',
            'clave' => 'Clave',
            'valor' => 'Valor',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public  function getConfiguracionAll()
    {
        return  EsysSetting::find()->orderBy('orden asc')->all();
    }

    public function saveConfiguracion($esysSetting_list)
    {
        foreach ($esysSetting_list["esysSetting_list"] as $key => $item) {
            $EsysSetting = EsysSetting::findOne(["clave" => $key]);
            $EsysSetting->valor = $item;
            $EsysSetting->update();
        }
    }

    public static function validRegisterTasas()
    {

       return  true;
    }

    public static function getTasaTermsofr30()
    {
    
        return 0;
    }


    public static function getTasaTermsofr90()
    {
        return '----';
    }


    public static function getTasaTermsofr180()
    {
        return '----';
    }


    public static function getTasaTiie28()
    {
    
        return '----';
    }

    public static function getTasaTiie91()
    {        
        return  '----';
    }

    public static function getTasaTiie182()
    {
        return '----';
    }
 


    public static function getIva(){
        $queryDateUnixEndDay = EsysSetting::findOne(["clave" => 'IVA'])->valor;
        return $queryDateUnixEndDay ?  $queryDateUnixEndDay : 0;
    }

    public static function getIvaFronteriso(){
        $queryDateUnixEndDay = EsysSetting::findOne(["clave" => 'IVA_FRONTERISO'])->valor;
        return $queryDateUnixEndDay ?  $queryDateUnixEndDay : 0;
    }




    //------------------------------------------------------------------------------------------------//
    // ACTIVE RECORD
    //------------------------------------------------------------------------------------------------//
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {

            if ($insert) {
                $this->created_at = time();
                $this->created_by = Yii::$app->user->identity? Yii::$app->user->identity->id: null;

            }else{

                // Quién y cuando
                $this->updated_at = time();
                $this->updated_by = Yii::$app->user->identity? Yii::$app->user->identity->id: null;
            }

            return true;

        } else
            return false;
    }

}
