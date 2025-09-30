<?php
namespace app\modules\v1\controllers;

use Yii;
use app\models\cliente\ClientePaquete;
use app\models\Esys;

class SystemController extends DefaultController
{
    public function actionFechaYHora()
    {
        return (new \DateTime())->format('Y-m-d\TH\:i\:s');
    }
}
