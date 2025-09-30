<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use app\assets\SummernoteAsset;
use app\assets\BlueimpFileUploadAsset;
use app\models\cuestionarios\CuestionariosGrupo;


BlueimpFileUploadAsset::register($this);


SummernoteAsset::register($this);

?>



<div class="creditos-credito-form" data-src='<?= Url::to(['/']) ?>'>
    <div class="panel">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'form-credito']) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'estado')->dropDownList(
                        CuestionariosGrupo::$status_list

                    ) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'descripcion')->textarea(['rows' => 4]) ?>
                </div>
            </div>



            <div class="form-group">
                <?= Html::submitButton('GUARDAR', ['class' => 'btn btn-success btn-zoom', 'id' => 'btnGenerarCredito']) ?>
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-white btn-zoom']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


</div>