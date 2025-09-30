<?php

$this->title = 'NUEVO PLAN DE COMISIONES';
$this->params['breadcrumbs'][] = 'CREDITO';
$this->params['breadcrumbs'][] = ['label' => 'PLAN DE COMISION', 'url' => ['index']];
?>


<div class="configuracion-comision-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
