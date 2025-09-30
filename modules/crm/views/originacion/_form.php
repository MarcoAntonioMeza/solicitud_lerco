<?php

use yii\helpers\Url;
use app\models\Esys;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use app\models\user\User;
use app\models\catalogo\CatalogoComision;
use app\models\empresa\Empresa;


?>

<style>
    h1 {
        text-align: center;
        color: #333;
    }

    form {
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
    }

    .form-group input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        cursor: pointer;

        color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .custom-file-upload:hover {
        background-color: #0056b3;
    }

    .preview {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .image-container {
        text-align: center;
    }

    .image-container img {
        max-width: 90%;
        border: 1px solid #ccc;
        padding: auto;
    }

    button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }


    button:hover {
        background-color: #218838;
    }


    .image-container {
        margin-bottom: 20px;
    }

    .image-container img {
        max-width: 100%;
        height: auto;
    }

    .information-container {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        max-height: 400px;
        /* Limita la altura de la sección */
        overflow-y: auto;
    }

    .information-container h3 {
        margin-bottom: 20px;
    }

    video {
        display: block;
        margin: 10px auto;
    }

    canvas {
        max-width: 100%;
        height: auto;
    }

    #video {
        transform: scaleX(-1);
        /* Efecto espejo */
    }
</style>
<div id="app">
    <div class="configuracion-comision-form">
        <div class="panel">

            <div class="tab-base">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-ine">CARGA DE INE</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab-camara">TOMA DE VIDEO Y FOTO</a>
                    </li>



                </ul>

                <div class="tab-content">
                    <!--INE -->
                    <div id="tab-ine" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h1>INE</h1>
                                                <form @submit.prevent="submitForm">
                                                    <div class="form-group">
                                                        <label for="ine-frontal" class="custom-file-upload">INE Frontal</label>
                                                        <input type="file" id="ine-frontal" @change="onFileChange('frontal', $event)" accept="image/*">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ine-trasero" class="custom-file-upload">INE Reverso</label>
                                                        <input type="file" id="ine-trasero" @change="onFileChange('trasero', $event)" accept="image/*">
                                                    </div>
                                                    <div class="preview" v-if="frontalImage || traseroImage">
                                                        <div class="image-container" v-if="frontalImage">
                                                            <h3>INE Frontal</h3>
                                                            <img :src="frontalImage" alt="INE Frontal">
                                                        </div>
                                                        <div class="image-container" v-if="traseroImage">
                                                            <h3>INE Trasero</h3>
                                                            <img :src="traseroImage" alt="INE Trasero">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                </form>

                                            </div>


                                            <div class="col-md-6">

                                                <h1>Información</h1>
                                                <div class="information-container" v-if="responseData">
                                                    <h3>Datos del INE</h3>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Nombres:</strong> {{ responseData.nombres }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Sexo:</strong> {{ responseData.sexo }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Nombre (MRZ):</strong> {{ responseData.validacionMRZ.nombre }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Estado:</strong> {{ responseData.estado }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Colonia:</strong> {{ responseData.colonia }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Ciudad:</strong> {{ responseData.ciudad }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Calle:</strong> {{ responseData.calle }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>CIC:</strong> {{ responseData.cic }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Clave Elector:</strong> {{ responseData.claveElector }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Código de Validación:</strong> {{ responseData.codigoValidacion }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>CURP:</strong> {{ responseData.curp }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Emisión:</strong> {{ responseData.emision }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Fecha de Nacimiento:</strong> {{ responseData.fechaNacimiento }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Identificador Ciudadano:</strong> {{ responseData.identificadorCiudadano }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Localidad:</strong> {{ responseData.localidad }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col">
                                                            <p><strong>Municipio:</strong> {{ responseData.municipio }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>OCR:</strong> {{ responseData.ocr }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Primer Apellido:</strong> {{ responseData.primerApellido }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Registro:</strong> {{ responseData.registro }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Sección:</strong> {{ responseData.seccion }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Segundo Apellido:</strong> {{ responseData.segundoApellido }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>SubTipo:</strong> {{ responseData.subTipo }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Tipo:</strong> {{ responseData.tipo }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Vigencia:</strong> {{ responseData.vigencia }}</p>
                                                        </div>
                                                    </div>
                                                    <h4>Validación MRZ:</h4>
                                                    <div class="row">
                                                        <div class="col">
                                                            <p><strong>Emisión:</strong> {{ responseData.validacionMRZ.emision }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Fecha de Nacimiento:</strong> {{ responseData.validacionMRZ.fechaNacimiento }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p><strong>Vigencia:</strong> {{ responseData.validacionMRZ.vigencia }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <p>No hay información disponible</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div id="tab-camara" class="tab-pane">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <h1>Tomar foto/video</h1>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col md-12">
                                            <video id="video" width="640" height="480" autoplay></video>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3"><button @click.prevent="startCamera">Iniciar</button></div>
                                        <div class="col-md-3"><button @click.prevent="stopCamera">Detener </button></div>
                                        <div class="col-md-3"><button @click.prevent="takePhoto">Tomar Foto</button></div>
                                        <div class="col-md-3"><button @click.prevent="takePhoto">Tomar video</button></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="canvas" width="640px" height="480px"></canvas>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script>
        new Vue({
            el: '#app',
            data: {
                STR: '{"calle":"C FRANCISCO I MADERO 6","cic":"199742463","ciudad":"TEPETITLA DE LARDIZABAL, TLAX.","claveElector":"MZSMMR01082829H200","codigoValidacion":"gd1718575341.330939","colonia":"- VILLA ALTA 90700","curp":"MESM010828HTLZMRA5","emision":"2019","estado":"29","fechaNacimiento":"28/08/2001","identificadorCiudadano":"125430041","localidad":"0002","mrz":"IDMEX1997424635\u003c\u003c02891254300410108283H2912316MEX\u003c00\u003c\u003c47611\u003c4MEZA\u003cSAMPEDRO\u003c\u003cMARCO\u003cANTONIO\u003c\u003c","municipio":"019","nombres":"MARCO ANTONIO","ocr":"0289125430041","primerApellido":"MEZA","registro":"2019 00","seccion":"0289","segundoApellido":"SAMPEDRO","sexo":"H","subTipo":"E","tipo":"INE","validacionMRZ":{"emision":"OK","fechaNacimiento":"OK","nombre":"OK","sexo":"OK","vigencia":"OK"},"vigencia":"2029"}',
                frontalImage: null,
                traseroImage: null,
                frontalBase64: '',
                traseroBase64: '',
                responseData: null,
                responseDataRFC: null,
                rfc: "",
                stream: null
            },
            methods: {
                startCamera(event) {
                    event.preventDefault(); // Evitar la recarga de la página
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        navigator.mediaDevices.getUserMedia({
                                video: true
                            })
                            .then(stream => {
                                this.stream = stream;
                                const video = document.getElementById('video');
                                video.srcObject = stream;
                                video.play();
                            })
                            .catch(err => {
                                console.error("Error al acceder a la cámara: ", err);
                            });
                    } else {
                        alert("Tu navegador no soporta acceso a la cámara.");
                    }
                },
                stopCamera(event) {
                    event.preventDefault(); // Evitar la recarga de la página
                    if (this.stream) {
                        this.stream.getTracks().forEach(track => track.stop());
                        this.stream = null;
                        const video = document.getElementById('video');
                        video.srcObject = null;
                    }
                },
                takePhoto(event) {
                    event.preventDefault(); // Evitar la recarga de la página
                    const video = document.getElementById('video');
                    const canvas = document.getElementById('canvas');
                    const context = canvas.getContext('2d');
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    const dataURL = canvas.toDataURL('image/png');
                    console.log("base64",dataURL);
                },
                onFileChange(type, event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            if (type === 'frontal') {
                                this.frontalImage = e.target.result;
                                this.frontalBase64 = e.target.result.split(',')[1];
                            } else if (type === 'trasero') {
                                this.traseroImage = e.target.result;
                                this.traseroBase64 = e.target.result.split(',')[1];
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                },
                // Función para enviar el formulario
                submitForm() {
                    const data = {
                        id: this.frontalBase64,
                        idReverso: this.traseroBase64
                    };
                    this.responseData = JSON.parse(this.STR);
                    return
                    $.ajax({
                        type: 'POST',
                        url: 'ine',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: (response) => {
                            this.responseData = JSON.parse(response);
                            console.log('Respuesta:', response);
                        },
                        error: (xhr, status, error) => {
                            console.error('Error en la solicitud:', error);
                        }
                    });
                },

            }
        });
    </script>