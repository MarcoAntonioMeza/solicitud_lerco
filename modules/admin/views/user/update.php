<?php
/* @var $this yii\web\View */
/* @var $user backend\models\user\User */

$this->title = $user->nombre . ' '. $user->apellidos;
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>


<div class="admin-user-update">

    <?= $this->render('_form', [
    	'user' => $user,
    ]) ?>

</div>
