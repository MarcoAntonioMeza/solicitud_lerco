<?php
namespace app\commands;

use fedemotta\cronjob\models\CronJob;
use app\models\system\SystemProcedureCierre;
use yii\console\Controller;


class SystemClosureOperationController extends Controller {


    public function actionInit($from, $to, $days){
        $dates      = CronJob::getDateRange($from, $to);
        $command    = CronJob::run($this->id, $this->action->id, 0, CronJob::countDateRange($dates));
        if ($command === false){
            return Controller::EXIT_CODE_ERROR;
        }else{

            $count = 0;
            while ( $count < $days ) {
                SystemProcedureCierre::registroProcesoCierre();
                $count = $count + 1;
            }

            $command->finish();
            return Controller::EXIT_CODE_NORMAL;
        }
    }

    public function actionIndex($days = 1){
        return $this->actionInit(date("Y-m-d"), date("Y-m-d"), $days);
    }
}
?>