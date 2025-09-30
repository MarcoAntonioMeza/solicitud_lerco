<?php

use yii\helpers\Url;
use yii\helpers\Html;

$baseUrl = Url::base(true) . '/' . 'cuestionarios/preguntas/';
/* @var $this yii\web\View */

$this->title = 'PREGUNTAS';
$this->params['breadcrumbs'][] = 'CONFIGURACIÓN';
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<div id="app">
    <?= Html::hiddenInput('baseUrl', $baseUrl, ['id' => 'baseUrl', 'title' => 'baseUrl']); ?>
    <div class="row">
        <div class="col-md-12">


            <div class="card">
                <div class="panel-heading text-center">
                    <h1 class="panel-title ">CONFIGURACIÓN DE PREGUNTAS</h1>
                </div>
                <div class="card-body">

                    <select class="form-control" v-model="grupo_selected " @change="cargarPreguntas()">
                        <option value=null disabled selected>Seleccione grupo</option>
                        <option v-for="grupo in GRUPOS_LIST" :value="grupo.id" :key="grupo.id">
                            {{ grupo.nombre }}
                        </option>
                    </select>
                    <div class="row mt-3 mb-3 text-center">
                       
                        <div class="col-md-6">
                            <button @click="agregarPregunta" class="btn btn-success mb-3">
                                <i class="fas fa-plus"></i> Agregar Pregunta
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button @click="guardarPreguntas" class="btn btn-primary btn-lg btn-zoom">
                                <i class="fas fa-save"></i> Guardar Todas las Preguntas
                            </button>
                        </div>
                    </div>




                    <div class="table-responsive ">
                        <div class="table-container">
                            <table class="excel-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Pregunta</th>
                                        <th>Tipo</th>
                                        <th>Requerido</th>
                                        <th>Opciones (si es Selector)</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(pregunta, index) in array_preguntas" :key="pregunta.id">
                                        <td>{{ pregunta.id }}</td>
                                        <td>
                                            <input v-model="pregunta.pregunta" class="form-control" placeholder="Texto de la pregunta">
                                            <small class="text-danger" v-if="pregunta.errorPregunta">{{ pregunta.errorPregunta }}</small>
                                        </td>
                                        <td>
                                            <select v-model="pregunta.tipo" class="form-control" @change="cambiarTipo(pregunta)">
                                                <option v-for="tipo in array_tipo" :value="tipo.type" :key="tipo.type">
                                                    {{ tipo.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    v-model="pregunta.is_required" 
                                                    :id="'required_' + pregunta.id"
                                                >
                                                <label class="form-check-label" :for="'required_' + pregunta.id">
                                                    <span v-if="pregunta.is_required" class="text-success">
                                                        <i class="fas fa-check-circle"></i> Sí
                                                    </span>
                                                    <span v-else class="text-muted">
                                                        <i class="far fa-circle"></i> No
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div v-if="pregunta.tipo === 3"> <!-- 3 = Selector -->
                                                <small class="text-danger" v-if="pregunta.errorOpciones">{{ pregunta.errorOpciones }}</small>
                                                <div v-for="(opcion, opcionIndex) in pregunta.selectes" :key="opcionIndex" class="mb-2 d-flex align-items-center">
                                                    <input v-model="opcion.texto" class="form-control mr-2" placeholder="Texto de opción">
                                                    <button @click="eliminarOpcion(pregunta, opcionIndex,opcion)" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <small class="text-danger ml-2" v-if="opcion.error">{{ opcion.error }}</small>
                                                </div>
                                                <button @click="agregarOpcion(pregunta)" type="button" class="btn btn-info btn-sm"  >
                                                    <i class="fas fa-plus"></i> Agregar Opción
                                                </button>
                                            </div>
                                            <span v-else class="text-muted">No aplica</span>
                                        </td>
                                        <td>
                                            <button @click="eliminarPregunta(index,pregunta)" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="row  text-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="mt-4">

                                <pre class="mt-3 bg-light p-3 rounded" style="display: none;">{{ JSON.stringify(array_preguntas, null, 2) }}</pre>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-guardar {
        width: 100%;
        height: 100%;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
    }

    .btn-guardar:hover {
        background-color: #45a049;
    }

    .panel {
        background-color: #f2f2f2;
        /* Color más claro para el fondo del panel */
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
    }

    /* Título del panel */
    .panel-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #00587a;
        /* Color del título */
    }

    /* Estilos generales para la tabla */
    .excel-table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Estilos para encabezados y celdas */
    .excel-table th,
    .excel-table td {
        border: 1px solid #00587a;
        /* Color de borde a juego */
        padding: 10px;
        text-align: left;
    }

    .excel-table th {
        background-color: #00587a;
        /* Color de fondo para encabezados */
        color: white;
        /* Color de texto en encabezados */
    }

    .excel-table thead th {
        position: sticky;
        top: 0;

        z-index: 1;
        padding: 10px;
        border-bottom: 2px solid #ddd;
        text-align: center;
    }

    .excel-table tbody tr td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .excel-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .excel-table th,
    .excel-table td {
        text-align: center;
        border: 1px solid #ddd;
    }

    /* Estilos alternos para las filas */
    .excel-table tr:nth-child(even) {
        background-color: #e5e5e5;
        /* Color alternativo más claro */
    }

    .excel-table tr:hover {
        background-color: #d0d0d0;
        /* Color de fondo al pasar el mouse */
    }

    button:disabled {
        background-color: #cccccc;
        cursor: not-allowed;
    }


    .error {
        border: 1px solid red;
    }

    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

    .max-limit-message {
        color: #666;
        font-style: italic;
        margin-top: 10px;
    }

    /* Estilos para botones */
    button {
        background-color: #00587a;
        /* Color de fondo de los botones */
        border: none;
        color: white;
        /* Color del texto */
        padding: 8px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    /* Estilos para botones específicos */
    .add-subconcept {
        background-color: #6ca36c;
        /* Color verde más claro para añadir */
    }

    .remove-subconcept {
        background-color: #e74c3c;
        /* Color rojo más fuerte para eliminar */
    }

    /* Contenedor de botones */
    .button-container {
        text-align: right;
        margin-top: 20px;
    }

    /* Estilos para campos de entrada */
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #00587a;
        /* Borde del mismo color que el panel */
        border-radius: 4px;
        box-sizing: border-box;


    }

    /* Placeholder styling */
    input::placeholder {
        color: #777;
        /* Color del texto placeholder */
        font-style: italic;
        /* Estilo en cursiva */
    }

    /* Estilo específico para el botón */
    button {
        background-color: #00587a;
        /* Color de fondo */
        border: none;
        /* Sin borde */
        color: white;
        /* Color del texto */
        padding: 5px 10px;
        /* Relleno reducido para hacerlo más compacto */
        text-align: center;
        /* Alineación del texto */
        text-decoration: none;
        /* Sin subrayado */
        display: inline-block;
        /* Para poder establecer dimensiones */
        font-size: 12px;
        /* Tamaño de fuente reducido */
        margin: 4px 2px;
        /* Margen reducido */
        cursor: pointer;
        /* Cambia el cursor al pasar sobre el botón */
        border-radius: 4px;
        /* Bordes redondeados */
    }

    /* Estilo específico para el botón compacto */
    button.compact {
        padding: 3px 8px;
        /* Menor relleno */
        font-size: 11px;
        /* Tamaño de fuente aún más pequeño */
    }





    .table-container {
        max-height: 800px;
        /* Ajusta esta altura según tus necesidades */
        overflow-y: auto;
        /* Permite el desplazamiento vertical */
        border: 1px solid #ddd;
        /* Opcional: agrega un borde alrededor del contenedor */
        border-radius: 8px;
        /* Opcional: bordes redondeados */
    }

    .concept-row {
        border-bottom: 2px solid #ddd;
        padding: 10px 0;
    }

    .concept-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
    }

    .concepto-nombre {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
        color: #333;
    }

    .btn.btn-add-subconcepto {
        padding: 8px 12px;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s ease;
    }

    .btn.btn-add-subconcepto:hover {
        background-color: #218838;
    }

    .moneda-total {
        font-size: 1.3rem;
        color: #555;
        font-weight: bold;
        margin: 0;
    }

    .text-center {
        text-align: center;
    }

    .concept-header-container h2 {
        margin: 0;
    }

    td {
        padding: 15px;
        vertical-align: middle;
    }

    .totalizadores-panel {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .totalizadores-title {
        font-size: 24px;
        font-weight: bold;
        color: #8B5E3C;
        letter-spacing: 1px;
    }

    .totalizador-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s ease-in-out;
    }

    .totalizador-card:hover {
        transform: translateY(-10px);
    }

    .totalizador-title {
        font-size: 18px;
        font-weight: 600;
        color: #8B5E3C;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .totalizador-body {
        text-align: center;
    }

    .totalizador-value {
        font-size: 36px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .totalizador-percentage {
        font-size: 24px;
        font-weight: 600;
        color: #999;
        margin-top: 5px;
    }

    /* Estilos para el checkbox de requerido */
    .form-check {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-check-label i {
        font-size: 16px;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }
</style>


<?= $this->registerJsFile('@web/js/my_js/configuracion_preguntas.js'); //.'?v='.Esys::getVersionadoArchivo('js/my_js/catalogo-plan-comision-script.js'), ['depends' => [yii\web\JqueryAsset::className()]] 
?>