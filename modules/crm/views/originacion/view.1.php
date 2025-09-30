<?php

use yii\helpers\Html;
use app\models\Esys;
use app\models\solicitud\Solicitud;
use app\models\Validacion;

$this->title = $model->persona->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>';
//print_r($modelO);die;
//
?>

<div class="solicitud-view">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3 class="panel-title">EMPRESA</h3>
                    <h4 class="panel-content"><?= $model->empresa_nombre ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3 class="panel-title">SUCURSAL</h3>
                    <h4 class="panel-content"><?= $model->sucursal_nom ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3 class="panel-title">PROMOTOR</h3>
                    <h4 class="panel-content"><?= $model->promotor ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3 class="panel-title">FECHA DE SOLICITUD</h3>
                    <h4 class="panel-content"><?= Esys::fecha_en_texto($model->created_at, 1) ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3 class="panel-title">ESTATUS</h3>
                    <h4 class="panel-content"><?= Solicitud::$statusList[$modelO->status] ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h3 class="panel-title">MONTO</h3>
                    <h4 class="panel-content">$<?= number_format($modelO->monto_credito, 2, '.', ',') ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    INFORMACIÓN PERSONAL
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> <?= $modelCli->nombreCompleto ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha de Nacimiento:</strong> <?= $modelCli->solicitante_fecha_nacimiento ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Sexo:</strong> <?= $modelCli->solicitante_sexo ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Estado civil:</strong> <?= $modelCli->estado_civil ?></p>
                        </div>


                        <div class="col-md-6">
                            <p><strong>CURP:</strong> <?= $modelCli->solicitante_curp ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>RFC:</strong> <?= $modelCli->solicitante_rfc ?></p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Teléfono:</strong> <?= $modelCli->solicitante_telefono ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    DIRECCIÓN Y CONTACTO
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Código Postal:</strong> <?= $modelCli->solicitante_domicilio_cp ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Estado:</strong> <?= $modelCli->solicitante_domicilio_estado ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Municipio:</strong> <?= $modelCli->solicitante_domicilio_municipio ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Colonia:</strong> <?= $modelCli->solicitante_domicilio_colonia ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Ciudad:</strong> <?= $modelCli->solicitante_domicilio_municipio ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Calle:</strong> <?= $modelCli->solicitante_domicilio_calle ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Número Exterior:</strong> <?= $modelCli->solicitante_domicilio_numEx ?></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Número Interior:</strong> <?= $modelCli->solicitante_domicilio_numInt != "null" ? $modelCli->solicitante_domicilio_numInt : ""  ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    CRÉDITO
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                            <p><strong>RUTA DE ANÁLISIS UTILIZADA:</strong> <?= $modelO->applyMezcla == 10 ? Validacion::$rutas[30] : ($modelO->ruta?Validacion::$rutas[$modelO->ruta]:'PENDIENTE') ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>RUTA DE ANÁLISIS ENVIADA A TECK:</strong> <?= $modelO->ruta ? Validacion::$rutas[$modelO->ruta] : 'N/A' ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>SCORE ENVIADO A TECK:</strong> <?= $modelO->score ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>RIESGO:</strong> <?= isset(Validacion::$riesgos[$modelO->risk]) ? Validacion::$riesgos[$modelO->risk] : 'N/A' ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>CORTE ASIGNADO:</strong> <?= $modelO->corte ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>NOTA DE RECHAZO:</strong> <?= $model->nota ? $model->nota : 'N/A' ?></p>
                        </div>

                        <div class="col-md-12">
                            <p><strong>SCORE CDC :</strong> <?= $modelO->applyMezcla == 10 ? $modelO->scoreCdc : 'N/A' ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>SCORE ALTERNO:</strong> <?= $modelO->applyMezcla == 10 ? $modelO->scoreAlterno : 'N/A' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    CUESTIONARIOS
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        foreach ($dataForm['groups'] as $group) {
                            $groupLabel = $group['label'];
                            echo "<div class='col-md-12'><h3 class='group-title'>$groupLabel</h3></div>";
                            foreach ($group['items'] as $item) {
                                $itemLabel = $item['label'];
                                $valueRegister = $item['value_register'];
                                echo "
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label><strong>$itemLabel:</strong></label>
                                    <p>$valueRegister</p>
                                </div>
                            </div>
                        ";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    CONYUGUES
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if ($modelCli->conyuges) : ?>
                            <?php foreach ($modelCli->conyuges as $index => $conyuge) : ?>
                                <div class="col-md-3">
                                    <p><strong>Nombre:</strong> <?= $conyuge->nombre ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Apellido Paterno:</strong> <?= $conyuge->apellido_paterno ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Apellido Materno:</strong> <?= $conyuge->apellido_materno ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Fecha de Nacimiento:</strong> <?= $conyuge->fecha_nacimiento ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Fecha de Casado:</strong> <?= $conyuge->fecha_casado ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Entidad de Nacimiento:</strong> <?= $conyuge->entidad_nacimiento ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Género:</strong> <?= $conyuge->genero ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Ocupación:</strong> <?= $conyuge->ocupacion ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Número:</strong> <?= $conyuge->numero ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Email:</strong> <?= $conyuge->email ?></p>
                                </div>
                                <?php if ($index < count($modelCli->conyuges) - 1) : ?>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    REFERENCIAS
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if ($modelCli->referencias) : ?>
                            <?php foreach ($modelCli->referencias as $index => $referencia) : ?>
                                <div class="col-md-3">
                                    <p><strong>Nombre:</strong> <?= $referencia->nombre ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Apellido Paterno:</strong> <?= $referencia->apellido_paterno ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Apellido Materno:</strong> <?= $referencia->apellido_materno ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Número:</strong> <?= $referencia->numero ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Parentesco:</strong> <?= $referencia->parentesco ?></p>
                                </div>

                                <div class="col-md-3">
                                    <p><strong>Entidad de Nacimiento:</strong> <?= $referencia->entidad_nacimiento ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Género:</strong> <?= $referencia->genero ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Ocupación:</strong> <?= $referencia->ocupacion ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Email:</strong> <?= $referencia->email ?></p>
                                </div>
                                <?php if ($index < count($modelCli->referencias) - 1) : ?>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                LISTA NOMINAL
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if ($modelCli->listaNominal) : ?>
                        <div class="col-md-12">
                            <p><strong>ESTATUS:</strong> <?= $modelCli->listaNominal->status ?></p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>MENSAJE:</strong> <?= $modelCli->listaNominal->mensaje ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                INE
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>INE Frontal:</strong>
                        <?php if (!empty($modelCli->ruta_img_ine_frontal)) : ?>
                            <img src="<?= Yii::getAlias('@web') . $modelCli->ruta_img_ine_frontal ?>" class="img-thumbnail" alt="INE Frontal">
                        <?php else : ?>
                            <p>No image available.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <strong>INE Reverso:</strong>
                        <?php if (!empty($modelCli->ruta_img_ine_reverso)) : ?>
                            <img src="<?= Yii::getAlias('@web') . $modelCli->ruta_img_ine_reverso ?>" class="img-thumbnail" alt="INE Reverso">
                        <?php else : ?>
                            <p>No image available.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                ROSTRO
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <strong></strong>
                        <?php if (!empty($modelCli->ruta_img_rostro)) : ?>
                            <img src="<?= Yii::getAlias('@web') . $modelCli->ruta_img_rostro ?>" class="img-thumbnail" alt="INE Frontal">
                        <?php else : ?>
                            <p>No image available.</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



<style>
    .panel {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .panel-heading {
        background-color: #f7f7f7;
        border-bottom: 1px solid #ddd;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .panel-body {
        padding: 20px;
        font-size: 16px;
        line-height: 1.6;
        color: #555;
    }

    .panel-title {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .panel-content {
        font-size: 18px;
        font-weight: normal;
        color: #555;
    }

    .text-center {
        text-align: center;
    }

    .img-thumbnail {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 4px;
        background-color: #f7f7f7;
    }

    .group-title {
        color: #31708f;
        border-bottom: 2px solid #31708f;
        padding-bottom: 5px;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
    }
</style>