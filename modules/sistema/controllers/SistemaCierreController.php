<?php
namespace app\modules\sistema\controllers;

use Yii;
use app\models\system\ViewSystemProcedureCierre;

/**
 * SistemaCierreController implements the CRUD actions for EsysAcceso model.
 */
class SistemaCierreController extends \app\controllers\AppController
{
    /**
     * Lists all EsysAcceso models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


//------------------------------------------------------------------------------------------------//
// BootstrapTable list
//------------------------------------------------------------------------------------------------//
    /**
     * Return JSON bootstrap-table 
     * @param  array $_GET
     * @return json
     */
    public function actionProcesoCierresJsonBtt()
    {
        return ViewSystemProcedureCierre::getJsonBtt(Yii::$app->request->get());
    }

}
