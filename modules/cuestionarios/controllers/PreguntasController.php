<?php

namespace app\modules\cuestionarios\controllers;

use Yii;
use app\models\cuestionarios\CuestionariosGrupo;
use app\models\cuestionarios\CuestionariosPreguntas;

use yii\web\NotFoundHttpException;


class PreguntasController extends \app\controllers\AppController
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
        return $this->render('index');
    }

    public function actionCargaInicial()
    {
        $grupos = CuestionariosGrupo::get_list_grupos();
        $preguntas_tipo = CuestionariosPreguntas::get_tipo_lista();

        $response = [
            'code' => 202,
            'grupos' => $grupos,
            'preguntas_tipo' => $preguntas_tipo,
            //'listas' => CuestionariosGrupo::findOne(2)->get_all_preguntas(),
        ];
        return $this->asJson($response);
    }

    public function actionSave()
    {
        $post = Yii::$app->request->post();
        //return $this->asJson($post);
        $preg_del = json_decode($post['preg_del'] ?? []);
        $opc_select_del = json_decode($post['opc_del'] ?? []);
        $grupo_id = $post['grupo_selected'] ?? null;
        $pregunta = $post['array_preguntas'] ?? [];

        $save = CuestionariosPreguntas::save_preguntas($grupo_id, $pregunta, $preg_del, $opc_select_del);


        return $this->asJson($save);
    }

    public function actionCargaList()
    {
        $post = Yii::$app->request->post();
        $grupo_id = $post['grupo_selected'] ?? null;
        $model = CuestionariosGrupo::findOne($grupo_id);
        $data[] = [
            'id' => 1,
            'main_id' => null,
            'pregunta' => '',
            'tipo' => 2,
            //'estado' => self::$status_list[$value->estado] ?? '--',
            'errorPregunta' => null,
            'errorOpciones' => null,
            'selectes' => [],
        ];
        $response = [
            'code' => 202,

            'listas' => $model ? $model->get_all_preguntas() : $data,
        ];
        return $this->asJson($response);
    }











    //------------------------------------------------------------------------------------------------//
    // BootstrapTable list
    //------------------------------------------------------------------------------------------------//
    /**
     * Return JSON bootstrap-table
     * @param  array $_GET
     * @return json
     */
    public function actionComprasJsonBtt()
    {
        // return ViewCompra::getJsonBtt(Yii::$app->request->get());
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
