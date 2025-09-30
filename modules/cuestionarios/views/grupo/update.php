<?php

$this->title = 'EDITAR GRUPO DE PREGUNTAS';
$this->params['breadcrumbs'][] = 'GRUPOS DE PREGUNTAS';
$this->params['breadcrumbs'][] = ['label' => 'GRUPOS', 'url' => ['index']];

$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];

?>

<div class="ayudas-solicitudes-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
