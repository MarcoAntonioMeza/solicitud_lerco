<?php


//$this->title = "Garantia " . $model->id ;
$this->title = "Garantia " ;
$this->params['breadcrumbs'][] = 'CREDITO';
$this->params['breadcrumbs'][] = ['label' => 'GARANTIAS', 'url' => ['index']];
?>


<div class="configuracion-garantia-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
