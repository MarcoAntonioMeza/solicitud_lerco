<?php

namespace app\modules\cuestionarios\controllers;

use Yii;
use app\models\cuestionarios\CuestionariosGrupo;
use yii\web\NotFoundHttpException;


class GrupoController extends \app\controllers\AppController
{
    private $can;


    public function init()
    {
        parent::init();
        //$this->layout = 'main';
        $this->can = [
            'create' => Yii::$app->user->can('admin'),
            'update' => Yii::$app->user->can('admin'),
            'cancel' => Yii::$app->user->can('admin'),
        ];
    }

    public function actionIndex()
    {
        //$etapa_name = ConfigEtapasCredito::consulta_etapa(6,1);
        //echo '<pre>';
        //print_r($etapa_name);
        //die();
        return $this->render('index', [
            'can' => $this->can,
        ]);
    }

    public function actionCreate()
    {
        $model = new CuestionariosGrupo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $errors = array_map(function ($e) {
                return implode(', ', $e);
            }, $model->getErrors());

            Yii::$app->session->setFlash(
                'error',
                'Error al guardar el registro.<br>' .
                    implode('<br>', array_map(
                        function ($attr, $errors) use ($model) {
                            return "<strong>{$model->getAttributeLabel($attr)}:</strong> $errors";
                        },
                        array_keys($errors),
                        $errors
                    ))
            );
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'can' => $this->can,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if ($post) {
                $errors = array_map(function ($e) {
                    return implode(', ', $e);
                }, $model->getErrors());

                Yii::$app->session->setFlash(
                    'error',
                    'Error al guardar el registro.<br>' .
                        implode('<br>', array_map(
                            function ($attr, $errors) use ($model) {
                                return "<strong>{$model->getAttributeLabel($attr)}:</strong> $errors";
                            },
                            array_keys($errors),
                            $errors
                        ))
                );
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionGrupoOrden(){
        $post = Yii::$app->request->post();
        $orden = $post['orden'] ?? [];
        foreach ($orden as $key => $value) {
            $model = CuestionariosGrupo::findOne($value['id']);
            $model->orden = $value['orden'];
            $model->save();
        }
        return $this->asJson($post);
    }









    //------------------------------------------------------------------------------------------------//
    // BootstrapTable list
    //------------------------------------------------------------------------------------------------//
    /**
     * Return JSON bootstrap-table
     * @param  array $_GET
     * @return json
     */
    public function actionGruposJsonBtt()
    {
         return CuestionariosGrupo::getJsonBtt(Yii::$app->request->get());
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
                $model = CuestionariosGrupo::findOne($name);
                break;

            case 'view':
                //$model = ViewCompra::findOne($name);
                break;
        }


        if ($model !== null)
            return $model;

        else
            throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
