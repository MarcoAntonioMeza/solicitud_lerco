<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\BootstrapTableAsset;
use kartik\daterange\DateRangePicker;
use app\models\user\User;
use app\models\auth\AuthAssignment;
use app\models\esys\EsysListaDesplegable;

BootstrapTableAsset::register($this);

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = $this->title;

$bttExport    = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl       = Url::to(['users-json-btt']);
$bttUrlView   = Url::to(['view?id=']);
$bttUrlUpdate = Url::to(['update?id=']);
$bttUrlDelete = Url::to(['delete?id=']);
?>

<div class="ibox">
    <div class="ibox-content">
        <p>
          <?= $can['create']?
                    Html::a('<i class="fa fa-plus"></i> Nuevo usuario', ['create'], ['class' => 'btn btn-primary add btn-zoom']): '' ?>
        </p>

        <div class="admin-user-internos-index">
            <div class="btt-toolbar">
                <div class="panel mar-btm-5px">
                    <div class="panel-body pad-btm-15px">
                        <div>
                            <strong class="pad-rgt">Filtrar:</strong>
                             <?= Html::dropDownList('perfil', null, AuthAssignment::getItemsAssignments(), ['prompt' => 'Todos los perfil', 'class' => 'max-width-170px']) ?>

                            <?= Html::dropDownList('departamento_id', null, EsysListaDesplegable::getItems('departamento_laboral'), ['prompt' => 'Todos los departamente', 'class' => 'max-width-170px']) ?>

                        </div>
                    </div>
                </div>
            </div>
            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var can     = JSON.parse('<?= json_encode($can) ?>'),
            actions = function(value, row) { return [
                '<a href="<?= $bttUrlView ?>' + row.id + '" title="Ver usuario" class="fa fa-eye"></a>',
                (can.update? '<a href="<?= $bttUrlUpdate ?>' + row.id + '" title="Editar usuario" class="fa fa-pencil"></a>': ''),
                (can.delete? '<a href="<?= $bttUrlDelete ?>' + row.id + '" title="Eliminar usuario" class="fa fa-trash" data-confirm="Confirma que deseas eliminar el usuario" data-method="post"></a>': '')
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
                    field: 'username',
                    title: 'Nombre de usuario',
                    sortable: true,
                },
                {
                    field: 'nombre_completo',
                    title: 'Nombre completo',
                    switchable: false,
                    sortable: true,
                },
                {
                    field: 'perfil',
                    title: 'Perfil',
                    align: 'center',
                    sortable: true,
                },
                {
                    field: 'perfiles_asignar',
                    title: 'Perfiles que pudiera asignar',
                    align: 'center',
                    sortable: true,
                    visible: false,
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
                    visible: false,
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
                id      : 'usuario',
                element : '.admin-user-internos-index',
                url     : '<?= $bttUrl ?>',
                bootstrapTable : {
                    columns : columns,
                    exportOptions : {"fileName":"<?= $bttExport ?>"},
                    onDblClickRow : function(row, $element){
                        window.location.href = '<?= $bttUrlView ?>' + row.id;
                    },

                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();
    });
</script>
