<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\widgets\CreatedByView;
use app\models\user\User;
use app\models\nomina\UserHorario;
use app\models\nomina\UserHorarioDetail;
use app\models\esys\EsysCambiosLog;
use app\models\esys\EsysDireccion;

/* @var $this yii\web\View */
/* @var $model common\models\ViewUser */

$this->title = $model->nombreCompleto;
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>

<div class="admin-user-view">
    <p>
        <?= $can['update']?
            Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-zoom']): '' ?>

        <?= $can['delete']?
            Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro de que deseas eliminar este usuario?',
                    'method' => 'post',
                ],
            ]): '' ?>
    </p>
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-7">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 >Cuenta de usuario y datos personales</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-7">
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'id',
                                            "username",
                                            "email:email",
                                        ],
                                    ]) ?>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            "tituloPersonal.singular",
                                            "nombre",
                                            "apellidos",
                                        ],
                                    ]) ?>
                                </div>
                                <div class="col-md-5">
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            "sexo",
                                            "fecha_nac:date",
                                            "cargo",
                                            "departamento.singular",
                                        ],
                                    ]) ?>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            "telefono",
                                            "telefono_movil",
                                        ],
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 >Permisos</h5>
                        </div>
                        <div class="ibox-content">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    "perfil.item_name",
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 >Dirección</h5>
                        </div>
                        <div class="ibox-content">
                            <?= DetailView::widget([
                                'model' => $model->direccion,
                                'attributes' => [
                                    'direccion',
                                    'num_ext',
                                    'num_int',
                                ]
                            ]) ?>
                            <?= DetailView::widget([
                                'model' => $model->direccion,
                                'attributes' => [
                                    "estado.singular",
                                    "municipio.singular",
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 >Información extra / Comentarios</h5>
                        </div>
                        <div class="ibox-content">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'informacion:ntext',
                                    'comentarios:ntext',
                                ]
                            ]) ?>
                        </div>
                    </div>

                </div>
            </div>
           

        </div>
        <div class="col-lg-3">
            <?php if (Yii::$app->user->can('admin')): ?>
                <div class="ibox">
                    <?= Html::a('ACCEDER <i class = "fa fa-caret-square-o-right"></i>', [ "login-user", "id" => $model->id ], [
                        'class' => 'btn btn-lg btn-success btn-block',
                        'style' => 'padding: 6%;',
                        "id"    => "btnAcuseDescarga"
                    ]) ?>
                </div>
            <?php endif ?>

            
             
            <div class="ibox">
                <div class="ibox-title">
                    <h5 >Historial de cambios</h5>
                </div>
                <div class="ibox-content historial-cambios nano">
                    <div class="nano-content">
                        <?= EsysCambiosLog::getHtmlLog([
                            [new User(), $model->id],
                            [new EsysDireccion(), $model->direccion->id],
                        ], 50, true) ?>
                    </div>
                </div>
                <div class="panel-footer">
                    <?= Html::a('Ver historial completo', ['historial-cambios', 'id' => $model->id], ['class' => 'text-primary']) ?>
                </div>
            </div>

            <?= app\widgets\CreatedByView::widget(['model' => $model]) ?>
        </div>
    </div>
</div>

