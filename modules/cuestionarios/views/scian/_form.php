<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use dosamigos\tinymce\TinyMce;


?>
<div class="panel-body">

    <?php $form = ActiveForm::begin(); ?>

    <div class="producto-form">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">actividad</h3>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'codigo')->textInput() ?>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row">

                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <?= $form->field($model, 'actividad')->widget(TinyMce::className(), [
                            'options' => ['rows' => 3],
                            'language' => 'es', // Cambia el idioma si es necesario
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
                            ]
                        ]) ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success sol']) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>