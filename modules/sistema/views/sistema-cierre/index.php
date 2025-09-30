<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\BootstrapTableAsset;
use app\models\esys\EsysSetting;

BootstrapTableAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'CIERRE DEL OPERACION';
$this->params['breadcrumbs'][] = 'Sistema';
$this->params['breadcrumbs'][] = $this->title;

$bttExport = Yii::$app->name . " - $this->title - " . date('Y-m-d H.i');
$bttUrl    = Url::to(['proceso-cierres-json-btt']);
?>

<div class="ibox">
    <div class="ibox-content">
        <div class="admin-sistema-cierre-index">
            <p><?= Html::button("<i class='fa fa-sign-out'></i>  CIERRE DEL OPERACION", ["class" => "btn btn-success btn-zoom", 'id' => 'btnProcesoCierre']) ?></p>
            <div class="btt-toolbar"></div>
            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        var columns = [
                {
                    field: 'id',
                    title: 'ID',
                    align: 'center',
                    width: '60',
                    sortable: true,
                    switchable:false,
                },
                {
                    field: 'fecha',
                    title: 'FECHA DE CIERRE',
                    align: 'center',
                    sortable: true,
                    switchable: false,
                },
                {
                    field: 'inicia',
                    title: 'INICIO',
                    align: 'center',
                    sortable: true,
                    formatter: btf.time.datetime,
                },
                {
                    field: 'termina',
                    title: 'TERMINA',
                    align: 'center',
                    sortable: true,
                    formatter: btf.time.datetime,
                },
                {
                    field: 'no_credito',
                    title: 'NO CREDITOS',
                    align: 'center',
                    align: "center",
                    sortable: true,
                    switchable: false,
                },
                {
                    field: 'status',
                    title: 'ESTATUS',
                    align: "center",
                    sortable: true,
                    switchable: false,
                    formatter: btf.status.system_cierre,
                },
            ],
            params = {
                id      : 'sistema-cierre',
                element : '.admin-sistema-cierre-index',
                url     : '<?= $bttUrl ?>',
                bootstrapTable : {
                    columns : columns,
                    exportOptions : {"fileName":"<?= $bttExport ?>"},
                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();
    });


    $('#btnProcesoCierre').click(function(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 5000
        };

        toastr.warning("INICIANDO CIERRE ........", "PROCESO DE CIERRE");
        $.get("<?= Url::to(['/system-procedure-cierre-operacion/start-procedure-cierre-operacion']) ?>",function(response){
            if (response.code == 202) {
                toastr.success("COMPLETADO", "PROCESO DE CIERRE");
                location.reload();
            }
        });
    });

</script>
