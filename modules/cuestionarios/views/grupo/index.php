<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\BootstrapTableAsset;

BootstrapTableAsset::register($this);

$this->title = 'Grupos de Cuestionarios';
$this->params['breadcrumbs'][] = $this->title;

$bttExport    = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
$bttUrl       = Url::to(['grupos-json-btt']);
$bttUrlView   = Url::to(['view?id=']);
$bttUrlUpdate = Url::to(['update?id=']);
$bttUrlDelete = Url::to(['cancel?id=']);

?>

<div class="ibox">
    <div class="ibox-content">
        <p>
            <?= $can['create']
                ? Html::a('<i class="fa fa-plus"></i> NUEVA GRUPO', ['create'], ['class' => 'btn btn-primary add btn-zoom'])
                : '' ?>
        </p>

        <div class="cajas-caja-index">
            <div class="btt-toolbar" style="border-style: solid; border-width: 1px; box-shadow: 2px 2px 5px #8d8d8d;">
                <div class="panel mar-btm-5px"></div>
            </div>
            <table class="bootstrap-table"></table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var can = JSON.parse('<?= json_encode($can) ?>'),
            actions = function(value, row) {
                return [
                    '<a href="<?= $bttUrlView ?>' + row.id + '" title="Ver" class="fa fa-eye"></a>',
                    (can.update ? '<a href="<?= $bttUrlUpdate ?>' + row.id + '" title="Editar" class="fa fa-pencil"></a>' : '')
                ].join('');
            },
            columns = [
                {
                    field: 'mover',
                    title: '',
                    align: 'center',
                    width: '60',
                    switchable: false,
                    formatter: function() {
                        return '<span class="mover-flecha arriba" style="cursor:pointer;" title="Subir">&#x25B2;</span>' +
                               '<span class="mover-flecha abajo" style="cursor:pointer; margin-left:8px;" title="Bajar">&#x25BC;</span>';
                    },
                    tableexportDisplay: 'none',
                },
                {
                    field: 'orden',
                    title: 'ORDEN',
                    align: 'center',
                    width: '60',
                    sortable: true,
                    switchable: false,
                },
                {
                    field: 'id',
                    title: 'ID',
                    align: 'center',
                    width: '60',
                    sortable: true,
                    switchable: false,
                },
                {
                    field: 'nombre',
                    title: 'NOMBRE',
                    align: 'left',
                    sortable: true,
                    switchable: true,
                },
                {
                    field: 'status',
                    title: 'Estatus',
                    align: 'center',
                    width: '100',
                    formatter: function(value) {
                        return value == 1
                            ? '<span class="badge bg-success">Activo</span>'
                            : '<span class="badge bg-danger">Inactivo</span>';
                    },
                    switchable: true,
                    sortable: true,
                },
                {
                    field: 'created_at',
                    title: 'Creado',
                    align: 'center',
                    sortable: true,
                    switchable: true,
                    visible: false,
                    formatter: btf.time.date,
                },
                {
                    field: 'created_by',
                    title: 'Creado por',
                    align: 'center',
                    sortable: true,
                    visible: false,
                    formatter: btf.user.created_by,
                    switchable: true,
                },
                {
                    field: 'updated_at',
                    title: 'Modificado',
                    align: 'center',
                    sortable: true,
                    visible: false,
                    formatter: btf.time.date,
                    switchable: true,
                },
                {
                    field: 'updated_by',
                    title: 'Modificado por',
                    align: 'center',
                    sortable: true,
                    visible: false,
                    formatter: btf.user.updated_by,
                    switchable: true,
                }
            ],
            params = {
                id: 'cajas',
                element: '.cajas-caja-index',
                url: '<?= $bttUrl ?>',
                bootstrapTable: {
                    columns: columns,
                    exportOptions: {
                        fileName: '<?= $bttExport ?>'
                    },
                    onDblClickRow: function(row) {
                        window.location.href = '<?= $bttUrlView ?>' + row.id;
                    }
                }
            };

        bttBuilder = new MyBttBuilder(params);
        bttBuilder.refresh();

        function setRowDataId() {
            let datos = $('.bootstrap-table').bootstrapTable('getData');
            $(".bootstrap-table tbody tr").each(function(index) {
                let row = datos[index];
                if (row && row.id) {
                    $(this).attr('data-id', row.id);
                    // console.log("Asignado data-id:", row.id); // Debug opcional
                }
            });
        }

        function actualizarOrden() {
            let orden = [];
            $(".bootstrap-table tbody tr").each(function(index) {
                let id = $(this).attr('data-id');
                $(this).find('td[data-field="orden"]').text(index + 1);
                if (id) orden.push({ id: id, orden: index + 1 });
            });

            if (orden.length === 0) return;

            $.ajax({
                url: '<?= Url::to(["grupo-orden"]) ?>',
                method: 'POST',
                data: { orden: orden },
                success: function(resp) {
                    // Aquí puedes agregar un toast de éxito si deseas
                    // console.log("Orden actualizado con éxito");
                }
            });
        }

        function postRefresh() {
            setRowDataId();
            actualizarOrden();
        }

        $(document).on('post-body.bs.table', '.bootstrap-table', function() {
            postRefresh();
        });

        setTimeout(postRefresh, 1300);

        $(document).on('click', '.mover-flecha', function() {
            var $row = $(this).closest('tr');
            if ($(this).hasClass('arriba')) {
                var $prev = $row.prev('tr');
                if ($prev.length) {
                    $row.insertBefore($prev);
                }
            } else if ($(this).hasClass('abajo')) {
                var $next = $row.next('tr');
                if ($next.length) {
                    $row.insertAfter($next);
                }
            }
            actualizarOrden();
        });

        setTimeout(function() {
            $(".bootstrap-table tbody").sortable({
                helper: fixWidthHelper,
                update: function(event, ui) {
                    actualizarOrden();
                }
            }).disableSelection();

            function fixWidthHelper(e, ui) {
                ui.children().each(function() {
                    $(this).width($(this).width());
                });
                return ui;
            }
        }, 1000);
    });
</script>
