<?php
namespace app\modules\configuracion\controllers;

use Yii;
use yii\web\Response;
use app\models\cliente\Cliente;
use app\models\catalogo\ViewGrupoRiesgo;
use app\models\catalogo\CatalogoGrupoRiesgo;

/**
 * Default controller for the `clientes` module
 */
class GruposRiesgoController extends \app\controllers\AppController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new CatalogoGrupoRiesgo();

        return $this->render('index', [
            'model' => $model
        ]);
    }


    public function actionCreateGrupoRiesgo()
    {
        $GrupoRiesgoId = Yii::$app->request->post()["GrupoRiesgo"]["id"] ? Yii::$app->request->post()["GrupoRiesgo"]["id"] : null;

        if ($GrupoRiesgoId)
            $model =  CatalogoGrupoRiesgo::findOne($GrupoRiesgoId);
        else
            $model = new CatalogoGrupoRiesgo();

        if ($model->load(Yii::$app->request->post())) {

            $model->monto_maximo_financiamiento   = floatval(str_replace(",", "", $model->monto_maximo_financiamiento));
            $model->importe_principal_grupo       = floatval(str_replace(",", "", $model->importe_principal_grupo));
            $model->importe_disponible_principal  = floatval(str_replace(",", "", $model->importe_disponible_principal));

            if ($GrupoRiesgoId)
                $model->id = $GrupoRiesgoId;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Se realizo correctamente la operacion");
                return $this->redirect(['index']);
            }
        }

        Yii::$app->session->setFlash('danger', 'Ocurrion un error, intenta nuevamente');

        return $this->redirect(['index']);
    }

    public function actionBaja($id)
    {
        $model = $this->findModel($id);
        $model->status = CatalogoGrupoRiesgo::STATUS_INACTIVE;

        if ($model->update())
            Yii::$app->session->setFlash('success', "Se realizo la baja correctamente ");
        else
            Yii::$app->session->setFlash('danger', 'Existen dependencias que impiden la baja.');

        return $this->redirect(['index']);
    }

    public function actionBajaParticipante($id)
    {
        $model = Cliente::findOne($id);
        $model->grupo_riesgo_id = null;

        if ($model->update())
            Yii::$app->session->setFlash('success', "SE REALIZO CORRECTAMENTE LA BAJA ");
        else
            Yii::$app->session->setFlash('danger', 'Existen dependencias que impiden la baja.');

        return $this->redirect(['index']);
    }

    public function actionGetParticipanteAjax($q = false)
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
            $user = ViewGrupoRiesgo::getUserAjax($text);

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


    public function actionPostAddParticipante($q = false)
    {
        $request = Yii::$app->request;

        // Cadena de busqueda
        if ($request->validateCsrfToken() && $request->isAjax) {

            $clienteID      = $request->post('participante_id');
            $GrupoRiesgoId  = $request->post('grupo_riesgo_id');

            Yii::$app->response->format = Response::FORMAT_JSON;


            $response = CatalogoGrupoRiesgo::addParticipanteGrupo($clienteID, $GrupoRiesgoId);
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
    public function actionGruposRiesgoJsonBtt(){
        return ViewGrupoRiesgo::getJsonBtt(Yii::$app->request->get());
    }

    public function actionParticipantesJsonBtt(){
        return ViewGrupoRiesgo::getParticipanteJsonBtt(Yii::$app->request->get());
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
                $model = CatalogoGrupoRiesgo::findOne($name);
                break;

            case 'view':
                $model = ViewGrupoRiesgo::findOne($name);
                break;
        }

        if ($model !== null)
            return $model;

        else
            throw new NotFoundHttpException('La página solicitada no existe.');
    }


}
