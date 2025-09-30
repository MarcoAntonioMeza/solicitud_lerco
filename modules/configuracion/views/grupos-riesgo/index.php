<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\select2\Select2;
use app\assets\BootstrapTableAsset;
use yii\widgets\ActiveForm;
use app\models\producto\Producto;
use app\models\catalogo\CatalogoGrupoRiesgo;
use app\models\esys\EsysListaDesplegable;

BootstrapTableAsset::register($this);
/* @var $this yii\web\View */


$this->title = 'GRUPOS DE RIESGO';
$this->params['breadcrumbs'][] = $this->title;

$bttExport                  = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl                     = Url::to(['grupos-riesgo-json-btt']);
$bttUrlParticipante         = Url::to(['participantes-json-btt']);
$bttUrlParticipanteDelete   = Url::to(['baja-participante?id=']);

$bttUrlDelete = Url::to(['baja?id=']);

?>
<style>
.navbar-static-side {
    z-index: 1040;
}
.modal-backdrop{
    z-index: 1040 !important;
}

.modal {
    z-index: 1050 !important;;
}
</style>

<div class="ibox">
    <div class="ibox-content">
        <p>
           <?=  Html::a('<i class="fa fa-plus"></i> NUEVO GRUPO DE RIESGO', ['create'], ['class' => 'btn btn-success add btn-zoom', "onclick" => "funct_refreshGrupoRiesgo(this)","data" => [ "target" => "#modal-grupo_riesgo", "toggle"=> "modal"] ]) ?>
        </p>

        <div class="originacion-grupo-riesgo-index">
            <div class="btt-toolbar" style="border-style: solid;border-width: 1px;box-shadow: 2px 2px 5px #8d8d8d;">
                <div class="panel mar-btm-5px">
                    <div class="panel-body pad-btm-15px">
                        <div>
                            <strong class="pad-rgt">Filtrar:</strong>
                            <?=  Html::dropDownList('status', null, CatalogoGrupoRiesgo::$statusList, [ 'class' => 'max-width-170px'])  ?>
                        </div>
                    </div>
                </div>
            </div>
            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>


<div class="fade modal inmodal " id="modal-grupo_riesgo"   role="dialog" aria-labelledby="modal-create-label"  >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!--Modal header-->
            <?php $form = ActiveForm::begin(['id' => 'form-grupo-riesgo', 'action' => Url::to(['create-grupo-riesgo']) ]) ?>
            <?= Html::hiddenInput("GrupoRiesgo[id]",null, ["id"=>"grupo_riesgo-id"]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"> GRUPO DE RIESGO </h4>
            </div>
            <!--Modal body-->
            <div class="modal-body">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'autocomplete'=> 'off', 'style' => 'font-size:18px; font-weight:700; color : #000' ])->label('GRUPO DE RIESGO') ?>



                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= Html::label("MONTO MÁXIMO DE FINANCIAMIENTO ","catalogogruporiesgo-monto_maximo_financiamiento", ["class" => "control-label"]) ?>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">$</span>
                                            </div>
                                            <?= Html::input('text', 'CatalogoGrupoRiesgo[monto_maximo_financiamiento]', ( $model->id ? number_format($model->monto_maximo_financiamiento ,2): false ), ["id"=> "catalogogruporiesgo-monto_maximo_financiamiento", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800']) ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <?= Html::label("IMPORTE DEL PRINCIPAL ","catalogogruporiesgo-importe_principal_grupo", ["class" => "control-label"]) ?>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">$</span>
                                            </div>
                                            <?= Html::input('text', 'CatalogoGrupoRiesgo[importe_principal_grupo]', ( $model->id ? number_format($model->importe_principal_grupo ,2): false ), ["id"=> "catalogogruporiesgo-importe_principal_grupo", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800','disabled' => true ]) ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <?= Html::label("IMPORTE DISPONIBLE DEL PRINCIPAL","catalogogruporiesgo-importe_disponible_principal", ["class" => "control-label"]) ?>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">$</span>
                                            </div>
                                            <?= Html::input('text', 'CatalogoGrupoRiesgo[importe_disponible_principal]', ( $model->id ? number_format($model->importe_disponible_principal ,2): false ), ["id"=> "catalogogruporiesgo-importe_disponible_principal", "class" => 'form-control','autocomplete'=> 'off','style' => 'font-size:14px; text-align:right; font-weight:800','disabled' => true]) ?>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="col-sm-4 offset-sm-8">
                            <div class="form-group ">
                                <button data-dismiss="modal" class="btn btn-default btn-zoom" style="width: 35%;" type="button">Cerrar</button>
                                <?=Html::submitButton('GUARDAR', ['class' => 'btn btn-primary btn-zoom', 'style' => 'width:60%' ]);?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="originacion-grupo-riesgo-modal-participante-index" >
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p style="font-size:12px; color: #000; font-weight: 600;">PARTICIPANTES: </p>
                                </div>
                                <div class="col-sm-4">
                                     <?= Select2::widget([
                                        'id' => 'participante-participante_id',
                                        'name' => 'Participante[participante_id]',
                                        'language' => 'es',
                                        'data' => [],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'minimumInputLength' => 3,
                                            'language'   => [
                                                'errorLoading' => new JsExpression("function () { return 'Esperando los resultados...'; }"),
                                            ],
                                            'ajax' => [
                                                'url'      => Url::to(['get-participante-ajax']),
                                                'dataType' => 'json',
                                                'cache'    => true,
                                                'processResults' => new JsExpression('function(data, params){  return {results: data} }'),
                                            ],
                                        ],
                                        'options' => [
                                            'placeholder' => '--- BUSCAR ---',
                                        ],
                                    ]) ?>

                                </div>
                                <div class="col-sm-4">
                                    <?=Html::Button('AGREGAR', ['class' => 'btn btn-primary btn-zoom btn-block', "id" => "btnAddParticipanteID"]);?>
                                </div>
                            </div>
                            <div class="btt-toolbar">
                                <?= Html::hiddenInput('grupo_riesgo_id', null, ["id" => "grupo_riesgo_id"]) ?>
                            </div>

                            <table class="bootstrap-table" ></table>
                        </div>
                    </div>
                </div>
                <div class="originacion-grupo-riesgo-modal-saldo-index" >
                    <div class="ibox">
                        <div class="ibox-content">
                            <p style="font-size:12px; color: #000; font-weight: 600;">SALDOS: </p>
                            <table class="bootstrap-table" ></table>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var actions = function(value, row) { return [
                '<button class="btn btn-default" data-target = "#modal-grupo_riesgo" data-toggle="modal" onclick="funct_refreshGrupoRiesgo(this,'+ row.id +')", data-grupo_riesgo= "'+ row.nombre+'"  data-monto_maximo= "'+  btf.conta.miles(row.monto_maximo_financiamiento) +'"  data-importe_principal= "'+ btf.conta.miles(row.importe_principal_grupo)+'" data-importe_disponible= "'+ btf.conta.miles(row.importe_disponible_principal)+'"><i class="fa fa-pencil"></i></button>',
                ( row.status == '<?= CatalogoGrupoRiesgo::STATUS_ACTIVE ?>' ? '<a href="<?= $bttUrlDelete ?>' + row.id + '"  title="Baja grupo riesgo" class="fa fa-level-down" data-confirm="Confirma que deseas realizar la baja del grupo riesgo" data-method="post"></a>': '')
            ].join(''); },
            columns = [
                {
                    field: 'id',
                    title: 'ID',
                    align: 'center',
                    width: '60',
                    sortable: true,
                    switchable:false,
                },
                {
                    field: 'nombre',
                    title: 'GRUPO DE RIESGO',
                    sortable: true,
                    formatter: btf.color.bold,
                },
                {
                    field: 'no_integrantes',
                    title: 'NO INTEGRANTES',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'monto',
                    title: 'SALDO GRUPO',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'status',
                    title: 'Estatus',
                    align: 'center',
                    formatter: btf.status.opt_a,
                },
                {
                    field: 'created_at',
                    title: 'Creado',
                    align: 'center',
                    sortable: true,
                    switchable: false,
                    formatter: btf.time.date,
                },
                {
                    field: 'created_by',
                    title: 'Creado por',
                    sortable: true,
                    switchable: false,
                    formatter: btf.user.created_by,
                },
                {
                    field: 'updated_at',
                    title: 'Modificado',
                    align: 'center',
                    sortable: true,
                    visible: false,
                    formatter: btf.time.date,
                },
                {
                    field: 'updated_by',
                    title: 'Modificado por',
                    sortable: true,
                    visible: false,
                    formatter: btf.user.updated_by,
                },
                {
                    field: 'action',
                    title: 'Acciones',
                    align: 'center',
                    switchable: false,
                    width: '100',
                    class: 'btt-icons',
                    formatter: actions,
                    tableexportDisplay:'none',
                },
            ],
            params = {
                id      : 'grupoRiesgo',
                element : '.originacion-grupo-riesgo-index',
                url     : '<?= $bttUrl ?>',
                bootstrapTable : {
                    columns : columns,
                    exportOptions : {"fileName":"<?= $bttExport ?>"},
                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();




        var columns_saldo = [

                {
                    field: 'credito_id',
                    title: 'CREDITO ID',
                    sortable: true,
                    formatter: btf.color.bold,
                },
                {
                    field: 'producto',
                    title: 'PRODUCTO',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'saldo',
                    title: 'SALDO',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'clasificacion_credito',
                    title: 'CLASIFICACION CREDITO',
                    align: 'center',
                    formatter: btf.status.opt_a,
                },
                {
                    field: 'estatus_credito',
                    title: 'ESTATUS CREDITO',
                    align: 'center',
                    sortable: true,
                    switchable: false,
                    formatter: btf.time.date,
                },

            ],
            paramsSaldo = {
                id      : 'grupoRiesgoSaldo',
                element : '.originacion-grupo-riesgo-modal-saldo-index',
                autoHeight  : false,
                //url     : '<?= $bttUrl ?>',
                bootstrapTable : {
                    columns : columns_saldo,
                    height  : 50,
                    showRefresh             : false,
                    showExport              : false,
                    showColumns             : false,
                    search                  : false,
                    showToggle              : false,
                    showPaginationSwitch    : false,
                    exportOptions : {"fileName":"<?= $bttExport ?>"},

                }
            };

        bttBuilderSaldo = new MyBttBuilder(paramsSaldo);
        bttBuilderSaldo.refresh();

        var actions = function(value, row) { return [
            '<button type="button" title="Ver saldos" class="btn btn-default"> <i class="fa fa-cloud-download"></i></button>',
            '<a href="<?= $bttUrlParticipanteDelete ?>' + row.id + '"  title="Baja de participante grupo riesgo" class="fa fa-level-down" data-confirm="Confirma que deseas realizar la baja del participante del grupo riesgo" data-method="post"></a>',
        ].join(''); };

        var columns_participante = [
                {
                    field: 'uidx',
                    align: 'center',
                    title: 'ID INTERNO',
                    sortable: true,
                },
                {
                    field: 'nombre_completo',
                    title: 'PARTICIPANTE',
                    sortable: true,
                    formatter: btf.color.bold,
                },
                {
                    field: 'tipo',
                    title: 'Tipo',
                    align: 'center',
                    switchable: false,
                    sortable: true,
                    formatter: btf.tipo.person,
                },
                {
                    field: 'status_text',
                    title: 'Estatus',
                    align: 'center',
                    formatter: btf.color.widget_card,
                },
                {
                    field: 'action',
                    title: 'ACCIONES',
                    align: 'center',
                    switchable: false,
                    width: '100',
                    class: 'btt-icons',
                    formatter: actions,
                    tableexportDisplay:'none',
                }
            ],
            paramsParticipante = {
                id          : 'grupoRiesgoParticipante',
                element     : '.originacion-grupo-riesgo-modal-participante-index',
                autoHeight  : false,
                url     : '<?= $bttUrlParticipante ?>',
                bootstrapTable : {
                    columns : columns_participante,
                    showRefresh             : false,
                    showExport              : false,
                    showColumns             : false,
                    search                  : false,
                    showToggle              : false,
                    showPaginationSwitch    : false,
                    sortName                : 'nombre_completo',
                    sortOrder   : 'asc',
                    exportOptions : {"fileName":"<?= $bttExport ?>"},

                }
            };

        bttBuilderParticipante = new MyBttBuilder(paramsParticipante);
        bttBuilderParticipante.refresh();


        $('#catalogogruporiesgo-monto_maximo_financiamiento').mask('$ 000,000,000,000,000.00', {reverse: true});
        $('#catalogogruporiesgo-importe_principal_grupo').mask('$ 000,000,000,000,000.00', {reverse: true});
        $('#catalogogruporiesgo-importe_disponible_principal').mask('$ 000,000,000,000,000.00', {reverse: true});
    });

    var funct_refreshGrupoRiesgo = function(element, grupoRiesgoId = null){
        $('#grupo_riesgo-id').val(grupoRiesgoId);
        grupoRiesgoVal  = $(element).data('grupo_riesgo');
        maximoVal       = $(element).data('monto_maximo');
        principalVal    = $(element).data('importe_principal');
        disponibleVal   = $(element).data('importe_disponible');
        if (grupoRiesgoVal){
            $('#catalogogruporiesgo-nombre').val(grupoRiesgoVal);
            $('#catalogogruporiesgo-monto_maximo_financiamiento').val(maximoVal);
            $('#catalogogruporiesgo-importe_principal_grupo').val(principalVal);
            $('#catalogogruporiesgo-importe_disponible_principal').val(disponibleVal);
            $('#grupo_riesgo_id').val(grupoRiesgoId).change();
            $('.originacion-grupo-riesgo-modal-saldo-index').show();
            $('.originacion-grupo-riesgo-modal-participante-index').show();
        }
        else{
            $('#catalogogruporiesgo-nombre').val(null);
            $('#catalogogruporiesgo-monto_maximo_financiamiento').val(null);
            $('#catalogogruporiesgo-importe_principal_grupo').val(null);
            $('#catalogogruporiesgo-importe_disponible_principal').val(null);
            $('#grupo_riesgo_id').val(null).change();
            $('.originacion-grupo-riesgo-modal-saldo-index').hide();
            $('.originacion-grupo-riesgo-modal-participante-index').hide();
        }
    }

    $('#btnAddParticipanteID').click(function(){
        if ($('#participante-participante_id').val() &&  $('#grupo_riesgo_id').val()) {
            $.post("<?= Url::to(['post-add-participante']) ?>",{ participante_id :  $('#participante-participante_id').val(), grupo_riesgo_id : $('#grupo_riesgo_id').val() }, function(response){
                if (response.code == 202) {

                    $('#participante-participante_id').val(null);
                    $('#participante-participante_id').html(null);

                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 5000
                    };

                    toastr.success("EL CLIENTE SE INGRESO CORRECTAMENTE", "GRUPO DE RIESGO");

                    bttBuilderParticipante.refresh();
                }
            })
        }else{

            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 5000
            };

            toastr.warning("EL CLIENTE ES REQUERIDO", "GRUPO DE RIESGO");
        }

    })

</script>
