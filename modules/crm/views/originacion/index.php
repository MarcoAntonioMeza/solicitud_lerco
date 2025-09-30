ahora ajsuta esto solo los campos de la vista <?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\BootstrapTableAsset;

use app\models\sucursal\Sucursal;

BootstrapTableAsset::register($this);
/* @var $this yii\web\View */


$this->title = 'SOLICITUDES';
//$this->params['breadcrumbs'][] = "CREDITO";
$this->params['breadcrumbs'][] = $this->title;

$bttExport                  = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl                     = Url::to(['solicitud-json-btt']);
$bttUrlUpdate               = Url::to(['update?id=']);
$bttUrlDelete               = Url::to(['baja?id=']);
$bttUrlView                = Url::to(['view?id=']);

?>



<div class="ibox">



    <div class="ibox-content">
        <div class="configuracion-comision-index">
            <div class="btt-toolbar" style="border-style: solid;border-width: 1px;box-shadow: 2px 2px 5px #8d8d8d;">
                <div class="panel mar-btm-5px">
                    <div class="panel-body pad-btm-15px">
                        <div>
                            <strong class="pad-rgt">Filtrar:</strong>
                            <?= "" //Html::dropDownList('status', null, Solicitud::$statusList, ['prompt' => '--- ESTATUS ---', 'class' => 'max-width-170px form-control m-b'])  
                            ?>
                            <?= "" #Html::dropDownList('sucursal_id', null, Sucursal::getSucursales(), ['prompt' => '--- SUCURSAL ---', 'class' => 'max-width-170px form-control m-b'])  
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        can = JSON.parse('<?= json_encode($can) ?>');
        var actions = function(value, row) {
                return [
                    '<a href="<?= $bttUrlView ?>' + row.id + '" title="Ver solicitud" class="fa fa-eye"></a>',
                    //(can.update ? '<a href="<?= $bttUrlUpdate ?>' + row.id + '" title="Editar empresa" class="fa fa-pencil"></a>' : ''),
                    //( row.status == '<?= $can['update'] ?>' ? '<a href="<?= $bttUrlUpdate ?>' + row.id + '"  title="Editar" class="fa fa-edit" ></a>': ''),
                    // ( row.status == '<?= "" //CatalogoGrupoRiesgo::STATUS_ACTIVE 
                                        ?>' ? '<a href="<?= $bttUrlDelete ?>' + row.id + '"  title="Baja" class="fa fa-level-down" data-confirm="Confirma que deseas realizar la baja del plan de comisiones" data-method="post"></a>': '')
                ].join('');
            },
            columns = [{
                    field: 'id',
                    title: 'ID',
                    align: 'center',
                    width: '60',
                    sortable: true,
                    switchable: false,
                },
                {
                    field: 'nombre_completo',
                    title: 'NOMBRE COMPLETO',
                    sortable: true,
                },
                {
                    field: 'email',
                    title: 'EMAIL',
                    sortable: true,
                },
                {
                    field: 'telefono',
                    title: 'TELÉFONO',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'cargo',
                    title: 'CARGO',
                    sortable: true,
                },
                {
                    field: 'empresa',
                    title: 'EMPRESA',
                    sortable: true,
                },
                {
                    field: 'fecha_creacion',
                    title: 'FECHA CREACIÓN',
                    align: 'center',
                    sortable: true,
                    //formatter: btf.time.date,
                },
                {
                    field: 'direccion',
                    title: 'DIRECCIÓN',
                    sortable: true,
                },
                {
                    field: 'estado',
                    title: 'ESTADO',
                    sortable: true,
                },
                {
                    field: 'municipio',
                    title: 'MUNICIPIO',
                    sortable: true,
                },
                {
                    field: 'codigo_postal',
                    title: 'C.P.',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'colonia_cp',
                    title: 'COLONIA',
                    sortable: true,
                },
                {
                    field: 'action',
                    title: 'Acciones',
                    align: 'center',
                    switchable: false,
                    width: '100',
                    class: 'btt-icons',
                    formatter: actions,
                    tableexportDisplay: 'none',
                },
            ],
            params = {
                id: 'comision',
                element: '.configuracion-comision-index',
                url: '<?= $bttUrl ?>',
                bootstrapTable: {
                    columns: columns,
                    exportOptions: {
                        "fileName": "<?= $bttExport ?>"
                    },
                    onDblClickRow: function(row, $element) {
                        window.location.href = '<?= $bttUrlView ?>' + row.id;
                    },
                },
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();

    });
</script>