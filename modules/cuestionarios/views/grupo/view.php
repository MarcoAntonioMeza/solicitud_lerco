<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\date\DatePicker;
use app\models\cuestionarios\CuestionariosGrupo;
use yii\widgets\DetailView;



$this->title = 'DETALLE DEL GRUPO';

$this->params['breadcrumbs'][] = 'grupos de preguntas';
$this->params['breadcrumbs'][] = ['label' => 'GRUPOS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = 'Ver';
?>
<div class="tu-modelo-view">
    <div class="panel">
        <div class="panel-heading text-center">
            <h1><?= Html::encode($this->title) ?></h1>
            <br>
            <p>
                <?= $can['update']?Html::a('EDITAR', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']): "" ?>
            </p>

        </div>
        <div class="panel-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'nombre',
                    'descripcion:ntext',
                    [
                        'attribute' => 'estado',
                        'value' => function ($model) {
                            return CuestionariosGrupo::$status_list[$model->estado] ?? 'No definido';
                        },
                    ],
                    [
                        'label' => 'Preguntas Asignadas',
                        'value' => function($model) {
                            return count($model->preguntas);
                        },
                        'format' => 'html',
                        'contentOptions' => ['class' => 'text-center font-weight-bold'],
                    ],
                    // Excluidos: created_at, updated_at, created_by, updated_by
                ],
            ]) ?>
        </div>
    </div>






</div>