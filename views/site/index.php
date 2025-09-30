<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\user\User;
use app\models\cliente\Cliente;
use app\models\Esys;


$this->title = '';

?>
<?php if(!isset(Yii::$app->user->identity)): ?>

<div class="site-index">

    <div class="jumbotron">
        <h1>LAAD</h1>
    </div>
</div>

<?php else: ?>

    <div class="panel">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <h2 style="padding: 25px;color: #003f5a;font-weight: 700;">BIENVENIDO <?= Yii::$app->name ?> </h2>
                </div>
                <div class="col-sm-6">
                    <div style="   background-color: #fff;border-radius: 10px;box-shadow: 0 10px 10px rgb(0 0 0 / 20%);display: flex;margin: 20px;overflow: hidden;max-width: 100%;width: 90%;">
                        <div style="width: 100%;text-align:left;    background-color: #007a7b;color: #fff;padding: 10px;max-width: 50%;text-align: center;">
                            <p style="color:#fff;font-size:14px;font-weight: 700;">@<?= User::authNombre() ?></p>
                        </div>
                        <div style="padding: 25px;position: relative;width: 100%;">
                            <p style="font-size:18px; font-weight: 700; color: #000;"><?= User::authPerfil()  ?></p>
                            <p style="font-size:10px; font-weight: 700;">Perfiles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

