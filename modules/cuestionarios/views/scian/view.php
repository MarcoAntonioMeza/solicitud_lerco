<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductoFinanciero */

$this->title = $model->clave;
$this->params['breadcrumbs'][] = ['label' => 'ACTIVIDAD SCIAN', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div id='app'>
    <div class="row">

        <div class="col-md-12 ">
            <?= $can['update'] ? Html::a('EDITAR', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : "" ?>
        </div>

    </div>




    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">

                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0"> DETALLE ACTIVIDAD</h5>
                </div>
                <div class="card-body p-4">

                    <div class="row text-center">
                        

                        <div class="col-6 col-md-6 mb-4">
                            <div class="bg-light rounded p-3 shadow-sm">
                                <h3 class="text-primary"><?= $model->getAttributeLabel('clave') ?></h3>
                                <p class="display-6 text-dark mb-0">
                                   <h4><?= $model->clave ?></h4>
                                </p>
                            </div>
                        </div>

                        
                        <div class="col-6 col-md-6 mb-4">
                            <div class="bg-light rounded p-3 shadow-sm">
                                <h3 class="text-primary"><?= $model->getAttributeLabel('titulo') ?></h3>
                                <p class="display-6 text-dark mb-0 text-center">
                                    <h4><?= $model->titulo ?></h4>
                                </p>
                            </div>
                        </div>


                        <div class="col-12 col-md-12 mb-4">
                            <div class="bg-light rounded p-3 shadow-sm">
                                <h3 class="text-primary"><?= $model->getAttributeLabel('descripcion') ?></h3>
                                <p class="display-6 text-dark mb-0 text-justify">
                                    <h4><?= $model->descripcion ?></h4>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>








</div>