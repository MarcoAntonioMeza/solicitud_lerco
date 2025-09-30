<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use app\models\esys\EsysListaDesplegable;
use app\models\user\User;
use app\models\comite\Comite;
use app\models\comite\ComiteUser;
?>

<div class="comites-credito-form">

    <?php $form = ActiveForm::begin(['id' => 'form-comite' ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear comite' : 'Guardar cambios', ['class' => $model->isNewRecord ? 'btn btn-success btn-zoom' : 'btn btn-primary btn-zoom']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-white btn-zoom']) ?>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>Información generales</h5>
                </div>
                <div class="ibox-content">
                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

                    <?= $form->field($model, 'user_voto_calidad_id')->widget(Select2::classname(),
                    [
                        'language' => 'es',
                            'data' => isset($model->user_voto_calidad_id)  && $model->user_voto_calidad_id ? [$model->votoCalidad->id => $model->votoCalidad->nombre ." ". $model->votoCalidad->apellidos] : [],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'language'   => [
                                    'errorLoading' => new JsExpression("function () { return 'Esperando los resultados...'; }"),
                                ],
                                'ajax' => [
                                    'url'      => Url::to(['user-ajax']),
                                    'dataType' => 'json',
                                    'cache'    => true,
                                    'processResults' => new JsExpression('function(data, params){  return {results: data} }'),
                                ],
                            ],
                            'options' => [
                                'placeholder' => 'Selecciona al usuario...',
                            ],

                    ]) ?>

                    <?= $form->field($model, 'nota')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
             <div class="ibox">
                 <div class="ibox-content" style="height:550px; overflow-y: auto;">
                     <div class="form-group">
                        <h5>Participantes</h5>
                        <div class="row" >

                            <?php foreach (User::getItems() as $key => $item): ?>
                                <?php $comite = ComiteUser::valUserComite($model->id, $key); ?>
                                        <div class="col-sm-6 col-xs-6 text-center" style="box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px; padding: 10px; border-radius:5%">
                                            <?= Html::img("@web/img/profile-photos/2.png", [ "class" =>  "rounded-circle circle-border m-b-md", "alt" => "profile"]) ?>
                                            <?= Html::checkbox("UserComite[$key][user]",
                                                false,
                                                [
                                                    "id"    => "user_id_{$key}_edit",
                                                    "class" => "modulo magic-checkbox btn-checkbox",
                                                    "checked" => isset($comite->id) ? true : $comite ,
                                                ]
                                            ) ?>
                                            <?= Html::label($item, "user_id_{$key}_edit") ?>
                                        </div>

                            <?php endforeach ?>

                        </div>
                    </div>
                 </div>
             </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>