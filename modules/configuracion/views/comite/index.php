<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\comite\Comite;
use app\assets\BootstrapTableAsset;

BootstrapTableAsset::register($this);
/* @var $this yii\web\View */

$this->title = 'COMITES';
$this->params['breadcrumbs'][] = $this->title;
$bttExport    = Yii::$app->name . ' - ' . $this->title . ' - ' . date('Y-m-d H.i');
?>

<p>
  <?= Html::a('<i class="fa fa-plus"></i> Nuevo comite', ['create'], ['class' => 'btn btn-success add btn-zoom']) ?>
</p>
<div class="row" style="    height: 100%;margin-bottom: 30%">
	<?php foreach ($comites as $key => $comite): ?>
		<div class="col-sm-3">
				<div style="height: 100%;max-height: 500px;">
	        <div class="widget-head-color-box navy-bg p-lg text-center" style="height: 70%;">
	            <div class="m-b-md">
		            <h5 class="font-bold no-margins">
		                <?= $comite->nombre ?>
		            </h5>
	            </div>

	            <?= Html::img(Url::to(["/img/profile-photos/comite.jpg"]),["class" => "rounded-circle img-responsive circle-border m-b-md", "alt" => "Profile Picture",  "style" => "width: 70%;height: 70%;" ]) ?>
	            <div>
	                <span><?= Comite::countSolicitud($comite->id) ?> Solicitudes</span> |
	                <span><?= Comite::countRechazo($comite->id) ?> Rechazos</span> |
	                <span><?= Comite::countAprobacion($comite->id) ?> Aprobaciones</span>
	            </div>
	        </div>
	        <div class="widget-text-box"  style="height: 30%;">
	            <h4 class="media-heading">VOTO RESOLUTIVO : </strong> <?=  $comite->user_voto_calidad_id ? $comite->votoCalidad->nombreCompleto : 'N/A'  ?></h4>

	            <div class="text-right" >

	                 <?= Html::a('<i class="fa fa-plus"></i> Editar', ['update', 'id' => $comite->id], [
					            'class' => 'btn btn-xs btn-primary',
					        ])  ?>
	                 <?=  Html::a('<i class="fa fa-trash"></i> Eliminar', ['delete', 'id' => $comite->id], [
					            'class' => 'btn btn-xs btn-white',
					            'data' => [
					                'confirm' => '¿Estás seguro de que deseas eliminar este comite?',
					                'method' => 'post',
					            ],
					        ]) ?>

	            </div>
	        </div>
				</div>
    </div>
	<?php endforeach ?>
</div>


