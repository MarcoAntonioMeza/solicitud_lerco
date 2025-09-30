<?php
namespace app\controllers;

use Yii;
use app\models\user\LoginForm;
use app\models\user\User;
use app\models\esys\EsysAcceso;

class SiteController extends AppController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        // user is logged in, he doesn't need to login
        if (!Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->render('index');
        }

        $model = new LoginForm(['scenario' => Yii::$app->params['lw']]);

        // monitor login status
        $successfulLogin = true;

        // posting data or login has failed

        if (!$model->load(Yii::$app->request->post()) || !$model->login()) {
            $successfulLogin = false;
        }

        // Guardamos registro de accesos
        if(Yii::$app->request->post()){
            $EsysAcceso = new EsysAcceso([
                'user'           => $model->username,
                'wrong_password' => $successfulLogin? null: $model->password,
                'ip'             => Yii::$app->getRequest()->getUserIP(),
                'access_login'   => time(),
                'access'         => 0,
            ]);
        }

        // if user's account is not activated, he will have to activate it first
        if ($model->status === User::STATUS_INACTIVE && $successfulLogin === false) {
            Yii::$app->session->setFlash('error', "Primero debes activar tu cuenta. Por favor revise tu correo electrónico.");

            $EsysAcceso->save();

            return $this->refresh();
        }

        // if user is not denied because he is not active, then his credentials are not good
        if ($successfulLogin === false) {
            if(isset($EsysAcceso))
                $EsysAcceso->save();

            return $this->renderPartial('index-main', ['model' => $model]);
        }

        $user = $model->getUser();

        $EsysAcceso->user_id = $user->id;
        $EsysAcceso->access  = 1;

        $EsysAcceso->save();

        // login was successful, let user go wherever he previously wanted
        return $this->render('index');
        /*
        if(!isset(Yii::$app->user->identity))
            return $this->renderPartial('index-main');
        else
            return $this->render('index');
            */
    }

    public function actionPermisos()
    {
        return $this->render('permisos');
    }

    public function actionAcercaDe()
    {
        return $this->render('acerca-de');
    }

   
}
