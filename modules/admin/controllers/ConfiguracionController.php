<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Response;
use app\models\esys\EsysSetting;


/**
 * Default controller for the `admin` module
 */
class ConfiguracionController extends \app\controllers\AppController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionConfiguracionUpdate()
    {
    	$model = new EsysSetting();
    	if (Yii::$app->request->post()) {

    		$model->saveConfiguracion(Yii::$app->request->post());
    		return $this->redirect('configuracion-update');
    	}

        return $this->render('configuracion-update',[ 'model' => $model ]);
    }

    public function actionUpdateFechaSistema()
    {
        $model = new EsysSetting();
        if (Yii::$app->request->post()) {
            $fechaSistema = isset(Yii::$app->request->post()["EsysSettiing"]["fecha_sistema"]) ? Yii::$app->request->post()["EsysSettiing"]["fecha_sistema"] : null;

            if ($fechaSistema) {

                $response = EsysSetting::updateFechaSistema($fechaSistema);
                if ($response)
                    Yii::$app->session->setFlash('success', 'Verifica tu información, intenta nuevamente.');
                else
                    Yii::$app->session->setFlash('danger', 'Ocurrion un error, intenta nuevamente.');

                return $this->redirect('configuracion-update');

            }else{
                Yii::$app->session->setFlash('danger', 'Verifica tu información, intenta nuevamente.');
            }
        }

        return $this->redirect('configuracion-update');
    }
}
