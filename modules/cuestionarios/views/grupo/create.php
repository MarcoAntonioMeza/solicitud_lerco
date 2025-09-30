<?php

$this->title = 'NUEVO GRUPO DE PREGUNTAS';
$this->params['breadcrumbs'][] = 'GRUPOS DE PREGUNTAS';
$this->params['breadcrumbs'][] = ['label' => 'GRUPOS', 'url' => ['index']];

?>

<div class="ayudas-solicitudes-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
