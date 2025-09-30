<?php

use yii\helpers\Html;
use app\utils\helpers\Cdc;
use app\models\cuestionario\CuestionariosGrupo;

$this->title = $viewModel->nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Solicitantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="panel panel-body">

    <!-- CARD: INFORMACIÓN DEL REGISTRO -->
    <div class="card-custom" style="border-left: 6px solid #007bff;">
        <div class="card-section">
            <h3 style="color: #007bff;">
                <i class="fas fa-info-circle"></i> Información del Registro
            </h3>
            <div class="info-grid">
                <div class="info-item"><i class="fas fa-hashtag"></i> <strong>ID:</strong> <?= Html::encode($viewModel->id) ?></div>
                <div class="info-item"><i class="fas fa-calendar-alt"></i> <strong>Fecha de Creación:</strong> <?= Html::encode($viewModel->fecha_creacion) ?></div>
            </div>
        </div>
    </div>

    <!-- CARD: DATOS PERSONALES -->
    <div class="card-custom">
        <div class="card-section">
            <h3><i class="fas fa-user"></i> Datos Personales</h3>

            <div class="perfil-box">
                <div class="perfil-img foto-principal">
                    <div class="sin-imagen">
                        <i class="fas fa-user" style="font-size: 2rem; color: white;"></i>
                    </div>
                </div>
                <div class="perfil-datos">
                    <strong><?= Html::encode($viewModel->nombre_completo) ?></strong>
                    <p class="perfil-rol">Solicitante</p>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item"><i class="fas fa-user"></i> <strong>Nombres:</strong> <?= Html::encode($viewModel->nombres) ?></div>
                <div class="info-item"><i class="fas fa-user"></i> <strong>Apellido Paterno:</strong> <?= Html::encode($viewModel->apellido_paterno ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-user"></i> <strong>Apellido Materno:</strong> <?= Html::encode($viewModel->apellido_materno ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-envelope"></i> <strong>Email:</strong> <?= Html::encode($viewModel->email ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-phone"></i> <strong>Teléfono:</strong> <?= Html::encode($viewModel->telefono ?? 'No especificado') ?></div>
            </div>
        </div>
    </div>

    <!-- CARD: DATOS LABORALES -->
    <div class="card-custom">
        <div class="card-section">
            <h3><i class="fas fa-briefcase"></i> Datos Laborales</h3>
            <div class="info-grid">
                <div class="info-item"><i class="fas fa-user-tie"></i> <strong>Cargo:</strong> <?= Html::encode($viewModel->cargo ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-building"></i> <strong>Empresa:</strong> <?= Html::encode($viewModel->empresa ?? 'No especificado') ?></div>
            </div>
        </div>
    </div>

    <!-- CARD: DIRECCIÓN -->
    <div class="card-custom">
        <div class="card-section">
            <h3><i class="fas fa-map-marker-alt"></i> Dirección del Solicitante</h3>
            <div class="info-grid">
                <div class="info-item"><i class="fas fa-road"></i> <strong>Dirección:</strong> <?= Html::encode($viewModel->direccion ?? 'No especificada') ?></div>
                <div class="info-item"><i class="fas fa-door-open"></i> <strong>No. Ext:</strong> <?= Html::encode($viewModel->num_ext ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-door-closed"></i> <strong>No. Int:</strong> <?= Html::encode($viewModel->num_int ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-building"></i> <strong>Colonia:</strong> <?= Html::encode($viewModel->colonia_cp ?? 'No especificada') ?></div>
                <div class="info-item"><i class="fas fa-map-pin"></i> <strong>Código Postal:</strong> <?= Html::encode($viewModel->codigo_postal ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-city"></i> <strong>Municipio:</strong> <?= Html::encode($viewModel->municipio ?? 'No especificado') ?></div>
                <div class="info-item"><i class="fas fa-globe"></i> <strong>Estado:</strong> <?= Html::encode($viewModel->estado ?? 'No especificado') ?></div>
            </div>
        </div>
    </div>




    
</div>

<!-- ESTILOS -->
<style>
    .card-custom {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .card-section h3 {
        margin-bottom: 20px;
        color: #333;
        font-size: 1.4em;
    }

    .perfil-box {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }

    .perfil-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #007bff, #00c6ff);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .perfil-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .perfil-img .sin-imagen {
        color: white;
        font-size: 0.9rem;
        text-align: center;
    }

    .perfil-datos strong {
        font-size: 1.2rem;
        color: #333;
    }

    .perfil-rol {
        font-size: 0.95rem;
        color: #666;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px 24px;
    }

    .info-item {
        font-size: 1rem;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-item i {
        color: #00c6ff;
        font-size: 1.1rem;
        min-width: 18px;
    }

    .ine-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 25px;
    }

    .ine-card {
        flex: 1 1 200px;
        background: #f9f9f9;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        border: 2px solid #ddd;
        transition: 0.3s;
    }

    .ine-card h5 {
        margin-bottom: 10px;
        font-size: 1em;
        color: #444;
    }

    .ine-card img {
        width: 100%;
        border-radius: 10px;
        object-fit: cover;
        max-height: 200px;
    }

    .rechazada {
        border: 2px solid #e74c3c !important;
        background: #fdecea !important;
    }

    .sin-imagen {
        font-style: italic;
        color: #aaa;
        padding: 40px 0;
    }
</style>