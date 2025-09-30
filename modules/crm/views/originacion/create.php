<?php

$this->title = 'NUEVA ORIGINACIÓN';
$this->params['breadcrumbs'][] = ['label' => 'Originaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Nuevo"
?>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

<!-- Incluir Axios desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<div class="configuracion-comision-create">

    <?= $this->render('_form', [
        'model' => $model,
        'can' => $can,
        'dataForm' =>$dataForm,
    ]) ?>

</div>
