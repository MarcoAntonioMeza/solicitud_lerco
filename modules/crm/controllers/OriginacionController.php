<?php

namespace app\modules\crm\controllers;

use Yii;
use yii\web\Response;
use app\models\Esys;

use app\models\persona\Persona;
use app\models\persona\ViewSolicitante;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `clientes` module
 */
class OriginacionController extends \app\controllers\AppController
{

    private $can;

    public function init()
    {
        parent::init();

        $this->can = [
            'create' => true,#Yii::$app->user->can('originacionCreate'),
            'update' => true,#Yii::$app->user->can('originacionUpdate'),
            'delete' => true,#Yii::$app->user->can('originacionDelete'),
            'view' =>   true,#Yii::$app->user->can('originacionView'),
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'can' => $this->can,
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);
        $viewModel = $this->findModel($id, 'view');

        

 

        return $this->render('view', [
            'model' => $model,
            'can' => $this->can,
            'viewModel' => $viewModel
        ]);
    }

    
    
    
    //------------------------------------------------------------------------------------------------//
    // BootstrapTable list
    //------------------------------------------------------------------------------------------------//
    /**
     * Return JSON bootstrap-table
     * @param  array $_GET
     * @return json
     */
    public function actionSolicitudJsonBtt()
    {
        return ViewSolicitante::getJsonBtt(Yii::$app->request->get());
    }


    //------------------------------------------------------------------------------------------------//
    // HELPERS
    //------------------------------------------------------------------------------------------------//
    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return Model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name, $_model = 'model')
    {
        switch ($_model) {
            case 'model':
                $model = Persona::findOne($name);
                break;

            case 'view':
                $model = ViewSolicitante::findOne($name);
                break;
        }

        if ($model !== null)
            return $model;

        else
            throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
