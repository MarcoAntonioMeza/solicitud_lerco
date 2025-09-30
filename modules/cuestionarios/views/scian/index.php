<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\BootstrapTableAsset;

BootstrapTableAsset::register($this);
/* @var $this yii\web\View */


$this->title = 'ACTIVIDADES SCIAN';
$this->params['breadcrumbs'][] = $this->title;

$bttExport    = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl       = Url::to(['actividad-json-btt']);
$bttUrlView   = Url::to(['view?id=']);
?>

<div class="ibox">
    <div class="ibox-content">
        <?= $can['create'] ? Html::a('<i class="fa fa-plus"></i> Nueva actividaD', ['create'], ['class' => 'btn btn-primary add btn-zoom']) : "" ?>
        <div class="solicitudes-solicitud-index">
            <div class="btt-toolbar">
            </div>
            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var actions = function(value, row) {
                return [
                    '<a href="<?= $bttUrlView ?>' + row.id + '" title="Ver solicitud" class="fa fa-eye"></a>'
                ].join('');
            },
            columns = [{
                    field: 'clave',
                    title: 'CLAVE',
                    align: 'justify',
                    sortable: true,

                },
                {
                    field: 'titulo',
                    title: 'ACTIVIDAD',
                    align: 'justify',
                    //width: '5',
                    sortable: true,
                    //switchable: false,
                },
                {
                    field: 'descripcion',
                    title: 'DESCRIPCIÓN',
                    align: 'justify',
                    //width: '5',
                    sortable: true,
                    //switchable: false,
                },







            ],
            params = {
                id: 'solicitudes',
                element: '.solicitudes-solicitud-index',
                url: '<?= $bttUrl ?>',
                bootstrapTable: {
                    columns: columns,
                    exportOptions: {
                        "fileName": "<?= $bttExport ?>"
                    },
                    onDblClickRow: function(row, $element) {
                        window.location.href = '<?= $bttUrlView ?>' + row.id;
                    },
                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();
    });
</script>