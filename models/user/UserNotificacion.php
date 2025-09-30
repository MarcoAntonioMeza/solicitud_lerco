<?php
namespace app\models\user;

use Yii;
use app\models\esys\EsysSetting;
use app\models\credito\Credito;
use app\models\credito\CreditoHistorialMovimiento;
use app\models\credito\CreditoSolicitudComision;
use app\models\credito\CreditoCargo;
use app\models\catalogo\CatalogoComision;

/**
 * This is the model class for table "user_notificacion".
 *
 * @property int $id ID
 * @property string $titulo Titulo
 * @property int|null $uid Uid
 * @property int|null $evento Evento
 * @property int|null $fecha Fecha
 * @property int $view Vista
 * @property int $created_by Creado por
 *
 * @property User $createdBy
 */
class UserNotificacion extends \yii\db\ActiveRecord
{
    const STATUS_VIEW_ON    = 10;
    const STATUS_VIEW_OFF   = 20;

    const STATUS_CERRADO   = 10;
    const STATUS_PROCESO   = 20;

    const APPLY_APROBACION_ON       = 10;
    const APPLY_APROBACION_OFF      = 20;

    const EVENTO_REVISION_APLICACION_DE_COMISION = 10;

    public static $eventoList = [
        self::EVENTO_REVISION_APLICACION_DE_COMISION => 'REVISION DE APLICACION DE COMISION',
    ];

    public static $statusList = [
        self::STATUS_CERRADO => 'CERRADO',
        self::STATUS_PROCESO => 'PROCESO',
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_notificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'created_by','user_id'], 'required'],
            [['uid', 'evento', 'fecha', 'view', 'created_by','status','apply_aprobacion'], 'integer'],
            [['titulo'], 'string', 'max' => 200],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'uid' => 'Uid',
            'evento' => 'Evento',
            'fecha' => 'Fecha',
            'view' => 'View',
            'created_by' => 'Created By',
        ];
    }

    public function getSolicitudComision(){
        return $this->hasOne(CreditoSolicitudComision::className(), ['id' => 'uid']);
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getNotificacionCount()
    {
        return UserNotificacion::find()->andwhere([ "and",
            [ "=", "user_id", Yii::$app->user->identity->id ],
            [ "=", "view", UserNotificacion::STATUS_VIEW_OFF ]
        ])->count();
    }

    public static function getNotificacionAll()
    {
        return  UserNotificacion::find()->andwhere([ "and",
            [ "=","user_id", Yii::$app->user->identity->id ],
          //  [ "=", "view", UserNotificacion::STATUS_VIEW_OFF ]
        ])
        ->orderBy('fecha DESC')
        ->limit(5)
        ->all();
    }

    public static function aprovedNotificacion($id)
    {
        $queryNotificacion = UserNotificacion::findOne($id);
        switch ($queryNotificacion->evento) {
            case UserNotificacion::EVENTO_REVISION_APLICACION_DE_COMISION:

                $transaction = Yii::$app->db->beginTransaction();
                $querySolicitudDisposicion  = CreditoSolicitudComision::findOne($queryNotificacion->uid);
                try {
                    $querySolicitudDisposicion->fecha_resolucion    = time();
                    $querySolicitudDisposicion->status              = CreditoSolicitudComision::STATUS_TERMINADO;
                    $querySolicitudDisposicion->save();

                    CreditoCargo::saveCargoComision($querySolicitudDisposicion->credito_id, $querySolicitudDisposicion->id, null,$querySolicitudDisposicion->credito_comision_id, $querySolicitudDisposicion->cantidad, $querySolicitudDisposicion->cantidad_iva );

                    if ($querySolicitudDisposicion->creditoComision->apply_pertenece == CatalogoComision::APLICA_DISPOSICION ) {
                        $getCredito = Credito::findOne($querySolicitudDisposicion->credito_id);

                        CreditoHistorialMovimiento::registerMovimiento($getCredito->id, CreditoHistorialMovimiento::PERTENECE_OPERADOR, CreditoHistorialMovimiento::MOVIMIENTO_CARGO_COMISION_POR_DISPOSICION, $saldoInsoluto = $getCredito->creditoSaldoCartera->saldo_insoluto, $principal = $getCredito->creditoSaldoCartera->principal, $principalVencidoTotal = null, $principalVencidoExigible = $getCredito->creditoSaldoCartera->principal_exigible, $amortizacionExigible = $getCredito->creditoSaldoCartera->amortizacion_exigible, $interesMoratorio = $getCredito->creditoSaldoCartera->interes_moratorio, $interesMoratorioTotal = null, $interesOrdinario = $getCredito->creditoSaldoCartera->interes_moratorio, $interesOrdinarioTotal = null, $pagoInteresMoratorio = null, $pagoInteresOrdinario = null, $pagoAmortizacion = null, $pagoPrincipal = null, $monto = $querySolicitudDisposicion->cantidad,Yii::$app->user->identity->id, EsysSetting::getFechaSistemaUnix() );


                        if ($querySolicitudDisposicion->cantidad_iva > 0 ) {
                            CreditoHistorialMovimiento::registerMovimiento($getCredito->id, CreditoHistorialMovimiento::PERTENECE_OPERADOR, CreditoHistorialMovimiento::MOVIMIENTO_CARGO_COMISION_POR_DISPOSICION_IVA, $saldoInsoluto = $getCredito->creditoSaldoCartera->saldo_insoluto, $principal = $getCredito->creditoSaldoCartera->principal, $principalVencidoTotal = null, $principalVencidoExigible = $getCredito->creditoSaldoCartera->principal_exigible, $amortizacionExigible = $getCredito->creditoSaldoCartera->amortizacion_exigible, $interesMoratorio = $getCredito->creditoSaldoCartera->interes_moratorio, $interesMoratorioTotal = null, $interesOrdinario = $getCredito->creditoSaldoCartera->interes_moratorio, $interesOrdinarioTotal = null, $pagoInteresMoratorio = null, $pagoInteresOrdinario = null, $pagoAmortizacion = null, $pagoPrincipal = null, $monto = $querySolicitudDisposicion->cantidad_iva,Yii::$app->user->identity->id, EsysSetting::getFechaSistemaUnix() );
                        }
                    }

                    $transaction->commit();

                } catch (\Exception $e) {
                    $transaction->rollBack();
                }

            break;
        }

    }

    public static function saveNotificacionUser($titulo, $uid, $evento, $userId, $applyAprobacion)
    {
        $UserNotificacion = new UserNotificacion();
        $UserNotificacion->titulo           = $titulo;
        $UserNotificacion->uid              = $uid;
        $UserNotificacion->evento           = $evento;
        $UserNotificacion->user_id          = $userId;
        $UserNotificacion->fecha            = time();
        $UserNotificacion->view             = self::STATUS_VIEW_OFF;
        $UserNotificacion->apply_aprobacion = $applyAprobacion;
        $UserNotificacion->status           = $applyAprobacion == UserNotificacion::APPLY_APROBACION_ON  ?   UserNotificacion::STATUS_PROCESO : UserNotificacion::STATUS_CERRADO ;
        $UserNotificacion->created_by   = Yii::$app->user->identity->id;
        $UserNotificacion->save();

    }
}
