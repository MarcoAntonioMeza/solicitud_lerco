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


$this->title = 'CONFIGURACION DE PLAN DE COMISIONES';
$this->params['breadcrumbs'][] = "CREDITO";
$this->params['breadcrumbs'][] = $this->title;

$bttExport                  = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl                     = Url::to(['plan-comisiones-json-btt']);
$bttUrlUpdate               = Url::to(['update?id=']);
$bttUrlDelete               = Url::to(['baja?id=']);

?>

<div class="ibox">
    <div class="ibox-content">
        <p><?=  Html::a('<i class="fa fa-plus"></i> NUEVA PLAN DE COMISION', ['create'], ['class' => 'btn btn-success add btn-zoom' ]) ?></p>

        <div class="configuracion-comision-index">

            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var actions = function(value, row) { return [
                ( row.status == '<?= CatalogoGrupoRiesgo::STATUS_ACTIVE ?>' ? '<a href="<?= $bttUrlUpdate ?>' + row.id + '"  title="Editar" class="fa fa-edit" ></a>': ''),
                ( row.status == '<?= CatalogoGrupoRiesgo::STATUS_ACTIVE ?>' ? '<a href="<?= $bttUrlDelete ?>' + row.id + '"  title="Baja" class="fa fa-level-down" data-confirm="Confirma que deseas realizar la baja del plan de comisiones" data-method="post"></a>': '')
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
                    field: 'clave',
                    title: 'CLAVE',
                    sortable: true,
                    formatter: btf.color.bold,
                },
                {
                    field: 'titulo',
                    title: 'PAQUETE',
                    sortable: true,
                    align: 'center',
                    formatter: btf.garantia.tipo,
                },
                {
                    field: 'descripcion',
                    title: 'DESCRIPCION',
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
                id      : 'comision',
                element : '.configuracion-comision-index',
                url     : '<?= $bttUrl ?>',
                bootstrapTable : {
                    columns : columns,
                    exportOptions : {"fileName":"<?= $bttExport ?>"},
                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();

    });



</script>
