<?php


//$this->title = "COMISION " . $model->id ;
$this->title = "ACTUALIZA EMPRESA " ;
$this->params['breadcrumbs'][] = ['label' => 'EMPRESA', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>


<div class="configuracion-garantia-update">

    <?= $this->render('_form', [
        'model' => $model,
        'can' => $can,
    ]) ?>

</div>
