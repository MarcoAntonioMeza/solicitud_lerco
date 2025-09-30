<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductoFinanciero */

$this->title = 'ACTIVIDAD:'  . $model->codigo .'';
$this->params['breadcrumbs'][] = ['label' => 'ACTIVIDAD SCIAN', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'EDITAR';
?>
<div class="producto-financiero-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
