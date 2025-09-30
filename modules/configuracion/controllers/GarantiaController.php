<?php
namespace app\modules\configuracion\controllers;

use Yii;
use yii\web\Response;
use app\models\Esys;
use app\models\cliente\Cliente;
use app\models\catalogo\ViewCatalogoGarantia;
use app\models\catalogo\CatalogoGarantia;
use app\models\cliente\ViewCliente;

/**
 * Default controller for the `clientes` module
 */
class GarantiaController extends \app\controllers\AppController
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
        $model = new CatalogoGarantia();

        if ($model->load(Yii::$app->request->post())) {


            $model->unidad_valor_total              = floatval(str_replace(",", "", $model->unidad_valor_total));
            $model->unidad_valor                    = floatval(str_replace(",", "", $model->unidad_valor));
            $model->valor                           = floatval(str_replace(",", "", $model->valor));
            $model->monto_valuado                   = floatval(str_replace(",", "", $model->monto_valuado));
            $model->aseguradora_suma_asegurada      = floatval(str_replace(",", "", $model->aseguradora_suma_asegurada));


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

            $model->unidad_valor_total  = floatval(str_replace(",", "", $model->unidad_valor_total));
            $model->unidad_valor        = floatval(str_replace(",", "", $model->unidad_valor));
            $model->valor               = floatval(str_replace(",", "", $model->valor));
            $model->monto_valuado       = floatval(str_replace(",", "", $model->monto_valuado));
            $model->aseguradora_suma_asegurada       = floatval(str_replace(",", "", $model->aseguradora_suma_asegurada));

            if ($model->save()) {
                return $this->redirect(['index']);
            }

        }
        $model->fecha_inscripcion              = Esys::unixTimeToString($model->fecha_inscripcion,'d-m-Y');
        $model->fecha_avaluo                   = Esys::unixTimeToString($model->fecha_avaluo,'d-m-Y');
        $model->aseguradora_vigencia_fin       = Esys::unixTimeToString($model->aseguradora_vigencia_fin,'d-m-Y');
        $model->aseguradora_fecha_emision      = Esys::unixTimeToString($model->aseguradora_fecha_emision,'d-m-Y');
        $model->aseguradora_vigencia_ini       = Esys::unixTimeToString($model->aseguradora_vigencia_ini,'d-m-Y');

        return $this->render('update', [
            'model' => $model
        ]);
    }



    public function actionBaja($id)
    {
        $model = $this->findModel($id);
        $model->status = CatalogoGarantia::STATUS_INACTIVE;

        if ($model->update())
            Yii::$app->session->setFlash('success', "Se realizo la baja correctamente ");
        else
            Yii::$app->session->setFlash('danger', 'Existen dependencias que impiden la baja.');

        return $this->redirect(['index']);
    }

     public function actionGetCliente()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        // Cadena de busqueda
        if ($request->validateCsrfToken() && $request->isAjax) {

            $IDORBP     = $request->get("cliente_id_and_bp") ? $request->get("cliente_id_and_bp") : null;
            $tipo       = $request->get("tipo") ? $request->get("tipo") : null;
            $response   = Cliente::getClienteItem($IDORBP, $tipo);
            if ($response["code"] == 202) {
                return [
                    "code"          => 202,
                    "cliente"       => $response["cliente"],
                ];
            }
            return [
                "code"          => 10,
                "cliente"       => "VERIFICA TU INFORMACIÓN",
            ];
        }

        throw new BadRequestHttpException('Solo se soporta peticiones AJAX');
    }

    public function actionClienteAjax($q = false)
    {
        $request = Yii::$app->request;

        // Cadena de busqueda
        if ($request->validateCsrfToken() && $request->isAjax) {
            if ($q) {
                $text = $q;

            } else {
                $text = Yii::$app->request->get('data');
                $text = $text['q'];
            }

            // Obtenemos user
            $user = ViewCliente::getClienteAjax($text);

            // Devolvemos datos YII2 SELECT2
            if ($q) {
                return $user;
            }

            // Devolvemos datos CHOSEN.JS
            $response = ['q' => $text, 'results' => $user];

            return $response;
        }

        throw new BadRequestHttpException('Solo se soporta peticiones AJAX');
    }


    //------------------------------------------------------------------------------------------------//
	// BootstrapTable list
	//------------------------------------------------------------------------------------------------//
    /**
     * Return JSON bootstrap-table
     * @param  array $_GET
     * @return json
     */
    public function actionGarantiasJsonBtt(){
        return ViewCatalogoGarantia::getJsonBtt(Yii::$app->request->get());
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
                $model = CatalogoGarantia::findOne($name);
                break;

            case 'view':
                $model = ViewCatalogoGarantia::findOne($name);
                break;
        }

        if ($model !== null)
            return $model;

        else
            throw new NotFoundHttpException('La página solicitada no existe.');
    }


}
