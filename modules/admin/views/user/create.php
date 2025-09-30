<?php
/* @var $this yii\web\View */
/* @var $user backend\models\user\User */

$this->title = 'Nuevo usuario';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
?>


<div class="admin-user-create">

    <?= $this->render('_form', [
		'user' => $user,
	]) ?>

</div>
