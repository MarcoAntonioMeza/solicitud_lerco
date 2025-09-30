<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductoFinanciero */

$this->title = '+ NUEVA ACTIVIDAD';
$this->params['breadcrumbs'][] = ['label' => 'ACTIVIDADES', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-financiero-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
