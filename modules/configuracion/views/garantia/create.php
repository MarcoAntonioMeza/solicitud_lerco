<?php

$this->title = 'Nuevo garantia';
$this->params['breadcrumbs'][] = 'CREDITO';
$this->params['breadcrumbs'][] = ['label' => 'GARANTIAS', 'url' => ['index']];
?>


<div class="configuracion-garantia-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
