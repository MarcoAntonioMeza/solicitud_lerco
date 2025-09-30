<?php
namespace app\modules\configuracion\controllers;

use Yii;
use yii\web\Controller;
use app\models\comite\Comite;
use app\models\user\ViewUser;
use yii\web\NotFoundHttpException;


class ComiteController extends \app\controllers\AppController
{

    public function actionIndex()
    {
        return $this->render('index',[
               "comites" => Comite::find()->All(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Comite();

        if ($model->load(Yii::$app->request->post())) {
            $post       = Yii::$app->request->post();
            $UserComite = isset($post["UserComite"]) ? $post["UserComite"] : null;



        	if ($model->save()) {
                if ($model->addUserComite($UserComite,$model->id)) {
    	            return $this->redirect(['index']);
                }
        	}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model =  $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $post       = Yii::$app->request->post();
            $UserComite = isset($post["UserComite"]) ? $post["UserComite"] : null;

            if ($model->save()) {
                if ($model->addUserComite($UserComite,$model->id)) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        try{
            // Eliminamos el usuario
            $this->findModel($id)->delete();

            Yii::$app->session->setFlash('success', "Se ha eliminado correctamente el comite #" . $id);

        }catch(\Exception $e){

            if($e->getCode() == 23000){
                Yii::$app->session->setFlash('danger', 'Existen dependencias que impiden la eliminación del comite.');

                header("HTTP/1.0 400 Relation Restriction");
            }else{
                throw $e;
            }
        }

        return $this->redirect(['index']);
    }

    public function actionUserAjax($q = false)
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
            $user = ViewUser::getUserAjax($text);

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
    public function actionSucursalesJsonBtt(){
        return ViewSucursal::getJsonBtt(Yii::$app->request->get());
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
                $model = Comite::findOne($name);
                break;
        }

        if ($model !== null)
            return $model;

        else
            throw new NotFoundHttpException('La página solicitada no existe.');
    }


}
