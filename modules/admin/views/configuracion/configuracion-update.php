<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\esys\EsysSetting;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\sucursales\Sucursal */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Configuraciones del Sitio';

?>

<div class="configuraciones-configuracion-form">


    <div class="row">
        <div class="col-lg-7">
            <?php $form = ActiveForm::begin(['id' => 'form-configuracion' ]) ?>
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>CONFIGURACION GENERAL</h5>
                    </div>
                    <div class="ibox-content">
                        <?php foreach ($model->configuracionAll as $key => $item): ?>
                            <?php if ( $item->clave == EsysSetting::NOMBRE_SITIO ): ?>
                                <div class="form-group">
                                    <?= Html::label("Nombre sitio", 'esysSetting_list', ["class" => "control-label"]) ?>

                                    <?= Html::input('text', 'esysSetting_list['.$item->clave.']',$item->valor,['class' => 'form-control']) ?>
                                </div>

                            <?php endif ?>

                            <?php if ( $item->clave == EsysSetting::EMAIL_SITIO ): ?>
                                <div class="form-group">
                                    <?= Html::label("Email del sitio", 'esysSetting_list', ["class" => "control-label"]) ?>

                                    <?= Html::input('text', 'esysSetting_list['.$item->clave.']',$item->valor,['class' => 'form-control']) ?>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
                                
                <div class="form-group">
                    <?= Html::submitButton( 'Guardar cambios', ['class' =>  'btn btn-primary btn-zoom']) ?>
                    <?= Html::a('Cancelar', ['index', 'tab' => 'index'], ['class' => 'btn btn-white btn-zoom']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-sm-5">
             
        </div>
    </div>
</div>
 
</script>