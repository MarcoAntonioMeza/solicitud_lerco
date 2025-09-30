<?php
use yii\helpers\Url;
use app\models\Esys;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use app\models\user\User;
use app\models\catalogo\CatalogoComision;

?>


<div class="configuracion-comision-form">
	<div class="ibox">
		<div class="ibox-content">
			<?php $form = ActiveForm::begin(['id' => 'form-comision']) ?>
                <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
			    <div class="form-group">
				    <?= Html::Button($model->isNewRecord ? 'GUARDAR PLAN DE COMISIÓN' : 'GUARDAR CAMBIOS', ['class' => $model->isNewRecord ? 'btn btn-success btn-zoom' : 'btn btn-primary btn-zoom', 'onclick' => 'funct_confirmPlanComision()']) ?>
					<?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-white btn-zoom']) ?>
			    </div>

                <div class="row control-formPlanComision">
                    <div class="col-sm-2">
                        <?= $form->field($model, 'clave')->textInput([ "autocomplete" => "off", "onkeyup" => "funcLowerCase(this)"]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'titulo')->textInput([ "autocomplete" => "off" , "onkeyup" => "funcLowerCase(this)"]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'descripcion')->textarea(['rows' => 1, "onkeyup" => "funcLowerCase(this)"]) ?>
                    </div>
                </div>
                <fieldset style="width:100%;border:2px solid #D3D3D3;border-radius:10px;padding:20px; ">
                    <legend class="text-center" style="width:auto;margin-bottom:0;font-size:18px;font-weight:bold; padding-left: 45px;padding-right: 45px;color: #000;border-style: solid;border-width: 2px;background: #d6dce5;">COMISIONES</legend>
                    <div class="row">
                        <div class="col-sm-12">
                             <div class="row">
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("CODIGO","inputCodigo", ["class" => "control-label"] ) ?>
                                        <?= Html::input('text', 'inputCodigo', null, ['class' => 'form-control','id' => 'inputCodigo', 'style' => 'font-size: 12px;font-weight: bold;', "onkeyup" => "funcLowerCase(this)"]) ?>
                                    </div>

                                 </div>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("NOMBRE COMISIÓN ","inputNombre", ["class" => "control-label"] ) ?>
                                        <?= Html::input('text', 'inputNombre', null, ['class' => 'form-control', 'id' => 'inputNombre', 'style' => 'font-size: 12px; font-weight: bold;', "onkeyup" => "funcLowerCase(this)"]) ?>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                        <?= Html::label("DESCRIPCION DE LA COMISIÓN","inputDescripcion", ["class" => "control-label"] ) ?>
                                        <?= Html::textarea("inputDescripcion",null,["class" => "form-control", "id" => "inputDescripcion", "rows" => 1 , "onkeyup" => "funcLowerCase(this)"]) ?>
                                    </div>
                                 </div>

                                 <div class="col-sm-3">
                                    <div class="form-group text-center">
                                        <?= Html::label("APLICA POR","inputAplicaPor", ["class" => "control-label"] ) ?>
                                        <p style="font-size:12px; color: #000; font-weight: 600;">
                                            <?= Html::radio('aplica_por', true, ['label' => 'MONTO FIJO', 'class' => 'form-control control-label', "style" => "font-size:8px; color: #000; margin-right:85px","onchange" => "funct_validCondicional()", "id" => "inputAplicaPorMonto"]); ?>
                                            /
                                            <?= Html::radio('aplica_por', false, ['label' => 'PORCENTAJE', 'class' => 'form-control control-label', "style" => "font-size:8px; color: #000; margin-right:85px","onchange" => "funct_validCondicional()", "id" => "inputAplicaPorPorcentaje"]); ?>
                                        </p>
                                    </div>
                                 </div>

                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("MONTO FIJO","inputValor", ["class" => "control-label", 'id' => "inputTitleValor"] ) ?>
                                        <div style="display:none" class="divinputValorPorcentaje">
                                            <div class="input-group">
                                                <?= Html::input('text', 'inputValorPorcentaje', false, ["id"=> "inputValorPorcentaje", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:16px; text-align:right; font-weight:800']) ?>
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">%</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div  class="inputValorFijo">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">$</span>
                                                </div>
                                                <?= Html::input('text', 'inputValorFijo', false, ["id"=> "inputValorFijo", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:16px; text-align:right; font-weight:800']) ?>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("IMPUESTO","inputImpuesto", ["class" => "control-label"] ) ?>
                                        <?=  Html::dropDownList('inputImpuesto', null, CatalogoComision::$impuestoList , ['class' => 'form-control', 'id'=> 'inputImpuesto','prompt' => '-- SELECT --']) ?>
                                    </div>
                                 </div>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("APLICA POR","inputAplicaPor", ["class" => "control-label"] ) ?>
                                        <?=  Html::dropDownList('inputAplicaPor', null, CatalogoComision::$aplicaPorList  , ['class' => 'form-control', 'id'=> 'inputAplicaPor','prompt' => '-- SELECT --']) ?>
                                    </div>
                                 </div>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("PERIODO DE COBRO","inputPeriodicidadCobro", ["class" => "control-label"] ) ?>
                                        <?=  Html::dropDownList('inputPeriodicidadCobro', null, CatalogoComision::$periodicidadCobroList , ['class' => 'form-control', 'id'=> 'inputPeriodicidadCobro','prompt' => '-- SELECT --']) ?>
                                    </div>
                                 </div>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("BASE DE COBRO","inputBaseCobro", ["class" => "control-label"] ) ?>
                                        <?=  Html::dropDownList('inputBaseCobro', null, CatalogoComision::$baseCobroList , ['class' => 'form-control', 'id'=> 'inputBaseCobro','prompt' => '-- SELECT --']) ?>
                                    </div>
                                 </div>
                                 <div class="col-sm-2 text-center">
                                    <p style="font-size:9px;font-weight: bold;color: #000;"><strong class="lbl_check_tipo"></strong>
                                        <label class="switch">
                                            <input type="checkbox"  id="inputRequiereAutorizacion" onchange="funct_validCondicional()">
                                            <span class="slider round"></span>
                                        </label>
                                    </p>
                                    <p style="font-size:12px; font-weight:700; text-align: center;">¿ REQUIERE AUTORIZACION ?</p>

                                 </div>
                                 <div class="col-sm-2">
                                    <div class="form-group">
                                        <?= Html::label("USUARIO FACULTADO PARA AUTORIZACION","inputUserAutorizadoID", ["class" => "control-label"] ) ?>
                                        <?= Html::dropDownList('inputUserAutorizadoID', null, User::getItems() , ['class' => 'form-control', 'id'=> 'inputUserAutorizadoID','style' => 'font-size:16px; height:65%','prompt' => '-- SELECT --', 'disabled' => true]) ?>

                                    </div>
                                 </div>
                             </div>


                            <div class="form-group">
                                <p><?= Html::Button('AGREGAR COMISION', ['class' => 'btn btn-success float-right' ,'id' => 'btnAddComision', "style" => "font-weight: bold; "]) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" >
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">CODIGO</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">DESCRIPCION</th>
                                <th class="text-center">APLICA POR</th>
                                <th class="text-center">PORCENTAJE</th>
                                <th class="text-center">VALOR</th>
                                <th class="text-center">IMPUESTO</th>
                                <th class="text-center">APLICA POR</th>
                                <th class="text-center">PERIODO DE COBRO</th>
                                <th class="text-center">BASE DEL COBRO</th>
                                <th class="text-center">REQUIERE AUTORIZACION</th>
                                <th class="text-center">AUTORIZA</th>
                                <th class="text-center">ACCION</th>
                            </tr>
                            </thead>
                            <tbody class="container-list">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </fieldset>
    		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

<?= $this->registerJsFile('@web/js/my_js/catalogo-plan-comision-script.js'.'?v='.Esys::getVersionadoArchivo('js/my_js/catalogo-plan-comision-script.js'), ['depends' => [yii\web\JqueryAsset::className()]]); ?>