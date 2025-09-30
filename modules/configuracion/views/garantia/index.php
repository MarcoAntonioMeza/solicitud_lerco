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


$this->title = 'GARANTIAS';
$this->params['breadcrumbs'][] = "CREDITO";
$this->params['breadcrumbs'][] = $this->title;

$bttExport                  = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl                     = Url::to(['garantias-json-btt']);
$bttUrlUpdate               = Url::to(['update?id=']);
$bttUrlDelete               = Url::to(['baja?id=']);

?>

<link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.12.0/maps/maps.css'>

<div class="ibox">
    <div class="ibox-content">
        <div class="filter-top">
            <div class="row">
                <div class="col-sm-6">
                    <p>
                        <?=  Html::a('<i class="fa fa-plus"></i> NUEVA GARANTIA', ['create'], ['class' => 'btn btn-success add btn-zoom' ]) ?>
                    </p>
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-4">
                    <?= Select2::widget([
                        'id' => 'cliente_id',
                        'name' => 'cliente_id',
                        'language' => 'es',
                        'data' => [],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'language'   => [
                                'errorLoading' => new JsExpression("function () { return 'Esperando los resultados...'; }"),
                            ],
                            'ajax' => [
                                'url'      => Url::to(['cliente-ajax']),
                                'dataType' => 'json',
                                'cache'    => true,
                                'processResults' => new JsExpression('function(data, params){  return {results: data} }'),
                            ],
                        ],
                        'options' => [
                            'placeholder' => '--- BUSCAR ---', 'style' => 'width: 100%'
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="configuracion-garantia-index">

            <table class="bootstrap-table"></table>
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


<script type="text/javascript">
    $(document).ready(function(){
        var actions = function(value, row) { return [
                '<button type="button" class="btn   fa fa-map-marker" onclick="funct_loadMaps('+ row.lat +','+ row.lng +')" style="margin: 15px; "></button>' ,
                ( row.status == '<?= CatalogoGrupoRiesgo::STATUS_ACTIVE ?>' ? '<a href="<?= $bttUrlUpdate ?>' + row.id + '"  title="Editar" class="fa fa-edit" ></a>': ''),
                ( row.status == '<?= CatalogoGrupoRiesgo::STATUS_ACTIVE ?>' ? '<a href="<?= $bttUrlDelete ?>' + row.id + '"  title="Baja" class="fa fa-level-down" data-confirm="Confirma que deseas realizar la baja del grupo riesgo" data-method="post"></a>': '')
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
                    field: 'cliente',
                    title: 'CLIENTE',
                    sortable: true,
                    formatter: btf.color.bold,
                },
                {
                    field: 'tipo',
                    title: 'TIPO',
                    sortable: true,
                    align: 'center',
                    formatter: btf.garantia.tipo,
                },
                {
                    field: 'unidad',
                    title: 'UNIDAD',
                    sortable: true,
                    align: 'center',
                    formatter: btf.garantia.unidad,
                },
                {
                    field: 'numero_unidad',
                    title: 'NUMERO DE UNIDADES',
                    sortable: true,
                    align: 'center',
                },
                {
                    field: 'unidad_valor_total',
                    title: 'TOTAL (NO DE UNIDAD * VALOR POR UNIDAD)',
                    sortable: true,
                    align: 'right',
                    formatter: btf.conta.money,
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
                id      : 'garantia',
                element : '.configuracion-garantia-index',
                url     : '<?= $bttUrl ?>',
                bootstrapTable : {
                    columns : columns,
                    exportOptions : {"fileName":"<?= $bttExport ?>"},
                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();

    });


var funct_loadMaps = function(lat,lng){
    $('#modal-maps').modal('show');
    $(".div_spiner_maps").show();
    $("#map_solicitud_view").css({"height" : "auto" });
    setTimeout( 2000);
    if (lat && lng) {
        $("#map_solicitud_view").css({"height" : "300px" });
        $(".mapboxgl-canvas").css({"height" : "300px", "width" : "748px"});
        $(".div_spiner_maps").hide();

        popup = new tt.Popup({
            offset: 35
        });

        map = tt.map({
            key: 'DhvUV3dfzRR1KyTOixQ8H7fPtZolRBCr',
            container: 'map_solicitud_view',
            //dragPan: !isMobileOrTablet(),
            center: [ parseFloat(lng), parseFloat(lat)],
            zoom: 14
        });
        map.addControl(new tt.FullscreenControl());


        marker = new tt.Marker({
            draggable: true
        }).setLngLat([ parseFloat(lng), parseFloat(lat)]).addTo(map);

        setTimeout(() => {
          map.resize()
        }, 2000);

    }
}

</script>
