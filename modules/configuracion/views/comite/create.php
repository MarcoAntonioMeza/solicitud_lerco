<?php

$this->title = 'Nuevo comite';
$this->params['breadcrumbs'][] = ['label' => 'Comites', 'url' => ['index']];
?>

<div class="comites-credito-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
