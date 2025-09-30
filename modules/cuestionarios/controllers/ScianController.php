<?php

namespace app\modules\cuestionarios\controllers;

use Yii;
use app\models\ProductoFinanciero;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\scian\ActividadesScian;


/**
 * ProductoController implements the CRUD actions for ProductoFinanciero model.
 */
class ScianController extends  \app\controllers\AppController
{

    private $can;

    public function init()
    {
        parent::init();

        $this->can = [
            'create' => true,#Yii::$app->user->can('scianCreate'),
            'update' => true,#Yii::$app->user->can('scianUpdate'),
            'cancel' => true,#Yii::$app->user->can('scianDelete'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'can' => $this->can,
            ]
        );
    }


    /**
     * Displays a single ProductoFinanciero model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
            'can'   => $this->can,
        ]);
    }



    /**
     * Creates a new ProductoFinanciero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActividadesScian();
        //DEFINIR LOS MONTOS QUITANDO COMAS, PARA QUE SE GUARDEN EN EL FORMATO DOUBLE DEFINIDO EN EL MODELO
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            try {



                if ($model->save()) {

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::error($model->getErrors(), 'validation');
                }

                //$model->saveOrUpdateTasaComicion(json_decode($post['json_tasa'],1));
            } catch (\Exception $e) {
                Yii::error($e->getMessage(), 'validation');
                echo '<pre>';
                print_r($post);
                die;
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        #$model->monto_min = number_format($model->monto_min, 2);
        #$model->monto_max = number_format($model->monto_max, 2);


        $post = Yii::$app->request->post();


        if ($model->load($post)) {

            //echo '<pre>';
            //var_dump($post);
            //die;
            try {

                if ($model->save()) {


                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::error($model->getErrors(), 'validation');
                }
            } catch (\Exception $e) {

                echo '<pre>';
                print_r($e->getMessage());
                print_r($post);
                die;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductoFinanciero model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductoFinanciero model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductoFinanciero the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActividadesScian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionActividadJsonBtt()
    {
        return ActividadesScian::getJsonBtt(Yii::$app->request->get());
    }
}
