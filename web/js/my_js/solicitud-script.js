

$(function () {
    $wizard             = $("#wizard");

    $wizard.steps({
        onInit : function(event, currentIndex){
            $formSolicitud = {
                inputClienteID              : $('#solicitud-cliente_id'),
                inputPromotor               : $('#solicitud-promotor_id'),
                inputComite                 : $('#solicitud-comite_id'),
                inputApplyGracia            : $('#solicitud-apply_gracia'),
                inputGraciaPeriodo          : $('#solicitud-gracia_periodo'),
                inputGraciaPeriodoInteres   : $('#solicitud-gracia_periodo_interes'),
                inputGraciaPagoPerido       : $('#solicitud-gracia_pago_interes'),
                inputGraciaPagoCapital      : $('#solicitud-gracia_pago_capital'),
                inputRegion                 : $('#solicitud-region_id'),
                inputPlaza                  : $('#solicitud-plaza_id'),
                inputSucursal               : $('#solicitud-sucursal_id'),
                inputFechaCredito           : $('#solicitud-fecha_credito'),
                inputLoanNumber             : $('#solicitud-loan_number'),
                inputProductoFinanciero     : $('#solicitud-producto_financiero'),
                inputProductoScian          : $('#solicitud-producto_scian'),
                inputDestinoCredito         : $('#solicitud-destino_credito'),
                inputMonto                  : $('#solicitud-monto'),
                inputTasaFija               : $('#solicitud-tasa_fija'),
                inputTasaVariable           : $('#solicitud-tasa_variable'),
                inputTasaVariableIndicador  : $('#solicitud-tasa_variable_indicador'),
                inputTasaVariablePuntoAdicional  : $('#solicitud-tasa_variable_punto_adicionales'),
                inputPlanComision                : $('#solicitud-plan_comision_id'),
                inputPlanComisionClave           : $('#solicitud-comision_clave'),
                inputPlanComisionDescripcion     : $('#solicitud-comision_descripcion'),
                inputPlanComisionId              : $('#solicitud-comision_id'),
                inputPlanComisionCreador         : $('#solicitud-comision_creador'),
                inputPlanComisionFecha           : $('#solicitud-comision_fecha'),
                inputPlanComisionStatus          : $('#solicitud-comision_estatus'),
                inputPerfilTransaccional         : $('#solicitud-perfil_transaccional_id'),

                inputCredito                    : $('#solicitud-credito'),
                inputFrecuencia                 : $('#solicitud-frecuencia'),
                inputOperacionesMax             : $('#solicitud-operaciones_max'),
                inputOperacionesMin             : $('#solicitud-operaciones_min'),
                inputMontoPago                  : $('#solicitud-monto_del_pago'),
                inputInstrumento                : $('#solicitud-instrumento'),
                inputMonedaPF                   : $('#solicitud-moneda_pf'),

                inputCreditoPa                  : $('#solicitud-credito_pa'),
                inputFrecuenciaPa               : $('#solicitud-frecuencia_pa'),
                inputOperacionesMaxPa           : $('#solicitud-operaciones_max_pa'),
                inputOperacionesMinPa           : $('#solicitud-operaciones_min_pa'),
                inputMontoPagoPa                : $('#solicitud-monto_del_pago_pa'),
                inputInstrumentoPa              : $('#solicitud-instrumento_pa'),
                inputMonedaPa                   : $('#solicitud-moneda_pa'),


                inputTasaVariablePeriodicidad    : $('#solicitud-tasa_variable_periodicidad'),
                inputTasaVariableDiaRevision     : $('#solicitud-tasa_variable_dia_revision'),
                inputTasaVariableProximaRevision : $('#solicitud-tasa_variable_proxima_revision'),
                inputTasaFijaUsuario             : $('#solicitud-tasa_fija_usuario_id'),
                inputTasaFijaDepartamento        : $('#solicitud-tasa_fija_departamento_id'),
                //inputPlazo                  : $('#solicitud-plazo'),
                inputMoneda                 : $('#solicitud-moneda'),
                inputTipoTasa               : $('#solicitud-tipo_tasa'),
                inputApplyCalculo           : $('#solicitud-apply_calculo'),
                inputPeriodicidadPagoCapital: $('#solicitud-periodicidad_pago_capital'),
                inputFechaVencimiento       : $('#solicitud-fecha_vencimiento'),
                inputNumeroPagoCapital      : $('#solicitud-numero_pago_capital'),
                inputFechaPrimerPagoCapital : $('#solicitud-fecha_primer_pago_capital'),
                inputPlazoDias              : $('#solicitud-plazo_en_dias'),
                inputPlazoMeses             : $('#solicitud-plazo_en_meses'),
                inputPeriodicidadPagoInteres: $('#solicitud-periodicidad_pago_interes'),
                inputNumeroPagoInteres      : $('#solicitud-numero_pago_interes'),
                inputFechaPrimerPagoInteres : $('#solicitud-fecha_primer_pago_interes'),
                inputTasaMoratoriaIndicador : $('#solicitud-tasa_moratoria_indicador'),
                inputTasaMoratoriaPuntos    : $('#solicitud-tasa_moratoria_puntos'),
                inputTasaMoratoriaOperador  : $('#solicitud-tasa_moratoria_operador'),
                inputTasaMoratoriaFactor    : $('#solicitud-tasa_moratoria_factor'),
                inputTasaMoratoriaValor     : $('#solicitud-tasa_moratoria_valor'),
            };


            $formGarantia = {
                inputGarantiaTipo                   : $('#solicitud-garantia_tipo'),
                inputPerteneceNoFinanciera          : $('#solicitud-pertenece_real_no_financiera'),
                inputPerteneceFinanciera            : $('#solicitud-pertenece_real_financiera'),
                inputPerteneceRealFinancieraLiquida : $('#solicitud-garantia_liquida_opcion'),
                inputGarantiaMoneda                 : $('#solicitud-garantia_moneda'),
                inputGarantiaValor                  : $('#solicitud-valor_garantia'),
                inputGarantiaValorPorcentaje        : $('#solicitud-valor_garantia_porcentaje'),
                inputGarantiaDescripcion            : $('#solicitud-descripcion_garantia'),
                inputGarantiaCatalogo               : $('#solicitud-catalogo_garantias_id'),
            };

            $inputFindClienteID     = $('#solicitud-find_cliente_id');
            $inputFindClienteBP     = $('#solicitud-bp_number');
            $inputSelectCliente     = $('#solicitud-cliente_text');
            $containerSolicitud     = $('.container_solicitud');
            $containerList          = $('.container-list');
            $inputSolicitudID       = $('#solicitud-solicitud_id');

            $containerDirecciones   = $('.container-direcciones'),
            $comisionID             = $('#solicitud-plan_comision_id'),
            $containerTelefono      = $('.container-telefono'),
            $btnGenerateBalance     = $('#btnGenerateBalance'),
            $btnPagosPersonalizados = $('#btnPagosPersonalizados'),
            $btnSolicitud           = $('#btnSolicitud'),
            $btnAddGarantiaAval     = $('#btnAddGarantiaAval'),
            $contentBalance         = $('.content_balance'),
            VAR_PATH_URL            = $('body').data('url-root'),
            $VAR_CREDITO            = [],
            ON                      = 10;
            OFF                     = 20;
            TASA_FIJA               = 10;
            TASA_VARIABLE           = 20;
            GARANTIA_FINANCIERA     = 10;
            GARANTIA_NO_FINANCIERA  = 20;
            GARANTIA_PERSONAL       = 30;
            GARANTIA_ACTIVO         = 10;
            GARANTIA_BAJA           = 20;
            VAR_GARANTIAS_ARRAY     = null;

            // PLAN DE COMISION
            ON                          = 10;
            OFF                         = 20;
            COMISION_ACTIVO             = 10;
            COMISION_BAJA               = 20;
            VAR_POR_MONTO               = 10;
            VAR_POR_PORCENTAJE          = 20;

            GARANTIA_PERTENECE_HIPOTECA  = 10;
            periodicidadValueList   = {
                10 : 1,
                20 : 2,
                30 : 3,
                40 : 4,
                60 : 6,
                50 : 12,
            },
            planComisionObject          = {
                "id"            : $comisionID.val(),
                "clave"         : null,
                "titulo"        : null,
                "descripcion"   : null,
                "fecha"         : null,
                "descripcion"   : null,
                "estatus"       : null,
                "comisionList"  : []
            },

            solicitudObject         = {
                "solicitud_id"                  : $('#solicitud-id').val() ? $('#solicitud-id').val() : null,
                "cliente_id"                    : null,
                "cliente_bp"                    : null,
                "cliente_text"                  : null,
                "cliente_status"                : null,
                "config_producto_financiero_id" : null,
                "config_producto_financiero_text" : null,
                "promotor_id"                   : null,
                "promotor_text"                 : null,
                "comite_id"                     : null,
                "comite_text"                   : null,
                "region_id"                     : null,
                "region_text"                   : null,
                "plaza_id"                      : null,
                "plaza_text"                    : null,
                "sucursal_id"                   : null,
                "sucursal_text"                 : null,
                "fecha_credito"                 : null,
                "loan_number"                   : null,
                "destino_credito"               : null,
                "plan_comision_id"              : null,
                "comision_clave"                : null,
                "perfil_transaccional_id"       : null,
                "monto"                         : null,
                "descripcion"                   : null,
                "comision_id"                   : null,
                "actividad_economica_id"        : null,
                "actividad_economica_text"      : null,
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


                "fecha_vencimiento"             : null,
                "moneda_text"                   : null,
                "moneda_pf"                     : null,
                "plazo_credito" : {
                    "periodicidad_pago_capital" : null,
                    "numero_pago_capital"       : null,
                    "fecha_primer_pago_capital" : null,
                    "plazo_en_dias"             : null,
                    "plazo_en_meses"            : null,
                    "periodicidad_pago_interes" : null,
                    "numero_pago_interes"       : null,
                    "fecha_primer_pago_interes" : null,
                    "apply_gracia"              : null,
                    "gracia_periodo"            : null,
                    "gracia_periodo_interes"    : null,
                    "gracia_pago_interes"       : null,
                    "gracia_pago_capital"       : null,
                },
                "plan_pagos"    : [],
                "tasa_interes"  : {
                    "tipo_tasa"         : null,
                    "tasa_fija"         : null,
                    "tasa_fija_departamento_id" : null,
                    "tasa_fija_usuario_id"      : null,
                    "tasa_variable"             : null,
                    "tasa_moratoria_indicador"  : null,
                    "tasa_moratoria_puntos"     : null,
                    "tasa_moratoria_operador"   : null,
                    "tasa_moratoria_factor"     : null,
                    "tasa_moratoria_valor"      : null,
                    "tasa_variable_valor"   : null,
                    "tasa_variable_indicador"   : null,
                    "tasa_variable_punto_adicionales"   : null,
                    "tasa_variable_periodicidad"        : null,
                    "tasa_variable_dia_revision"        : null,
                    "tasa_variable_proxima_revision"    : null,
                },
                "garantias" : [],
            },
            clienteObject           = {
                "generales": {
                    "direcciones"       : [],
                    "telefonos"         : [],
                },
            };


            funct_get_info_seccion();
            render_garantiasAvales();
        
            
            

            $formSolicitud.inputMonto.mask('$ 000,000,000,000,000.00', {reverse: true});
            $formGarantia.inputGarantiaValor.mask('$ 000,000,000,000,000.00', {reverse: true});
            $formGarantia.inputGarantiaValorPorcentaje.mask('$ 000,000,000,000,000.00', {reverse: true});
            $formSolicitud.inputMontoPago.mask('$ 000,000,000,000,000.00', {reverse: true});
            $formSolicitud.inputMontoPagoPa.mask('$ 000,000,000,000,000.00', {reverse: true});



            $('.form-solicitud :input').on('change', function(){
                //solicitudObject.cliente_id                      = $formSolicitud.inputClienteID.val();
                solicitudObject.promotor_id                     = $formSolicitud.inputPromotor.val();
                solicitudObject.comite_id                       = $formSolicitud.inputComite.val();
                solicitudObject.region_id                       = $formSolicitud.inputRegion.val();
                solicitudObject.plaza_id                        = $formSolicitud.inputPlaza.val();
                solicitudObject.sucursal_id                     = $formSolicitud.inputSucursal.val();
                solicitudObject.fecha_credito                   = $formSolicitud.inputFechaCredito.val();
                solicitudObject.fecha_vencimiento               = $formSolicitud.inputFechaVencimiento.val();
                solicitudObject.loan_number                     = $formSolicitud.inputLoanNumber.val();
                solicitudObject.config_producto_financiero_id   = $formSolicitud.inputProductoFinanciero.val();
                solicitudObject.destino_credito                 = $formSolicitud.inputDestinoCredito.val();
                solicitudObject.plan_comision_id                = $formSolicitud.inputPlanComision.val();
                solicitudObject.comision_creador                = $formSolicitud.inputPlanComisionCreador.val();
                solicitudObject.comision_fecha                  =$formSolicitud.inputPlanComisionFecha.val();
                solicitudObject.comision_status                 =$formSolicitud.inputPlanComisionStatus.val();
                
                solicitudObject.perfil_transaccional_id         = $formSolicitud.inputPerfilTransaccional.val();

                solicitudObject.credito                         = $formSolicitud.inputCredito.val();
                solicitudObject.frecuencia                      = $formSolicitud.inputFrecuencia.val();
                solicitudObject.operaciones_max                 = $formSolicitud.inputOperacionesMax.val();
                solicitudObject.operaciones_min                 = $formSolicitud.inputOperacionesMin.val();
                solicitudObject.monto_del_pago                  = $formSolicitud.inputMontoPago.val();
                solicitudObject.instrumento                     = $formSolicitud.inputInstrumento.val();
                solicitudObject.moneda                          = $formSolicitud.inputMoneda.val();

                solicitudObject.credito_pa                      = $formSolicitud.inputCreditoPa.val();
                solicitudObject.frecuencia_pa                   = $formSolicitud.inputFrecuenciaPa.val();
                solicitudObject.operaciones_max_pa              = $formSolicitud.inputOperacionesMaxPa.val();
                solicitudObject.operaciones_min_pa              = $formSolicitud.inputOperacionesMinPa.val();
                solicitudObject.monto_del_pago_pa               = $formSolicitud.inputMontoPagoPa.val();
                solicitudObject.instrumento_pa                  = $formSolicitud.inputInstrumentoPa.val();
                solicitudObject.moneda_pa                       = $formSolicitud.inputMonedaPa.val();




                solicitudObject.comision_clave                  = $formSolicitud.inputPlanComisionClave.val();    
                solicitudObject.monto                           = $formSolicitud.inputMonto.val().replaceAll(',','');
                //solicitudObject.plazo                           = $formSolicitud.inputPlazo.val();
                solicitudObject.moneda_pf                          = $formSolicitud.inputMonedaPF.val();
                solicitudObject.tasa_interes.tasa_fija                       = $formSolicitud.inputTasaFija.val();
                solicitudObject.tasa_interes.tipo_tasa                       = $formSolicitud.inputTipoTasa.val();
                solicitudObject.actividad_economica_id                       = $formSolicitud.inputProductoScian.val();

                solicitudObject.tasa_interes.tasa_variable                    = $formSolicitud.inputTasaVariable.val();
                solicitudObject.tasa_interes.tasa_variable_indicador          = $formSolicitud.inputTasaVariableIndicador.val();
                solicitudObject.tasa_interes.tasa_variable_punto_adicionales  = $formSolicitud.inputTasaVariablePuntoAdicional.val();
                solicitudObject.tasa_interes.tasa_variable_periodicidad       = $formSolicitud.inputTasaVariablePeriodicidad.val();
                solicitudObject.tasa_interes.tasa_variable_dia_revision       = $formSolicitud.inputTasaVariableDiaRevision.val();
                solicitudObject.tasa_interes.tasa_variable_proxima_revision   = $formSolicitud.inputTasaVariableProximaRevision.val();
                solicitudObject.tasa_interes.tasa_fija_usuario_id             = $formSolicitud.inputTasaFijaUsuario.val();
                solicitudObject.tasa_interes.tasa_fija_departamento_id        = $formSolicitud.inputTasaFijaDepartamento.val();

                solicitudObject.plazo_credito.periodicidad_pago_capital     = $formSolicitud.inputPeriodicidadPagoCapital.val();
                solicitudObject.plazo_credito.numero_pago_capital           = $formSolicitud.inputNumeroPagoCapital.val();
                solicitudObject.plazo_credito.fecha_primer_pago_capital     = $formSolicitud.inputFechaPrimerPagoCapital.val();
                solicitudObject.plazo_credito.plazo_en_dias                 = $formSolicitud.inputPlazoDias.val();
                solicitudObject.plazo_credito.plazo_en_meses                = $formSolicitud.inputPlazoMeses.val();
                solicitudObject.plazo_credito.periodicidad_pago_interes     = $formSolicitud.inputPeriodicidadPagoInteres.val();
                solicitudObject.plazo_credito.numero_pago_interes           = $formSolicitud.inputNumeroPagoInteres.val();
                solicitudObject.plazo_credito.fecha_primer_pago_interes     = $formSolicitud.inputFechaPrimerPagoInteres.val();

                solicitudObject.plazo_credito.apply_gracia                  = $formSolicitud.inputApplyGracia.is(':checked') ? ON : OFF;
                solicitudObject.plazo_credito.gracia_periodo                = $formSolicitud.inputGraciaPeriodo.val();
                solicitudObject.plazo_credito.gracia_periodo_interes        = $formSolicitud.inputGraciaPeriodoInteres.val();
                solicitudObject.plazo_credito.gracia_pago_interes           = $formSolicitud.inputGraciaPagoPerido.val();
                solicitudObject.plazo_credito.gracia_pago_capital           = $formSolicitud.inputGraciaPagoCapital.val();

                solicitudObject.tasa_interes.tasa_moratoria_indicador       = $formSolicitud.inputTasaMoratoriaIndicador.val();
                solicitudObject.tasa_interes.tasa_moratoria_puntos          = $formSolicitud.inputTasaMoratoriaPuntos.val();
                solicitudObject.tasa_interes.tasa_moratoria_operador        = $formSolicitud.inputTasaMoratoriaOperador.val();
                solicitudObject.tasa_interes.tasa_moratoria_factor          = $formSolicitud.inputTasaMoratoriaFactor.val();
                solicitudObject.tasa_interes.tasa_moratoria_valor           = $formSolicitud.inputTasaMoratoriaValor.val();

                fuct_cal_tasa_moratoria();

                func_cal_plazo_diameses();

                func_valid_periodo_interes();

                func_cal_tasa_variable();

                func_valid_gracia();

                func_valid_pagos_inicial();
                init();

      

            
            });

            $('.form-garantia-aval :input').on('change', function(){
                funct_valid_garantia_required();
            });

            $inputFindClienteID.bind("enterKey",function(e){
                funct_get_cliente($inputFindClienteID.val(),10);
            });

            $inputFindClienteID.keyup(function(e){
                if(e.keyCode == 13)
                {
                    funct_get_cliente($inputFindClienteID.val(),10);
                }
            });


            $inputFindClienteBP.bind("enterKey",function(e){
                funct_get_cliente($inputFindClienteBP.val(),20);
            });

            $inputFindClienteBP.keyup(function(e){
                if(e.keyCode == 13)
                {
                    funct_get_cliente($inputFindClienteBP.val(),20);
                }
            });


            $inputSelectCliente.change(function(e){
                funct_get_cliente($inputSelectCliente.val(),10);
            });

            $formSolicitud.inputProductoScian.change(function(){
                $('.lbl_producto_clave').html('----');
                $('.lbl_producto_clase').html('----');
                $('.lbl_producto_producto').html('----');
                if ($formSolicitud.inputProductoScian.val()) {
                    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-info-producto", { producto_id : $formSolicitud.inputProductoScian.val() }, function(response){
                        if (response.code == 202) {
                            $('.lbl_producto_clave').html(response.producto.codigo);
                            $('.lbl_producto_rama').html(response.producto.rama);
                            $('.lbl_producto_subrama').html(response.producto.subrama);
                            $('.lbl_producto_producto').html(response.producto.producto);
                        }
                    });
                }
            });

            $formSolicitud.inputPromotor.change(function(e){
                $formSolicitud.inputRegion.html(null);
                $formSolicitud.inputPlaza.html(null);
                $formSolicitud.inputSucursal.html(null);

                if ($formSolicitud.inputPromotor.val()) {
                    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-region",{ promotor_id : $formSolicitud.inputPromotor.val() }, function(response){
                        if (response.code == 202) {

                            if (response.regionList.region)
                                $formSolicitud.inputRegion.append(new Option(response.regionList.region.nombre, response.regionList.region.id));


                            if (response.regionList.plaza)
                                $formSolicitud.inputPlaza.append(new Option(response.regionList.plaza.nombre, response.regionList.plaza.id));

                            if (response.regionList.sucursal)
                                $formSolicitud.inputSucursal.append(new Option(response.regionList.sucursal.nombre, response.regionList.sucursal.id));

                        }
                    });
                }
            });

            $formSolicitud.inputMonto.change(function(){

                if ($formSolicitud.inputProductoFinanciero.val()) {
                    if ($formSolicitud.inputMonto.val()) {
                        if ( parseFloat( $formSolicitud.inputMonto.val() ? $formSolicitud.inputMonto.val().replaceAll(',','') : 0 ) > $VAR_CREDITO.monto_maximo ) {
                            $formSolicitud.inputMonto.val(null);
                            solicitudObject.monto = null;

                            toast("SOLICITUD", "EL RANGO PERMITIDO ES DE " + btf.conta.money($VAR_CREDITO.monto_minimo) + " A  " + btf.conta.money($VAR_CREDITO.monto_maximo)  , "warning");
                        }

                        if ( parseFloat( $formSolicitud.inputMonto.val() ? $formSolicitud.inputMonto.val().replaceAll(',','') : 0 ) < $VAR_CREDITO.monto_minimo ) {
                            $formSolicitud.inputMonto.val(null);
                            solicitudObject.monto = null;
                            toast("SOLICITUD", "EL RANGO PERMITIDO ES DE " + btf.conta.money($VAR_CREDITO.monto_minimo) + " A  " + btf.conta.money($VAR_CREDITO.monto_maximo)  , "warning");
                        }
                    }
                }else{
                    $formSolicitud.inputMonto.val(null);
                    solicitudObject.monto = 0;
                    toast("SOLICITUD", "VERIFICA TU INFORMACION, EL PRODUCTO FINANCIERO ES REQUERIDO", "warning");
                }
            });

            /*$formSolicitud.inputPlazo.change(function(){
                if ($formSolicitud.inputProductoFinanciero.val()) {
                    if ( parseFloat( $formSolicitud.inputPlazo.val() ? $formSolicitud.inputPlazo.val().replaceAll(',','') : 0 ) > $VAR_CREDITO.plazo_credito_maximo  ||  parseFloat( $formSolicitud.inputPlazo.val() ? $formSolicitud.inputPlazo.val().replaceAll(',','') : 0 ) < $VAR_CREDITO.plazo_credito_minimo ) {
                        $formSolicitud.inputPlazo.val($VAR_CREDITO.plazo_credito_maximo);
                        toast("SOLICITUD", "EL RANGO PERMITIDO ES DE " + $VAR_CREDITO.plazo_credito_minimo + " A  " + $VAR_CREDITO.plazo_credito_maximo  , "warning");
                    }
                }else{
                    $formSolicitud.inputPlazo.val(null);
                    toast("SOLICITUD", "VERIFICA TU INFORMACION, EL PRODUCTO FINANCIERO ES REQUERIDO", "warning");
                }
            });*/


            $formSolicitud.inputProductoFinanciero.change(function(){
                //funct_form_clean();
                if ($formSolicitud.inputProductoFinanciero.val()) {
                    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-producto-financiero",{ productoFinancieroId : $formSolicitud.inputProductoFinanciero.val() }, function(response){
                        if (response.code == 202) {
                            $VAR_CREDITO = response.prFinanciero;
                            //$btnGenerateBalance.show();
                            $(".lbl-tipo_credito").html($VAR_CREDITO.tipo_credito_text);
                            $('#text-solicitud-tasa_fija_anualizada_maxima').html($VAR_CREDITO.tasa_fija_maxima+"%");
                            $('#text-solicitud-tasa_fija_anualizada_minima').html($VAR_CREDITO.tasa_fija_minima+"%");
                            $formSolicitud.inputTipoTasa.val($VAR_CREDITO.tipo_tasa);
                            $formSolicitud.inputMoneda.val($VAR_CREDITO.moneda);

                            if ($VAR_CREDITO.apply_cambio_tasa == ON) {
                                $formSolicitud.inputTipoTasa.attr("disabled", false);
                            }else{
                                $formSolicitud.inputTipoTasa.attr("disabled", true);
                            }

                            $formSolicitud.inputTipoTasa.trigger('change');

                            if ($VAR_CREDITO.apply_cambio_moneda == ON) {
                                $formSolicitud.inputMoneda.attr("disabled", false);
                            }else{
                                $formSolicitud.inputMoneda.attr("disabled", true);
                            }

                            $formSolicitud.inputMonto.change();
                        }
                    });
                }
            });


            $btnSolicitud.click(function(){
                show_loader();
                $('#modal-confirm-save-solicitud').modal({backdrop: 'static', keyboard: false});
            });


            $formSolicitud.inputTipoTasa.change(function(){
                $('#tab_tasa_fija').removeClass("disabled");
                $('#tab_tasa_fija').removeClass("active");
                //$('#tab_tasa_fija').css({"background" : "#fff"});

                $('#solicitud-tasa_termsoft_valor').html('----');


                $('#tab_tasa_variable').removeClass("disabled");
                $('#tab_tasa_variable').removeClass("active");
                //$('#tab_tasa_variable').css({"background" : "#fff"});

                $('#tab_tasa_moratoria').removeClass("active");
                $('#tab-definicion-tasa-fija').removeClass("active");
                $('#tab-definicion-tasa-variable').removeClass("active");
                $('#tab-definicion-tasa-moratoria').removeClass("active");

                if ($formSolicitud.inputTipoTasa.val() ==  TASA_FIJA) {
                    $('#tab_tasa_variable').addClass("disabled");
                    $('#tab_tasa_variable').css({"background" : "#e0e0e0"});
                    $('#tab_tasa_fija').addClass("active");
                    $('#tab-definicion-tasa-fija').addClass("active");

                }

                if ($formSolicitud.inputTipoTasa.val() ==  TASA_VARIABLE) {
                    $('#tab_tasa_fija').addClass("disabled");
                    $('#tab_tasa_fija').css({"background" : "#e0e0e0"});
                    $('#tab_tasa_variable').addClass("active");
                    $('#tab-definicion-tasa-variable').addClass("active");
                }
            });

            $formSolicitud.inputTasaFija.change(function(){
                if ( parseInt($formSolicitud.inputTasaFija.val()) > parseFloat($VAR_CREDITO.tasa_fija_maxima) ) {
                    $formSolicitud.inputTasaFija.val(null);
                    toast("LA TASA MAXIMA ES DE : " + $VAR_CREDITO.tasa_fija_maxima ,"SOLICITUD", "warning");
                }

                if ( parseInt($formSolicitud.inputTasaFija.val()) < parseInt($VAR_CREDITO.tasa_fija_minima) ) {
                    $formSolicitud.inputTasaFija.val(null);
                    toast("EL TASA MINIMA ES DE : " + $VAR_CREDITO.tasa_fija_minima,"SOLICITUD", "warning");
                }
            });


            $formSolicitud.inputTasaVariableIndicador.change(function(){
                if ($formSolicitud.inputTasaVariableIndicador.val()) {
                    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-tasa-termsoft", { tasa_id : $formSolicitud.inputTasaVariableIndicador.val() }, function(response){
                        if (response.code == 202) {
                            solicitudObject.tasa_interes.tasa_variable_valor = response.tasa_valor;
                            $('#solicitud-tasa_termsoft_valor').html(solicitudObject.tasa_interes.tasa_variable_valor);
                            func_cal_tasa_variable();
                        }

                    });
                }

            });





            $formSolicitud.inputNumeroPagoCapital.change(function(){
                $formSolicitud.inputGraciaPeriodo.html(null);
                if ($formSolicitud.inputNumeroPagoCapital.val()) {
                    $formSolicitud.inputGraciaPeriodo.append($('<option>', {
                        value: 0,
                        text : "0"
                    }));
                    for (var i = 0; i < parseInt($formSolicitud.inputNumeroPagoCapital.val()); i++) {
                        $formSolicitud.inputGraciaPeriodo.append($('<option>', {
                            value: i + 1,
                            text : i + 1
                        }));
                    }
                }
            });


            $formSolicitud.inputNumeroPagoInteres.change(function(){
                $formSolicitud.inputGraciaPeriodoInteres.html(null);
                if ($formSolicitud.inputNumeroPagoInteres.val()) {
                    $formSolicitud.inputGraciaPeriodoInteres.append($('<option>', {
                        value: 0,
                        text : "0"
                    }));
                    for (var i = 0; i < parseInt($formSolicitud.inputNumeroPagoInteres.val()); i++) {
                        $formSolicitud.inputGraciaPeriodoInteres.append($('<option>', {
                            value: i + 1,
                            text : i + 1
                        }));
                    }
                }
            });

            $btnGenerateBalance.click(function(){
                if (valid_balance()) {
                    $("#inputTempSaveTabla").remove();
                    funct_calBalance();
                }
            });

            $btnPagosPersonalizados.click(function(){
                if (valid_balance()) {
                    $("#inputTempSaveTabla").remove();
                    $(".btnControlAmortizacion").hide();
                    funct_renderBalanceEdit();
                    $('.container-tabla-amortizacion').append('<input type="button" class="btn btn-warning float-right btn-zoom" value="GUARDAR CAMBIOS"  onclick="funct_saveEditBalance(this)" id="inputTempSaveTabla" />');
                }
            });




            
            $formSolicitud.inputPlanComision.change(function(){
                var idPC = $formSolicitud.inputPlanComision.val();
                //alert(idPC);
                funct_get_plan_comision();

            });


            $formGarantia.inputGarantiaTipo.change(function(){
                $('.garantia_real_financiera').hide();
                $('.garantia_real_no_financiera').hide();
                $('.div_input_liquida_opcion').hide();
                $('.div_input_valor_garantia').show();
                $('.div_input_valor_garantia_porcentaje').hide();

                if ($formGarantia.inputGarantiaTipo.val() == GARANTIA_FINANCIERA){
                    $('.garantia_real_financiera').show();
                    $('.div_input_liquida_opcion').show();
                    $('.div_input_valor_garantia').hide();
                    $('.div_input_valor_garantia_porcentaje').hide();
                }

                if ($formGarantia.inputGarantiaTipo.val() == GARANTIA_NO_FINANCIERA){
                    $('.garantia_real_no_financiera').show();
                }

                $formGarantia.inputPerteneceNoFinanciera.change();

            });

            $formGarantia.inputPerteneceNoFinanciera.change(function(){

                $('.garantia_hipotecaria').hide();
                if ($formGarantia.inputGarantiaTipo.val() == GARANTIA_NO_FINANCIERA && $formGarantia.inputPerteneceNoFinanciera.val() ==  GARANTIA_PERTENECE_HIPOTECA) {
                    $('.garantia_hipotecaria').show();
                    funct_refreshHipoteca();
                }

            });

            $formGarantia.inputPerteneceNoFinanciera.change(function(){

               
                if ($formGarantia.inputGarantiaTipo.val() == GARANTIA_PERSONAL) {
                    $formGarantia.inputGarantiaValorPorcentaje.val(0);
                }

            });

            $formGarantia.inputPerteneceRealFinancieraLiquida.change(function(){

                $('.div_input_valor_garantia').hide();
                $('.div_input_valor_garantia_porcentaje').hide();

                if ($formGarantia.inputPerteneceRealFinancieraLiquida.val() == 10) {
                    $('.div_input_valor_garantia_porcentaje').show();
                    $formGarantia.inputGarantiaValor.val(0);
                }

                if ($formGarantia.inputPerteneceRealFinancieraLiquida.val() == 20) {
                    $('.div_input_valor_garantia').show();
                    $formGarantia.inputGarantiaValorPorcentaje.val(0);
                }

            });





            $btnAddGarantiaAval.click(function(){
                funct_valid_garantia_required()
                if (funct_form_garantia()) {
                    solicitudObject.garantias.push({
                        "element_id"                        : 10000 + (solicitudObject.garantias.length + 1),
                        "garantiaTipo"                      : $formGarantia.inputGarantiaTipo.val(),
                        "garantiaTipoText"                  : $('option:selected', $formGarantia.inputGarantiaTipo ).text(),
                        "perteneceNoFinanciera"             : $formGarantia.inputPerteneceNoFinanciera.val(),
                        "perteneceFinanciera"               : $formGarantia.inputPerteneceFinanciera.val(),
                        "perteneceRealFinancieraLiquida"    : $formGarantia.inputPerteneceRealFinancieraLiquida.val(),
                        "perteneceRealFinancieraLiquidaText": $('option:selected', $formGarantia.inputPerteneceRealFinancieraLiquida ).text(),
                        "garantiaMoneda"                    : $formGarantia.inputGarantiaMoneda.val(),
                        "garantiaMonedaText"                : $('option:selected', $formGarantia.inputGarantiaMoneda ).text(),
                        "garantiaValor"                     : parseFloat($formGarantia.inputGarantiaValor.val().replaceAll(',','')),
                        //"garantiaValor"                     : $formGarantia.inputGarantiaValor.val(),
                        "garantiaValorPorcentaje"           : parseFloat($formGarantia.inputGarantiaValorPorcentaje.val().replaceAll(',','')),
                        "catalogoGarantiaId"                : $formGarantia.inputGarantiaCatalogo.val(),
                        "garantiaDescripcion"               : $formGarantia.inputGarantiaDescripcion.val(),
                        "status"                                : GARANTIA_ACTIVO,
                        "create"                                : ON,
                        "update"                                : OFF,
                    });

                    render_garantiasAvales();
                    funct_clear_form_garantia();



                }
            });



            

         $formGarantia.inputGarantiaCatalogo.change(function(){
                if ($formGarantia.inputGarantiaCatalogo.val()) {
                    $.each(VAR_GARANTIAS_ARRAY, function(key_garantia, item_garantia){

                        if (item_garantia.id == $formGarantia.inputGarantiaCatalogo.val()) { // VERIFICAR ESTA LINEA PARA INSERTAR REGISTROS DISTINTOS A 20
                            $formGarantia.inputGarantiaMoneda.val(item_garantia.moneda);
                            $formGarantia.inputGarantiaValor.val(btf.conta.miles(item_garantia.valor_total));
                            $formGarantia.inputGarantiaDescripcion.val(item_garantia.descripcion);
                            $formGarantia.inputGarantiaValorPorcentaje.val(0);

                        }
                    })

                }
            }); 

            


        },

        onContentLoaded : function(event, currentIndex){
            console.log("entro en la carga");
        },

        onStepChanging: function (event, currentIndex, newIndex) {
            //Para validar antes de hacer un cambio entre secciones para bloquear el cambio solo es necesario return false

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

            show_loader();
            $('#modal-confirm-save-solicitud').modal({backdrop: 'static', keyboard: false});

        },

        labels: {
          finish: "GUARDAR Y SALIR",
          next: "GUARDAR Y CONTINUAR",
          previous: "ATRAS",
          cancel: "No"
        }
    });
});

var funct_get_plan_comision = function(){
    var idPC = $formSolicitud.inputPlanComision.val();
    if (idPC) {
        $.get(VAR_PATH_URL + "configuracion/comision/get-plan-comision", {'plan_comision_id' : idPC }, function(response) {
          if ( response.code == 202 )
              planComisionObject = response.planComisionObject;

          render_container();
        }, 'json');
    }
}


var funct_refreshHipoteca = function(){

    $formGarantia.inputGarantiaCatalogo.html(false);
    VAR_GARANTIAS_ARRAY = null;
    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-garantias", { clienteId: solicitudObject.cliente_id }, function(response){
        if (response.code == 202) {
            VAR_GARANTIAS_ARRAY = response.garantias;

            $.each(VAR_GARANTIAS_ARRAY, function(key_garantia, item_garantia){
                $formGarantia.inputGarantiaCatalogo.append(new Option(item_garantia.garantia, item_garantia.id));
            });

            $formGarantia.inputGarantiaCatalogo.change();
        }
    });
}

var funct_calBalance = function(){
    $contentBalance.html(loader_balance());
    setTimeout( 1000);
    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-balance", { productoFinancieroId: solicitudObject.config_producto_financiero_id, monto : solicitudObject.monto, tasa_fija : solicitudObject.tasa_interes.tasa_fija, tasa_variable : solicitudObject.tasa_interes.tasa_variable, tipo_tasa : solicitudObject.tasa_interes.tipo_tasa, pagos_capital : solicitudObject.plazo_credito.numero_pago_capital, pagos_interes : solicitudObject.plazo_credito.numero_pago_interes, fecha_pago_capital : solicitudObject.plazo_credito.fecha_primer_pago_capital, fecha_pago_interes : solicitudObject.plazo_credito.fecha_primer_pago_interes, periodicidad_pago_capital : solicitudObject.plazo_credito.periodicidad_pago_capital, periodicidad_pago_interes : solicitudObject.plazo_credito.periodicidad_pago_interes, fecha_credito : solicitudObject.fecha_credito ,apply_gracia : solicitudObject.plazo_credito.apply_gracia,gracia_periodo : solicitudObject.plazo_credito.gracia_periodo,gracia_pago_interes : solicitudObject.plazo_credito.gracia_pago_interes, gracia_pago_capital : solicitudObject.plazo_credito.gracia_pago_capital, gracia_periodo_interes : solicitudObject.plazo_credito.gracia_periodo_interes  }, function(responseBalance){
        solicitudObject.plan_pagos = responseBalance.balance;
        funct_render_balance();
    });
}

var funct_getBalanceAmortiza = function(){
    $contentBalance.html(loader_balance());
    setTimeout( 1000);
    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-solicitud-balance", { solicitudId: solicitudObject.solicitud_id }, function(responseBalance){
        solicitudObject.plan_pagos = responseBalance.balance;
        funct_render_balance();
    });
}

var funct_saveEditBalance = function(element){
    $(".btnControlAmortizacion").show();
    $contentBalance.html(loader_balance());
    $(element).remove();
    setTimeout( 1000);
    funct_render_balance();
}


var funct_render_balance = function(){

    containerBalanceHtml = "";

    $.each(solicitudObject.plan_pagos,function(key, item_balance){
        containerBalanceHtml += "<tr>"+
            '<td style= "font-size:14px; font-weight:400; color: #000">'+ item_balance.num_pago +'</td>'+
            '<td style= "font-size:14px; font-weight:bold; color: #000" class="text-center">'+ item_balance.fecha_pago +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_balance.fecha_inicial +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_balance.fecha_fin +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ btf.conta.money(item_balance.saldo_inicial) +'</td>'+
            '<td style= "font-size:14px; font-weight:400; '+ ( item_balance.apply_capital == 10 ? 'color: #03a619': 'color: #000') +'" class="text-right">'+ btf.conta.money(item_balance.pago_capital) +'</td>'+
            '<td style= "font-size:14px; font-weight:400; '+ ( item_balance.apply_interes == 10 ? 'color: #f7bc38': 'color: #000') +'" class="text-right">'+ btf.conta.money(item_balance.pago_interes) +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ item_balance.tasa +'%</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ btf.conta.money(item_balance.monto_pago) +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ item_balance.plazo_dias +' </td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ btf.conta.money(item_balance.saldo_final) +'</td>'+
        "</tr>";
    });

    $contentBalance.html(containerBalanceHtml);
}





var funct_renderBalanceEdit = function(){
    $contentBalance.html(loader_balance());
    setTimeout( 1000);
    containerBalanceHtml    = "";
    sumTotalCapital         = 0;
    sumTotalInteres         = 0;

    $.each(solicitudObject.plan_pagos,function(key, item_balance){
        containerBalanceHtml += "<tr>"+
            '<td style= "font-size:14px; font-weight:400; color: #000">'+ item_balance.num_pago +'</td>'+
            '<td style= "font-size:14px; font-weight:bold; color: #000" class="text-center"><input type="date" class="form-control" style="font-size:14px"   onchange="funct_refreshBalance('+ item_balance.num_pago +', this, 10 )"  value="'+  moment(item_balance.fecha_pago,"DD-MM-YYYY").format('Y-MM-DD')  +'"  /></td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_balance.fecha_inicial +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_balance.fecha_fin +'</td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ btf.conta.money(item_balance.saldo_inicial) +'</td>'+
            '<td style= "font-size:14px; font-weight:700; '+ ( item_balance.apply_capital == 10 ? 'color: #03a619': 'color: #000') +'" class="text-right"><input type="number"  onchange="funct_refreshBalance('+ item_balance.num_pago +', this, 20 )" class="form-control text-right" style="font-size:14px" value="'+ item_balance.pago_capital +'" /></td>'+
            '<td style= "font-size:14px; font-weight:700; '+ ( item_balance.apply_interes == 10 ? 'color: #f7bc38': 'color: #000') +'" class="text-right">'+ btf.conta.money(item_balance.pago_interes) +' </td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ item_balance.tasa +' %</td>'+
            '<td style= "font-size:14px; font-weight:700; color: #000" class="text-right">'+ btf.conta.money(item_balance.monto_pago) +' </td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ item_balance.plazo_dias +' </td>'+
            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ btf.conta.money(item_balance.saldo_final) +' </td>'+
        "</tr>";

        sumTotalCapital = sumTotalCapital + parseFloat(parseFloat(item_balance.pago_capital).toFixed(2));
        sumTotalInteres = sumTotalInteres + item_balance.pago_interes;
    })

    validCapital = parseFloat(parseFloat(sumTotalCapital).toFixed(2)) == parseFloat(solicitudObject.monto) ? true : false

    containerBalanceHtml += "<tr>"+
        '<td colspan="5" style= "font-size:14px; font-weight:400; color: #000; text-align: right"> TOTALES:</td>'+
        '<td style= "font-size:14px; font-weight:400; color: #000; text-align:right; '+ (validCapital ? 'color: #fff;background:#29770c' :'color: #fff;background: #c53c3c;') +' ">'+ btf.conta.money(sumTotalCapital) +'</td>'+
        '<td style= "font-size:14px; font-weight:400; color: #000; text-align:right">'+ btf.conta.money(sumTotalInteres) +'</td>'+
        '<td  colspan="4"></td>'+

    "</tr>";


    if (validCapital)
        $('#inputTempSaveTabla').attr('disabled', false);
    else
        $('#inputTempSaveTabla').attr('disabled', true);


    $contentBalance.html(containerBalanceHtml);
}


var funct_refreshBalance = function(numPago, element, tipo){
    $contentBalance.html(loader_balance());
    setTimeout( 1000);

    $.get(VAR_PATH_URL + "productofinanciero/solicitud/get-valid-fecha", { fecha_valida :  $(element).val() }, function(response){
        if (response.code == 202 ) {
            if (response.valid == 10) {

                $.each(solicitudObject.plan_pagos,function(key_amortiza, item_balance){
                    if (item_balance.num_pago == numPago) {
                        if (tipo == 10){


                            solicitudObject.plan_pagos[key_amortiza].fecha_pago     = $(element).val() ? new Date(moment($(element).val(), "YYYY-MM-DD").toDate()).format("d/m/Y") : item_balance.fecha_pago;
                            solicitudObject.plan_pagos[key_amortiza].fecha_fin      = funct_Yesterday(solicitudObject.plan_pagos[key_amortiza].fecha_pago);
                            funct_recalculaPlanPagos();

                        }

                        if (tipo == 20)
                            solicitudObject.plan_pagos[key_amortiza].pago_capital   = $(element).val() ? $(element).val() : item_balance.pago_capital;
                    }

                });

                amortizaNex = 1;
                $.each(solicitudObject.plan_pagos,function(key_amortiza, item_balance){

                    solicitudObject.plan_pagos[key_amortiza].plazo_dias     = funct_RangeDay(item_balance.fecha_inicial, item_balance.fecha_fin);

                    if (item_balance.apply_interes == 10)
                        solicitudObject.plan_pagos[key_amortiza].pago_interes   = ( (item_balance.saldo_inicial * (item_balance.tasa / 100 )) / 360) * solicitudObject.plan_pagos[key_amortiza].plazo_dias ;

                    solicitudObject.plan_pagos[key_amortiza].monto_pago     = (parseFloat(solicitudObject.plan_pagos[key_amortiza].pago_interes) + parseFloat(item_balance.pago_capital));
                    solicitudObject.plan_pagos[key_amortiza].saldo_final    = item_balance.saldo_inicial -  item_balance.pago_capital;

                    if (solicitudObject.plan_pagos.length > amortizaNex ){
                        solicitudObject.plan_pagos[key_amortiza + 1].saldo_inicial = solicitudObject.plan_pagos[key_amortiza].saldo_final;

                        //solicitudObject.plan_pagos[key_amortiza + 1].fecha_inicial = item_balance.fecha_fin;
                        //solicitudObject.plan_pagos[key_amortiza + 1].fecha_pago    = funct_calNextPago(item_balance.fecha_pago, solicitudObject.plazo_credito.) ;

                    }

                    amortizaNex++;
                });


            }

            if (response.valid == 20) {
                toast("SOLICITUD", "LA FECHA INGRESADA NO ES UN DIA HABIL", "warning");
                //return false;
            }

            funct_renderBalanceEdit();
        }
    });

}

var funct_Yesterday = function(date_str){
    Oneday = (24 * 60) * 60000;
    dateFormat = new Date(moment(date_str, "DD-MM-YYYY").toDate() - Oneday);
    return dateFormat.format("d/m/Y");
}

var funct_RangeDay = function(date_ini, date_fin){
    Oneday        = (24 * 60) * 60000;
    dateIni       = new Date(moment(date_ini, "DD-MM-YYYY").toDate());
    dateFin       = new Date(moment(date_fin, "DD-MM-YYYY").toDate());
    diff          = (dateFin - dateIni) + Oneday;

    return diff/(1000*60*60*24);
}

var funct_recalculaPlanPagos = function(){
    amortizaNexCapital = 1;
    amortizaNexInteres = 1;
    amortizaNex        = 1;
    fechaPagoTopCapital       = null;
    fechaPagoTopInteres       = null;
    fechaInicialCapital       = null;
    periodicidadInteres= solicitudObject.plazo_credito.periodicidad_pago_interes;
    periodicidadCapital= solicitudObject.plazo_credito.periodicidad_pago_capital;


    $.each(solicitudObject.plan_pagos,function(key_amortiza, item_balance){

        if (item_balance.apply_capital == 10 && item_balance.apply_interes == 10 ) {


            fechaPagoTopCapital = item_balance.fecha_pago;
            fechaPagoTopInteres = item_balance.fecha_pago;

            if (solicitudObject.plan_pagos.length > amortizaNex && amortizaNex > 1 ){
                solicitudObject.plan_pagos[key_amortiza].fecha_inicial = solicitudObject.plan_pagos[key_amortiza - 1].fecha_pago;
            }

            if (amortizaNex > 1 ){
                if (solicitudObject.plan_pagos.length > amortizaNex )
                    solicitudObject.plan_pagos[key_amortiza].fecha_fin     = funct_Yesterday(solicitudObject.plan_pagos[key_amortiza].fecha_pago);
            }else{

                if (amortizaNex == 1 ) {
                    solicitudObject.plan_pagos[key_amortiza].fecha_fin     = funct_Yesterday(solicitudObject.plan_pagos[key_amortiza].fecha_pago);
                }
            }
        }

        if (item_balance.apply_capital == 10 && item_balance.apply_interes == 20 ) {


            if (fechaPagoTopCapital){
                solicitudObject.plan_pagos[key_amortiza].fecha_inicial = fechaPagoTopCapital;
                solicitudObject.plan_pagos[key_amortiza].fecha_pago    = funct_getProxAmortizacion(fechaPagoTopCapital, periodicidadCapital);
                solicitudObject.plan_pagos[key_amortiza].fecha_fin     = funct_Yesterday(funct_getProxAmortizacion(fechaPagoTopCapital, periodicidadCapital));
            }

            fechaPagoTopCapital = item_balance.fecha_pago;

        }

        if (item_balance.apply_capital == 20 && item_balance.apply_interes == 10 ) {


            if (fechaPagoTopInteres){

                solicitudObject.plan_pagos[key_amortiza].fecha_inicial = fechaPagoTopInteres;
                solicitudObject.plan_pagos[key_amortiza].fecha_pago    = funct_getProxAmortizacion(fechaPagoTopInteres, periodicidadInteres);
                solicitudObject.plan_pagos[key_amortiza].fecha_fin     = funct_Yesterday(funct_getProxAmortizacion(fechaPagoTopInteres, periodicidadInteres));
            }

            fechaPagoTopInteres = item_balance.fecha_pago;
        }

        amortizaNex++;
    });
}

var funct_getProxAmortizacion = function(fechaPago, periodicidad){
    dateIni       = new Date(moment(fechaPago, "DD-MM-YYYY").toDate());
    getMeses      = periodicidadValueList[periodicidad];
    dateProxima   = dateIni.setMonth(dateIni.getMonth() + getMeses);

    return new Date(dateProxima).format("d/m/Y")
}




function dateFormater(date_str, separator) {
  var date_format = Date.parse(date_str);
  var date  = new Date(date_format);
  var day   = date.getDate();
  var month = date.getMonth() + 1;
  var year  = date.getFullYear();

  //console.log(date_format +" - "+ date_format + " - "+ date_str);

  if (day < 10) {
    day = '0' + day;
  }
  if (month < 10) {
    month = '0' + month;
  }

  return year + separator + month + separator + day;
}


var funct_get_cliente = function(params_id, tipo){
    funct_form_clean();
    if (params_id) {
        show_loader();
        $.get(VAR_PATH_URL+ "productofinanciero/solicitud/get-cliente",{ cliente_id_and_bp : params_id, tipo : tipo }, function(response){
            if (response.code == 202) {

                solicitudObject.cliente_id = response.cliente.id;

                toast("LINEA DE CREDITO", "BUSQUEDA CORRECTA", "success");
                $(".label-rfc").html(response.cliente.rfc);
                $(".label-curp").html(response.cliente.rfc);
                $(".label-riesgo").html(response.cliente.riesgo_text);
                $(".label-tipo").html(response.cliente.tipo_text);
                $(".label-status").html(response.cliente.status_text);
                $(".label-grupo-riesgo").html(response.cliente.grupo_riesgo);

                $inputFindClienteID.val(response.cliente.id);
                $inputFindClienteBP.val(response.cliente.uidx);

                if (response.cliente.tipo == 10 || response.cliente.tipo == 30) {
                    var newOption       = new Option(response.cliente.nombreCompleto, response.cliente.id, false, true);
                    $inputSelectCliente.append(newOption);
                }

                if (response.cliente.tipo == 20 || response.cliente.tipo == 40) {
                    var newOption       = new Option(response.cliente.razon_social, response.cliente.id, false, true);
                    $inputSelectCliente.append(newOption);
                }

                $containerSolicitud.fadeIn( 9000, function() {
                    $containerSolicitud.css({"opacity": "1"}).fadeIn( 100 );
                });
                //$inputSelectCliente.val();
            }else{
                toast("LINEA DE CREDITO", "VERIFICA TU INFORMACION", "warning");
            }
            hide_loader();
        }).fail(function() {
            toast("LINEA DE CREDITO", "ERROR EN EL SERVIDOR", "danger");
            hide_loader();
        });
    }
}


var fuct_cal_tasa_moratoria = function(){
    //if (!$formSolicitud.inputTasaMoratoriaValor.val()) {
        if (solicitudObject.tasa_interes.tasa_fija && $formSolicitud.inputTasaMoratoriaPuntos.val() && $formSolicitud.inputTasaMoratoriaOperador.val() && $formSolicitud.inputTasaMoratoriaFactor.val()  ) {
            $result = ( solicitudObject.tasa_interes.tasa_fija ? parseFloat(solicitudObject.tasa_interes.tasa_fija) : 0 ) +  parseFloat($formSolicitud.inputTasaMoratoriaPuntos.val());

            if ($formSolicitud.inputTasaMoratoriaOperador.val() == 10)
                $result = $result * $formSolicitud.inputTasaMoratoriaFactor.val();

            if ($formSolicitud.inputTasaMoratoriaOperador.val() == 20)
                $result = $result / $formSolicitud.inputTasaMoratoriaFactor.val();


            if ($formSolicitud.inputTasaMoratoriaOperador.val() == 30)
                $result = $result + $formSolicitud.inputTasaMoratoriaFactor.val();

            if ($formSolicitud.inputTasaMoratoriaOperador.val() == 40)
                $result = $result - $formSolicitud.inputTasaMoratoriaFactor.val();

            $formSolicitud.inputTasaMoratoriaValor.val($result);
            solicitudObject.tasa_interes.tasa_moratoria_valor = $result;
        }
    //}
}


var func_cal_tasa_variable = function()
{
    if (solicitudObject.tasa_interes.tasa_variable_indicador){
        valTasaVariable = parseFloat(solicitudObject.tasa_interes.tasa_variable_valor) + parseFloat((solicitudObject.tasa_interes.tasa_variable_punto_adicionales ? solicitudObject.tasa_interes.tasa_variable_punto_adicionales : 0));
        $formSolicitud.inputTasaVariable.val(valTasaVariable);
    }else{
        $formSolicitud.inputTasaVariable.val(null);
    }

}


var func_cal_plazo_diameses = function(){
    if ($formSolicitud.inputPeriodicidadPagoCapital.val() && $formSolicitud.inputNumeroPagoCapital.val() && $formSolicitud.inputFechaPrimerPagoCapital.val() ) {

        calFechaFinalPago  = "";

        fechaOtorgamiento       = new Date(moment(solicitudObject.fecha_credito, "DD-MM-YYYY").toDate());
        fechaUltimaAmortizacion = new Date(moment(solicitudObject.fecha_credito, "DD-MM-YYYY").toDate());
        fecha1Amortizacion      = new Date(moment($formSolicitud.inputFechaPrimerPagoCapital.val(), "DD-MM-YYYY").toDate()).getTime();
        getPeriodicidadMeses    = $formSolicitud.inputNumeroPagoCapital.val() * (periodicidadValueList[$formSolicitud.inputPeriodicidadPagoCapital.val()]);
        fechaUltimaAmortizacion = fechaUltimaAmortizacion.setMonth(fechaOtorgamiento.getMonth() + getPeriodicidadMeses);


        fechaOtorgamiento       = fechaOtorgamiento.setDate(fechaOtorgamiento.getDate() + 1);

        diff = fechaUltimaAmortizacion - fechaOtorgamiento;



        $formSolicitud.inputPlazoDias.val(diff/(1000*60*60*24) );
        $formSolicitud.inputPlazoMeses.val(getPeriodicidadMeses);
        $formSolicitud.inputFechaVencimiento.val(new Date(fechaUltimaAmortizacion).format("d/m/Y"));
        solicitudObject.fecha_vencimiento = $formSolicitud.inputFechaVencimiento.val();

    }
}




var func_valid_periodo_interes = function(){


    if ( $formSolicitud.inputPeriodicidadPagoInteres.val() && $formSolicitud.inputNumeroPagoInteres.val() && $formSolicitud.inputPeriodicidadPagoCapital.val() && $formSolicitud.inputNumeroPagoCapital.val() ) {

        getPerMesesCapital      = $formSolicitud.inputNumeroPagoCapital.val() * (periodicidadValueList[$formSolicitud.inputPeriodicidadPagoCapital.val()]);
        getPerMesesInteres      = $formSolicitud.inputNumeroPagoInteres.val() * (periodicidadValueList[$formSolicitud.inputPeriodicidadPagoInteres.val()]);

        if (getPerMesesInteres >  getPerMesesCapital) {
            $formSolicitud.inputNumeroPagoInteres.val(null);
            solicitudObject.plazo_credito.numero_pago_interes = 0;
            toast("SOLICITUD", "EL NUMERO DE PAGOS DE INTERES ES INCORRECTO, VERIFICA TU INFORMACION", "warning");

        }

    }
}


var func_valid_gracia = function(){
    $formSolicitud.inputGraciaPeriodo.attr('disabled', true);
    $formSolicitud.inputGraciaPagoPerido.attr('disabled', true);
    $formSolicitud.inputGraciaPagoCapital.attr('disabled', true);
    $formSolicitud.inputGraciaPeriodoInteres.attr('disabled', true);
    if ( $formSolicitud.inputApplyGracia.is(':checked') ) {
        $formSolicitud.inputGraciaPeriodo.attr('disabled', false);
        $formSolicitud.inputGraciaPagoPerido.attr('disabled', false);
        $formSolicitud.inputGraciaPagoCapital.attr('disabled', false);
        $formSolicitud.inputGraciaPeriodoInteres.attr('disabled', false);
    }else{
        $formSolicitud.inputGraciaPeriodo.val(null);
        $formSolicitud.inputGraciaPagoPerido.val(null);
        $formSolicitud.inputGraciaPagoCapital.val(null);
        $formSolicitud.inputGraciaPeriodoInteres.val(null);
    }
}

var func_valid_pagos_inicial = function(){
    $formSolicitud.inputFechaPrimerPagoCapital.attr("disabled",true);
    $formSolicitud.inputFechaPrimerPagoInteres.attr("disabled",true);
    if ($formSolicitud.inputFechaCredito.val() && $formSolicitud.inputPeriodicidadPagoCapital.val() && $formSolicitud.inputPeriodicidadPagoInteres.val() && $formSolicitud.inputNumeroPagoCapital.val() && $formSolicitud.inputNumeroPagoInteres.val() ) {
        $formSolicitud.inputFechaPrimerPagoCapital.attr("disabled",false);
        $formSolicitud.inputFechaPrimerPagoInteres.attr("disabled",false);

        getFechaAlta       = new Date(moment($formSolicitud.inputFechaCredito.val(), "DD-MM-YYYY").toDate());

        getFechaAlta    = getFechaAlta.setDate(getFechaAlta.getDate() + 1);

        $formSolicitud.inputFechaPrimerPagoCapital.parent().kvDatepicker('setStartDate', new Date(getFechaAlta));
        $formSolicitud.inputFechaPrimerPagoInteres.parent().kvDatepicker('setStartDate', new Date(getFechaAlta));

        getFechaAltaMesCap        = new Date(moment($formSolicitud.inputFechaCredito.val(),"DD-MM-YYYY").toDate());
        setFechaAltaMesCap        = new Date(moment($formSolicitud.inputFechaCredito.val(),"DD-MM-YYYY").toDate());


        setFechaAltaMesCap         = setFechaAltaMesCap.setMonth(getFechaAltaMesCap.getMonth() + periodicidadValueList[$formSolicitud.inputPeriodicidadPagoCapital.val()] );
        setFechaAltaMesCap         = new Date(setFechaAltaMesCap);
        setFechaAltaMesCap         = setFechaAltaMesCap.setDate(setFechaAltaMesCap.getDate() + 1);


        getFechaAltaMesInt        = new Date(moment($formSolicitud.inputFechaCredito.val(),"DD-MM-YYYY").toDate());
        setFechaAltaMesInt        = new Date(moment($formSolicitud.inputFechaCredito.val(),"DD-MM-YYYY").toDate());

        setFechaAltaMesInt         = setFechaAltaMesInt.setMonth(getFechaAltaMesInt.getMonth() + periodicidadValueList[$formSolicitud.inputPeriodicidadPagoCapital.val()]);
        setFechaAltaMesInt         = new Date(setFechaAltaMesInt);
        setFechaAltaMesInt         = setFechaAltaMesInt.setDate(setFechaAltaMesInt.getDate() + 1);



        $formSolicitud.inputFechaPrimerPagoCapital.parent().kvDatepicker('setEndDate', new Date(setFechaAltaMesCap));
        $formSolicitud.inputFechaPrimerPagoInteres.parent().kvDatepicker('setEndDate', new Date(setFechaAltaMesInt));
    }
}


var funct_valid_garantia_required  = function(){

    funct_clear_garantia_required();

    if(!$formGarantia.inputGarantiaTipo.val())
        $formGarantia.inputGarantiaTipo.parent().addClass("has-error");
    if(!$formGarantia.inputPerteneceNoFinanciera.val())
        $formGarantia.inputPerteneceNoFinanciera.parent().addClass("has-error");
    if(!$formGarantia.inputGarantiaMoneda.val())
        $formGarantia.inputGarantiaMoneda.parent().addClass("has-error");
    if(!$formGarantia.inputGarantiaValor.val())
        $formGarantia.inputGarantiaValor.parent().parent().addClass("has-error");
    if(!$formGarantia.inputGarantiaDescripcion.val())
        $formGarantia.inputGarantiaDescripcion.parent().addClass("has-error");


}

var funct_clear_garantia_required = function(){
    $formGarantia.inputGarantiaTipo.parent().removeClass("has-error");
    $formGarantia.inputPerteneceNoFinanciera.parent().removeClass("has-error");
    $formGarantia.inputGarantiaMoneda.parent().removeClass("has-error");
    $formGarantia.inputGarantiaValor.parent().parent().removeClass("has-error");
    $formGarantia.inputGarantiaDescripcion.parent().removeClass("has-error");

}

var funct_clear_form_garantia = function(){
    $formGarantia.inputGarantiaTipo.val(null).trigger('change');
    $formGarantia.inputPerteneceNoFinanciera.val(null);
    $formGarantia.inputGarantiaMoneda.val(null);
    $formGarantia.inputGarantiaValor.val(null);
    $formGarantia.inputGarantiaValorPorcentaje.val(null);
    $formGarantia.inputGarantiaDescripcion.val(null);
    $formGarantia.inputPerteneceRealFinancieraLiquida.val(null);

    funct_clear_garantia_required();
};

var funct_no_aplica_pagos_anticipados = function(){
    $formSolicitud.inputCreditoPa.attr("disabled", true);
    $formSolicitud.inputFrecuenciaPa.attr("disabled", true);
    $formSolicitud.inputOperacionesMaxPa.attr("disabled",true);
    $formSolicitud.inputOperacionesMinPa.attr("disabled",true);
    $formSolicitud.inputMontoPagoPa.attr("disabled", true);
    $formSolicitud.inputInstrumentoPa.attr("disabled", true);
    $formSolicitud.inputMonedaPa.attr("disabled", true);

};

var confirmSaveSolicitud = function()
{
    if (valid_form_create()) {


        $.post(VAR_PATH_URL + "productofinanciero/solicitud/post-registro-solicitud", { solicitudObject : solicitudObject }, function(responseRegistro){
            if (responseRegistro.code == 202 ) {

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 5000
                };
                toastr.success('SE REGISTRO CORRECTAMENTE');

                window.location.href  = VAR_PATH_URL + "productofinanciero/solicitud/index";
            }else{

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 5000
                };
                toastr.warning('OCURRIO UN ERROR, INTENTA NUEVAMENTE');

            }
        });
    }else{
        hide_loader();
    }
}


var render_garantiasAvales = function(){
    $('.container-garantias').html(false);
    containerGarantia = '';
    $.each(solicitudObject.garantias, function(key, item_garantia){
        containerGarantia += '<tr>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_garantia.garantiaTipoText +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_garantia.garantiaMonedaText +'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ ( item_garantia.perteneceRealFinancieraLiquida == 10 ?  btf.conta.porcentaje(item_garantia.garantiaValorPorcentaje): btf.conta.money(item_garantia.garantiaValor) )+'</p></td>'+
            '<td class="text-center"><p style="color:#000; font-weight:400; font-size:16px">'+ item_garantia.garantiaDescripcion +'</p></td>';

            if (item_garantia.status == GARANTIA_ACTIVO && item_garantia.create == ON )
                containerGarantia +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_garantiaAval('+ item_garantia.element_id +')"><i class="fa fa-trash"></i></button></td>';

            if (item_garantia.status == GARANTIA_ACTIVO && item_garantia.create == OFF )
                containerGarantia +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_garantiaAval('+ item_garantia.element_id +')"><i class="fa fa-level-down"></i></button></td>';

            if (item_garantia.status == GARANTIA_BAJA  )
                containerGarantia +=  '<td  class="text-center"></td>';

        containerGarantia += '</tr>';
    });

    $('.container-garantias').html(containerGarantia);
}


var drop_garantiaAval = function(element_id){

    $.each(solicitudObject.garantias, function(key_garantia, item_garantia){
        if (item_garantia.element_id == element_id )
            solicitudObject.garantias.splice(key_garantia,1);
    });

    render_garantiasAvales();
};

var baja_garantiaAval = function(element_id){

    $.each(solicitudObject.garantias, function(key_garantia, item_garantia){
        if (item_garantia.element_id == element_id )
            solicitudObject.garantias[key_garantia].status = TELEFONO_BAJA;
    });

    render_garantiasAvales();
};

var funct_form_clean = function(){
    $contentBalance.html(false);
    //$btnGenerateBalance.hide();
    $(".lbl-tipo_credito").html('-------- --------------');
    $formSolicitud.inputTasaFija.val(null);
    $formSolicitud.inputTasaVariable.val(null);
    $formSolicitud.inputMonto.val(null);
    $formSolicitud.inputNumeroPagoCapital.val(null);
    $formSolicitud.inputNumeroPagoInteres.val(null);

    $(".label-text").html(' ---------------- ');
    $inputFindClienteID.val(null);
    $inputFindClienteBP.val(null);
    $inputSelectCliente.val(null);
    $inputSelectCliente.html(null);
    $containerSolicitud.css({"opacity": "0.3"}).first().fadeIn( 4000 );
}




/**************GENERAR BALANCE*****************/

var loader_balance = function(){
    return '<tr>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
    '</tr>';
}


var funct_get_info_seccion = function(){
    if (solicitudObject.solicitud_id) {
        $.get( VAR_PATH_URL + "productofinanciero/solicitud/get-solicitud-detail",{ solicitud_id : solicitudObject.solicitud_id }, function(respSolicitud){
            if (respSolicitud.code == 202) {

                solicitudObject.cliente_id                      = respSolicitud.solicitud.cliente_id;

                solicitudObject.cliente_bp                      = respSolicitud.solicitud.cliente_bp;
                solicitudObject.cliente_status                  = respSolicitud.solicitud.cliente_status;
                solicitudObject.cliente_text                    = respSolicitud.solicitud.cliente_text;
                solicitudObject.config_producto_financiero_id   = respSolicitud.solicitud.config_producto_financiero_id;
                solicitudObject.config_producto_financiero_text = respSolicitud.solicitud.config_producto_financiero_text;
                solicitudObject.promotor_id                   = respSolicitud.solicitud.promotor_id;
                solicitudObject.promotor_text                 = respSolicitud.solicitud.promotor_text;
                solicitudObject.comite_id                   = respSolicitud.solicitud.comite_id;
                solicitudObject.comite_text                 = respSolicitud.solicitud.comite_text;
                solicitudObject.region_id                     = respSolicitud.solicitud.region_id;
                solicitudObject.region_text                   = respSolicitud.solicitud.region_text;
                solicitudObject.plaza_id                      = respSolicitud.solicitud.plaza_id;
                solicitudObject.plaza_text                    = respSolicitud.solicitud.plaza_text;
                solicitudObject.sucursal_id                   = respSolicitud.solicitud.sucursal_id;
                solicitudObject.sucursal_text                 = respSolicitud.solicitud.sucursal_text;
                solicitudObject.fecha_credito                 = respSolicitud.solicitud.fecha_credito;
                solicitudObject.loan_number                   = respSolicitud.solicitud.loan_number;
                solicitudObject.destino_credito               = respSolicitud.solicitud.destino_credito;
                solicitudObject.plan_comision_id              = respSolicitud.solicitud.plan_comision_id;
                solicitudObject.perfil_transaccional_id       = respSolicitud.solicitud.perfil_transaccional_id;
                solicitudObject.monto                         = btf.conta.miles(respSolicitud.solicitud.monto);
                solicitudObject.descripcion                   = respSolicitud.solicitud.descripcion;
                solicitudObject.actividad_economica_id        = respSolicitud.solicitud.actividad_economica_id;
                solicitudObject.actividad_economica_text      = respSolicitud.solicitud.actividad_economica_text;
                solicitudObject.moneda                        = respSolicitud.solicitud.moneda;

                solicitudObject.moneda_text                   = respSolicitud.solicitud.moneda_text;
                solicitudObject.moneda_pf                     = respSolicitud.solicitud.moneda_pf;
                solicitudObject.credito                       = respSolicitud.solicitud.credito;
                solicitudObject.frecuencia                    = respSolicitud.solicitud.frecuencia;
                solicitudObject.operaciones_max               = respSolicitud.solicitud.operaciones_max;
                solicitudObject.operaciones_min               = respSolicitud.solicitud.operaciones_min;
                solicitudObject.monto_del_pago                = respSolicitud.solicitud.monto_del_pago;
                solicitudObject.instrumento                   = respSolicitud.solicitud.instrumento;

                solicitudObject.moneda_text_pa                = respSolicitud.solicitud.moneda_text_pa;
                solicitudObject.moneda_pa                     = respSolicitud.solicitud.moneda_pa;
                solicitudObject.credito_pa                    = respSolicitud.solicitud.credito_pa;
                solicitudObject.frecuencia_pa                 = respSolicitud.solicitud.frecuencia_pa;
                solicitudObject.operaciones_max_pa            = respSolicitud.solicitud.operaciones_max_pa;
                solicitudObject.operaciones_min_pa            = respSolicitud.solicitud.operaciones_min_pa;
                solicitudObject.monto_del_pago_pa             = respSolicitud.solicitud.monto_del_pago_pa;
                solicitudObject.instrumento_pa                = respSolicitud.solicitud.instrumento_pa;

                solicitudObject.plazo_credito.periodicidad_pago_capital = respSolicitud.solicitud.periodicidad_pago_capital;
                solicitudObject.plazo_credito.numero_pago_capital       = respSolicitud.solicitud.numero_pago_capital;
                solicitudObject.plazo_credito.fecha_primer_pago_capital = respSolicitud.solicitud.fecha_primer_pago_capital;
                solicitudObject.plazo_credito.plazo_en_dias             = respSolicitud.solicitud.plazo_en_dias;
                solicitudObject.plazo_credito.plazo_en_meses            = respSolicitud.solicitud.plazo_en_meses;
                solicitudObject.plazo_credito.periodicidad_pago_interes = respSolicitud.solicitud.periodicidad_pago_interes;
                solicitudObject.plazo_credito.numero_pago_interes       = respSolicitud.solicitud.numero_pago_interes;
                solicitudObject.plazo_credito.fecha_primer_pago_interes = respSolicitud.solicitud.fecha_primer_pago_interes;

                solicitudObject.plazo_credito.apply_gracia              = respSolicitud.solicitud.apply_gracia;
                solicitudObject.plazo_credito.gracia_periodo            = respSolicitud.solicitud.gracia_periodo;
                solicitudObject.plazo_credito.gracia_pago_interes       = respSolicitud.solicitud.gracia_pago_interes;

                solicitudObject.comision_clave                          = respSolicitud.solicitud.comision_clave;
                solicitudObject.comision_descripcion                    = respSolicitud.solicitud.comision_descripcion;
                solicitudObject.comision_id                             = respSolicitud.solicitud.comision_id;
                solicitudObject.comision_creador                        = respSolicitud.solicitud.comision_creador;
                solicitudObject.comision_fecha                          = respSolicitud.solicitud.comision_fecha; 
                solicitudObject.comision_estatus                         = respSolicitud.solicitud.comision_estatus;


                solicitudObject.tasa_interes.tipo_tasa                  = respSolicitud.solicitud.tipo_tasa;
                solicitudObject.tasa_interes.tasa_fija                  = respSolicitud.solicitud.tasa_fija;
                solicitudObject.tasa_interes.tasa_fija_departamento_id  = respSolicitud.solicitud.tasa_fija_departamento_id;
                solicitudObject.tasa_interes.tasa_fija_usuario_id       = respSolicitud.solicitud.tasa_fija_usuario_id;
                solicitudObject.tasa_interes.tasa_variable              = respSolicitud.solicitud.tasa_variable;
                solicitudObject.tasa_interes.tasa_moratoria_indicador   = respSolicitud.solicitud.tasa_moratoria_indicador;
                solicitudObject.tasa_interes.tasa_moratoria_puntos      = respSolicitud.solicitud.tasa_moratoria_puntos;
                solicitudObject.tasa_interes.tasa_moratoria_operador    = respSolicitud.solicitud.tasa_moratoria_operador;
                solicitudObject.tasa_interes.tasa_moratoria_factor      = respSolicitud.solicitud.tasa_moratoria_factor;
                solicitudObject.tasa_interes.tasa_moratoria_valor       = respSolicitud.solicitud.tasa_moratoria_valor;
                solicitudObject.tasa_interes.tasa_variable_valor        = respSolicitud.solicitud.tasa_variable_valor;
                solicitudObject.tasa_interes.tasa_variable_indicador   = respSolicitud.solicitud.tasa_variable_indicador;
                solicitudObject.tasa_interes.tasa_variable_punto_adicionales   = respSolicitud.solicitud.tasa_variable_punto_adicionales;
                solicitudObject.tasa_interes.tasa_variable_periodicidad        = respSolicitud.solicitud.tasa_variable_periodicidad;
                solicitudObject.tasa_interes.tasa_variable_dia_revision        = respSolicitud.solicitud.tasa_variable_dia_revision;
                solicitudObject.tasa_interes.tasa_variable_proxima_revision    = respSolicitud.solicitud.tasa_variable_proxima_revision;
                solicitudObject.garantias                                       = respSolicitud.solicitud.garantias;




                $inputFindClienteID.val(solicitudObject.cliente_id);
                $inputFindClienteBP.val(solicitudObject.cliente_bp);
                $inputSolicitudID.val(solicitudObject.solicitud_id);

                var newOption       = new Option(solicitudObject.cliente_text, solicitudObject.cliente_id, false, true);
                $inputSelectCliente.append(newOption);



                $formSolicitud.inputClienteID.val(solicitudObject.cliente_id);
                $formSolicitud.inputPromotor.val(solicitudObject.promotor_id);
                $formSolicitud.inputComite.val(solicitudObject.comite_id);
                $formSolicitud.inputFechaCredito.val(solicitudObject.fecha_credito);
                $formSolicitud.inputLoanNumber.val(solicitudObject.loan_number);
                $formSolicitud.inputProductoFinanciero.val(solicitudObject.config_producto_financiero_id);
                $formSolicitud.inputDestinoCredito.val(solicitudObject.destino_credito);
                $formSolicitud.inputPlanComision.val(solicitudObject.plan_comision_id);
                $formSolicitud.inputPlanComisionClave.val(solicitudObject.comision_clave);
                $formSolicitud.inputPlanComisionDescripcion.val(solicitudObject.comision_descripcion);
                $formSolicitud.inputPlanComisionId.val(solicitudObject.comision_id);
                $formSolicitud.inputPlanComisionCreador.val(solicitudObject.comision_creador);
                $formSolicitud.inputPlanComisionFecha.val(solicitudObject.comision_fecha);
                $formSolicitud.inputPlanComisionStatus.val(solicitudObject.comision_estatus);

                $formSolicitud.inputPerfilTransaccional.val(solicitudObject.perfil_transaccional_id);

                $formSolicitud.inputCredito.val(solicitudObject.credito);
                $formSolicitud.inputFrecuencia.val(solicitudObject.frecuencia);
                $formSolicitud.inputOperacionesMax.val(solicitudObject.operaciones_max);
                $formSolicitud.inputOperacionesMin.val(solicitudObject.operaciones_min);
                $formSolicitud.inputMontoPago.val(solicitudObject.monto_del_pago);
                $formSolicitud.inputInstrumento.val(solicitudObject.instrumento);
                $formSolicitud.inputMoneda.val(solicitudObject.moneda);

                $formSolicitud.inputCreditoPa.val(solicitudObject.credito_pa);
                $formSolicitud.inputFrecuenciaPa.val(solicitudObject.frecuencia_pa);
                $formSolicitud.inputOperacionesMaxPa.val(solicitudObject.operaciones_max_pa);
                $formSolicitud.inputOperacionesMinPa.val(solicitudObject.operaciones_min_pa);
                $formSolicitud.inputMontoPagoPa.val(solicitudObject.monto_del_pago_pa);
                $formSolicitud.inputInstrumentoPa.val(solicitudObject.instrumento_pa);
                $formSolicitud.inputMonedaPa.val(solicitudObject.moneda_pa);

                


                $formSolicitud.inputMonto.val(solicitudObject.monto);
                $formSolicitud.inputMonedaPF.val(solicitudObject.moneda_pf);
            
               

                var newOption       = new Option(solicitudObject.actividad_economica_text, solicitudObject.actividad_economica_id, false, true);
                $formSolicitud.inputProductoScian.append(newOption);

                $formSolicitud.inputPlaza.append(new Option(solicitudObject.plaza_text,solicitudObject.plaza_id, false, true));
                $formSolicitud.inputRegion.append(new Option(solicitudObject.region_text,solicitudObject.region_id , false, true));
                $formSolicitud.inputSucursal.append(new Option(solicitudObject.sucursal_text,solicitudObject.sucursal_id, false, true));

                $formSolicitud.inputPeriodicidadPagoCapital.val(solicitudObject.plazo_credito.periodicidad_pago_capital);
                $formSolicitud.inputNumeroPagoCapital.val(solicitudObject.plazo_credito.numero_pago_capital);
                $formSolicitud.inputFechaPrimerPagoCapital.val(solicitudObject.plazo_credito.fecha_primer_pago_capital);
                $formSolicitud.inputPlazoDias.val(solicitudObject.plazo_credito.plazo_en_dias);
                $formSolicitud.inputPlazoMeses.val(solicitudObject.plazo_credito.plazo_en_meses);
                $formSolicitud.inputPeriodicidadPagoInteres.val(solicitudObject.plazo_credito.periodicidad_pago_interes);
                $formSolicitud.inputNumeroPagoInteres.val(solicitudObject.plazo_credito.numero_pago_interes);
                $formSolicitud.inputFechaPrimerPagoInteres.val(solicitudObject.plazo_credito.fecha_primer_pago_interes);

                $formSolicitud.inputGraciaPeriodo.val(solicitudObject.plazo_credito.gracia_periodo);
                $formSolicitud.inputGraciaPagoPerido.val(solicitudObject.plazo_credito.gracia_pago_interes);

                if (solicitudObject.plazo_credito.apply_gracia == ON) {
                    $formSolicitud.inputApplyGracia.prop('checked',true);
                    $formSolicitud.inputGraciaPeriodo.attr('disabled',)
                }



                $formSolicitud.inputTasaFija.val(solicitudObject.tasa_interes.tasa_fija);

                $formSolicitud.inputTasaVariable.val(solicitudObject.tasa_interes.tasa_variable);
                $formSolicitud.inputTasaVariableIndicador.val(solicitudObject.tasa_interes.tasa_variable_indicador);
                $formSolicitud.inputTasaVariablePuntoAdicional.val(solicitudObject.tasa_interes.tasa_variable_punto_adicionales);
                $formSolicitud.inputTasaVariablePeriodicidad.val(solicitudObject.tasa_interes.tasa_variable_periodicidad);
                $formSolicitud.inputTasaVariableDiaRevision.val(solicitudObject.tasa_interes.tasa_variable_dia_revision);
                $formSolicitud.inputTasaVariableProximaRevision.val(solicitudObject.tasa_interes.tasa_variable_proxima_revision);
                $formSolicitud.inputTasaFijaUsuario.val(solicitudObject.tasa_interes.tasa_fija_usuario_id);
                $formSolicitud.inputTasaFijaDepartamento.val(solicitudObject.tasa_interes.tasa_fija_departamento_id);
                $formSolicitud.inputTasaMoratoriaIndicador.val(solicitudObject.tasa_interes.tasa_moratoria_indicador);
                $formSolicitud.inputTasaMoratoriaPuntos.val(solicitudObject.tasa_interes.tasa_moratoria_puntos);
                $formSolicitud.inputTasaMoratoriaOperador.val(solicitudObject.tasa_interes.tasa_moratoria_operador);
                $formSolicitud.inputTasaMoratoriaFactor.val(solicitudObject.tasa_interes.tasa_moratoria_factor);
                $formSolicitud.inputTasaMoratoriaValor.val(solicitudObject.tasa_interes.tasa_moratoria_valor);


                $formSolicitud.inputTipoTasa.val(solicitudObject.tasa_interes.tipo_tasa).change();

                $("#text-solicitud-tasa_fija_anualizada_minima").html(respSolicitud.solicitud.tasa_fija_minima +'%');
                $("#text-solicitud-tasa_fija_anualizada_maxima").html(respSolicitud.solicitud.tasa_fija_maxima +'%');


                $(".lbl_producto_clave").html(respSolicitud.solicitud.actividad_economica_clave);
                $(".lbl_producto_clase").html(respSolicitud.solicitud.actividad_economica_sub_rama);
                $(".lbl_producto_producto").html(respSolicitud.solicitud.actividad_economica_producto);

                $(".label-rfc").html(respSolicitud.solicitud.cliente_rfc);
                $(".label-curp").html(respSolicitud.solicitud.cliente_curp);
                $(".label-riesgo").html(respSolicitud.solicitud.cliente_riesgo_text);
                $(".label-tipo").html(respSolicitud.solicitud.cliente_tipo_text);
                $(".label-status").html(solicitudObject.cliente_status);


                $containerSolicitud.fadeIn( 9000, function() {
                    $containerSolicitud.css({"opacity": "1"}).fadeIn( 100 );
                });

                $formSolicitud.inputMonto.mask('000,000,000,000,000.00', {reverse: true});

                funct_getBalanceAmortiza();
                render_garantiasAvales();
            }
        });
    }
    
}


var valid_balance = function()
{
    if (!$formSolicitud.inputMonto.val() || parseFloat($formSolicitud.inputMonto.val().replaceAll(',','')) == 0 ) {
        toast("TPV", "Debes ingresar un monto para generar el balance", "warning");
        return false;
    }

    if (!solicitudObject.fecha_credito) {
        toast("TPV", "La fecha del credito es requerido, intenta nuevamente", "warning");
        return false;
    }

    /*if (!$formSolicitud.inputTasaFija.val() || parseFloat($formSolicitud.inputTasaFija.val().replaceAll(',','')) == 0 ) {
        toast("TPV", "Debes ingresar un Tasa para generar el balance", "warning");
        return false;
    }*/

    /*if (!$formSolicitud.inputPlazo.val() || parseFloat($formSolicitud.inputPlazo.val().replaceAll(',','')) == 0 ) {
        toast("TPV", "Debes ingresar un Plazo para generar el balance", "warning");
        return false;
    }*/

    /*if (!$formSolicitud.inputApplyCalculo.val()) {
        toast("TPV", "Debes seleccionar un TIPO CALCULO para generar el balance", "warning");
        return false;
    }*/

    return true;

}

var valid_form_create = function()
{
    if (!$formSolicitud.inputMonto.val() || parseFloat($formSolicitud.inputMonto.val().replaceAll(',','')) == 0 ) {
        toast("TPV", "EL MONTO ES REQUERIDO", "warning");
        return false;
    }

    /*if (!$formSolicitud.inputTasa.val() || parseFloat($formSolicitud.inputTasa.val().replaceAll(',','')) == 0 ) {
        toast("TPV", "LA TASA ES REQUERIDO", "warning");
        return false;
    }*/

    /*if (!$formSolicitud.inputPlazo.val() || parseFloat($formSolicitud.inputPlazo.val().replaceAll(',','')) == 0 ) {
        toast("TPV", "EL PLAZO ES REQUERIDO", "warning");
        return false;
    }*/

    return true;

}

var funct_form_garantia = function()
{
    if (!$formGarantia.inputGarantiaTipo.val()) {
        toast("TPV", "EL TIPO DE GARANTIA ES REQUERIDO", "warning");
        $formGarantia.inputGarantiaTipo.parent().addClass("has-error");
        return false;
    }

    if (!$formGarantia.inputGarantiaMoneda.val()) {
        toast("TPV", "LA MONEDA DE GARANTIA ES REQUERIDO", "warning");
        $formGarantia.inputGarantiaMoneda.parent().addClass("has-error");
        return false;
    }

    if ($formGarantia.inputGarantiaTipo.val() != GARANTIA_FINANCIERA) {
        if ( !$formGarantia.inputGarantiaValor.val() || parseFloat($formGarantia.inputGarantiaValor.val().replaceAll(',','')) == 0 ) {
            toast("TPV", "EL VALOR DE GARANTIA ES REQUERIDO", "warning");
            $formGarantia.inputGarantiaTipo.parent().addClass("has-error");
            return false;
        }
    }

    if (!$formGarantia.inputGarantiaDescripcion.val()) {
        toast("TPV", "LA DESCRIPCION DE GARANTIA ES REQUERIDO", "warning");
        $formGarantia.inputGarantiaDescripcion.parent().addClass("has-error");
        return false;
    }




 if ($formGarantia.inputGarantiaTipo.val() == 10){

    if (!$formGarantia.inputPerteneceRealFinancieraLiquida.val()){
        toast("TPV", "ES NECESARIO ESCOGER UNA OPCION DE GARANTIA", "warning");
        $formGarantia.inputGarantiaValor.parent().addClass("has-error");
        return false;
    }
}
if ($formGarantia.inputPerteneceRealFinancieraLiquida.val() == 10) {

    if (!$formGarantia.inputGarantiaValorPorcentaje.val()) {
        toast("TPV", "EL VALOR DEL PORCENTAJE ES NECESARIO", "warning");
        $formGarantia.inputGarantiaValorPorcentaje.parent().addClass("has-error");
        return false;
    }

}

    if ($formGarantia.inputPerteneceRealFinancieraLiquida.val() == 20) {

        if (!$formGarantia.inputGarantiaValor.val()) {
        toast("TPV", "EL VALOR DE LA GARANTIA ES NECESARIO", "warning");
        $formGarantia.inputGarantiaValor.parent().addClass("has-error");
        return false;
        }
      
    }

    return true;
}





/*******************END**********************/


var closeSaveProducto = function()
{
    $('#modal-confirm-save-solicitud').modal('hide');
    hide_loader();
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

var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}

var hide_loader = function(){
    $('#page_loader').remove();
}





var render_container = function()
{
    $containerList.html("");
    item_count = 0;
    template_producto  = "";
    $formSolicitud.inputPlanComisionDescripcion.val(planComisionObject.descripcion);
    $formSolicitud.inputPlanComisionId.val(planComisionObject.id);
    $formSolicitud.inputPlanComisionClave.val(planComisionObject.clave);
    $formSolicitud.inputPlanComisionFecha.val(planComisionObject.fecha);
    $formSolicitud.inputPlanComisionCreador.val(planComisionObject.creador);
    $formSolicitud.inputPlanComisionStatus.val(planComisionObject.estatus);
    $.each(planComisionObject.comisionList, function(key, element){
        if (element.item_id) {
            item_count++;
            template_producto += '<tr class="text-center" style="'+ ( element.status == COMISION_BAJA ? 'background: #7c7070;color: #fff;' : '' )+'">'+
                '<td style="font-size: 18px;font-weight: 600;">'+ item_count +'</td>'+
                '<td style="font-size: 12px;font-weight: 600;">'+ element.codigo +'</td>'+
                '<td style="font-size: 12px;font-weight: 600;">'+ element.nombre +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ element.descripcion +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ (element.apply_aplica_por == VAR_POR_PORCENTAJE?  'PORCENTAJE': 'MONTO FIJO') +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ (element.apply_porcentaje ? btf.conta.porcentaje(element.apply_porcentaje) : '') +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ (element.apply_monto ? btf.conta.money(element.apply_monto) : '')  +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ element.impuesto_text +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ element.aplica_por_text +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ element.periodicidad_cobro_text +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ element.base_cobro_text +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ (element.apply_autorizacion == ON ? 'SI' : 'NO') +'</td>'+
                '<td style="font-size: 14px;font-weight: 600;">'+ (element.apply_autorizacion == ON ? element.autorizador_id_text  : '') +'</td>';
            template_producto += '</tr>';
        }
    });

    $containerList.html(template_producto);

    //$inputCompraDetalleArray.val(JSON.stringify(planComisionObject.comisionList));
};

var init = function(){
 
  $comisionID = $formSolicitud.inputPlanComisionId.val();
  // alert($comisionID); 
    if ($comisionID) {
        $.get(VAR_PATH_URL + "configuracion/comision/get-plan-comision", {'plan_comision_id' : $comisionID }, function(response) {
            if ( response.code == 202 )
                planComisionObject = response.planComisionObject;

            render_container();
        }, 'json');
    }
}



