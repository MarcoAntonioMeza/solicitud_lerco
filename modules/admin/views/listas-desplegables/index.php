<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\esys\EsysListaDesplegable;
use app\assets\EsysListasDesplegablesAsset;


EsysListasDesplegablesAsset::register($this);

$this->title = 'Listas desplegables';
$this->params['breadcrumbs'][] = 'Administración';
$this->params['breadcrumbs'][] = 'Configuraciones';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-listas-desplegables-index">
	<div id="listas-desplegables"
	    data-src='<?= Url::to(['.']) ?>'>
		<div class="row">
			<div class="col-sm-9">
				<div class="ibox">
					<div class="ibox-content">
					    <div class="form-horizontal">
					        <div class="form-group">
					            <label class="col-sm-2 control-label" for="modulo_id">Seleccionar módulo</label>
					            <div class="col-sm-4">
					                <?= Html::dropDownList('modulo_id', null, EsysListaDesplegable::getModulos(), ['class' => 'form-control']) ?>
					            </div>
					        </div>
					        <div class="form-group">
					            <label for="lista_id" class="col-sm-2 control-label">Seleccionar lista desplegable</label>
					            <div class="col-sm-4">
					                <select name="lista_id" class='form-control'></select>
					            </div>
					        </div>
					    </div>
					</div>
				</div>
			</div>
		</div>

	    <hr>

	    <div class="row">
	        <div class="col-sm-6 panel lista-items">
	            <div class="panel-heading ibox-title">
	                <h5 class="panel-title">&nbsp;</h5>
	            </div>
	            <div class="panel-body ibox-content"></div>
	        </div>

	        <div class="col-sm-6">
	            <div class="pull-left pad-rgt">
	                <?= $can['create']? Html::button('Agregar elemento', ['class' => 'btn btn-default btn-cfg-listas add']): '' ?>
	                <?= $can['update']? Html::button('Renombrar elemento', ['class' => 'btn btn-default btn-cfg-listas rename']): '' ?>
	                <?= $can['delete']? Html::button('Eliminar elementos', ['class' => 'btn btn-danger btn-cfg-listas del', "data-loading-text" => "Eliminando...", "autocomplete" => "off"]): '' ?>
	                <?= $can['delete']? Html::button('Baja elementos', ['class' => 'btn btn-warning btn-cfg-listas baja', "data-loading-text" => "Baja...", "autocomplete" => "off"]): '' ?>
	                <?= $can['create'] || $can['update']? Html::button('Guardar orden', ['class' => 'btn btn-success btn-cfg-listas saveOrder', "data-loading-text" => "Guardando...", "autocomplete" => "off"]): '' ?>
	            </div>
	            <div>
	                <?php if($can['update']): ?>
	                    <p><i class="fa fa-info-circle"></i> Arrastra los elementos para reposicionarlos</p>
	                <?php endif ?>
	                <?php if($can['update'] || $can['delete']): ?>
	                    <p>Selecciona un elemento para renombrarlo o eliminarlo</p>
	                <?php endif ?>
	            </div>
	        </div>
	    </div>

	    <!-- Modal form -->
	    <div class="modal inmodal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="titleModal">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Cancelar"><span aria-hidden="true">&times;</span></button>
	                    <h4 class="modal-title" id="titleModal"></h4>
	                </div>
	                <div class="modal-body">
	                    <div class="form-horizontal">

	                        <div class="row">
	                        	<div class="col-sm-12">
	                        		<div class="ibox">
	                        			<div class="ibox-content">
					                        <div class="form-group singular">
					                            <label class="col-sm-3 control-label" for="input">Nombre</label>
					                            <div class="col-sm-8">
					                                <?= Html::input('text', 'singular', null, ['class' => 'form-control', 'placeholder' => 'Nombre de elemento de lista', 'autocomplete' => 'off' ]) ?>
					                            </div>
					                        </div>

					                        <div class="div_form_params" style="display: none">
						                        <div class="form-group params_val1">
						                            <label class="col-sm-3 control-label" for="input">REQUERIDO</label>
						                            <div class="col-sm-8">
						                            	<div class="input-group mar-btm text-center">
						                            		<p style="font-size:9px;font-weight: bold;color: #000;"><strong class="lbl_check_tipo"></strong>
				                                                <label class="switch">
				                                                    <input type="checkbox" name="params_val1"  id="params_val1">
				                                                    <span class="slider round"></span>
				                                                </label>
				                                            </p>
						                            		<?php /* Html::input('text', 'params_val1', null, ['class' => 'form-control', 'placeholder' => '[[ PARAMS ]]', 'autocomplete' => 'off','id' => 'params_val1' ]) */ ?>
						                            	</div>
						                            </div>
						                        </div>
						                    </div>
	                        			</div>
	                        		</div>
	                        	</div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <?= Html::button('Cancelar', ['class' => 'btn btn-white', 'data-dismiss' => "modal"]) ?>
	                    <?= Html::button(null, ['class' => 'btn btn-primary submit', 'data-loading-text' => "Guardando...", "autocomplete" => "off"]) ?>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#listas-desplegables').esysListasDesplegables();
    });
</script>
