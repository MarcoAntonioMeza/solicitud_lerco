
 $(function () {
    $wizard             = $("#wizard");
    $wizard.steps({
        onInit : function(event, currentIndex){

            $formGenerales = {
                inputUidx             : $('#cliente-uidx'),
                inputAsignado         : $('#cliente-asignado_id'),
                inputRazonSocial      : $('#cliente-razon_social'),
                //inputNacionalidad     : $('#cliente-nacionalidad'),
                inputRfc              : $('#cliente-rfc'),
                inputFechaConstitucion: $('#cliente-fecha_constitucion'),
                inputNumeroConstitucion: $('#cliente-numero_constitucion'),
                inputPaisConstitucion  : $('#cliente-pais_constitucion'),
                inputPaisQueEmite  : $('#cliente-pais_que_emite'),
                inputGrupoRiesgoId      : $('#cliente-grupo_riesgo_id'),
                inputRegion                 : $('#cliente-region_id'),
                inputPlaza                  : $('#cliente-plaza_id'),
                inputSucursal               : $('#cliente-sucursal_id'),
                inputFechaIntegracion       : $('#cliente-fecha_integracion'),
            };

            $formActividadOrigen = {
                //inputPreciseGiroActividad       : $('#cliente-precise_giro_actividad'),
                inputEmpleado                   : $('#cliente-empleado'),
                inputPuesto                     : $('#cliente-puesto_que_responde'),
                inputFacturaDolares             : $('#cliente-factura_dolares'),
                inputOrigenRecurso              : $('#cliente-origen_recurso'),
                inputDestinoCredito             : $('#cliente-destino_credito'),
                inputParticipacionCredito       : $('#cliente-participacion_credito'),
                inputRiesgo                     : $('#cliente-riesgo'),
                inputProducto                   : $('#cliente-producto'),
                inputIngresoMensuales           : $('#cliente-ingresos_mensuales'),
                inputEgresosMensuales           : $('#cliente-egresos_mensuales'),
                inputAplicaOtrosIngresos        : $('#cliente-apply_otros_ingresos'),
                inputFuenteOtrosIngresos        : $('#cliente-fuente_otros_ingresos'),
                inputMontoFuentesIngreso        : $('#cliente-monto_fuentes_ingresos'),
            };


            $formDireccion = {
                inputPais         : $('#form-direccion-pais_id'),
                inputCategoria    : $('#form-direccion-tipo'),
                inputEstado       : $('#form-direccion-local-estado'),
                inputMunicipio    : $('#form-direccion-local-municipio'),
                inputCuidad       : $('#form-direccion-local-cuidad'),
                inputColonia      : $('#form-direccion-local-colonia'),
                inputCodigoSearch : $('#form-direccion-local-cp'),
                inputDireccion    : $('#form-direccion-direccion'),
                inputNumeroExt    : $('#form-direccion-num-exterior'),
                inputNumeroInt    : $('#form-direccion-num-int'),
                inputReferencia   : $('#form-direccion-referencia'),
                inputAntiguedad   : $('#form-direccion-antiguedad'),
            };


            $formPropietariosReales = {
                inputNombre             : $('#form-preales-nombre'),
                inputSegundoNombre      : $('#form-preales-segundo_nombre'),
                inputApellidoPaterno    : $('#form-preales-apellido_paterno'),
                inputApellidoMaterno    : $('#form-preales-apellido_materno'),
                inputFechaNacimiento    : $('#form-preales-fecha_nacimiento'),
                inputNacionalidad       : $('#form-preales-nacionalidad'),
                inputEntidadFederativaOtro  : $('#form-preales-entidad-federativa-nacimiento-otro'),
                inputEntidadFederativaMx    : $('#form-preales-entidad-federativa-nacimiento-mx'),
                inputTenencia           : $('#form-preales-tenencia'),
                inputEjerceControl      : $('#form-preales-ejerce-control'),
            };

            $formRepresentantesLegales = {
                inputNombre             : $('#form-plegales-nombre'),
                inputSegundoNombre      : $('#form-plegales-segundo_nombre'),
                inputApellidoPaterno    : $('#form-plegales-apellido_paterno'),
                inputApellidoMaterno    : $('#form-plegales-apellido_materno'),
                inputFechaNacimiento    : $('#form-plegales-fecha_nacimiento'),
                inputNacionalidad       : $('#form-plegales-nacionalidad'),
                inputEntidadFederativaOtro  : $('#form-plegales-entidad-federativa-nacimiento-otro'),
                inputEntidadFederativaMx    : $('#form-plegales-entidad-federativa-nacimiento-mx'),
            };


            $formPersonaPoliticamenteEx = {
                inputSino            : $('#form-pPolitcamenteEx-si-no'),
                inputPuestoCargo     : $('#form-pPolitcamenteEx-puesto-cargo'),
                inputDependencia     : $('#form-pPolitcamenteEx-dependecia'),
                inputEjercicioCargo  : $('#form-pPolitcamenteEx-ejercicio-cargo'),
                inputSinoCargo            : $('#form-pPolitcamenteEx-si-no-cargo'),
                inputFechaSeparacion : $('#form-pPolitcamenteEx-fecha_separacion'),
            };

            $formPersonaPoliticamenteExOtro = {
                inputSino            : $('#form-pPolitcamenteExOtro-si-no'),
                inputPuestoCargo     : $('#form-pPolitcamenteExOtro-puesto-cargo'),
                inputDependencia     : $('#form-pPolitcamenteExOtro-dependecia'),
                inputEjercicioCargo  : $('#form-pPolitcamenteExOtro-ejercicio-cargo'),
                inputSinoCargo       : $('#form-pPolitcamenteExOtro-si-no-cargo'),
                inputFechaSeparacion : $('#form-pPolitcamenteExOtro-fecha_separacion'),
            };

            $formPerfilTransaccional = {
                inputCredito        : $('#form-perfilTransaccional-credito'),
                inputFrecuencia     : $('#form-perfilTransaccional-frecuencia'),
                inputMontoPago      : $('#form-perfilTransaccional-monto_del_pago'),
                inputInstrumento    : $('#form-perfilTransaccional-instrumento'),
                inputMoneda         : $('#form-perfilTransaccional-moneda'),
                inputOperacionesMin : $('#form-perfilTransaccional-operaciones_min'),
                inputOperacionesMax : $('#form-perfilTransaccional-operaciones_max'),
                inputEstimaPagos    : $('#form-perfilTransaccional-estima_pagos_anticipados'),
            };

            $formPerfilTransaccionalOtro = {
                inputCredito        : $('#form-perfilTransaccionalOtro-credito'),
                inputFrecuencia     : $('#form-perfilTransaccionalOtro-frecuencia'),
                inputMontoPago      : $('#form-perfilTransaccionalOtro-monto_del_pago'),
                inputInstrumento    : $('#form-perfilTransaccionalOtro-instrumento'),
                inputMoneda         : $('#form-perfilTransaccionalOtro-moneda'),
                inputOperacionesMin : $('#form-perfilTransaccionalOtro-operaciones_min'),
                inputOperacionesMax : $('#form-perfilTransaccionalOtro-operaciones_max'),
                inputFechaAct       : $('#form-perfilTransaccionalOtro-fechaAct'),
            };

            $formTelefono = {
                inputPertenece  : $('#form-telefono-pertenece'),
                inputPais       : $('#form-telefono-pais'),
                inputNumero     : $('#form-telefono-numero'),
                inputCodigo     : $('#form-telefono-codigo'),
                inputExtension  : $('#form-telefono-extension'),
            };

            $formActividadEconomica = {
                inputTipoAcctividad                 : $('#form-cliente-tipo_actividad'),
                actividadEconomicaID                : $('#cliente-precise_giro_actividad'),
                inputOtroClaveActividad             : $('#cliente-precise_giro_actividad_otro_clave'),
                inputOtroActividadEconomica         : $('#cliente-precise_giro_actividad_otro_nombre'),
            };

            $formBanco = {
                inputCuentaInterbancaria    : $('#form-cuenta-interbancaria'),
                lblBancoText                : $('#lbl-banco-text'),
            };


            $btnAgregarDireccion    = $('#btnAgregarDireccion'),
            $btnAgregarTelefono     = $('#btnAgregarTelefono'),
            $btnAgregarActividadEconomica   = $('#btnAgregarActividadEconomica'),
            $inputFileEvidencia     = $('.inputFileEvidencia'),
            $btnAgregarPropetariosReales          = $('#btnAgregarPropetariosReales'),
            $btnAgregarRepresentatesLegales       = $('#btnAgregarRepresentatesLegales'),
            $btnAgregarPersonasExpuestas          = $('#btnAgregarPersonasExpuestas'),
            $btnAgregarPersonasExpuestasOtro      = $('#btnAgregarPersonasExpuestasOtro'),
            $btnAgregarPerfilTransaccional        = $('#btnAgregarPerfilTransaccional'),
            $btnAgregarPerfilTransaccionalOtro    = $('#btnAgregarPerfilTransaccionalOtro'),
            $btnActPT                             = $('#btnActPT'),
            $btnCancelPT                             = $('#btnCancelPT'),
            $btnSavePT                             = $('#btnSavePT'),
            $btnRecord                             = $('#btnRecord'),
            $btnRecordHide                         = $('#btnRecordHide'),
            $containerDirecciones   = $('.container-direcciones'),
            $containerTelefono      = $('.container-telefono'),
            $containerActividad     = $('.container-actividad'),
            $containerPropietariosReal          = $('.container-propietarios-reales'),
            $containerRepresentantesLegales     = $('.container-representantes-legales'),
            $containerPersonasPoliticamenteEx   = $('.container-personas-politicamente-exp'),
            $containerPersonasPoliticamenteExOtro   = $('.container-personas-politicamente-exp-otro'),
            $containerHistorico     = $('.container-historico-cambios'),
            $containerPerfilTransaccional       = $('.container-perfil-transaccional'),
            $containerPerfilTransaccionalOtro = $('.container-perfil-transaccional-otro'),
            $btnAgregarBanco        = $('#btnAgregarBanco'),
            $containerBanco         = $('.container-bancos'),
            VAR_TIPO_CLIENTE        = $('#inputTipo').val(),
            municipioSelected       = null;
            VAR_PATH_URL            = $('body').data('url-root');
            SECCION_GENERAL         = 10;
            SECCION_ACTIORIG        = 20;
            TELEFONO_ACTIVO         = 10;
            DIRECCION_ACTIVO        = 10;
            DIRECCION_BAJA          = 1;
            TELEFONO_BAJA           = 1;
            ACTIVIDAD_ACTIVO         = 10;
            ACTIVIDAD_BAJA           = 1;
            PROPETARIOS_REALES_ACTIVO           = 10;
            PROPETARIOS_REALES_BAJA             = 1;
            REPRESENTANTES_LEGAL_ACTIVO         = 10;
            REPRESENTANTES_LEGAL_BAJA           = 1;
            PERSONAS_POLITICAMENTE_EX_ACTIVO    = 10;
            PERSONAS_POLITICAMENTE_EX_BAJA      = 1;
            PERFIL_TRANSACCIONAL_ACTIVO         = 10;
            PERFIL_TRANSACCIONAL_BAJA           = 1;
            BANCO_ACTIVO            = 10;
            DOCUMENTO_TIPO_LOAD     = null;
            BANCO_BAJA              = 1;
            ON                      = 10;
            OFF                     = 20;
            clienteObject           = {
                "generales": {
                    "cliente_id"        : $('#cliente-id').val() ? $('#cliente-id').val() : null,
                    "asignado_id"       : null,
                    "asignado_text"     : null,
                    "fecha_integracion" : null,
                    "uidx"              : null,
                    "tipo"              : VAR_TIPO_CLIENTE,
                    "razon_social"      : null,
                    "nacionalidad"      : null,
                    "rfc"               : null,
                    "pais_que_emite"    :null,
                    "grupo_riesgo_id"   : null,

                    "moneda"                        : null,
                    "credito"                       : null,
                    "frecuencia"                    : null,
                    "operaciones_max"               : null,
                    "operaciones_min"               : null,
                    "monto_pago"                    : null,
                    "instrumento"                   : null,
    
                    "moneda_pa"                     : null,
                    "credito_pa"                    : null,
                    "frecuencia_pa"                 : null,
                    "operaciones_max_pa"            : null,
                    "operaciones_min_pa"            : null,
                    "monto_pago_pa"                 : null,
                    "instrumento_pa"                : null,
                    "estima_pagos"                  : null,
                    "fecha_act"                     : null,
                    "cambios"                       : null,


                    "direcciones"       : [],
                    "telefonos"         : [],
                    "bancos"            : [],
                },
                "actividadOrigen" : {
                    "cliente_id"                : $('#cliente-id').val() ? $('#cliente-id').val() : null,
                    "precise_giro_actividad"    : [],
                    "empleado"                  : null,
                    "puesto_que_responde"       : null,
                    "factura_dolares"           : null,
                    "origen_recurso"            : null,
                    "destino_credito"           : null,
                    "participacionCredito"      : null,
                    "riesgo"                    : null,
                    "producto"                  : null,
                    "producto_text"             : null,
                    "ingresos_mensuales"        : null,
                    "egresos_mensuales"         : null,
                    "apply_otros_ingresos"      : null,
                    "fuente_otros_ingresos"     : null,
                    "monto_fuentes_ingresos"    : null,
                },
                "propietarios_reales":[],
                "representantes_legal":[],
                "personasPoliticamenteEx":[],
                "perfilTransaccional":[],
                "perfilTransaccionalPa":[],
                "creditos":[],
                "historico":[],
                "expedienteDigital" : []
            };

            //funct_refresh_title_tabs();
            funct_get_info_seccion();

            $inputFileEvidencia.fileupload({
                add: function(e, data) {
                        var uploadErrors = [];
                        //var acceptFileTypes = /^image\/(gif|jpe?g|png)$/i;
                        var acceptFileTypes = /(\.|\/)(pdf|x-zip-compressed|jpe?g|png)$/i;
                        if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                            uploadErrors.push('No se acceptan este tipo de documento, intenta nuevamente');
                        }
                        if(data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 5000000) {
                            uploadErrors.push('El tamaño del documento es demasiado grande, contanta al administrador');
                        }
                        if(uploadErrors.length > 0) {
                            alert(uploadErrors.join("\n"));
                        } else {
                            data.submit();
                        }
                },
                dataType: 'json',
                replaceFileInput : false,
                //acceptFileTypes: /(\.|\/)(pdf|jpeg|png|jpg)$/i,

                start : function (e, data) {
                    data.files = document.getElementsByClassName("inputFileEvidencia").files;
                },
                progressall: function (e, data) {

                    data.context = $('.file-row-text'); //create new DIV with "file-wrapper" class
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    $('.'+DOCUMENTO_TIPO_LOAD+'-progress-file').css('width',progress + '%');

                    $('.'+DOCUMENTO_TIPO_LOAD+'-lbl-progress-file').html(progress + '%');

                    if (data.context) {
                        data.context.each(function () {
                            $(this).find('.'+DOCUMENTO_TIPO_LOAD+'-progress').attr('aria-valuenow', progress).children().first().css('width',progress + '%').text(progress + '%');
                        });
                    }

                },
                done: function (e, data) {
                    if (data.result.code == 202 ){
                        clienteObject.expedienteDigital.push({
                            "element_id": 1000000 + (clienteObject.expedienteDigital.length + 1),
                            "cliente_id": clienteObject.generales.cliente_id,
                            "extension" : data.result.extension,
                            "name_new"  : data.result.name_new,
                            "name_old"  : data.result.name_old,
                            "tipo"      : data.result.tipo,
                            "fecha"     : data.result.fecha,
                            "fecha_vigencia"    : null,
                            "pertenece" : DOCUMENTO_TIPO_LOAD,
                            "create"    : ON,
                            "delete"    : OFF,
                        });

                        render_documentacion();

                        DOCUMENTO_TIPO_LOAD = null;
                    }
                },
            });

            $btnRecord.click(function(){
                document.getElementById("div-record").style.display = "block";
                document.getElementById("record-btn").style.display = "none";
                document.getElementById("record-btn-hide").style.display = "block";
      
            });

            $btnRecordHide.click(function(){
                document.getElementById("div-record").style.display = "none";
                document.getElementById("record-btn").style.display = "block";
                document.getElementById("record-btn-hide").style.display = "none";

            });


            $btnActPT.click(function(){
                if(confirm("¿Desea continuar con la edicion del PT?")){


                    if (clienteObject.generales.estima_pagos == "ON") {
                       
                        $formPerfilTransaccional.inputEstimaPagos.prop("checked", true);
                        $formPerfilTransaccionalOtro.inputCredito.attr("disabled", false);
                        $formPerfilTransaccionalOtro.inputFrecuencia.attr("disabled", false);
                        $formPerfilTransaccionalOtro.inputMontoPago.attr("disabled", false);
                        $formPerfilTransaccionalOtro.inputInstrumento.attr("disabled", false);
                        $formPerfilTransaccionalOtro.inputMoneda.attr("disabled", false);
                        $formPerfilTransaccionalOtro.inputOperacionesMin.attr("disabled", false);
                        $formPerfilTransaccionalOtro.inputOperacionesMax.attr("disabled", false);
        
                        }else{ $formPerfilTransaccional.inputEstimaPagos.prop("checked", false); }


                        $formPerfilTransaccional.inputCredito.attr("disabled", false);
                        $formPerfilTransaccional.inputFrecuencia.attr("disabled", false);
                        $formPerfilTransaccional.inputMontoPago.attr("disabled", false);
                        $formPerfilTransaccional.inputInstrumento.attr("disabled", false);
                        $formPerfilTransaccional.inputMoneda.attr("disabled", false);
                        $formPerfilTransaccional.inputOperacionesMin.attr("disabled", false);
                        $formPerfilTransaccional.inputOperacionesMax.attr("disabled", false);
                        $formPerfilTransaccional.inputEstimaPagos.attr("disabled", false);


                        document.getElementById("fechaActPT").style.display = "block";
                        document.getElementById("update-pt-section").style.display = "block";
                        document.getElementById("update-btn").style.display = "none";



                        if(clienteObject.generales.fecha_act == "" || clienteObject.generales.fecha_act == null){
                            var today = moment().format('YYYY-MM-DD');
                            $formPerfilTransaccionalOtro.inputFechaAct.val(today);
                            //alert(clienteObject.generales.fecha_act);
                        }else{ 
                            $formPerfilTransaccionalOtro.inputFechaAct.val(clienteObject.generales.fecha_act);
                        }


                    }else{ }
              
            });

            $btnCancelPT.click(function(){
                if(confirm("¿Desea cancelar la edicion del PT?")){
                        $formPerfilTransaccional.inputCredito.attr("disabled", true);
                        $formPerfilTransaccional.inputFrecuencia.attr("disabled", true);
                        $formPerfilTransaccional.inputMontoPago.attr("disabled", true);
                        $formPerfilTransaccional.inputInstrumento.attr("disabled", true);
                        $formPerfilTransaccional.inputMoneda.attr("disabled", true);
                        $formPerfilTransaccional.inputOperacionesMin.attr("disabled", true);
                        $formPerfilTransaccional.inputOperacionesMax.attr("disabled", true);
                        //$formPerfilTransaccional.inputEstimaPagos.attr("disabled", true);

                        $formPerfilTransaccionalOtro.inputCredito.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputFrecuencia.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputMontoPago.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputInstrumento.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputMoneda.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputOperacionesMin.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputOperacionesMax.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputFechaAct.val(null);
                        document.getElementById("fechaActPT").style.display = "none";
                        document.getElementById("update-pt-section").style.display = "none";
                        document.getElementById("update-btn").style.display = "inline";

                        if(clienteObject.generales.fecha_act == "" || clienteObject.generales.fecha_act == null){
                            var today = moment().format('YYYY-MM-DD');
                            $formPerfilTransaccionalOtro.inputFechaAct.val(null);
                            alert(clienteObject.generales.fecha_act);
                        }else{ 
                            $formPerfilTransaccionalOtro.inputFechaAct.val(clienteObject.generales.fecha_act);
                        }

                        render_perfil_transaccional();
                        
                        
                        
                    }else{ }
              
            });

            $btnSavePT.click(function(){
                if(confirm("¿Confirmar la edicion del PT?")){

                        clienteObject.generales.credito = $formPerfilTransaccional.inputCredito.val();
                        clienteObject.generales.frecuencia = $formPerfilTransaccional.inputFrecuencia.val();
                        clienteObject.generales.operaciones_max = $formPerfilTransaccional.inputOperacionesMax.val();
                        clienteObject.generales.operaciones_min = $formPerfilTransaccional.inputOperacionesMin.val();
                        clienteObject.generales.monto_pago = $formPerfilTransaccional.inputMontoPago.val();
                        clienteObject.generales.instrumento = $formPerfilTransaccional.inputInstrumento.val();
                        clienteObject.generales.moneda = $formPerfilTransaccional.inputMoneda.val();
                        clienteObject.generales.credito_pa = $formPerfilTransaccionalOtro.inputCredito.val();
                        clienteObject.generales.frecuencia_pa = $formPerfilTransaccionalOtro.inputFrecuencia.val();
                        clienteObject.generales.operaciones_max_pa = $formPerfilTransaccionalOtro.inputOperacionesMax.val();
                        clienteObject.generales.operaciones_min_pa = $formPerfilTransaccionalOtro.inputOperacionesMin.val();
                        clienteObject.generales.monto_pago_pa = $formPerfilTransaccionalOtro.inputMontoPago.val();
                        clienteObject.generales.instrumento_pa = $formPerfilTransaccionalOtro.inputInstrumento.val();
                        clienteObject.generales.moneda_pa = $formPerfilTransaccionalOtro.inputMoneda.val();
                        clienteObject.generales.fecha_act = $formPerfilTransaccionalOtro.inputFechaAct.val();
                        

                        
                        

                        $formPerfilTransaccional.inputCredito.attr("disabled", true);
                        $formPerfilTransaccional.inputFrecuencia.attr("disabled", true);
                        $formPerfilTransaccional.inputMontoPago.attr("disabled", true);
                        $formPerfilTransaccional.inputInstrumento.attr("disabled", true);
                        $formPerfilTransaccional.inputMoneda.attr("disabled", true);
                        $formPerfilTransaccional.inputOperacionesMin.attr("disabled", true);
                        $formPerfilTransaccional.inputOperacionesMax.attr("disabled", true);
    
                        $formPerfilTransaccionalOtro.inputCredito.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputFrecuencia.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputMontoPago.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputInstrumento.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputMoneda.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputOperacionesMin.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputOperacionesMax.attr("disabled", true);
                        $formPerfilTransaccionalOtro.inputFechaAct.attr("disabled", true);

                    document.getElementById("fechaActPT").style.disabled = true;
                    document.getElementById("update-pt-section").style.display = "none";
                    document.getElementById("update-btn").style.display = "block";



                    }else{ }
              
            });


            $btnAgregarDireccion.click(function(){
                if (valid_add_direccion()) {
                    if (valid_exist_direccion($formDireccion.inputCategoria.val())) {
                        clienteObject.generales.direcciones.push({
                            "element_id"    : 1000000 + (clienteObject.generales.direcciones.length + 1),
                            "pais_id"       : $formDireccion.inputPais.val(),
                            "pais_text"     : $('option:selected', $formDireccion.inputPais ).text(),
                            "tipo"          : $formDireccion.inputCategoria.val(),
                            "tipo_text"     : $('option:selected', $formDireccion.inputCategoria ).text(),
                            "estado"        : $formDireccion.inputEstado.val(),
                            "estado_text"   : $formDireccion.inputEstado.val(),
                            "municipio_text": $formDireccion.inputMunicipio.val(),
                            "municipio"     : $formDireccion.inputMunicipio.val(),
                            "cuidad"        : $formDireccion.inputCuidad.val(),
                            "cuidad_text"   : $formDireccion.inputCuidad.val(),
                            "colonia"   : $formDireccion.inputColonia.val(),
                            "colonia_text"   : $formDireccion.inputColonia.val(),
                            "cp"        : $formDireccion.inputCodigoSearch.val(),
                            "direccion" : $formDireccion.inputDireccion.val(),
                            "n_ext"     : $formDireccion.inputNumeroExt.val(),
                            "n_int"     : $formDireccion.inputNumeroInt.val(),
                            "referencia" : $formDireccion.inputReferencia.val(),
                            "antiguedad" : $formDireccion.inputAntiguedad.val(),
                            "apply_local"   : OFF,
                            "status"        : DIRECCION_ACTIVO,
                            "apply_principal"   : ON,
                            "create"        : ON,
                            "update"        : OFF,
                        });
                        render_direccion();
                        clear_direccion();
                    }
                }
            });

            $btnAgregarTelefono.click(function(){
                if (valid_add_telefono()) {
                    if (valid_exist_telefono($formTelefono.inputPertenece.val())) {
                        clienteObject.generales.telefonos.push({
                            "element_id"    : 1000000 + (clienteObject.generales.telefonos.length + 1),
                            "pertenece"     : $formTelefono.inputPertenece.val(),
                            "pertenece_text": $('option:selected', $formTelefono.inputPertenece ).text(),
                            "pais"          : $formTelefono.inputPais.val(),
                            "pais_text"     : $('option:selected', $formTelefono.inputPais ).text(),
                            "numero"        : $formTelefono.inputNumero.val(),
                            "extension"     : $formTelefono.inputExtension.val(),
                            "codigo"        : $formTelefono.inputCodigo.val(),
                            "status"        : TELEFONO_ACTIVO,
                            "apply_principal"   : ON,
                            "create"        : ON,
                            "update"        : OFF,
                        });
                        render_telefono();
                        clear_telefono();
                    }
                }
            });

            $btnAgregarActividadEconomica.click(function(){
                if (valid_actividas_economica()) {
                    clienteObject.actividadOrigen.precise_giro_actividad.push({
                        "element_id"    : 1000000 + (clienteObject.actividadOrigen.precise_giro_actividad.length + 1),
                        "tipo"          : $formActividadEconomica.inputTipoAcctividad.val(),
                        "tipo_text"     : $('option:selected', $formActividadEconomica.inputTipoAcctividad ).text(),
                        "producto_id"   : $formActividadEconomica.actividadEconomicaID.val(),
                        "producto_text" : $('option:selected', $formActividadEconomica.actividadEconomicaID ).text(),
                        "otro_clave"    : $formActividadEconomica.inputOtroClaveActividad.val(),
                        "otro_producto_text"    : $formActividadEconomica.inputOtroActividadEconomica.val(),
                        "status"                : ACTIVIDAD_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });
                    render_actividad();
                    clear_actividad();
                }
            });

            $btnAgregarBanco.click(function(){
                if (valid_add_banco()) {

                    $.get( VAR_PATH_URL + "clientes/cliente/get-info-banco",{ clave : $formBanco.inputCuentaInterbancaria.val() },function(response){
                        if (response.code == 202) {

                            clienteObject.generales.bancos.push({
                                "element_id"              : 1000000 + (clienteObject.generales.bancos.length + 1),
                                "clave_interbancaria"     : $formBanco.inputCuentaInterbancaria.val(),
                                "catalogo_banco_id"       : response.clave.id,
                                "clave_banco"             : response.clave.clave,
                                "banco"                   : response.clave.descripcion,
                                "razon_social"            : response.clave.banco,
                                "status"                  : BANCO_ACTIVO,
                                "create"                  : ON,
                                "update"                  : OFF,
                            });

                            render_banco();
                            clear_banco();
                        }else{
                            $formBanco.lblBancoText.html("----------");
                        }
                    },'json');
                }
            });

            $btnAgregarPropetariosReales.click(function(){
                if (valid_add_propietarios_reales()) {
                    clienteObject.propietarios_reales.push({
                        "element_id"            : 1000000 + (clienteObject.propietarios_reales.length + 1),
                        "nombre"                : $formPropietariosReales.inputNombre.val(),
                        "segundo_nombre"        : $formPropietariosReales.inputSegundoNombre.val(),
                        "apellido_paterno"      : $formPropietariosReales.inputApellidoPaterno.val(),
                        "apellido_materno"      : $formPropietariosReales.inputApellidoMaterno.val(),
                        "fecha_nacimiento"      : $formPropietariosReales.inputFechaNacimiento.val(),
                        "nacionalidad_text"     : $('option:selected', $formPropietariosReales.inputNacionalidad ).text(),
                        "nacionalidad"          : $formPropietariosReales.inputNacionalidad.val(),
                        "entidad_federativa_nacimiento"  : $('option:selected', $formPropietariosReales.inputNacionalidad ).text() === 'MÉXICO' ? $('option:selected', $formPropietariosReales.inputEntidadFederativaMx ).text() : $formPropietariosReales.inputEntidadFederativaOtro.val(),
                        "tenencia"              : $formPropietariosReales.inputTenencia.val(),
                        "ejerce_control_text"   : $('option:selected', $formPropietariosReales.inputEjerceControl ).text(),
                        "ejerce_control"        : $formPropietariosReales.inputEjerceControl.val(),
                        "status"                : PROPETARIOS_REALES_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });

                    render_propietarios_reales();
                    clear_propietarios_reales();
                }
            });

            $btnAgregarRepresentatesLegales.click(function(){
                if (valid_add_representantes_legal()) {
                    clienteObject.representantes_legal.push({
                        "element_id"            : 1000000 + (clienteObject.representantes_legal.length + 1),
                        "nombre"                : $formRepresentantesLegales.inputNombre.val(),
                        "segundo_nombre"        : $formRepresentantesLegales.inputSegundoNombre.val(),
                        "apellido_paterno"      : $formRepresentantesLegales.inputApellidoPaterno.val(),
                        "apellido_materno"      : $formRepresentantesLegales.inputApellidoMaterno.val(),
                        "fecha_nacimiento"      : $formRepresentantesLegales.inputFechaNacimiento.val(),
                        "nacionalidad_text"     : $('option:selected', $formRepresentantesLegales.inputNacionalidad ).text(),
                        "nacionalidad"          : $formRepresentantesLegales.inputNacionalidad.val(),
                        "entidad_federativa_nacimiento"  : $('option:selected', $formRepresentantesLegales.inputNacionalidad ).text() === 'MÉXICO' ? $('option:selected', $formRepresentantesLegales.inputEntidadFederativaMx ).text() : $formRepresentantesLegales.inputEntidadFederativaOtro.val(),
                        "status"                : REPRESENTANTES_LEGAL_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });

                    render_representante_legal();
                    clear_representante_legal();
                }
            });

            $btnAgregarPersonasExpuestas.click(function(){
                if (valid_add_personas_politicamente_expuesta()) {
                    clienteObject.personasPoliticamenteEx.push({
                        "element_id"            : 1000000 + (clienteObject.personasPoliticamenteEx.length + 1),
                        "tipo"                  : ON,
                        "si_no"                 : $formPersonaPoliticamenteEx.inputSino.val(),
                        "si_no_text"            : $('option:selected', $formPersonaPoliticamenteEx.inputSino ).text(),
                        "puesto_cargo"          : $formPersonaPoliticamenteEx.inputPuestoCargo.val(),
                        "dependencia"           : $formPersonaPoliticamenteEx.inputDependencia.val(),
                        "ejercicio_cargo"       : $formPersonaPoliticamenteEx.inputEjercicioCargo.val(),
                        "fecha_separacion"      : $formPersonaPoliticamenteEx.inputFechaSeparacion.val(),
                        "status"                : PERSONAS_POLITICAMENTE_EX_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });

                    render_personas_politicamente_ex();
                    clear_personas_politicamente_ex();
                }
            });

            $btnAgregarPersonasExpuestasOtro.click(function(){
                if (valid_add_personas_politicamente_expuesta_otro()) {
                    clienteObject.personasPoliticamenteEx.push({
                        "element_id"            : 1000000 + (clienteObject.personasPoliticamenteEx.length + 1),
                        "tipo"                  : OFF,
                        "si_no"                 : $formPersonaPoliticamenteExOtro.inputSino.val(),
                        "si_no_text"            : $('option:selected', $formPersonaPoliticamenteExOtro.inputSino ).text(),
                        "puesto_cargo"          : $formPersonaPoliticamenteExOtro.inputPuestoCargo.val(),
                        "dependencia"           : $formPersonaPoliticamenteExOtro.inputDependencia.val(),
                        "ejercicio_cargo"       : $formPersonaPoliticamenteExOtro.inputEjercicioCargo.val(),
                        "fecha_separacion"      : $formPersonaPoliticamenteExOtro.inputFechaSeparacion.val(),
                        "status"                : PERSONAS_POLITICAMENTE_EX_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });

                    render_personas_politicamente_ex();
                    clear_personas_politicamente_ex_otro();
                }
            });


            $btnAgregarPerfilTransaccional.click(function(){
                if (valid_add_perfil_transaccional()) {
                    clienteObject.perfilTransaccional.push({
                        "element_id"            : 1000000 + (clienteObject.perfilTransaccional.length + 1),
                        "tipo"                  : ON,
                        "credito"               : $formPerfilTransaccional.inputCredito.val(),
                        "credito_text"          : $('option:selected', $formPerfilTransaccional.inputCredito ).text(),
                        "frecuencia"            : $('option:selected', $formPerfilTransaccional.inputFrecuencia ).text(),
                        'operaciones_min'       : $formPerfilTransaccional.inputOperacionesMin.val(),
                        'operaciones_max'       : $formPerfilTransaccional.inputOperacionesMax.val(),
                        "monto_pago"            : $formPerfilTransaccional.inputMontoPago.val(),
                        "instrumento"           : $formPerfilTransaccional.inputInstrumento.val(),
                        "instrumento_text"      : $('option:selected', $formPerfilTransaccional.inputInstrumento ).text(),
                        "moneda"                : $formPerfilTransaccional.inputMoneda.val(),
                        "moneda_text"           : $('option:selected', $formPerfilTransaccional.inputMoneda ).text(),
                        "status"                : PERFIL_TRANSACCIONAL_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });

                    render_perfil_transaccional();
                    clear_perfil_transaccional();
                }
            });

            $btnAgregarPerfilTransaccionalOtro.click(function(){
                if (valid_add_perfil_transaccional_otro()) {
                    clienteObject.perfilTransaccional.push({
                        "element_id"            : 1000000 + (clienteObject.perfilTransaccional.length + 1),
                        "tipo"                  : OFF,
                        "credito"               : $formPerfilTransaccionalOtro.inputCredito.val(),
                        "credito_text"          : $('option:selected', $formPerfilTransaccionalOtro.inputCredito ).text(),
                        "frecuencia"            : $('option:selected', $formPerfilTransaccionalOtro.inputFrecuencia ).text(),
                        'operaciones_min'       : $formPerfilTransaccionalOtro.inputOperacionesMin.val(),
                        'operaciones_max'       : $formPerfilTransaccionalOtro.inputOperacionesMax.val(),
                        "monto_pago"            : $formPerfilTransaccionalOtro.inputMontoPago.val(),
                        "instrumento"           : $formPerfilTransaccionalOtro.inputInstrumento.val(),
                        "instrumento_text"      : $('option:selected', $formPerfilTransaccionalOtro.inputInstrumento ).text(),
                        "moneda"                : $formPerfilTransaccionalOtro.inputMoneda.val(),
                        "moneda_text"           : $('option:selected', $formPerfilTransaccionalOtro.inputMoneda ).text(),
                        "status"                : PERFIL_TRANSACCIONAL_ACTIVO,
                        "create"                : ON,
                        "update"                : OFF,
                    });

                    render_perfil_transaccional();
                    clear_perfil_transaccional_otro();
                }
            });


            $('.form-info-general :input').on('change', function(){
                clienteObject.generales.asignado_id     = $formGenerales.inputAsignado.val();
                clienteObject.generales.uidx         = $formGenerales.inputUidx.val();
                clienteObject.generales.razon_social = $formGenerales.inputRazonSocial.val();
                //clienteObject.generales.nacionalidad = $formGenerales.inputNacionalidad.val();
                clienteObject.generales.rfc          = $formGenerales.inputRfc.val();
                clienteObject.generales.fecha_constitucion      = $formGenerales.inputFechaConstitucion.val();
                clienteObject.generales.numero_constitucion    = $formGenerales.inputNumeroConstitucion.val();
                clienteObject.generales.pais_constitucion       = $formGenerales.inputPaisConstitucion.val();
                clienteObject.generales.pais_que_emite       = $formGenerales.inputPaisQueEmite.val();
                clienteObject.generales.grupo_riesgo_id     = $formGenerales.inputGrupoRiesgoId.val();
                clienteObject.generales.fecha_integracion    = $formGenerales.inputFechaIntegracion.val();

            });

            $('.form-actividad-origen :input').on('change', function(){

                //clienteObject.actividadOrigen.precise_giro_actividad    = $formActividadOrigen.inputPreciseGiroActividad.val();
                clienteObject.actividadOrigen.empleado                  = $formActividadOrigen.inputEmpleado.val();
                clienteObject.actividadOrigen.puesto_que_responde       = $formActividadOrigen.inputPuesto.val();
                clienteObject.actividadOrigen.factura_dolares           = $formActividadOrigen.inputFacturaDolares.val();
                clienteObject.actividadOrigen.origen_recurso            = $formActividadOrigen.inputOrigenRecurso.val();
                clienteObject.actividadOrigen.destino_credito           = $formActividadOrigen.inputDestinoCredito.val();
                clienteObject.actividadOrigen.participacionCredito      = $formActividadOrigen.inputParticipacionCredito.val();
                clienteObject.actividadOrigen.riesgo                    = $formActividadOrigen.inputRiesgo.val();
                clienteObject.actividadOrigen.producto                  = $formActividadOrigen.inputProducto.val();
                clienteObject.actividadOrigen.ingresos_mensuales        = parseFloat($formActividadOrigen.inputIngresoMensuales.val().replaceAll(',',''));
                clienteObject.actividadOrigen.egresos_mensuales         = parseFloat($formActividadOrigen.inputEgresosMensuales.val().replaceAll(',',''));
                clienteObject.actividadOrigen.apply_otros_ingresos      = $formActividadOrigen.inputAplicaOtrosIngresos.is(':checked') ? ON: OFF;
                clienteObject.actividadOrigen.fuente_otros_ingresos     = $formActividadOrigen.inputFuenteOtrosIngresos.val();
                clienteObject.actividadOrigen.monto_fuentes_ingresos    = parseFloat($formActividadOrigen.inputMontoFuentesIngreso.val().replaceAll(',',''));

            });


            
            // LAS SIGUIENTES LINEAS, DEFINEN EL NUEVO VALOR QUE SERA INSERTADO EN LA BD AL CAMBIARSE EN LOS INPUTS, Y ALMACENANDOSE EN VARIABLES DIFERENTES AL ARRAY DE PT
            $changes = 0;
            $formPerfilTransaccional.inputCredito.change(function(){
                clienteObject.generales.credito = $formPerfilTransaccional.inputCredito.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            
            });

            $formPerfilTransaccional.inputFrecuencia.change(function(){
                clienteObject.generales.frecuencia = $formPerfilTransaccional.inputFrecuencia.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;   
            });
            $formPerfilTransaccional.inputOperacionesMax.change(function(){
                clienteObject.generales.operaciones_max = $formPerfilTransaccional.inputOperacionesMax.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccional.inputOperacionesMin.change(function(){
                clienteObject.generales.operaciones_min = $formPerfilTransaccional.inputOperacionesMin.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccional.inputMontoPago.change(function(){
                clienteObject.generales.monto_pago = $formPerfilTransaccional.inputMontoPago.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccional.inputInstrumento.change(function(){
                clienteObject.generales.instrumento = $formPerfilTransaccional.inputInstrumento.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccional.inputMoneda.change(function(){
                clienteObject.generales.moneda = $formPerfilTransaccional.inputMoneda.val();
                $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            // CAMPOS Y VALORES PERTENECIENTES A LA SECCION "¿ESTIMA HACER PAGOS ADELANTADOS?"

            $formPerfilTransaccionalOtro.inputCredito.change(function(){
            clienteObject.generales.credito_pa = $formPerfilTransaccionalOtro.inputCredito.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccionalOtro.inputFrecuencia.change(function(){
            clienteObject.generales.frecuencia_pa = $formPerfilTransaccionalOtro.inputFrecuencia.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccionalOtro.inputOperacionesMax.change(function(){
            clienteObject.generales.operaciones_max_pa = $formPerfilTransaccionalOtro.inputOperacionesMax.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccionalOtro.inputOperacionesMin.change(function(){
            clienteObject.generales.operaciones_min_pa = $formPerfilTransaccionalOtro.inputOperacionesMin.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccionalOtro.inputMontoPago.change(function(){
            clienteObject.generales.monto_pago_pa = $formPerfilTransaccionalOtro.inputMontoPago.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccionalOtro.inputInstrumento.change(function(){
            clienteObject.generales.instrumento_pa = $formPerfilTransaccionalOtro.inputInstrumento.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });

            $formPerfilTransaccionalOtro.inputMoneda.change(function(){
            clienteObject.generales.moneda_pa = $formPerfilTransaccionalOtro.inputMoneda.val();
            $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;
            });





            $formBanco.inputCuentaInterbancaria.on( "keyup", function() {
                if ($formBanco.inputCuentaInterbancaria.val().length >= 3 ) {
                    $.get( VAR_PATH_URL + "clientes/cliente/get-info-banco",{ clave : $formBanco.inputCuentaInterbancaria.val() },function(response){
                        if (response.code == 202) {
                            $formBanco.lblBancoText.html(response.clave.descripcion);
                        }else{
                            $formBanco.lblBancoText.html("----------");
                        }
                    },'json');
                }
            })

            $formActividadOrigen.inputAplicaOtrosIngresos.change(function(){
                $formActividadOrigen.inputFuenteOtrosIngresos.val(null).attr("disabled", true).trigger('change');
                $formActividadOrigen.inputMontoFuentesIngreso.val(null).attr("disabled", true).trigger('change');
                if ($formActividadOrigen.inputAplicaOtrosIngresos.is(':checked')) {
                    $formActividadOrigen.inputFuenteOtrosIngresos.val(null).attr("disabled", false).trigger('change');
                    $formActividadOrigen.inputMontoFuentesIngreso.val(null).attr("disabled", false).trigger('change');
                }
            });

            $formActividadOrigen.inputProducto.change(function(){
                $('.lbl_producto_clave').html('----');
                $('.lbl_producto_clase').html('----');
                $('.lbl_producto_producto').html('----');
                if ($formActividadOrigen.inputProducto.val()) {
                    $.get(VAR_PATH_URL + "clientes/cliente/get-info-producto", { producto_id : $formActividadOrigen.inputProducto.val() }, function(response){
                        if (response.code == 202) {
                            $('.lbl_producto_clave').html(response.producto.codigo);
                            $('.lbl_producto_rama').html(response.producto.rama);
                            $('.lbl_producto_subrama').html(response.producto.subrama);
                            $('.lbl_producto_producto').html(response.producto.producto);
                        }
                    });
                }
            });

            $formGenerales.inputGrupoRiesgoId.change(function(){
                funct_renderPersonGrupoRiesgo();
            });

            $formGenerales.inputAsignado.change(function(e){
                $formGenerales.inputRegion.html(null);
                $formGenerales.inputPlaza.html(null);
                $formGenerales.inputSucursal.html(null);

                if ($formGenerales.inputAsignado.val()) {
                    $.get(VAR_PATH_URL + "clientes/cliente/get-region",{ promotor_id : $formGenerales.inputAsignado.val() }, function(response){
                        if (response.code == 202) {

                            if (response.regionList.region)
                                $formGenerales.inputRegion.append(new Option(response.regionList.region.nombre, response.regionList.region.id));


                            if (response.regionList.plaza)
                                $formGenerales.inputPlaza.append(new Option(response.regionList.plaza.nombre, response.regionList.plaza.id));

                            if (response.regionList.sucursal)
                                $formGenerales.inputSucursal.append(new Option(response.regionList.sucursal.nombre, response.regionList.sucursal.id));

                        }
                    });
                }
            });

            $formActividadEconomica.inputTipoAcctividad.change(function(){
                $('.container-opcion-catalgo-actividad').hide();
                $('.container-opcion-otro-actividad').hide();
                if ($formActividadEconomica.inputTipoAcctividad.val() == ON)
                    $('.container-opcion-catalgo-actividad').show();

                if ($formActividadEconomica.inputTipoAcctividad.val() == OFF)
                    $('.container-opcion-otro-actividad').show();


            });

            $formPersonaPoliticamenteEx.inputSino.change(function(){

                $formPersonaPoliticamenteEx.inputPuestoCargo.attr("disabled", false);
                $formPersonaPoliticamenteEx.inputDependencia.attr("disabled", false);
                $formPersonaPoliticamenteEx.inputEjercicioCargo.attr("disabled", false);
                $formPersonaPoliticamenteEx.inputFechaSeparacion.attr("disabled", false);

                if ($formPersonaPoliticamenteEx.inputSino.val() == OFF) {
                    $formPersonaPoliticamenteEx.inputPuestoCargo.attr("disabled", true);
                    $formPersonaPoliticamenteEx.inputDependencia.attr("disabled", true);
                    $formPersonaPoliticamenteEx.inputEjercicioCargo.attr("disabled", true);
                    $formPersonaPoliticamenteEx.inputFechaSeparacion.attr("disabled", true);
                }

            })

            $formPersonaPoliticamenteEx.inputSinoCargo.change(function(){

                $('#fecha-separacion').hide();
                $formPersonaPoliticamenteEx.inputFechaSeparacion.val(null);

                if ($formPersonaPoliticamenteEx.inputSinoCargo.val() == OFF) {
                   $('#fecha-separacion').show();
                   $formPersonaPoliticamenteEx.inputFechaSeparacion.attr("disabled", false);
                }

            })


            $formPersonaPoliticamenteExOtro.inputSinoCargo.change(function(){

                $('#fecha-separacion-otro').hide();
                $formPersonaPoliticamenteExOtro.inputFechaSeparacion.val(null);

                if ($formPersonaPoliticamenteExOtro.inputSinoCargo.val() == OFF) {
                   $('#fecha-separacion-otro').show();
                   $formPersonaPoliticamenteExOtro.inputFechaSeparacion.attr("disabled", false);
                }

            })


        },

        onContentLoaded : function(event, currentIndex){
            console.log("entro en la carga");
        },

        onStepChanging: function (event, currentIndex, newIndex) {
            //Para validar antes de hacer un cambio entre secciones para bloquear el cambio solo es necesario return false

            if (newIndex === 1 )
            {

                show_loader();


                return funct_sendGenerales();

            }

            if (newIndex === 2) {

                show_loader();

                return funct_sendActividadOrigen();
            }

            if (newIndex === 3 ) {

                show_loader();

                return funct_sendRepresentanteLegal();
            }

            if (newIndex === 4 ) {
                show_loader();

                return funct_sendPropietarioReal();
            }

            if (newIndex === 5 ) {
                show_loader();

                return funct_sendPersonasPoliticasEx();
            }

            if (newIndex === 6 ) {
                show_loader();

                return funct_sendPerfilTransaccional();
            }

            function funct_sendGenerales(){

                if (valid_seccion(SECCION_GENERAL)) {
                    $.post(VAR_PATH_URL + "clientes/cliente/post-datos-general",{ clienteGeneralObject: clienteObject.generales}, function(response){
                        if (response["code"] == 202 ) {
                            clienteObject.generales.cliente_id          = response["cliente_id"];
                            clienteObject.actividadOrigen.cliente_id    = response["cliente_id"];


                            hide_loader();
                            //funct_refresh_title_tabs();
                            funct_get_info_seccion();

                        }else{
                            toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                            $.each(response["errors"], function(key, item_error){
                                toast("CLIENTE", item_error, "warning");
                            });
                            hide_loader();
                            $wizard.steps('previous');
                        }
                    });

                    return true;


                }else{

                    hide_loader();
                    $wizard.steps('previous');
                    return false;
                }
            }


            function funct_sendActividadOrigen(){

                if (valid_seccion(SECCION_ACTIORIG)) {
                    $.post(VAR_PATH_URL + "clientes/cliente/post-actividad-origen",{ clienteActividadObject: clienteObject.actividadOrigen}, function(response){
                        if (response["code"] == 202 ) {
                            clienteObject.generales.cliente_id = response["cliente_id"];
                            clienteObject.actividadOrigen.cliente_id = response["cliente_id"];
                            hide_loader();
                            //funct_refresh_title_tabs();
                            funct_get_info_seccion();

                        }else{
                            toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                            $.each(response["errors"], function(key, item_error){
                                toast("CLIENTE", item_error, "warning");
                            });
                            hide_loader();
                            $wizard.steps('previous');
                        }
                    });
                    return true;
                }else{

                    hide_loader();
                    return false;
                }
            }


            function funct_sendPropietarioReal(){


                    $.post(VAR_PATH_URL + "clientes/cliente/post-propietario-real",{ clientePropietarioRealbject: clienteObject.propietarios_reales, cliente_id:  clienteObject.generales.cliente_id }, function(response){
                        if (response["code"] == 202 ) {

                            hide_loader();
                            //funct_refresh_title_tabs();
                            funct_get_info_seccion();

                        }else{
                            toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                            $.each(response["errors"], function(key, item_error){
                                toast("CLIENTE", item_error, "warning");
                            });
                            hide_loader();
                            $wizard.steps('previous');
                        }
                    });
                    return true;

            }

            function funct_sendRepresentanteLegal(){


                    $.post(VAR_PATH_URL + "clientes/cliente/post-representante-legal",{ clienteRepresentanteLegalbject: clienteObject.representantes_legal, cliente_id:  clienteObject.generales.cliente_id }, function(response){
                        if (response["code"] == 202 ) {

                            hide_loader();
                            //funct_refresh_title_tabs();
                            funct_get_info_seccion();

                        }else{
                            toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                            $.each(response["errors"], function(key, item_error){
                                toast("CLIENTE", item_error, "warning");
                            });
                            hide_loader();
                            $wizard.steps('previous');
                        }
                    });
                    return true;

            }


            function funct_sendPersonasPoliticasEx(){

                $.post(VAR_PATH_URL + "clientes/cliente/post-personas-politicas-ex",{ clientePersonasPoliticamenteExObject: clienteObject.personasPoliticamenteEx, cliente_id:  clienteObject.generales.cliente_id }, function(response){
                    if (response["code"] == 202 ) {
                        hide_loader();
                        funct_get_info_seccion();
                    }else{
                        toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                        $.each(response["errors"], function(key, item_error){
                            toast("CLIENTE", item_error, "warning");
                        });
                        hide_loader();
                        $wizard.steps('previous');
                    }
                });
                return true;

            }

            function funct_sendPerfilTransaccional(){

                $.post(VAR_PATH_URL + "clientes/cliente/post-perfil-transaccional",{ clientePerfilTransaccionalObject: clienteObject.generales, cliente_id:  clienteObject.generales.cliente_id }, function(response){
                    if (response["code"] == 202 ) {
                        hide_loader();
                        funct_get_info_seccion();
                    }else{
                        toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                        $.each(response["errors"], function(key, item_error){
                            toast("CLIENTE", item_error, "warning");
                        });
                        hide_loader();
                        $wizard.steps('previous');
                    }
                });
                return true;

            }

         return true;
        },
        onStepChanged: function (event, currentIndex, priorIndex) {

        },
        onCanceled: function (event) {

        },
        onFinishing: function (event, currentIndex) {
            return true;
        },
        onFinished: function (event, currentIndex) {
            event.preventDefault();

            show_loader();

            $.post(VAR_PATH_URL + "clientes/cliente/post-expediente-digital",{ clienteExpedienteObject: clienteObject.expedienteDigital }, function(response){
                if (response["code"] == 202 ) {
                    hide_loader();

                    toast("CLIENTE", "SE REGISTRO CORRECTAMENTE LA INFORMACION", "success");

                    window.location.href = VAR_PATH_URL + "clientes/cliente/view?id=" + clienteObject.generales.cliente_id;
                }else{
                    toast("CLIENTE", "Ocurrion un error, intenta nuevamente", "warning");
                    $.each(response["errors"], function(key, item_error){
                        toast("CLIENTE", item_error, "warning");
                    });
                    hide_loader();
                }
            });
        },

        labels: {
          finish: "GUARDAR Y SALIR",
          next: "GUARDAR Y CONTINUAR",
          previous: "ATRAS",
          cancel: "No"
        }
    });

});


var funct_documento = function($tipo_documento){
    DOCUMENTO_TIPO_LOAD = $tipo_documento;
}

var funct_renderPersonGrupoRiesgo = function(){
    $('.container-items-grupo').html(false);
    if ($formGenerales.inputGrupoRiesgoId.val()) {
        $.get( VAR_PATH_URL + "clientes/cliente/get-person-grupo-riesgo", { grupo_riesgo_id : $formGenerales.inputGrupoRiesgoId.val() }, function(response){
            if ( response.code == 202 ) {
                containerHtmlPerson = "";
                $.each(response.persons, function(key, item_person){
                    containerHtmlPerson += '<li>'+
                        '<a href="javascript:void(0)"><i class="fa fa-circle"></i> '+ item_person +'</a>'+
                    '</li>';
                });
                $('.container-items-grupo').html(containerHtmlPerson);
            }
        });
    }
}

var funct_get_info_seccion = function(){
    if (clienteObject.generales.cliente_id) {
        $.get( VAR_PATH_URL + "clientes/cliente/get-cliente-detail",{ cliente_id : clienteObject.generales.cliente_id }, function(responseClienteObject){
            if (responseClienteObject.code == 202) {
                clienteObject.generales.asignado_id             = responseClienteObject.cliente.asignado_id;
                clienteObject.generales.asignado_text           = responseClienteObject.cliente.asignado_text;
                clienteObject.generales.uidx                    = responseClienteObject.cliente.uidx;
                clienteObject.generales.razon_social            = responseClienteObject.cliente.razon_social;
                //clienteObject.generales.nacionalidad            = responseClienteObject.cliente.nacionalidad;
                clienteObject.generales.fecha_constitucion      = responseClienteObject.cliente.fecha_constitucion;
                clienteObject.generales.numero_constitucion    = responseClienteObject.cliente.numero_constitucion;
                clienteObject.generales.pais_constitucion       = responseClienteObject.cliente.pais_constitucion;
                clienteObject.generales.pais_que_emite       = responseClienteObject.cliente.pais_que_emite;
                clienteObject.generales.grupo_riesgo_id    = responseClienteObject.cliente.grupo_riesgo_id;
                clienteObject.generales.fecha_integracion   = responseClienteObject.cliente.fecha_integracion;
                clienteObject.generales.rfc             = responseClienteObject.cliente.rfc;
                clienteObject.generales.telefonos       = responseClienteObject.cliente.telefonos;
                clienteObject.generales.direcciones     = responseClienteObject.cliente.direcciones;
                clienteObject.generales.bancos          = responseClienteObject.cliente.bancos;
                clienteObject.propietarios_reales       = responseClienteObject.cliente.propietarios_reales;
                clienteObject.representantes_legal       = responseClienteObject.cliente.representantes_legal;
                clienteObject.expedienteDigital         = responseClienteObject.cliente.expedienteDigital;
                clienteObject.personasPoliticamenteEx   = responseClienteObject.cliente.personasPoliticamenteEx;
                clienteObject.perfilTransaccional       = responseClienteObject.cliente.perfilTransaccional;
                clienteObject.perfilTransaccionalPa       = responseClienteObject.cliente.perfilTransaccionalPa;
                clienteObject.creditos                      = responseClienteObject.cliente.creditos;
                clienteObject.historico                      = responseClienteObject.cliente.historico;


                clienteObject.actividadOrigen.cliente_id                = responseClienteObject.cliente.id;
                clienteObject.actividadOrigen.precise_giro_actividad    = responseClienteObject.cliente.precise_giro_actividad;
                clienteObject.actividadOrigen.empleado                  = responseClienteObject.cliente.empleado;
                clienteObject.actividadOrigen.puesto_que_responde       = responseClienteObject.cliente.puesto_que_responde;
                clienteObject.actividadOrigen.factura_dolares           = responseClienteObject.cliente.factura_dolares;
                clienteObject.actividadOrigen.origen_recurso            = responseClienteObject.cliente.origen_recurso;
                clienteObject.actividadOrigen.riesgo                    = responseClienteObject.cliente.riesgo;
                clienteObject.actividadOrigen.destino_credito           = responseClienteObject.cliente.destino_credito;
                clienteObject.actividadOrigen.participacionCredito      = responseClienteObject.cliente.participacionCredito;
                clienteObject.actividadOrigen.producto                  = responseClienteObject.cliente.producto;
                clienteObject.actividadOrigen.producto_text             = responseClienteObject.cliente.producto_text;
                clienteObject.actividadOrigen.ingresos_mensuales        = responseClienteObject.cliente.ingresos_mensuales;
                clienteObject.actividadOrigen.egresos_mensuales         = responseClienteObject.cliente.egresos_mensuales;
                clienteObject.actividadOrigen.apply_otros_ingresos      = responseClienteObject.cliente.apply_otros_ingresos;
                clienteObject.actividadOrigen.fuente_otros_ingresos     = responseClienteObject.cliente.fuente_otros_ingresos;
                clienteObject.actividadOrigen.monto_fuentes_ingresos    = responseClienteObject.cliente.monto_fuentes_ingresos;

                //$formActividadOrigen.inputPreciseGiroActividad.val(clienteObject.actividadOrigen.precise_giro_actividad);
                $formActividadOrigen.inputEmpleado.val(clienteObject.actividadOrigen.empleado);
                $formActividadOrigen.inputPuesto.val(clienteObject.actividadOrigen.puesto_que_responde);
                $formActividadOrigen.inputFacturaDolares.val(clienteObject.actividadOrigen.factura_dolares);
                $formActividadOrigen.inputOrigenRecurso.val(clienteObject.actividadOrigen.origen_recurso);
                $formActividadOrigen.inputRiesgo.val(clienteObject.actividadOrigen.riesgo);
                $formActividadOrigen.inputDestinoCredito.val(clienteObject.actividadOrigen.destino_credito);
                $formActividadOrigen.inputParticipacionCredito.val(clienteObject.actividadOrigen.participacionCredito);
                //$formActividadOrigen.inputProducto.val(clienteObject.actividadOrigen.producto);
                $formActividadOrigen.inputIngresoMensuales.val(btf.conta.miles(clienteObject.actividadOrigen.ingresos_mensuales));
                $formActividadOrigen.inputEgresosMensuales.val(btf.conta.miles(clienteObject.actividadOrigen.egresos_mensuales));
                $formActividadOrigen.inputFuenteOtrosIngresos.val(clienteObject.actividadOrigen.fuente_otros_ingresos);
                $formActividadOrigen.inputMontoFuentesIngreso.val(btf.conta.miles(clienteObject.actividadOrigen.monto_fuentes_ingresos));



                $formGenerales.inputUidx.val(clienteObject.generales.uidx);
                $formGenerales.inputRazonSocial.val(clienteObject.generales.razon_social);
                $formGenerales.inputFechaIntegracion.val(clienteObject.generales.fecha_integracion);
                //$formGenerales.inputNacionalidad.val(clienteObject.generales.nacionalidad);
                $formGenerales.inputRfc.val(clienteObject.generales.rfc);
                $formGenerales.inputFechaConstitucion.val(clienteObject.generales.fecha_constitucion);
                $formGenerales.inputNumeroConstitucion.val(clienteObject.generales.numero_constitucion);
                $formGenerales.inputPaisConstitucion.val(clienteObject.generales.pais_constitucion);
                $formGenerales.inputGrupoRiesgoId.val(clienteObject.generales.grupo_riesgo_id);


                if (clienteObject.generales.asignado_id) {
                    var newOption       = new Option(clienteObject.generales.asignado_text, clienteObject.generales.asignado_id, false, true);
                    $formGenerales.inputAsignado.append(newOption).trigger('change');
                }

                if (clienteObject.actividadOrigen.producto) {
                    var newOption       = new Option(clienteObject.actividadOrigen.producto_text, clienteObject.actividadOrigen.producto, false, true);
                    $formActividadOrigen.inputProducto.append(newOption).trigger('change');

                }

                if (clienteObject.actividadOrigen.apply_otros_ingresos == ON)
                    $formActividadOrigen.inputAplicaOtrosIngresos.prop('checked', true);



                render_telefono();
                render_actividad();
                render_direccion();
                render_banco();
                render_perfil_transaccional();
                render_personas_politicamente_ex();
                funct_renderPersonGrupoRiesgo();
                render_propietarios_reales();
                render_representante_legal();
                render_documentacion();

                $('.lbl_sistema_id').html(clienteObject.generales.cliente_id);
                $('.lbl_number_interno').html(clienteObject.generales.uidx ? clienteObject.generales.uidx : 'N/A');
                $('.lbl_nombre_cliente').html(clienteObject.generales.razon_social);
                $('.lbl_rfc_cliente').html(clienteObject.generales.rfc);


                $formActividadOrigen.inputIngresoMensuales.mask('000,000,000,000,000.00', {reverse: true});
                $formActividadOrigen.inputEgresosMensuales.mask('000,000,000,000,000.00', {reverse: true});
                $formActividadOrigen.inputMontoFuentesIngreso.mask('000,000,000,000,000.00', {reverse: true});
                $formPerfilTransaccional.inputMontoPago.mask('000,000,000,000,000.00', {reverse: true});
                $formPerfilTransaccionalOtro.inputMontoPago.mask('000,000,000,000,000.00', {reverse: true});
                
                if ($formActividadOrigen.inputAplicaOtrosIngresos.is(':checked')) {
                    $formActividadOrigen.inputFuenteOtrosIngresos.attr("disabled", false);
                    $formActividadOrigen.inputMontoFuentesIngreso.attr("disabled", false);
                }else{
                    $formActividadOrigen.inputFuenteOtrosIngresos.val(null).attr("disabled", true).trigger('change');
                    $formActividadOrigen.inputMontoFuentesIngreso.val(null).attr("disabled", true).trigger('change');
                }
            }
        });
    }
}

var valid_seccion = function(seccion)
{
    switch(parseInt(seccion)){
        case SECCION_GENERAL:

            is_valid = true;

            if(!$formGenerales.inputRazonSocial.val()){
                toast("CLIENTE", "El campo razon social es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }

            /*if(!$formGenerales.inputNacionalidad.val()){
                toast("CLIENTE", "El campo  pais de nacimiento es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }*/

            if(!$formGenerales.inputFechaConstitucion.val()){
                toast("CLIENTE", "El campo  fecha de constitucion es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }

            if(!$formGenerales.inputNumeroConstitucion.val()){
                toast("CLIENTE", "El campo  numero de constitucion es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }

            if(!$formGenerales.inputFechaIntegracion.val()){
                toast("CLIENTE", "El campo  Fecha de entrevista es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }

            if(!$formGenerales.inputPaisConstitucion.val()){
                toast("CLIENTE", "El campo  pais de constitucion es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }

            if(!$formGenerales.inputRfc.val()){
                toast("CLIENTE", "El campo  rfc es requerido, intenta nuevamente", "warning");
                is_valid = false;
            }

            return is_valid;

        break;

        case SECCION_ACTIORIG:

            is_valid = true;
                if(!$formActividadOrigen.inputEmpleado.val()){
                    toast("CLIENTE", "El campo empleado es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formActividadOrigen.inputPuesto.val()){
                    toast("CLIENTE", "El campo  puesto paterno es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formActividadOrigen.inputFacturaDolares.val()){
                    toast("CLIENTE", "El campo  factura en dolares materno es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formActividadOrigen.inputOrigenRecurso.val()){
                    toast("CLIENTE", "El campo  origen recurso es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formActividadOrigen.inputDestinoCredito.val()){
                    toast("CLIENTE", "El campo  destino credito de nacimiento es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formActividadOrigen.inputProducto.val()){
                    toast("CLIENTE", "El campo  producto es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }

                if(!$formActividadOrigen.inputIngresoMensuales.val()){
                    toast("CLIENTE", "El campo  ingreso mensuales de nacimiento es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }

                if(!$formActividadOrigen.inputEgresosMensuales.val()){
                    toast("CLIENTE", "El campo  egresos mensuales requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }

                return is_valid;

        break;
    }

}

/*function funct_refresh_title_tabs()
{

    $tabs = $('.wizard > .steps  a');

    if (clienteObject.generales.cliente_id) {

        $.each($tabs, function(key, item_tabs){
            template = $(item_tabs).html();
            $(item_tabs).html( template.replace("{{}}", "[ ID: "+clienteObject.generales.cliente_id) +" ]");
        })
    }
}*/


var clear_direccion = function(){
    $formDireccion.inputCategoria.val(null);
    $formDireccion.inputEstado.val(null);
    $formDireccion.inputMunicipio.val(null);
    $formDireccion.inputCuidad.val(null);
    $formDireccion.inputColonia.val(null);
    $formDireccion.inputCodigoSearch.val(null);
    $formDireccion.inputDireccion.val(null);
    $formDireccion.inputNumeroExt.val(null);
    $formDireccion.inputNumeroInt.val(null);
    $formDireccion.inputAntiguedad.val(null);
    $formDireccion.inputReferencia.val(null);
}


var clear_telefono = function(){
    $formTelefono.inputPertenece.val(null);
    $formTelefono.inputPais.val(null);
    $formTelefono.inputNumero.val(null);
    $formTelefono.inputExtension.val(null);
    $formTelefono.inputCodigo.val(null);
}

var clear_actividad = function(){
    $formActividadEconomica.inputTipoAcctividad.val(null);
    $formActividadEconomica.inputOtroClaveActividad.val(null);
    $formActividadEconomica.inputOtroActividadEconomica.val(null);
    $formActividadEconomica.actividadEconomicaID.val(null);
    $('.container-opcion-catalgo-actividad').hide();
    $('.container-opcion-otro-actividad').hide();
}

var clear_propietarios_reales = function(){
    $formPropietariosReales.inputNombre.val(null);
    $formPropietariosReales.inputSegundoNombre.val(null);
    $formPropietariosReales.inputApellidoPaterno.val(null);
    $formPropietariosReales.inputApellidoMaterno.val(null);
    $formPropietariosReales.inputFechaNacimiento.val(null);
    $formPropietariosReales.inputNacionalidad.val(null);
    $formPropietariosReales.inputEntidadFederativaOtro.val(null);
    $formPropietariosReales.inputEntidadFederativaMx.val(null);
    $formPropietariosReales.inputTenencia.val(null);
    $formPropietariosReales.inputEjerceControl.val(null);
}

var clear_representante_legal = function(){
    $formRepresentantesLegales.inputNombre.val(null);
    $formRepresentantesLegales.inputSegundoNombre.val(null);
    $formRepresentantesLegales.inputApellidoPaterno.val(null);
    $formRepresentantesLegales.inputApellidoMaterno.val(null);
    $formRepresentantesLegales.inputFechaNacimiento.val(null);
    $formRepresentantesLegales.inputNacionalidad.val(null);
    $formRepresentantesLegales.inputEntidadFederativaOtro.val(null);
    $formRepresentantesLegales.inputEntidadFederativaMx.val(null);
}

var clear_personas_politicamente_ex = function(){
    $formPersonaPoliticamenteEx.inputSino.val(null);
    $formPersonaPoliticamenteEx.inputPuestoCargo.val(null);
    $formPersonaPoliticamenteEx.inputDependencia.val(null);
    $formPersonaPoliticamenteEx.inputEjercicioCargo.val(null);
    $formPersonaPoliticamenteEx.inputSinoCargo.val(null);
    $formPersonaPoliticamenteEx.inputFechaSeparacion.val(null);
}


var clear_personas_politicamente_ex_otro = function(){
    $formPersonaPoliticamenteExOtro.inputSino.val(null);
    $formPersonaPoliticamenteExOtro.inputPuestoCargo.val(null);
    $formPersonaPoliticamenteExOtro.inputDependencia.val(null);
    $formPersonaPoliticamenteExOtro.inputEjercicioCargo.val(null);
    $formPersonaPoliticamenteExOtro.inputFechaSeparacion.val(null);
    $formPersonaPoliticamenteExOtro.inputFechaSeparacion.val(null);
}



var clear_perfil_transaccional = function(){
    $formPerfilTransaccional.inputCredito.val(null);
    $formPerfilTransaccional.inputFrecuencia.val(null);
    $formPerfilTransaccional.inputOperacionesMin.val(null);
    $formPerfilTransaccional.inputOperacionesMax.val(null);
    $formPerfilTransaccional.inputMontoPago.val(null);
    $formPerfilTransaccional.inputInstrumento.val(null);
    $formPerfilTransaccional.inputMoneda.val(null);
}

var clear_perfil_transaccional_otro = function(){
    $formPerfilTransaccionalOtro.inputCredito.val(null);
    $formPerfilTransaccionalOtro.inputFrecuencia.val(null);
    $formPerfilTransaccionalOtro.inputOperacionesMin.val(null);
    $formPerfilTransaccionalOtro.inputOperacionesMax.val(null);
    $formPerfilTransaccionalOtro.inputMontoPago.val(null);
    $formPerfilTransaccionalOtro.inputInstrumento.val(null);
    $formPerfilTransaccionalOtro.inputMoneda.val(null);
}


var clear_banco = function(){
    $formBanco.inputCuentaInterbancaria.val(null);
    $formBanco.lblBancoText.html('------');
}


var valid_exist_telefono = function(pertenece_id){

    search_existTelefono = false;
    $.each(clienteObject.generales.telefonos, function(key_telefono, item_telefono){
        if (pertenece_id == item_telefono.pertenece) {
            search_existTelefono = true;
        }
    })

    if (search_existTelefono) {
        if (confirm("SE INGRESARA COMO PRINCIPAL, DESEAS CONTINUAR")) {
            $.each(clienteObject.generales.telefonos, function(key_telefono, item_telefono){
                if (pertenece_id == item_telefono.pertenece) {
                    clienteObject.generales.telefonos[key_telefono].apply_principal = OFF;
                }
            });

            return true;
        }
        return false;
    }

    return true;
}

var valid_exist_direccion = function(tipo){

    search_existDireccion = false;
    $.each(clienteObject.generales.direcciones, function(key_direccion, item_direccion){
        if (tipo == item_direccion.tipo) {
            search_existDireccion = true;
        }
    })

    if (search_existDireccion) {
        if (confirm("SE INGRESARA COMO PRINCIPAL, DESEAS CONTINUAR")) {
            $.each(clienteObject.generales.direcciones, function(key_direccion, item_direccion){
                if (tipo == item_direccion.tipo) {
                    clienteObject.generales.direcciones[key_direccion].apply_principal = OFF;
                }
            });

            return true;
        }
        return false;
    }

    return true;
}



var valid_add_direccion = function(){

    if (!$formDireccion.inputPais.val()) {
        toast("CLIENTE", "Debes seleccionar una pais, intenta nuevamente", "warning");
        return false;
    }

    if (!$formDireccion.inputCategoria.val()) {
        toast("CLIENTE", "Debes seleccionar una categoria, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formDireccion.inputEstado.val() ) {
        toast("CLIENTE", "Debes seleccionar un estado, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formDireccion.inputMunicipio.val() ) {
        toast("CLIENTE", "Debes seleccionar un municipio, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formDireccion.inputColonia.val() ) {
        toast("CLIENTE", "Debes seleccionar una colonia, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formDireccion.inputDireccion.val() ) {
        toast("CLIENTE", "Debes seleccionar una direccion, intenta nuevamente", "warning");
        return false;
    }
    if ( !$formDireccion.inputAntiguedad.val() ) {
        toast("CLIENTE", "Debes ingrear la antiguedad, intenta nuevamente", "warning");
        return false;
    }


    return true;

}

var valid_add_telefono = function(){

    if (!$formTelefono.inputPertenece.val()) {
        toast("CLIENTE", "Debes seleccionar pertenece, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formTelefono.inputPais.val() ) {
        toast("CLIENTE", "Debes seleccionar un pais, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formTelefono.inputNumero.val() ) {
        toast("CLIENTE", "Debes ingresar un numero telefonico, intenta nuevamente", "warning");
        return false;
    }

    if ( $formTelefono.inputNumero.val().length < 10 || $formTelefono.inputNumero.val().length > 15  ) {
        toast("CLIENTE", "El numero telefonico debe ser a 10-15 digitos, intenta nuevamente", "warning");
        return false;
    }

    return true;
}

var valid_actividas_economica = function(){

    if ( !$formActividadEconomica.inputTipoAcctividad.val() ) {
        toast("CLIENTE", "Debes seleccionar tipo actividad economica, intenta nuevamente", "warning");
        return false;
    }

    if ($formActividadEconomica.inputTipoAcctividad.val() == ON) {
        if ( !$formActividadEconomica.actividadEconomicaID.val() ) {
            toast("CLIENTE", "Debes seleccionar actividad economica, intenta nuevamente", "warning");
            return false;
        }
    }

    if ($formActividadEconomica.inputTipoAcctividad.val() == OFF) {
        if ( !$formActividadEconomica.inputOtroClaveActividad.val() ) {
            toast("CLIENTE", "La clave es requerida, intenta nuevamente", "warning");
            return false;
        }

        if ( !$formActividadEconomica.inputOtroActividadEconomica.val() ) {
            toast("CLIENTE", "El nombre de actividad economica es requerido, intenta nuevamente", "warning");
            return false;
        }
    }


    return true;
}

var valid_add_propietarios_reales = function(){

    if (!$formPropietariosReales.inputNombre.val()) {
        toast("CLIENTE", "El campo nombre es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPropietariosReales.inputFechaNacimiento.val() ) {
        toast("CLIENTE", "El campo Fecha de nacimiento es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPropietariosReales.inputNacionalidad.val() ) {
        toast("CLIENTE", "El campo nacionalidad es requerido, intenta nuevamente", "warning");
        return false;
    }

    return true;
}

var valid_add_representantes_legal = function(){

    if (!$formRepresentantesLegales.inputNombre.val()) {
        toast("CLIENTE", "El campo nombre es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formRepresentantesLegales.inputFechaNacimiento.val() ) {
        toast("CLIENTE", "El campo Fecha de nacimiento es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formRepresentantesLegales.inputNacionalidad.val() ) {
        toast("CLIENTE", "El campo nacionalidad es requerido, intenta nuevamente", "warning");
        return false;
    }

    return true;
}

var valid_add_personas_politicamente_expuesta = function(){

    if (!$formPersonaPoliticamenteEx.inputSino.val()) {
        toast("CLIENTE", "El campo Si/No es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ($formPersonaPoliticamenteEx.inputSino.val() == 10) {

        if ( !$formPersonaPoliticamenteEx.inputPuestoCargo.val() ) {
            toast("CLIENTE", "El campo Puesto Cargo es requerido, intenta nuevamente", "warning");
            return false;
        }

        if ( !$formPersonaPoliticamenteEx.inputDependencia.val() ) {
            toast("CLIENTE", "El campo dependencia es requerido, intenta nuevamente", "warning");
            return false;
        }


        if ( !$formPersonaPoliticamenteEx.inputEjercicioCargo.val() ) {
            toast2("CLIENTE", "El campo ejercicio cargo es requerido, intenta nuevamente", "warning");
            return false;
        }

        if ($formPersonaPoliticamenteEx.inputSinoCargo.val() == 20) {
            if ( !$formPersonaPoliticamenteEx.inputFechaSeparacion.val() ) {
                toast2("CLIENTE", "El campo fecha de separacion es requerido, intenta nuevamente", "warning");
                return false;
            }
        }


    }



    return true;
}


var valid_add_personas_politicamente_expuesta_otro = function(){

    if (!$formPersonaPoliticamenteExOtro.inputSino.val()) {
        toast("CLIENTE", "El campo Si/No es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ($formPersonaPoliticamenteExOtro.inputSino.val() == 10) {

        if ( !$formPersonaPoliticamenteExOtro.inputPuestoCargo.val() ) {
            toast("CLIENTE", "El campo Puesto Cargo es requerido, intenta nuevamente", "warning");
            return false;
        }

        if ( !$formPersonaPoliticamenteExOtro.inputDependencia.val() ) {
            toast("CLIENTE", "El campo dependencia es requerido, intenta nuevamente", "warning");
            return false;
        }


        if ($formPersonaPoliticamenteExOtro.inputSinoCargo.val() == 20) {
            if ( !$formPersonaPoliticamenteExOtro.inputFechaSeparacion.val() ) {
                toast2("CLIENTE", "El campo fecha de separacion es requerido, intenta nuevamente", "warning");
                return false;
            }
    
        }
    }




    return true;
}

var valid_add_perfil_transaccional = function(){

    if (!$formPerfilTransaccional.inputCredito.val()) {
        toast("CLIENTE", "El campo CREDITO es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccional.inputFrecuencia.val() ) {
        toast("CLIENTE", "El campo FRECUENCIA es requerido, intenta nuevamente", "warning");
        return false;
    }


    if ( !$formPerfilTransaccional.inputOperacionesMin.val() ) {
        toast2("CLIENTE", "El campo 'NUMERO DE OPERACIONES MINIMAS' es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccional.inputOperacionesMax.val() ) {
        toast2("CLIENTE", "El campo 'NUMERO DE OPERACIONES MAXIMAS' es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccional.inputMontoPago.val() ) {
        toast("CLIENTE", "El campo MONTO PAGO es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccional.inputInstrumento.val() ) {
        toast2("CLIENTE", "El campo INSTRUMENTO es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccional.inputMoneda.val() ) {
        toast2("CLIENTE", "El campo MONEDA es requerido, intenta nuevamente", "warning");
        return false;
    }



    return true;
}

var valid_add_perfil_transaccional_otro = function(){

    if (!$formPerfilTransaccionalOtro.inputCredito.val()) {
        toast("CLIENTE", "El campo CREDITO es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccionalOtro.inputFrecuencia.val() ) {
        toast("CLIENTE", "El campo FRECUENCIA es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccionalOtro.inputOperacionesMin.val() ) {
        toast2("CLIENTE", "El campo 'NUMERO DE OPERACIONES MINIMAS' es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccionalOtro.inputOperacionesMax.val() ) {
        toast2("CLIENTE", "El campo 'NUMERO DE OPERACIONES MAXIMAS' es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ( !$formPerfilTransaccionalOtro.inputMontoPago.val() ) {
        toast("CLIENTE", "El campo MONTO PAGO es requerido, intenta nuevamente", "warning");
        return false;
    }
    if ( !$formPerfilTransaccionalOtro.inputInstrumento.val() ) {
        toast2("CLIENTE", "El campo Instrumento es requerido, intenta nuevamente", "warning");
        return false;
    }
    if ( !$formPerfilTransaccionalOtro.inputMoneda.val() ) {
        toast2("CLIENTE", "El campo MONEDA es requerido, intenta nuevamente", "warning");
        return false;
    }



    return true;
}


var valid_add_banco = function(){

    if (!$formBanco.inputCuentaInterbancaria.val()) {
        toast("CLIENTE", "El campo cuenta interbancaria es requerido, intenta nuevamente", "warning");
        return false;
    }

    if ($formBanco.inputCuentaInterbancaria.val()) {
        if ($formBanco.inputCuentaInterbancaria.val().length != 18) {
            toast("CLIENTE", "La cuenta interbancaria debe ser de 18 caracteres, intenta nuevamente", "warning");
            return false;
        }
    }

    return true;
}

var functInputCondiccionTab3 = function()
{

    $('.tab_nacionalidad_mx').hide();
    $('.tab_nacioanlidad_otro').show();

    if ($('option:selected', $formRepresentantesLegales.inputNacionalidad ).text() === 'MÉXICO') {
        $('.tab_nacionalidad_mx').show();
        $('.tab_nacioanlidad_otro').hide();
        $formPropietariosReales.inputEntidadFederativaMx.val(null);
    }
}


var functInputCondiccionTab4 = function()
{

    $('.nacionalidad_mx').hide();
    $('.nacioanlidad_otro').show();

    if ($('option:selected', $formPropietariosReales.inputNacionalidad ).text() === 'MÉXICO') {
        $('.nacionalidad_mx').show();
        $('.nacioanlidad_otro').hide();
        $formPropietariosReales.inputEntidadFederativaMx.val(null);
    }
}


var toast = function(title, message, tipo){
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 5000
    };

    if (tipo == 'warning')
        toastr.warning(message, title);

    if (tipo == 'success')
        toastr.success(message, title);

    if (tipo == 'danger')
        toastr.error(message, title);
}

var render_documentacion = function(){

    $('.container-imagen-files').html(null);

    $.each(clienteObject.expedienteDigital, function(key, item_file){

        if (item_file.delete == OFF) {
            contentItem = '<div  style="height: 50px;display: inline-block;padding: 10px;">'+
                        '<div  style="height: 100%;">'+
                            '<span class="corner"></span>';
                            contentItem += '<div class="image"><i class="fa fa-file-image-o" style="font-size: 24px;"></i></div>';
                            contentItem +='<p><strong>EXPEDIENTE DIGITIAL</strong></p>'+
                                '<a  href="' + ( item_file.create == OFF ? ( VAR_PATH_URL +'cliente/documentacion/' + item_file.name_new ): ( VAR_PATH_URL + 'cliente/temp/' + item_file.name_new +'.'+ item_file.extension ) ) + '" class="btn btn-success btn-xs btn-circle float-right" target="_blank"><i class="fa fa-eye" style="color: #fff;"></i></a>';
                                if (item_file.create == ON )
                                    contentItem +='<button onclick="drop_file('+ item_file.element_id +')" class="btn btn-warning btn-xs btn-circle float-right"><i class="fa fa-trash" style="color: #fff;"></i></button>';

                                if (item_file.create == OFF )
                                    contentItem +='<button onclick="baja_file('+ item_file.element_id +')" class="btn btn-warning btn-xs btn-circle float-right"><i class="fa fa-trash" style="color: #fff;"></i></button>';

                                contentItem +='<small>REGISTRO: '+ item_file.fecha +'</small>'+
                                '<p><strong>VIGENCIA: <input type="date"  min="'+ item_file.fecha +'" class="form-control" onchange="funct_refreshFechaExpira('+ item_file.element_id +', this)"  style="'+ ( item_file.fecha_vigencia ?  '' : 'border-color: #c30909; border-width: 1px;')+'"  value='+ (item_file.fecha_vigencia ? item_file.fecha_vigencia : '' ) +'></strong></p>'+
                                 (item_file.fecha_vigencia ? '' : ' <div class="invalid-feedback" style="display: block;">* LA FECHA DE VIGENCIA ES REQUERIDO</div>' ) +
                                '</div>'+
                        '</div>'+
                    '</div>';

            $('.container-imagen-' + item_file.pertenece).append(contentItem);
        }
    });
}


var render_direccion = function(){
    $containerDirecciones.html(false);
    containerDireccionHtml = '';
    $.each(clienteObject.generales.direcciones, function(key, item_direccion){
        containerDireccionHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.tipo_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.cp +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.estado_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.municipio_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.cuidad_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.colonia_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.direccion +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.n_ext +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.n_int +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.referencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_direccion.antiguedad +'</p></td>'+
            '<td class="text-center '+ (item_direccion.status == DIRECCION_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_direccion.status == DIRECCION_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p>'+  (item_direccion.apply_principal == ON ? '<small class="bg-primary p-xs b-r-xl">PRINCIPAL</small>': '')  +'</td>';

            if (item_direccion.status == DIRECCION_ACTIVO && item_direccion.create == ON )
                containerDireccionHtml += '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_direccion('+ item_direccion.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_direccion.status == DIRECCION_ACTIVO && item_direccion.create == OFF )
                containerDireccionHtml += '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_direccion('+ item_direccion.element_id +')"><i class="fa  fa-level-down"></i></button></td>';

            if (item_direccion.status == DIRECCION_BAJA  )
                containerDireccionHtml +=  '<td  class="text-center"></td>';

        containerDireccionHtml += '</tr>';
    });

    $containerDirecciones.html(containerDireccionHtml);
}

var render_banco = function(){
    $containerBanco.html(false);
    containerBancoHtml = '';
    $.each(clienteObject.generales.bancos, function(key, item_banco){
        containerBancoHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_banco.clave_interbancaria +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_banco.clave_banco +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_banco.banco +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_banco.razon_social +'</p></td>'+
            '<td class="text-center '+ (item_banco.status == BANCO_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_banco.status == BANCO_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_banco.status == BANCO_ACTIVO && item_banco.create == ON )
                containerBancoHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_banco('+ item_banco.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_banco.status == BANCO_ACTIVO && item_banco.create == OFF )
                containerBancoHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_banco('+ item_banco.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_banco.status == BANCO_BAJA  )
                containerBancoHtml +=  '<td  class="text-center"></td>';

        containerBancoHtml += '</tr>';
    });

    $containerBanco.html(containerBancoHtml);
}

var render_telefono = function(){
    $containerTelefono.html(false);
    containerTelefonoHtml = '';
    $.each(clienteObject.generales.telefonos, function(key, item_telefono){
        containerTelefonoHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_telefono.pertenece_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_telefono.pais_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_telefono.codigo +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_telefono.numero +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_telefono.extension +'</p></td>'+
            '<td class="text-center '+ (item_telefono.status == TELEFONO_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_telefono.status == TELEFONO_ACTIVO ? 'ACTIVO': 'INACTIVO')    +'</p>'+  (item_telefono.apply_principal == ON ? '<small class="bg-primary p-xs b-r-xl">PRINCIPAL</small>': '')  +'</td>';
            if (item_telefono.status == TELEFONO_ACTIVO && item_telefono.create == ON )
                containerTelefonoHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_telefono('+ item_telefono.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_telefono.status == TELEFONO_ACTIVO && item_telefono.create == OFF )
                containerTelefonoHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_telefono('+ item_telefono.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_telefono.status == TELEFONO_BAJA  )
                containerTelefonoHtml +=  '<td  class="text-center"></td>';

        containerTelefonoHtml += '</tr>';
    });

    $containerTelefono.html(containerTelefonoHtml);
}


var render_actividad = function(){
    $containerActividad.html(false);
    containerActividadHtml = '';
    $.each(clienteObject.actividadOrigen.precise_giro_actividad, function(key, item_actividad){
        containerActividadHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_actividad.tipo_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ ( item_actividad.tipo == ON ? item_actividad.producto_text  : item_actividad.otro_producto_text + '['+ item_actividad.otro_clave+']' ) +'</p></td>'+
            '<td class="text-center '+ (item_actividad.status == ACTIVIDAD_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_actividad.status == ACTIVIDAD_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_actividad.status == ACTIVIDAD_ACTIVO && item_actividad.create == ON )
                containerActividadHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_actividad('+ item_actividad.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_actividad.status == ACTIVIDAD_ACTIVO && item_actividad.create == OFF )
                containerActividadHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_actividad('+ item_actividad.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_actividad.status == ACTIVIDAD_BAJA  )
                containerActividadHtml +=  '<td  class="text-center"></td>';

        containerActividadHtml += '</tr>';
    });

    $containerActividad.html(containerActividadHtml);
}


var render_propietarios_reales = function(){
    $containerPropietariosReal.html(false);
    containerPropietarioRealHtml = '';
    $.each(clienteObject.propietarios_reales, function(key, item_propietarios_reales){
        containerPropietarioRealHtml += '<tr>'+

            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.nombre +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.segundo_nombre +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.apellido_paterno +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.apellido_materno +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.fecha_nacimiento +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.nacionalidad_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.entidad_federativa_nacimiento +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.tenencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_propietarios_reales.ejerce_control_text +'</p></td>'+
            '<td class="text-center '+ (item_propietarios_reales.status == PROPETARIOS_REALES_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_propietarios_reales.status == PROPETARIOS_REALES_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_propietarios_reales.status == PROPETARIOS_REALES_ACTIVO && item_propietarios_reales.create == ON )
                containerPropietarioRealHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_propietario_real('+ item_propietarios_reales.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_propietarios_reales.status == PROPETARIOS_REALES_ACTIVO && item_propietarios_reales.create == OFF )
                containerPropietarioRealHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_propietario_real('+ item_propietarios_reales.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_propietarios_reales.status == PROPETARIOS_REALES_BAJA  )
                containerPropietarioRealHtml +=  '<td  class="text-center"></td>';

        containerPropietarioRealHtml += '</tr>';
    });

    $containerPropietariosReal.html(containerPropietarioRealHtml);
}

var render_representante_legal = function(){
    $containerRepresentantesLegales.html(false);
    containerRepresentantesLegalesHtml = '';
    $.each(clienteObject.representantes_legal, function(key, item_representante_legal){
        containerRepresentantesLegalesHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.nombre +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.segundo_nombre +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.apellido_paterno +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.apellido_materno +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.fecha_nacimiento +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.nacionalidad_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_representante_legal.entidad_federativa_nacimiento +'</p></td>'+
            '<td class="text-center '+ (item_representante_legal.status == REPRESENTANTES_LEGAL_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_representante_legal.status == REPRESENTANTES_LEGAL_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_representante_legal.status == REPRESENTANTES_LEGAL_ACTIVO && item_representante_legal.create == ON )
                containerRepresentantesLegalesHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_propietario_real('+ item_representante_legal.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_representante_legal.status == REPRESENTANTES_LEGAL_ACTIVO && item_representante_legal.create == OFF )
                containerRepresentantesLegalesHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_propietario_real('+ item_representante_legal.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_representante_legal.status == REPRESENTANTES_LEGAL_BAJA  )
                containerRepresentantesLegalesHtml +=  '<td  class="text-center"></td>';

        containerRepresentantesLegalesHtml += '</tr>';
    });

    $containerRepresentantesLegales.html(containerRepresentantesLegalesHtml);
}

var render_personas_politicamente_ex = function(){
    $containerPersonasPoliticamenteEx.html(false);
    $containerPersonasPoliticamenteExOtro.html(false);
    containerPersonasPoliticamenteExHtml = '';
    containerPersonasPoliticamenteExHtmlOtro = '';
    $.each(clienteObject.personasPoliticamenteEx, function(key, item_personasPoliticamenteEx){

        if (item_personasPoliticamenteEx.tipo == ON) {
            containerPersonasPoliticamenteExHtml += '<tr>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.si_no_text +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.puesto_cargo +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.dependencia +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.ejercicio_cargo +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.fecha_separacion +'</p></td>'+
                '<td class="text-center '+ (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

                if (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO && item_personasPoliticamenteEx.create == ON )
                    containerPersonasPoliticamenteExHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_personas_politicamente_ex('+ item_personasPoliticamenteEx.element_id +')"><i class="fa fa-trash"></i></button></td>';

                if (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO && item_personasPoliticamenteEx.create == OFF )
                    containerPersonasPoliticamenteExHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_personas_politicamente_ex('+ item_personasPoliticamenteEx.element_id +')"><i class="fa fa-level-down"></i></button></td>';

                if (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_BAJA  )
                    containerPersonasPoliticamenteExHtml +=  '<td  class="text-center"></td>';

            containerPersonasPoliticamenteExHtml += '</tr>';
        }

        if (item_personasPoliticamenteEx.tipo == OFF) {

            containerPersonasPoliticamenteExHtmlOtro += '<tr>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.si_no_text +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.puesto_cargo +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.dependencia +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.ejercicio_cargo +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_personasPoliticamenteEx.fecha_separacion +'</p></td>'+
                '<td class="text-center '+ (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

                if (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO && item_personasPoliticamenteEx.create == ON )
                    containerPersonasPoliticamenteExHtmlOtro +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_personas_politicamente_ex('+ item_personasPoliticamenteEx.element_id +')"><i class="fa fa-trash"></i></button></td>';

                if (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_ACTIVO && item_personasPoliticamenteEx.create == OFF )
                    containerPersonasPoliticamenteExHtmlOtro +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_personas_politicamente_ex('+ item_personasPoliticamenteEx.element_id +')"><i class="fa fa-level-down"></i></button></td>';

                if (item_personasPoliticamenteEx.status == PERSONAS_POLITICAMENTE_EX_BAJA  )
                    containerPersonasPoliticamenteExHtmlOtro +=  '<td  class="text-center"></td>';

            containerPersonasPoliticamenteExHtmlOtro += '</tr>';

        }
    });

    $containerPersonasPoliticamenteEx.html(containerPersonasPoliticamenteExHtml);
    $containerPersonasPoliticamenteExOtro.html(containerPersonasPoliticamenteExHtmlOtro);
}


var render_perfil_transaccional = function(){
    $containerPerfilTransaccional.html(false);
    $containerPerfilTransaccionalOtro.html(false);
    $containerHistorico.html(false);
    containerPerfilTransaccionalHtml = '';
    containerPerfilTransaccionalHtmlOtro = '';
    containerHistorico = '';
    

    clienteObject.generales.credito          = $formPerfilTransaccional.inputCredito.val();
    clienteObject.generales.operaciones_min  = $formPerfilTransaccional.inputOperacionesMin.val();
    clienteObject.generales.operaciones_max  = $formPerfilTransaccional.inputOperacionesMax.val();
    clienteObject.generales.moneda           = $formPerfilTransaccional.inputMoneda.val();
    clienteObject.generales.frecuencia       = $formPerfilTransaccional.inputFrecuencia.val();
    clienteObject.generales.instrumento      = $formPerfilTransaccional.inputInstrumento.val();
    clienteObject.generales.monto_pago       = $formPerfilTransaccional.inputMontoPago.val();

    clienteObject.generales.credito_pa           = $formPerfilTransaccionalOtro.inputCredito.val();
    clienteObject.generales.operaciones_min_pa   = $formPerfilTransaccionalOtro.inputOperacionesMin.val();
    clienteObject.generales.operaciones_max_pa   = $formPerfilTransaccionalOtro.inputOperacionesMax.val();
    clienteObject.generales.moneda_pa            = $formPerfilTransaccionalOtro.inputMoneda.val();
    clienteObject.generales.frecuencia_pa        = $formPerfilTransaccionalOtro.inputFrecuencia.val();
    clienteObject.generales.instrumento_pa       = $formPerfilTransaccionalOtro.inputInstrumento.val();
    clienteObject.generales.monto_pago_pa        = $formPerfilTransaccionalOtro.inputMontoPago.val();


    $.each(clienteObject.perfilTransaccional, function(key, item_perfilTransaccional){
        if (item_perfilTransaccional.tipo == ON) {

            if (item_perfilTransaccional.estima_pagos == "ON") {
                $formPerfilTransaccional.inputEstimaPagos.prop("checked", true);
             }else{   $formPerfilTransaccional.inputEstimaPagos.prop("checked", false); }

            clienteObject.generales.estima_pagos = item_perfilTransaccional.estima_pagos;
            clienteObject.generales.fecha_act = item_perfilTransaccional.fecha_act;

            $formPerfilTransaccional.inputCredito.val(item_perfilTransaccional.credito);
            $formPerfilTransaccional.inputOperacionesMin.val(item_perfilTransaccional.operaciones_min);
            $formPerfilTransaccional.inputOperacionesMax.val(item_perfilTransaccional.operaciones_max);
            $formPerfilTransaccional.inputMoneda.val(item_perfilTransaccional.moneda);
            $formPerfilTransaccional.inputFrecuencia.val(item_perfilTransaccional.frecuencia);
            $formPerfilTransaccional.inputInstrumento.val(item_perfilTransaccional.instrumento);
            $formPerfilTransaccional.inputMontoPago.val(item_perfilTransaccional.monto_pago);
            $formPerfilTransaccionalOtro.inputFechaAct.val(item_perfilTransaccional.fecha_act);

            $formPerfilTransaccionalOtro.inputCredito.val(item_perfilTransaccional.credito_pa);
            $formPerfilTransaccionalOtro.inputOperacionesMin.val(item_perfilTransaccional.operaciones_min_pa);
            $formPerfilTransaccionalOtro.inputOperacionesMax.val(item_perfilTransaccional.operaciones_max_pa);
            $formPerfilTransaccionalOtro.inputMoneda.val(item_perfilTransaccional.moneda_pa);
            $formPerfilTransaccionalOtro.inputFrecuencia.val(item_perfilTransaccional.frecuencia_pa);
            $formPerfilTransaccionalOtro.inputInstrumento.val(item_perfilTransaccional.instrumento_pa);
            $formPerfilTransaccionalOtro.inputMontoPago.val(item_perfilTransaccional.monto_pago_pa);
            
        }

       
    });

    $.each(clienteObject.creditos, function(key, item_perfilTransaccional){

        containerPerfilTransaccionalHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.credito_id +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.loan_number+'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.credito_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.frecuencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_min +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_max +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:14px">$ '+ (parseFloat(item_perfilTransaccional.monto_pago)).toFixed(2) +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.instrumento_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.moneda_text +'</p></td>';

                containerPerfilTransaccionalHtml += 
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.frecuencia_pa +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_min_pa +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_max_pa +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:14px">$'+ (parseFloat(item_perfilTransaccional.monto_pago_pa)).toFixed(2) +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.instrumento_text_pa +'</p></td>'+
                '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.moneda_text_pa+'</p></td>'+
                '<td class="text-center '+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';
    
                if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == ON )
                    containerPerfilTransaccionalHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-trash"></i></button></td>';
    
                if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == OFF )
                    containerPerfilTransaccionalHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-level-down"></i></button><a href="../../creditos/credito/view?id='+item_perfilTransaccional.credito_id+'" target="_new"><button type="button" class="btn btn-light"><i class="fa fa-eye"></button></a></td>';
    
                if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_BAJA  )
                    containerPerfilTransaccionalHtml +=  '<td  class="text-center"></td>';
                '</tr>'; 

       
    });

    $.each(clienteObject.perfilTransaccionalPa, function(key, item_perfilTransaccional){
        if (item_perfilTransaccional.tipo == ON) {

            $formPerfilTransaccionalOtro.inputCredito.val(item_perfilTransaccional.credito);
            $formPerfilTransaccionalOtro.inputOperacionesMin.val(item_perfilTransaccional.operaciones_min);
            $formPerfilTransaccionalOtro.inputOperacionesMax.val(item_perfilTransaccional.operaciones_max);
            $formPerfilTransaccionalOtro.inputMoneda.val(item_perfilTransaccional.moneda);
            $formPerfilTransaccionalOtro.inputFrecuencia.val(item_perfilTransaccional.frecuencia);
            $formPerfilTransaccionalOtro.inputInstrumento.val(item_perfilTransaccional.instrumento);
            $formPerfilTransaccionalOtro.inputMontoPago.val(item_perfilTransaccional.monto_pago);

            containerPerfilTransaccionalHtmlOtro += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.credito_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.frecuencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_min +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_max +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">$'+ item_perfilTransaccional.monto_pago +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.instrumento_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_perfilTransaccional.moneda_text +'</p></td>'+
            '<td class="text-center '+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == ON )
                containerPerfilTransaccionalHtmlOtro +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == OFF )
                containerPerfilTransaccionalHtmlOtro +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_BAJA  )
                containerPerfilTransaccionalHtmlOtro +=  '<td  class="text-center"></td>';

            containerPerfilTransaccionalHtmlOtro += 
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">-</p></td>'+
            '</tr>';
        }

       
    });


    $.each(clienteObject.historico, function(key, item_historico){

            containerHistorico += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.date +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.credito_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.frecuencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.operaciones_min +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.operaciones_max +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">$'+ item_historico.monto_pago +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.instrumento_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.moneda_text +'</p></td>';
            if(item_historico.estima_pagos == "ON"){
            containerHistorico +=  '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px; color: darkgreen;"><b>SI</b></p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.frecuencia_pa +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.operaciones_min_pa +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.operaciones_max_pa +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">$'+ item_historico.monto_pago_pa +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.instrumento_text_pa +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">'+ item_historico.moneda_text_pa +'</p></td>';
            +'</tr>';
            }else{
            containerHistorico +=  '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px; color: darkred;"><b>NO</b></p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">-</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:12px">-</p></td>';
            +'</tr>';
            }
            
            
    });

    $containerPerfilTransaccional.html(containerPerfilTransaccionalHtml);
    $containerPerfilTransaccionalOtro.html(containerPerfilTransaccionalHtmlOtro);
    $containerHistorico.html(containerHistorico);

   
  
} 




/*
var render_perfil_transaccional = function(){
    $containerPerfilTransaccional.html(false);
    $containerPerfilTransaccionalOtro.html(false);
    containerPerfilTransaccionalHtml = '';
    containerPerfilTransaccionalHtmlOtro = '';
    $.each(clienteObject.perfilTransaccional, function(key, item_perfilTransaccional){
        if (item_perfilTransaccional.tipo == ON) {
            containerPerfilTransaccionalHtml += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.credito_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.frecuencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_min +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_max +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.monto_pago +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.instrumento_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.moneda_text +'</p></td>'+
            '<td class="text-center '+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == ON )
                containerPerfilTransaccionalHtml +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == OFF )
                containerPerfilTransaccionalHtml +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_BAJA  )
                containerPerfilTransaccionalHtml +=  '<td  class="text-center"></td>';

            containerPerfilTransaccionalHtml += '</tr>';
        }

        if (item_perfilTransaccional.tipo == OFF) {
            containerPerfilTransaccionalHtmlOtro += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.credito_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.frecuencia +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_min +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.operaciones_max +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.monto_pago +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.instrumento_text +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_perfilTransaccional.moneda_text +'</p></td>'+
            '<td class="text-center '+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'text-primary': 'text-danger')  +'"><p style="font-weight:600; font-size:16px;">'+ (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO ? 'ACTIVO': 'INACTIVO')  +'</p></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == ON )
                containerPerfilTransaccionalHtmlOtro +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_ACTIVO && item_perfilTransaccional.create == OFF )
                containerPerfilTransaccionalHtmlOtro +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_perfil_transaccional('+ item_perfilTransaccional.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_perfilTransaccional.status == PERFIL_TRANSACCIONAL_BAJA  )
                containerPerfilTransaccionalHtmlOtro +=  '<td  class="text-center"></td>';

            containerPerfilTransaccionalHtmlOtro += '</tr>';
        }
    });

    $containerPerfilTransaccional.html(containerPerfilTransaccionalHtml);
    $containerPerfilTransaccionalOtro.html(containerPerfilTransaccionalHtmlOtro);
} */

var drop_direccion = function(element_id){

    $.each(clienteObject.generales.direcciones, function(key_direccion, item_direccion){
        if (item_direccion.element_id == element_id )
            clienteObject.generales.direcciones.splice(key_direccion,1);

        if (item_direccion.apply_principal == ON) {
            $.each(clienteObject.generales.direcciones, function(key_telefono_principal, item_direccion_principal){
                if (item_direccion_principal.tipo == item_direccion.tipo) {
                    clienteObject.generales.direcciones[key_telefono_principal].apply_principal = ON;
                }
            });
        }
    });

    render_direccion();
};

var drop_telefono = function(element_id){

    $.each(clienteObject.generales.telefonos, function(key_telefono, item_telefono){
        if (item_telefono.element_id == element_id )
            clienteObject.generales.telefonos.splice(key_telefono,1);

        if (item_telefono.apply_principal == ON) {
            $.each(clienteObject.generales.telefonos, function(key_telefono_principal, item_telefono_principal){
                if (item_telefono_principal.pertenece == item_telefono.pertenece) {
                    clienteObject.generales.telefonos[key_telefono_principal].apply_principal = ON;
                }
            });
        }
    });

    render_telefono();
};

var drop_actividad = function(element_id){

    $.each(clienteObject.actividadOrigen.precise_giro_actividad, function(key_actividad, item_actividad){
        if (item_actividad.element_id == element_id )
            clienteObject.actividadOrigen.precise_giro_actividad.splice(key_actividad,1);
    });

    render_actividad();
};

var drop_propietario_real = function(element_id){

    $.each(clienteObject.propietarios_reales, function(key_propietario, item_propietario){
        if (item_propietario.element_id == element_id )
            clienteObject.propietarios_reales.splice(key_propietario,1);
    });

    render_propietarios_reales();
};

var drop_personas_politicamente_ex = function(element_id){

    $.each(clienteObject.personasPoliticamenteEx, function(key_politicamenteEx, item_politicamenteEx){
        if (item_politicamenteEx.element_id == element_id )
            clienteObject.personasPoliticamenteEx.splice(key_politicamenteEx,1);
    });

    render_personas_politicamente_ex();
};

var drop_perfil_transaccional = function(element_id){

    $.each(clienteObject.perfilTransaccional, function(key_perfilTrans, item_perfilTransaccional){
        if (item_perfilTransaccional.element_id == element_id )
            clienteObject.perfilTransaccional.splice(key_perfilTrans,1);
    });

    render_perfil_transaccional();
};


var drop_banco = function(element_id){

    $.each(clienteObject.generales.bancos, function(key_banco, item_banco){
        if (item_banco.element_id == element_id )
            clienteObject.generales.bancos.splice(key_banco,1);
    });

    render_banco();
};


var baja_telefono = function(element_id){

    $.each(clienteObject.generales.telefonos, function(key_telefono, item_telefono){
        if (item_telefono.element_id == element_id ){
            clienteObject.generales.telefonos[key_telefono].status = TELEFONO_BAJA;

            if (parseInt(item_telefono.apply_principal) == ON) {
                clienteObject.generales.telefonos[key_telefono].apply_principal = OFF;
                $apply_one = true;

                $.each(clienteObject.generales.telefonos, function(key_telefono_principal, item_telefono_principal){
                    if ( $apply_one &&  element_id != item_telefono_principal.element_id  && item_telefono_principal.tipo == item_telefono.tipo) {
                        clienteObject.generales.telefonos[key_telefono_principal].apply_principal = ON;
                        $apply_one = false;
                    }
                });
            }
        }
    });

    render_telefono();
};

var baja_actividad = function(element_id){

    $.each(clienteObject.actividadOrigen.precise_giro_actividad, function(key_actividad, item_actividad){
        if (item_actividad.element_id == element_id )
            clienteObject.actividadOrigen.precise_giro_actividad[key_actividad].status = ACTIVIDAD_BAJA;
    });

    render_actividad();
};

var baja_propietario_real = function(element_id){

    $.each(clienteObject.propietarios_reales, function(key_propietario, item_propietario){
        if (item_propietario.element_id == element_id )
            clienteObject.propietarios_reales[key_propietario].status = PROPETARIOS_REALES_BAJA;
    });

    render_propietarios_reales();
};

var baja_personas_politicamente_ex = function(element_id){

    $.each(clienteObject.personasPoliticamenteEx, function(key_politicamenteEx, item_politicamenteEx){
        if (item_politicamenteEx.element_id == element_id )
            clienteObject.personasPoliticamenteEx[key_politicamenteEx].status = PERFIL_TRANSACCIONAL_BAJA;
    });

    render_personas_politicamente_ex();
};

var baja_perfil_transaccional = function(element_id){

    $.each(clienteObject.perfilTransaccional, function(key_perfilTrans, item_perfilTransaccional){
        if (item_perfilTransaccional.element_id == element_id )
            clienteObject.perfilTransaccional[key_perfilTrans].status = PERFIL_TRANSACCIONAL_BAJA;
    });

    render_perfil_transaccional();
};

var baja_direccion = function(element_id){

    $.each(clienteObject.generales.direcciones, function(key_direccion, item_direccion){
        if (item_direccion.element_id == element_id )
            clienteObject.generales.direcciones[key_direccion].status = DIRECCION_BAJA;


        if (parseInt(item_direccion.apply_principal) == ON) {
            clienteObject.generales.direcciones[key_direccion].apply_principal = OFF;
            $apply_one = true;

            $.each(clienteObject.generales.direcciones, function(key_direccion_principal, item_direccion_principal){
                if ( $apply_one &&  element_id != item_direccion_principal.element_id  && item_direccion_principal.tipo == item_direccion.tipo) {
                    clienteObject.generales.direcciones[key_direccion_principal].apply_principal = ON;
                    $apply_one = false;
                }
            });
        }

    });

    render_direccion();
};


var baja_banco = function(element_id){

    $.each(clienteObject.generales.bancos, function(key_banco, item_banco){
        if (item_banco.element_id == element_id )
            clienteObject.generales.bancos[key_banco].status = BANCO_BAJA;
    });

    render_banco();
};


var funcLowerCase = function(input){
    return  $.trim($(input).val($(input).val().toUpperCase()));
}



var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}

var hide_loader = function(){
    $('#page_loader').remove();
}

var funct_no_aplica_pagos_anticipados = function(){

    $changes = $changes + 1;
                clienteObject.generales.cambios = $changes;

    if ( $formPerfilTransaccional.inputEstimaPagos.is(':checked')){
    clienteObject.generales.estima_pagos = "ON" ;
    $formPerfilTransaccionalOtro.inputCredito.attr("disabled", false);
    $formPerfilTransaccionalOtro.inputFrecuencia.attr("disabled", false);
    $formPerfilTransaccionalOtro.inputMontoPago.attr("disabled", false);
    $formPerfilTransaccionalOtro.inputInstrumento.attr("disabled", false);
    $formPerfilTransaccionalOtro.inputMoneda.attr("disabled", false);
    $formPerfilTransaccionalOtro.inputOperacionesMin.attr("disabled", false);
    $formPerfilTransaccionalOtro.inputOperacionesMax.attr("disabled", false);
    }else{
        clienteObject.generales.estima_pagos = "OFF" ;
    $formPerfilTransaccionalOtro.inputCredito.attr("disabled", true);
    $formPerfilTransaccionalOtro.inputFrecuencia.attr("disabled", true);
    $formPerfilTransaccionalOtro.inputMontoPago.attr("disabled", true);
    $formPerfilTransaccionalOtro.inputInstrumento.attr("disabled", true);
    $formPerfilTransaccionalOtro.inputMoneda.attr("disabled", true);
    $formPerfilTransaccionalOtro.inputOperacionesMin.attr("disabled", true);
    $formPerfilTransaccionalOtro.inputOperacionesMax.attr("disabled", true);
        
    }

    

};

window.addEventListener('beforeunload', (event) => {
    event.preventDefault();
    event.returnValue ='¿Estás seguro de abandonar el proceso del registro ?';
});