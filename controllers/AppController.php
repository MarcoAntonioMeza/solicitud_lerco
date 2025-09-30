<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * AppController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC ) for your controllers and their actions.
 */
class AppController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    /*************************
                     * Site
                     *************************/
                    [
                        'controllers' => ['site'],
                        'actions' => ['index', 'acerca-de', 'permisos', 'error', 'post-catalogo-tasas', 'post-cierre-tasas'],
                        'allow' => true,
                    ],

                    /*************************
                     * Admin
                     *************************/
                    [
                        'controllers' => ['admin/migracion'],
                        'actions' => ['cliente-index', 'importar-cvs-cliente', 'importar-data-cvs-cliente', 'operacion-carga-json-btt', 'linea-index', 'pago-index', 'importar-cvs-linea'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // Dashboard
                    [
                        'controllers' => ['admin/dashboard'],
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['dashboardAdmin'],
                    ],

                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['login-user'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],


                    // Usuarios
                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['login', 'signup', 'activate-account', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['logout', 'change-password', "mi-perfil", "detail-view", 'apply-aprobacion'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['index', 'users-json-btt', 'view', 'historial-cambios', 'user-ajax', 'enable-acceso-app', 'desabled-acceso-app'],
                        'allow' => true,
                        'roles' => ['userView'],
                    ],
                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['userCreate'],
                    ],
                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['userUpdate'],
                    ],
                    [
                        'controllers' => ['admin/user'],
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['userDelete'],
                    ],
                    // Perfiles
                    [
                        'controllers' => ['admin/perfil'],
                        'actions' => ['index', 'perfiles-json-btt', 'view'],
                        'allow' => true,
                        'roles' => ['perfilUserView'],
                    ],
                    [
                        'controllers' => ['admin/perfil'],
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['perfilUserCreate'],
                    ],
                    [
                        'controllers' => ['admin/perfil'],
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['perfilUserUpdate'],
                    ],
                    [
                        'controllers' => ['admin/perfil'],
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['perfilUserDelete'],
                    ],
                    // Listas desplegables
                    [
                        'controllers' => ['admin/listas-desplegables'],
                        'actions'     => ['index', 'listas', 'items', 'tabla'],
                        'allow'       => true,
                        'roles'       => ['listaDesplegableView'],
                    ],
                    [
                        'controllers' => ['admin/listas-desplegables'],
                        'actions'     => ['create-ajax'],
                        'allow'       => true,
                        'roles'       => ['listaDesplegableCreate'],
                    ],
                    [
                        'controllers' => ['admin/listas-desplegables'],
                        'actions'     => ['update-ajax', 'sort-ajax'],
                        'allow'       => true,
                        'roles'       => ['listaDesplegableUpdate'],
                    ],
                    [
                        'controllers' => ['admin/listas-desplegables'],
                        'actions'     => ['delete-ajax', 'baja-ajax'],
                        'allow'       => true,
                        'roles'       => ['listaDesplegableDelete'],
                    ],
                    // Configuraciones
                    [
                        'controllers' => ['admin/setting'],
                        'actions' => ['parametros', 'parametos-json-btt'],
                        'allow' => true,
                        'roles' => ['parametrosView'],
                    ],
                    [
                        'controllers' => ['admin/setting'],
                        'actions' => ['parametros-update'],
                        'allow' => true,
                        'roles' => ['parametrosUpdate'],
                    ],
                    // Configuraciones del sitio
                    [
                        'controllers' => ['admin/configuracion'],
                        'actions' => ['configuracion-update', 'update-fecha-sistema'],
                        'allow' => true,
                        'roles' => ['configuracionSitio'],
                    ],

                    // Historial de acceso
                    [
                        'controllers' => ['admin/historial-de-acceso'],
                        'actions' => ['index', 'historial-de-accesos-json-btt'],
                        'allow' => true,
                        'roles' => ['historialAccesosUser'],
                    ],


                    /*******************************
                     *       CUESTIONARIO GRUPOS
                     *******************************/
                    [
                        'controllers' => ['cuestionarios/grupo'],
                        'actions' => ['index', 'save-etapa', 'view', 'grupos-json-btt','grupo-orden'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['cuestionarios/grupo'],
                        'actions' => ['create',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['cuestionarios/grupo'],
                        'actions' => ['update',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['cuestionarios/grupo'],
                        'actions' => ['delete', 'baja', 'get-etapa'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    /*******************************
                     *       CUESTIONARIO preguntas
                     *******************************/
                    [
                        'controllers' => ['cuestionarios/preguntas'],
                        'actions' => ['index', 'carga-inicial', 'carga-preguntas', 'carga-list',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['cuestionarios/preguntas'],
                        'actions' => ['create', 'save',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['cuestionarios/preguntas'],
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'controllers' => ['cuestionarios/preguntas'],
                        'actions' => ['delete', 'baja', 'get-etapa'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    /**
                     * ===========================================
                     *              SCIAN
                     * ===========================================
                     */
                    [
                        'controllers' => ['cuestionarios/scian'],
                        'actions' => ['index', 'actividad-json-btt', 'view'],
                        'allow' => true,
                        'roles' => ['scianView'],//Yii::$app->user->can('solicitudCreate')
                    ],
                    [
                        'controllers' => ['cuestionarios/scian'],
                        'actions' => ['create',],
                        'allow' => true,
                        'roles' => ['scianCreate'],
                    ],
                    [
                        'controllers' => ['cuestionarios/scian'],
                        'actions' => ['update',],
                        'allow' => true,
                        'roles' => ['scianUpdate'],
                    ],

                    /**
                     * ===========================================
                     *                  CRM ORIGINACION
                     * ===========================================
                     */
                    [
                        'controllers' => ['crm/originacion'],
                        'actions' => ['index', 'solicitud-json-btt', 'view'],
                        'allow' => true,
                        'roles' => ['@'],//Yii::$app->user->can('solicitudCreate')
                    ],
                    

                ], // rules
            ], // access
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout'      => ['post'],
                    'create-ajax' => ['post'],
                    'update-ajax' => ['post'],
                    'sort-ajax'   => ['put'],
                    'cancel-ajax' => ['post'],
                    'delete-ajax' => ['delete'],
                ],
            ], // verbs
        ]; // return
    } // behaviors

} // AppController
