<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use yii\base\Component;
use yii\helpers\Html;
use yii\widgets\Menu;
use app\models\user\User;
use app\models\esys\EsysSetting;
use app\models\Esys;


class NiftyComponent extends Component
{
	private $menuItems;

	public function __construct($config = [])
	{
		// ... initialization before configuration is applied

		parent::__construct($config);
	}


	public function init()
	{
		parent::init();

		if (!isset(Yii::$app->user->identity)) {
			$this->menuItems[] = ['label' =>  Yii::$app->name, 'options' => ['class' => 'list-header']];
			$this->menuItems[] = ['label' => '<i class="fa fa-lock"></i><span class="menu-title">Iniciar sesión</span>', 'url' => ['/admin/user/login']];
			$this->menuItems[] = ['label' => '<i class="fa fa-lock"></i><span class="menu-title">¿Olvidaste tu contraseña?</span>', 'url' => ['/admin/user/request-password-reset']];
		} else {

			$home 	= [];
			$home[] = ['label' => '<i class="fa fa-home"></i><span class="nav-label">Inicio</span>',  'url' => ['/']];

			$solicitudConfig = [];
			if (/*Yii::$app->user->can('originacionView')*/ 1)
				$solicitudConfig[] = [
					'label' => '<i class="fa fa-file-text"></i><span class="menu-title">SOLICITUDES</span>',
					'url' => ['/crm/originacion/index']
				];

			#$cuestionarioConfig = [];
			#if (Yii::$app->user->can('userView'))
			#	$cuestionarioConfig[] = [
			#		'label' => '<i class="fa fa-object-group"></i><span class="menu-title">GRUPOS DE CUESTIONARIO</span>',
			#		'url' => ['/cuestionarios/grupo/index']
			#	];
#
			#if (Yii::$app->user->can('userView'))
			#	$cuestionarioConfig[] = [
			#		'label' => '<i class="fa fa-list-alt"></i><span class="menu-title">CUESTIONARIO</span>',
			#		'url' => ['/cuestionarios/preguntas/index']
			#	];
			##if (Yii::$app->user->can('userView'))
			##	$cuestionarioConfig[] = [
			#		'label' => '<i class="fa fa-list-alt"></i><span class="menu-title">CATALOGOS SCIAN</span>',
			#		'url' => ['/cuestionarios/scian']
			#	];
			#




			/*****************************
			 * Administración
			 *****************************/
			$sistema = [];
			$subSistema = [];

			if (Yii::$app->user->can('userView'))
				$subSistema[] = ['label' => 'Usuarios', 'url' => ['/admin/user/index']];


			$adminConfig = [];

			if (Yii::$app->user->can('perfilUserView'))
				$adminConfig[] = ['label' => 'Perfiles de usuarios', 'url' => ['/admin/perfil/index']];

			if (Yii::$app->user->can('listaDesplegableView'))
				$adminConfig[] = ['label' => 'Listas desplegables', 'url' => ['/admin/listas-desplegables/index']];

			if (Yii::$app->user->can('configuracionSitio'))
				$adminConfig[] = ['label' => 'Configuracion del sitio', 'url' => ['/admin/configuracion/configuracion-update']];


			if (!empty($adminConfig))
				$subSistema[] = ['label' => '<span class="nav-label">Configuraciones</span> <span class="fa arrow"></span>', 'url' => '#', 'items' => $adminConfig, 'submenuTemplate' => "\n<ul class='nav nav-second-level'>\n{items}\n</ul>\n"];


			$adminSistema = [];

			if (Yii::$app->user->can('historialAccesosUser'))
				$adminSistema[] = ['label' => 'Historial de accesos', 'url' => ['/admin/historial-de-acceso/index']];

			if (!empty($adminSistema))
				$subSistema[] = ['label' => '<span class="nav-label">Historial</span> <span class="fa arrow"></span>', 'url' => '#', 'items' => $adminSistema, 'submenuTemplate' => "\n<ul class='nav nav-second-level'>\n{items}\n</ul>\n"];


			if (Yii::$app->user->can('userView') || Yii::$app->user->can('perfilUserView') || Yii::$app->user->can('listaDesplegableView') || Yii::$app->user->can('listaDesplegableView') || Yii::$app->user->can('configuracionSitio'))
				$sistema[] = ['label' => '<i class="fa fa-database"></i><span class="nav-label">SISTEMA</span> <span class="fa arrow"></span>', 'url' => '#', 'items' => $subSistema, 'submenuTemplate' => "\n<ul class='nav nav-second-level'>\n{items}\n</ul>\n"];


			/*****************************
			 * Menú Items
			 *****************************/
			if (!empty($home)) {
				foreach ($home as $key => $item) {
					$this->menuItems[] = $item;
				}
			}
			if (!empty($solicitudConfig)) {
				foreach ($solicitudConfig as $key => $item) {
					$this->menuItems[] = $item;
				}
			}
			if (!empty($cuestionarioConfig)) {
				foreach ($cuestionarioConfig as $key => $item) {
					$this->menuItems[] = $item;
				}
			}


			if (!empty($sistema)) {
				foreach ($sistema as $key => $item) {
					$this->menuItems[] = $item;
				}
			}
		}
	}


	/*********************************
	/ Navigation Bar - Elements Template
	/********************************/
	public function get_notification_dropdown()
	{
		if (!isset(Yii::$app->user->identity))
			return false;
		ob_start();
?>
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
		</div>
		<ul class="nav navbar-top-links navbar-right">
			<li>
				<span class="m-r-sm text-muted welcome-message">Bienvenido a <?= Yii::$app->name ?>.</span>
			</li>


			</li>
			<li>
				<?= Html::a('<i class="fa fa-sign-out"></i> Cerrar sesión', ['/admin/user/logout'], ['data-method' => 'post']) ?>
			</li>
		</ul>
	<?php
		return ob_get_clean();
	}

	public function get_mega_dropdown()
	{
		if (!isset(Yii::$app->user->identity))
			return false;

		ob_start();
	?>
		<li class="mega-dropdown">
			<a href="#" class="mega-dropdown-toggle">
				<i class="fa fa-th-large fa-lg"></i>
			</a>
			<div class="dropdown-menu mega-dropdown-menu">
				<div class="clearfix">

				</div>
			</div>
		</li>

	<?php

		return ob_get_clean();
	}

	public function get_language_selector()
	{
		ob_start();
	?>
		<!--Language selector-->
		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

		<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
		<!--End language selector-->
	<?php

		return ob_get_clean();
	}

	public function get_user_dropdown()
	{
		if (!isset(Yii::$app->user->identity))
			return false;

		ob_start();
	?>
		<li id="dropdown-user" class="dropdown">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
				<span class="pull-right">
					<i class="demo-pli-male ic-user"></i>
				</span>
				<div class="username hidden-xs"><?= Yii::$app->user->identity->email ?></div>
			</a>

			<div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">

				<!-- User dropdown menu -->
				<ul class="head-list">
					<li>
						<?= Html::a('<i class="demo-pli-male icon-lg icon-fw"></i> Mi perfil', ['/admin/user/mi-perfil']) ?>
					</li>
					<li>
						<?= Html::a('<i class="demo-psi-lock-2 icon-lg icon-fw"></i> Cambiar contraseña', ['/admin/user/change-password']) ?>
					</li>
					<li>
						<?= Html::a('<i class="fa fa-code icon-fw"></i> Acerca de . . .', ['/site/about']) ?>
					</li>
				</ul>

				<!-- Dropdown footer -->
				<div class="pad-all text-right">
					<?= Html::a('<i class="fa fa-sign-out fa-fw"></i> Cerrar sesión', ['/admin/user/logout'], [
						'class' => 'btn btn-primary',
						'data-method' => 'post'
					]) ?>
				</div>
			</div>
		</li>
	<?php

		return ob_get_clean();
	}


	/*********************************
	/ MAIN NAVIGATION - Elements Template
	/********************************/
	public function get_profile_widget()
	{
		if (!isset(Yii::$app->user->identity))
			return false;

		ob_start();
	?>

		<li class="nav-header">
			<div class="dropdown profile-element">
				<?= Html::img('@web/img/logo-white.png', ["alt" => "IFNB", "style" => "width:65px; height:35px"]) ?>
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<span class="block m-t-xs font-bold"><?= Yii::$app->user->identity->username ?></span>
					<span class="text-muted text-xs block"><?= Yii::$app->user->identity->email ?> <b class="caret"></b></span>
				</a>
				<ul class="dropdown-menu animated fadeInRight m-t-xs">
					<li>
						<?= Html::a('Mi perfil', ['/admin/user/mi-perfil'], ['class' => 'dropdown-item']) ?>
					</li>
					<li>
						<?= Html::a('Cambiar contraseña', ['/admin/user/change-password'], ['class' => 'dropdown-item']) ?>
					</li>
					<li>
						<?= Html::a('Cerrar sesión', ['/admin/user/logout'], ['class' => 'dropdown-item', 'data-method' => 'post']) ?>
					</li>
				</ul>
			</div>
			<div class="logo-element">
				CD
			</div>
		</li>
<?php

		return ob_get_clean();
	}



	public function get_menu()
	{
		return  Menu::widget([
			'options'         => ['class' => 'nav metismenu', 'id' => 'side-menu', 'style' => 'width: 100%;'],
			'encodeLabels'    => false,
			'activateParents' => true,
			'activeCssClass'  => 'active',
			'items'           => $this->menuItems == null ? ['label' => ''] : $this->menuItems,
		]);
	}
}
