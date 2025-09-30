<?php


//$this->title = "COMISION " . $model->id ;
$this->title = "COMISION " ;
$this->params['breadcrumbs'][] = 'CREDITO';
$this->params['breadcrumbs'][] = ['label' => 'comision', 'url' => ['index']];
?>


<div class="configuracion-garantia-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
