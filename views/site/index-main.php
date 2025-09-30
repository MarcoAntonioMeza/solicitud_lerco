<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use app\assets\MainAsset;
use app\widgets\Alert;

MainAsset::register($this);

$this->title = "Iniciar sesión";
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title . ($this->title? ' | ': '') . Yii::$app->name) ?></title>
        <?php $this->head() ?>
		
    </head>
	
    <body>
        <?php $this->beginBody() ?>
		<img style="position: absolute; margin: 0px; padding: 0px; border: none; width: 2400px; height: 1371.36px; max-height: none; max-width: none; z-index: -999999; left: 0px; top: -116.18px;opacity: 0.5;" src="<?= Url::to('@web/img/fondo.jpg') ?>">
		<div class="container" id="container">
			<div class="form-container sign-in-container">
				<?= Alert::widget(); ?>
				<?php $form = ActiveForm::begin(['id' => 'login-form', "options" => ["class" => "m-t"] ]) ?>
					<h2 class="text-primary">Bienvenido</h2>
					<p class="text-muted">Ingresa con tu cuenta de usuario</p>
					<?= Html::img(Url::to('@web/img/logo.png'), ['class' => 'img-responsive','style' => 'text-align: center;height: auto;width: 50%;' ]) ?>
					
					<div class="row" style="width:100%">
						<div class="col-sm-12" width="100%">
							<?php if($model->scenario === 'e'): ?>
								<?= $form->field($model, 'email')->input('email', ['placeholder' => 'Ingresa tu correo electrónico', 'autofocus' => true, 'style' => 'width:100%'])->label(false) ?>
		
							<?php elseif($model->scenario === 'u'): ?>
								<?= $form->field($model, 'username')->textInput(['placeholder' => 'Ingresa tu nombre de usuario', 'autofocus' => true])->label(false) ?>
		
							<?php else: ?>
								<?= $form->field($model, 'username')->textInput(['placeholder' => 'Ingresa tu correo o nombre de usuario', 'autofocus' => true])->label(false) ?>
		
							<?php endif ?>
						</div>
					</div>
					<div class="row" style="width:100%">
						<div class="col-sm-12">
							<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Ingresa tu contraseña'])->label(false) ?>
						</div>
					</div>
					
					<button class="btn btn-success w-100" type="submit">Iniciar sesion</button>
					<?php ActiveForm::end(); ?>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>Welcome Back!</h1>
						<p>To keep connected with us please login with your personal info</p>
						<button class="ghost" id="signIn">Sign In</button>
					</div>
					<div class="overlay-panel overlay-right" style="background-image:url('img/Condusef.jpg');position: absolute;
			top: 0;
			bottom: 0;
			
			opacity: .8;
			background-position: center center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;">
					
					</div>
				</div>
			</div>
		</div>

 

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
