<?php
namespace app\modules\configuracion\controllers;

use Yii;
use yii\web\Response;
use app\models\Esys;
use app\models\cliente\Cliente;
use app\models\catalogo\ViewCatalogoPlanComision;
use app\models\catalogo\CatalogoPlanComision;
use app\models\cliente\ViewCliente;

/**
 * Default controller for the `clientes` module
 */
class ComisionController extends \app\controllers\AppController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new CatalogoPlanComision();

        if ($model->load(Yii::$app->request->post())) {


            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }


    public function actionPostPlanComision()
    {
        $request = Yii::$app->request;

        // Cadena de busqueda
        if ($request->validateCsrfToken() && $request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->post('comisionObject')) {


                $response = CatalogoPlanComision::savePlanComision($request->post('comisionObject'));

                if ($response["code"] == 202 ) {

                    return [
                        "code"      => 202,
                        "folio_id"   => $response["folio_id"],
                    ];
                }
            }

            return [
                "code"      => 10,
                "message"   => "Ocurrio un error, intenta nuevamente",
            ];
        }

        throw new BadRequestHttpException('Solo se soporta peticiones AJAX');

    }

    public function actionGetPlanComision()
    {
        $request = Yii::$app->request;

        // Cadena de busqueda
        if ($request->validateCsrfToken() && $request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->get('plan_comision_id')) {
                return [
                    "code"                  => 202,
                    "planComisionObject"    => CatalogoPlanComision::getPlanComision($request->get('plan_comision_id')),
                ];
            }

            return [
                "code"      => 10,
                "message"   => "Ocurrio un error, intenta nuevamente",
            ];
        }

        throw new BadRequestHttpException('Solo se soporta peticiones AJAX');

    }



    public function actionBaja($id)
    {
        $model = $this->findModel($id);
        $model->status = CatalogoPlanComision::STATUS_INACTIVE;

        if ($model->update())
            Yii::$app->session->setFlash('success', "Se realizo la baja correctamente ");
        else
            Yii::$app->session->setFlash('danger', 'Existen dependencias que impiden la baja.');

        return $this->redirect(['index']);
    }





    //------------------------------------------------------------------------------------------------//
	// BootstrapTable list
	//------------------------------------------------------------------------------------------------//
    /**
     * Return JSON bootstrap-table
     * @param  array $_GET
     * @return json
     */
    public function actionPlanComisionesJsonBtt(){
        return ViewCatalogoPlanComision::getJsonBtt(Yii::$app->request->get());
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
                $model = CatalogoPlanComision::findOne($name);
                break;

            case 'view':
                $model = ViewCatalogoPlanComision::findOne($name);
                break;
        }

        if ($model !== null)
            return $model;

        else
            throw new NotFoundHttpException('La página solicitada no existe.');
    }


}
