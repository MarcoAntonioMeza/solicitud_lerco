<?php
use yii\helpers\Url;
use app\models\Esys;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use app\models\solicitud\Solicitud;
use app\models\catalogo\CatalogoGarantia;
use app\models\catalogo\CatalogoAseguradora;
use app\models\catalogo\CatalogoMoneda;
use app\models\esys\EsysDireccionCodigoPostal;
use app\models\esys\EsysListaDesplegable;

?>

<link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps.css'>

<div class="configuracion-garantia-form">
	<div class="ibox">
		<div class="ibox-content">
			<?php $form = ActiveForm::begin(['id' => 'form-garantia']) ?>
                <?= $form->field($model, 'cliente_id')->hiddenInput()->label(false) ?>
			    <div class="form-group">
				    <?= Html::submitButton($model->isNewRecord ? 'GUARDAR GARANTIA' : 'GUARDAR CAMBIOS', ['class' => $model->isNewRecord ? 'btn btn-success btn-zoom' : 'btn btn-primary btn-zoom']) ?>
					<?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-white btn-zoom']) ?>
			    </div>

                <fieldset style="width:100%;border:2px solid #D3D3D3;border-radius:10px;padding:20px; ">
                    <legend class="text-center" style="width:auto;margin-bottom:0;font-size:18px;font-weight:bold; padding-left: 45px;padding-right: 45px;color: #000;border-style: solid;border-width: 2px;background: #d6dce5;">DATOS CLIENTE</legend>
                    <div class="row">
                        <div class="col-sm-2">
                            <?= Html::label("ID CLIENTE","garantia-find_cliente_id", ["class" => "control-label"]) ?>
                            <?= Html::input('text', 'CatalogoGarantia[find_cliente_id]', false, ["id"=> "garantia-find_cliente_id", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:16px; text-align:center','placeholder' => '--']) ?>
                        </div>
                        <div class="col-sm-2">
                            <?= Html::label("BP NUMBER","garantia-bp_number", ["class" => "control-label"]) ?>
                            <?= Html::input('text', 'CatalogoGarantia[bp_number]', false, ["id"=> "garantia-bp_number", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:16px; text-align:center','placeholder' => '--']) ?>

                        </div>
                        <div class="col-sm-4">
                            <?= Html::label("CLIENTE","garantia-cliente_text", ["class" => "control-label"]) ?>
                            <?= Select2::widget([
                                'id' => 'garantia-cliente_text',
                                'name' => 'CatalogoGarantia[cliente_text]',
                                'data' => [],
                                'options' => [
                                    'placeholder' => '---- BUSCA AL CLIENTE -----'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language'   => [
                                        'errorLoading' => new JsExpression("function () { return 'Esperando los resultados...'; }"),
                                    ],
                                    'ajax' => [
                                        'url'      => Url::to(['clientes-ajax']),
                                        'dataType' => 'json',
                                        'cache'    => true,
                                        'processResults' => new JsExpression('function(data, params){  return {results: data} }'),
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-2 text-center">
                            <?= Html::label("GRUPO DE RIESGO","garantia-grupo-riesgo", ["class" => "control-label"]) ?>
                            <h3 class="label-text label-grupo-riesgo"> ---------------- </h3>
                        </div>
                        <div class="col-sm-2 text-center">
                            <?= Html::label("ESTATUS","garantia-status", ["class" => "control-label"]) ?>
                            <h3 class="label-text label-status"> ---------------- </h3>
                        </div>
                    </div>
                </fieldset>
                <div class="form-garantia-content" style="opacity: 0.2;">
                    <fieldset style="width:100%;border:2px solid #D3D3D3;border-radius:10px;padding:20px; ">
                        <div class='ibox'>
                            <div class='ibox-content'>
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab" href="#tab-datos-garantia">DATOS DE LA GARANTIA</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab-detos-escritura">DATOS DE ESCRITURA PUBLICA RPP</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab-datos-avaluo">DATOS DE AVALÚO</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab-direccion">DATOS DE DIRECCION</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-toggle="tab" href="#tab-aseguradora">DATOS DE ASEGURADORA</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" id="tab-datos-garantia" class="tab-pane active">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'tipo')->dropDownList(CatalogoGarantia::$tipoList, ['prompt' => '---SELECT ---']) ?>
                                                </div>
                                                <div class="col-sm-9">
                                                     <?= $form->field($model, 'descripcion')->textarea(['rows' => 1, "onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'componente')->dropDownList(CatalogoGarantia::$componenteList, ['prompt' => '---SELECT ---']) ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'unidad')->dropDownList(CatalogoGarantia::$unidadList, ['prompt' => '---SELECT ---']) ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'numero_unidad')->textInput(['type' => 'number', "autocomplete" => "off"]) ?>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group-money">
                                                        <?= Html::label("VALOR POR UNIDAD","catalogogarantia-unidad_valor", ["class" => "control-label"]) ?>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                            </div>
                                                            <?= Html::input('text', 'CatalogoGarantia[unidad_valor]',( $model->id ? number_format($model->unidad_valor,2)  : false ), ["id"=> "catalogogarantia-unidad_valor", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800']) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group-money">
                                                        <?= Html::label("TOTAL (NO DE UNIDAD * VALOR POR UNIDAD)","catalogogarantia-unidad_valor_total", ["class" => "control-label"]) ?>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                            </div>
                                                            <?= Html::input('text', 'CatalogoGarantia[unidad_valor_total]', ( $model->id ? number_format($model->unidad_valor_total ,2): false ), ["id"=> "catalogogarantia-unidad_valor_total", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800']) ?>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'moneda')->dropDownList(CatalogoMoneda::getItems(), ['prompt' => '---SELECT ---']) ?>
                                                </div>

                                                <div class="col-sm-3">

                                                    <?= $form->field($model, 'folio_rug')->textInput(['maxlength' => true, "autocomplete" => "off", "onkeyup" => "funcLowerCase(this)"]) ?>

                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'libre_gravamen')->dropDownList(CatalogoGarantia::$libreGravamenList, ['prompt' => '---SELECT ---']) ?>
                                                </div>

                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'prelacion_pago')->dropDownList(CatalogoGarantia::$prelacionPagoList, ['prompt' => '---SELECT ---']) ?>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="tab-detos-escritura"  role="tabpanel" class="tab-pane">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'no_escritura')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'libro')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'folio_inscripcion')->textInput(['maxlength' => true, "autocomplete" => "off", "onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">

                                                    <?= $form->field($model, 'fecha_inscripcion')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => '--/--/----', 'autocomplete' => 'off'],
                                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                        'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                                        'removeIcon' => '<i class="fa fa-trash"></i>',
                                                        'language' => 'es',
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-mm-yyyy',
                                                        ]
                                                    ]) ?>

                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'notaria')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <?= Html::label("VALOR","catalogogarantia-valor", ["class" => "control-label"]) ?>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">$</span>
                                                            </div>
                                                            <?= Html::input('text', 'CatalogoGarantia[valor]', ( $model->id ? number_format($model->valor ,2): false ), ["id"=> "catalogogarantia-valor", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800']) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="tab-datos-avaluo"  role="tabpanel" class="tab-pane">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'entidad')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'perito')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'folio_avaluo')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'fecha_avaluo')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => '--/--/----', 'autocomplete' => 'off'],
                                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                        'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                                        'removeIcon' => '<i class="fa fa-trash"></i>',
                                                        'language' => 'es',
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-mm-yyyy',
                                                        ]
                                                    ]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= Html::label("MONTO VALUADO ","catalogogarantia-monto_valuado", ["class" => "control-label"]) ?>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">$</span>
                                                        </div>
                                                        <?= Html::input('text', 'CatalogoGarantia[monto_valuado]', ( $model->id ? number_format($model->monto_valuado ,2): false ), ["id"=> "catalogogarantia-monto_valuado", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800']) ?>
                                                    </div>

                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'requiere_valuacion')->dropDownList(CatalogoGarantia::$requierePeriodicidadList, ['prompt' => '---SELECT ---']) ?>
                                                </div>

                                                <div  class="garantia_tipo_hipotecaria_requiere_valuacion_si col-sm-8" style="<?= $model->id && $model->requiere_valuacion == 10 ? '' : 'display:none' ?>">
                                                    <div class="row">
                                                        <div class="col-sm-6" >
                                                            <?= $form->field($model, 'requiere_periodicidad')->dropDownList(CatalogoGarantia::$periodicidadList, ['prompt' => '---SELECT ---']) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= $form->field($model, 'notificacion_dia_antes')->textInput(['type' => 'number', "autocomplete" => "off"]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="tab-direccion"  role="tabpanel" class="tab-pane">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'pais_id')->dropDownList(EsysListaDesplegable::getItems('paises_nacimiento',false,'order_name'), ['prompt' => '---SELECT ---', 'onchange' => 'functInputCondiccionPais()']) ?>
                                                </div>
                                            </div>
                                            <div class="row div_content_direccion_mx">
                                                <div class="col-sm-3">
                                                    <?= Html::label('C.P.', 'catalogogarantia-codigo_postal', ['class' => 'control-label']) ?>
                                                    <?= Html::input("number", "CatalogoGarantia[codigo_postal]",( $model->id && $model->codigo_postal  ? $model->codigo_postal : false ), ["class" => "form-control", "id" => "catalogogarantia-codigo_postal", "autocomplete" => "off" ]) ?>
                                                </div>
                                                <div class="col-sm-3">

                                                    <?= Html::label('Estado', 'catalogogarantia-estado_id', ['class' => 'control-label']) ?>
                                                    <?= Select2::widget([
                                                        'id' => 'catalogogarantia-estado_id',
                                                        'name' => 'CatalogoGarantia[estado_id]',
                                                        'language' => 'es',
                                                        'value' => ( $model->id && $model->estado_id  ? number_format($model->estado_id ,2): null ),
                                                        'data' => EsysListaDesplegable::getEstados(),
                                                        'pluginOptions' => [
                                                            'allowClear' => true,
                                                        ],
                                                        'options' => [
                                                            'placeholder' => 'Selecciona el estado',
                                                        ],
                                                        'pluginEvents' => [
                                                            "change" => "function(){ onEstadoChange() }",
                                                        ]
                                                    ]) ?>



                                                </div>
                                                <div class="col-sm-2">
                                                    <?= Html::label('Deleg./Mpio.', 'catalogogarantia-municipio_id', ['class' => 'control-label']) ?>
                                                    <?= Select2::widget([
                                                        'id' => 'catalogogarantia-municipio_id',
                                                        'name' => 'CatalogoGarantia[municipio_id]',
                                                        'language' => 'es',
                                                        'data' =>  $model->id && $model->estado_id  ? EsysListaDesplegable::getMunicipios(['estado_id' => $model->estado_id]): [],
                                                        'value' => $model->id && $model->municipio_id  ? $model->municipio_id : null,
                                                        'pluginOptions' => [
                                                            'allowClear' => true,
                                                        ],
                                                        'options' => [
                                                            'placeholder' => 'Selecciona el municipio'
                                                        ],
                                                    ]) ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <?= Html::label('CUIDAD', 'catalogogarantia-cuidad_id', ['class' => 'control-label']) ?>
                                                    <?= Html::dropDownList('catalogogarantia[cuidad_id]', null, $model->id && $model->codigo_postal_id  && $model->codigo_postal ? EsysDireccionCodigoPostal::getCuidad(['codigo_postal' => $model->codigo_postal]): [], ['class' => 'form-control', 'id'=> 'catalogogarantia-cuidad_id']) ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <?= Html::label('COLONIA', 'catalogogarantia-codigo_postal_id', ['class' => 'control-label']) ?>
                                                    <?= Select2::widget([
                                                        'id'        => 'catalogogarantia-codigo_postal_id',
                                                        'name'      => 'CatalogoGarantia[codigo_postal_id]',
                                                        'language'  => 'es',
                                                        'data' =>  $model->id && $model->codigo_postal_id  && $model->codigo_postal ? EsysDireccionCodigoPostal::getColonia(['codigo_postal' => $model->codigo_postal]): [],
                                                        'value' => $model->id && $model->codigo_postal_id  && $model->codigo_postal ? $model->codigo_postal_id : null,
                                                        'pluginOptions' => [
                                                            'allowClear' => true,
                                                        ],
                                                        'options' => [
                                                            'placeholder' => 'Selecciona la colonia'
                                                        ],
                                                    ]) ?>
                                                </div>

                                            </div>

                                            <div class="row div_content_direccion_otro" style="display:none">
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'local_cp')->textInput(['maxlength' => true, "autocomplete" => "off"])->label("CP") ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'loca_estado')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"])->label("ESTADO") ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'local_municipio')->textInput(['maxlength' => true, "autocomplete" => "off", "onkeyup" => "funcLowerCase(this)"])->label("MUNICIPIO") ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'local_colonia')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"])->label("COLONIA") ?>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"])->label("Calle ó Avenida") ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <?= $form->field($model, 'num_ext')->textInput(['type' => 'number', "autocomplete" => "off"])->label("Num. Exterior") ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <?= $form->field($model, 'num_int')->textInput(['type' => 'number', "autocomplete" => "off"])->label("Num. Interior") ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?= $form->field($model, 'referencia')->textInput(['maxlength' => true, "autocomplete" => "off", "onkeyup" => "funcLowerCase(this)"])->label("REFERENCIA") ?>
                                                </div>
                                            </div>

                                            <hr>
                                            <p style="font-size:14PX; font-weight: 700; color: #000;">GEORREFERENCIA</p>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <?= $form->field($model, 'lat')->textInput(['maxlength' => true, "autocomplete" => "off"])->label("LATITUD") ?>
                                                </div>
                                                <div class="col-sm-5">
                                                    <?= $form->field($model, 'lng')->textInput(['maxlength' => true, "autocomplete" => "off"])->label("LONGITUD") ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <?= Html::button('<i class="fa fa-map-marker"></i> BUSCAR MAPS', [ 'class' =>  'btn btn-sm btn-primary btn-zoom btn-block', "onclick" => "funct_loadMaps()", "style" => "margin: 15px; " ] ) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="tab-aseguradora"  role="tabpanel" class="tab-pane">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_id')->dropDownList(CatalogoAseguradora::getItems(), ['prompt' => '---SELECT ---']) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_poliza')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_inciso')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_fecha_emision')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => '--/--/----', 'autocomplete' => 'off'],
                                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                        'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                                        'removeIcon' => '<i class="fa fa-trash"></i>',
                                                        'language' => 'es',
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-mm-yyyy',
                                                        ]
                                                    ])->label("FECHA DE EMISIÓN") ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_vigencia_ini')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => '--/--/----', 'autocomplete' => 'off'],
                                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                        'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                                        'removeIcon' => '<i class="fa fa-trash"></i>',
                                                        'language' => 'es',
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-mm-yyyy',
                                                        ]
                                                    ])->label("VIGENCIA DESDE") ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_vigencia_fin')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => '--/--/----', 'autocomplete' => 'off'],
                                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                                        'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                                        'removeIcon' => '<i class="fa fa-trash"></i>',
                                                        'language' => 'es',
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'dd-mm-yyyy',
                                                        ]
                                                    ])->label("VIGENCIA HASTA") ?>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_endoso_preferente')->dropDownList(CatalogoGarantia::$endosoList, ['prompt' => '---SELECT ---']) ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?= $form->field($model, 'aseguradora_cobertura')->textInput(['maxlength' => true, "autocomplete" => "off","onkeyup" => "funcLowerCase(this)"]) ?>
                                                </div>

                                                <div class="col-sm-4">
                                                    <?= Html::label("MONTO ASEGURADO ","catalogogarantia-aseguradora_suma_asegurada", ["class" => "control-label"]) ?>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">$</span>
                                                        </div>
                                                        <?= Html::input('text', 'CatalogoGarantia[aseguradora_suma_asegurada]', ( $model->id ? number_format($model->aseguradora_suma_asegurada ,2): false ), ["id"=> "catalogogarantia-aseguradora_suma_asegurada", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800']) ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
    		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>


<div class="fade modal inmodal " id="modal-maps"    role="dialog" aria-labelledby="modal-create-label"  >
    <div class="modal-dialog modal-lg" style="padding-top: 15%;" >
        <div class="modal-content">
            <div style="padding: 25PX;" class="ibox-content">

                <div class="spiner-example div_spiner_maps" style="height: 100%;padding: 10%;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div>
                <div id='map_solicitud_view' style="width: 100%;" class='map'></div>
            </div>
        </div>
    </div>
</div>



<script src='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps-web.min.js'></script>
<script type='text/javascript' src='<?= Url::to(['/js/mobile-or-tablet.js']) ?>'></script>
<script type='text/javascript' src='<?= Url::to(['/js/formatters.js']) ?>'></script>

<?= $this->registerJsFile('@web/js/my_js/catalogo-garantias-script.js'.'?v='.Esys::getVersionadoArchivo('js/my_js/catalogo-garantias-script.js'), ['depends' => [yii\web\JqueryAsset::className()]]); ?>

