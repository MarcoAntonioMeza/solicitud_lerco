<?php

namespace app\models\sms;

use Yii;

/**
 * This is the model class for table "sms_verificacion".
 *
 * @property int $id
 * @property string $codigo
 * @property int|null $intentos
 * @property string $key
 * @property string $created_at
 * @property int|null $is_used
 * @property int|null $is_expired
 */
class SmsVerificacion extends \yii\db\ActiveRecord
{

    const NUN_INTENTOS_PRO = 50;
    const NUN_INT_TEST = 50;
    const EXPIRATION_TIME_MINUTES = 20;
    const NUM_INTENTOS = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_verificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'key'], 'required'],
            [['intentos', 'is_used', 'is_expired'], 'integer'],
            [['created_at'], 'safe'],
            [['codigo'], 'string', 'max' => 10],
            [['key'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'intentos' => 'Intentos',
            'key' => 'Key',
            'created_at' => 'Created At',
            'is_used' => 'Is Used',
            'is_expired' => 'Is Expired',
        ];
    }

    public function isExpired()
    {
        $expirationTime = strtotime($this->created_at) + (self::EXPIRATION_TIME_MINUTES * 60);
        return time() > $expirationTime;
    }

    public function markAsUsed()
    {
        $this->is_used = 1;
        $this->save();
    }

    public function markAsExpired()
    {
        $this->is_expired = 1;
        $this->save();
    }

    public static function verificar($codigo, $key)
    {
        $smsVerification = self::find()
            ->where(['key' => $key, 'codigo' => $codigo])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if ($smsVerification) {
            if ($smsVerification->intentos !== null && $smsVerification->intentos >= self::NUM_INTENTOS) {
                return [
                    "code"    => 10,
                    "name"    => "INTENTOS EXCEDIDOS",
                    "type"    => "error",
                    "verify"  => false,
                    "message" => 'Se ha excedido el número máximo de intentos.',
                ];
            }
            if ($smsVerification->is_used) {
                return [
                    "code"    => 10,
                    "name"    => "CÓDIGO YA USADO",
                    "type"    => "error",
                    "verify"  => false,
                    "message" => 'El código de verificación ya ha sido usado.',
                ];
            }
            if ($smsVerification->isExpired()) {
                $smsVerification->markAsExpired();
                return [
                    "code"    => 10,
                    "name"    => "CÓDIGO EXPIRADO",
                    "type"    => "error",
                    "verify"  => false,
                    "message" => 'El código de verificación ha expirado.',
                ];
            }
            $smsVerification->markAsUsed();
            return [
                "code"    => 202,
                "name"    => "VERIFICACIÓN EXITOSA",
                "type"    => "success",
                "verify"  => true,
                "message" => 'Código verificado correctamente.',
            ];
        }
    
        // Código incorrecto, aumentar intentos si existe registro por key
        $smsByKey = self::find()->where(['key' => $key])->orderBy(['created_at' => SORT_DESC])->one();
        if ($smsByKey) {
            $smsByKey->intentos = ($smsByKey->intentos ?? 0) + 1;
            $smsByKey->save(false);
            if ($smsByKey->intentos >= self::NUM_INTENTOS) {
                return [
                    "code"    => 10,
                    "name"    => "INTENTOS EXCEDIDOS",
                    "type"    => "error",
                    "verify"  => false,
                    "message" => 'Se ha excedido el número máximo de intentos.',
                ];
            }
        }
        return [
            "code"    => 10,
            "name"    => "CÓDIGO INCORRECTO",
            "type"    => "error",
            "verify"  => false,
            "message" => 'Código de verificación incorrecto.',
        ];
    }
}
