 $(function () {
    $wizard             = $("#wizard");

    $wizard.steps({
        onInit : function(event, currentIndex){

        	$formGenerales = {
                inputProductoId       	: $('#configproductofinanciero-producto_id'),
                inputNombre         	: $('#configproductofinanciero-nombre'),
                inputTipoCredito      	: $('#configproductofinanciero-tipo_credito'),
                inputMoneda     		: $('#configproductofinanciero-moneda'),
                inputApplyCambioMoneda  : $('#configproductofinanciero-apply_cambio_moneda'),
                inputMontoMinimo        : $('#configproductofinanciero-monto_minimo'),
                inputMontoMaximo		: $('#configproductofinanciero-monto_maximo'),

                inputTasaFijaMinima     : $('#configproductofinanciero-tasa_fija_minima'),
                inputTasaFijaMaxima     : $('#configproductofinanciero-tasa_fija_maxima'),

                inputMonedaLimites		: $('#configproductofinanciero-moneda_limites'),
                inputPlazoCreditoMinimo : $('#configproductofinanciero-plazo_credito_minimo'),
                inputPlazoCreditoMaximo : $('#configproductofinanciero-plazo_credito_maximo'),
                inputApplyCambioPlazo 	: $('#configproductofinanciero-apply_cambio_plazo'),
                inputApplyProductoOpt1 	: $('#configproductofinanciero-apply_producto_opt_1'),
                inputApplyProductoOpt2 	: $('#configproductofinanciero-apply_producto_opt_2'),
                inputApplyFechaVigencia : $('#configproductofinanciero-apply_fecha_vigencia'),
                inputFechaInicial 		: $('#configproductofinanciero-fecha_inicial'),
                inputFechaFinal 		: $('#configproductofinanciero-fecha_final'),
            };

            $formTasaInteres = {
              inputCapitalBase           : $('#configproductofinanciero-capital_base'),
              inputTipoInteres          : $('#configproductofinanciero-tipo_interes'),
              inputTipoTasa             : $('#configproductofinanciero-tipo_tasa'),
              inputApplyCambioTasa      : $('#configproductofinanciero-apply_cambio_tasa'),
              inputIndiceReferencia     : $('#configproductofinanciero-indice_referencia'),
              inputPuntoSobreTasa       : $('#configproductofinanciero-punto_sobre_tasa'),
              inputPeriodoActTasa       : $('#configproductofinanciero-periodo_actualizacion_tasa'),
              inputPeriodicidad         : $('#configproductofinanciero-periodicidad'),
            };

            ON                      = 10;
            OFF                     = 20;
            SECCION_GENERAL         = 10;
            TASA_FIJA               = 10;
            TASA_VARIABLE           = 20;
            VAR_PATH_URL            = $('body').data('url-root');
            prFinancieroObject           = {
                "generales": {
                    "pr_financiero_id"         : $('#configproductofinanciero-id').val() ? $('#configproductofinanciero-id').val() : null,
                    "clave"                 : null,
                    "nombre"                : null,
                    "tipo_credito"          : null,
                    "tipo_credito_text"     : null,
                    "moneda"                : null,
                    "moneda_text"           : null,
                    "apply_cambio_moneda"   : null,
                    "monto_minimo"          : null,
                    "monto_maximo"          : null,
                    "moneda_para_limite"    : null,
                    "plazo_credito_minimo"  : null,
                    "plazo_credito_maximo"  : null,
                    "apply_cambio_plazo"    : null,
                    "apply_producto"        : null,
                    "apply_fecha_vigencia"  : null,
                    "fecha_inicial"         : null,
                    "fecha_final"           : null,
                },
                "tasa_interes" : {
                    "pr_financiero_id"          : $('#configproductofinanciero-id').val() ? $('#configproductofinanciero-id').val() : null,
                    "capital_base"              : null,
                    "tipo_interes"              : null,
                    "tipo_tasa"                 : null,
                    "apply_cambio_tasa"         : null,
                    "indice_referencia"         : null,
                    "punto_sobre_tasa"          : null,
                    "periodo_actualizacion_tasa": null,
                    "tasa_fija_minima"      : null,
                    "tasa_fija_maxima"      : null,
                    "periodicidad"              : null,
                }
            };

            funct_get_info_seccion();

            $('#configproductofinanciero-monto_maximo').mask('000,000,000,000,000.00', {reverse: true});
            $('#configproductofinanciero-monto_minimo').mask('000,000,000,000,000.00', {reverse: true});
            $('#configproductofinanciero-moneda_limites').mask('000,000,000,000,000.00', {reverse: true});


            $('.form-info-general :input').on('change', function(){
                prFinancieroObject.generales.clave                   = $formGenerales.inputProductoId.val();
                prFinancieroObject.generales.nombre                  = $formGenerales.inputNombre.val();
                prFinancieroObject.generales.tipo_credito            = $formGenerales.inputTipoCredito.val();
                prFinancieroObject.generales.moneda                  = $formGenerales.inputMoneda.val();
                prFinancieroObject.generales.apply_cambio_moneda     = $formGenerales.inputApplyCambioMoneda.is(':checked') ? ON: OFF;
                prFinancieroObject.generales.monto_minimo            = parseFloat($formGenerales.inputMontoMinimo.val().replaceAll(',',''));
                prFinancieroObject.generales.monto_maximo            = parseFloat($formGenerales.inputMontoMaximo.val().replaceAll(',',''));
                prFinancieroObject.generales.moneda_para_limite      = parseFloat($formGenerales.inputMonedaLimites.val().replaceAll(',',''));



                prFinancieroObject.generales.plazo_credito_minimo    = $formGenerales.inputPlazoCreditoMinimo.val();
                prFinancieroObject.generales.plazo_credito_maximo    = $formGenerales.inputPlazoCreditoMaximo.val();
                prFinancieroObject.generales.apply_cambio_plazo      = $formGenerales.inputApplyCambioPlazo.is(':checked') ? ON: OFF;
                prFinancieroObject.generales.apply_fecha_vigencia    = $formGenerales.inputApplyFechaVigencia.is(':checked') ? ON: OFF;
                prFinancieroObject.generales.fecha_inicial           = $formGenerales.inputFechaInicial.val();
                prFinancieroObject.generales.fecha_final             = $formGenerales.inputFechaFinal.val();
                prFinancieroObject.generales.apply_producto          = prFinancieroObject.generales.apply_producto ? prFinancieroObject.generales.apply_producto : 100 ;
            });

            $('.form-tasa-interes :input').on('change', function(){
                prFinancieroObject.tasa_interes.capital_base                = $formTasaInteres.inputCapitalBase.val();
                prFinancieroObject.tasa_interes.tipo_interes                = $formTasaInteres.inputTipoInteres.val();
                prFinancieroObject.tasa_interes.tipo_tasa                   = $formTasaInteres.inputTipoTasa.val();
                prFinancieroObject.tasa_interes.apply_cambio_tasa           = $formTasaInteres.inputApplyCambioTasa.is(':checked') ? ON: OFF;
                prFinancieroObject.tasa_interes.indice_referencia           = $formTasaInteres.inputIndiceReferencia.val();
                prFinancieroObject.tasa_interes.punto_sobre_tasa            = $formTasaInteres.inputPuntoSobreTasa.val();
                prFinancieroObject.tasa_interes.periodo_actualizacion_tasa  = $formTasaInteres.inputPeriodoActTasa.val();
                prFinancieroObject.tasa_interes.periodicidad                = $formTasaInteres.inputPeriodicidad.val();

                prFinancieroObject.tasa_interes.tasa_fija_maxima        = $formGenerales.inputTasaFijaMaxima.val();
                prFinancieroObject.tasa_interes.tasa_fija_minima        = $formGenerales.inputTasaFijaMinima.val();
            });

            $formGenerales.inputApplyProductoOpt1.change(function(){
                if ( $formGenerales.inputApplyProductoOpt1.is(':checked')){
                    prFinancieroObject.generales.apply_producto = 100 ;
                    $formGenerales.inputApplyProductoOpt2.prop("checked", false);
                }else{
                    prFinancieroObject.generales.apply_producto = 200 ;
                    $formGenerales.inputApplyProductoOpt2.prop("checked", true);
                }
            });

            $formGenerales.inputApplyProductoOpt2.change(function(){
                if ($formGenerales.inputApplyProductoOpt2.is(':checked')) {
                    prFinancieroObject.generales.apply_producto = 200 ;
                    $formGenerales.inputApplyProductoOpt1.prop("checked", false);
                }else{
                    prFinancieroObject.generales.apply_producto = 100 ;
                    $formGenerales.inputApplyProductoOpt1.prop("checked", true);
                }
            });

            $formGenerales.inputApplyFechaVigencia.change(function(){
                $formGenerales.inputFechaInicial.val(null).attr("disabled", true).trigger('change');
                $formGenerales.inputFechaFinal.val(null).attr("disabled", true).trigger('change');
                if ($formGenerales.inputApplyFechaVigencia.is(':checked')) {
                    $formGenerales.inputFechaInicial.val(null).attr("disabled", false).trigger('change');
                    $formGenerales.inputFechaFinal.val(null).attr("disabled", false).trigger('change');
                }
            });


            $formTasaInteres.inputTipoTasa.change(function(){
                funct_render_tasa_variable();
            });

            $formTasaInteres.inputApplyCambioTasa.change(function(){
                funct_render_tasa_variable();
            });
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


            function funct_sendGenerales(){

                if (valid_seccion(SECCION_GENERAL)) {
                    $.post(VAR_PATH_URL + "productofinanciero/configuracion/post-datos-general",{ prFinancieroGeneralObject: prFinancieroObject.generales}, function(response){
                        if (response["code"] == 202 ) {
                            prFinancieroObject.generales.pr_financiero_id = response["pr_financiero_id"];
                            prFinancieroObject.tasa_interes.pr_financiero_id = response["pr_financiero_id"];
                            //prFinancieroObject.actividadOrigen.pr_financiero_id = response["pr_financiero_id"];
                            hide_loader();
                            funct_get_info_seccion();
                            funct_render_tasa_variable();

                        }else{
                            toast("PRODUCTO FINANCIERO", "Ocurrion un error, intenta nuevamente", "warning");
                            $.each(response["errors"], function(key, item_error){
                                toast("PRODUCTO FINANCIERO", item_error, "warning");
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

            $.post(VAR_PATH_URL + "productofinanciero/configuracion/post-tasa-interes",{ tasaInteresObject: prFinancieroObject.tasa_interes }, function(response){
                if (response["code"] == 202 ) {
                    hide_loader();

                    toast("PRODUCTO FINANCIERO", "SE REGISTRO CORRECTAMENTE LA INFORMACION", "success");

                    window.location.href = VAR_PATH_URL + "productofinanciero/configuracion/index";
                }else{
                    toast("PRODUCTO FINANCIERO", "Ocurrion un error, intenta nuevamente", "warning");
                    $.each(response["errors"], function(key, item_error){
                        toast("PRODUCTO FINANCIERO", item_error, "warning");
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

var funct_render_tasa_variable = function(){


    if ($formTasaInteres.inputTipoTasa.val() == TASA_VARIABLE || $formTasaInteres.inputApplyCambioTasa.is(':checked') ) {
        $('.container_config_tasa_variable').css({"opacity" : 1});
        if (parseInt($formTasaInteres.inputTipoTasa.val()) == TASA_VARIABLE  && $formTasaInteres.inputApplyCambioTasa.is(':checked'))
            $('.container_config_tasa_fija').css({"opacity" : 1});
        else{
            if (parseInt($formTasaInteres.inputTipoTasa.val()) == TASA_FIJA)
                $('.container_config_tasa_fija').css({"opacity" : 1 });
            else
                $('.container_config_tasa_fija').css({"opacity" : 0.3});
        }
    }else{


        if (parseInt($formTasaInteres.inputTipoTasa.val()) == TASA_VARIABLE  && !$formTasaInteres.inputApplyCambioTasa.is(':checked'))
            $('.container_config_tasa_fija').css({"opacity" : 0.3});
        else{
            $('.container_config_tasa_fija').css({"opacity" : 1});
        }

        $formTasaInteres.inputIndiceReferencia.val(null);
        $formTasaInteres.inputPuntoSobreTasa.val(null);
        $formTasaInteres.inputPeriodoActTasa.val(null);
        $formTasaInteres.inputPeriodicidad.val(null);

        $('.container_config_tasa_variable').css({"opacity" : 0.3});
        //$('.container_config_tasa_fija').css({"opacity" : 1 });
    }
}

var funct_get_info_seccion = function(){
    if (prFinancieroObject.generales.pr_financiero_id) {
        $.get( VAR_PATH_URL + "productofinanciero/configuracion/get-producto-detail",{ pr_financiero_id : prFinancieroObject.generales.pr_financiero_id }, function(responseFinancieroObject){
            if (responseFinancieroObject.code == 202) {


                prFinancieroObject.generales.clave                   = responseFinancieroObject.prFinanciero.clave;
                prFinancieroObject.generales.nombre                  = responseFinancieroObject.prFinanciero.nombre;
                prFinancieroObject.generales.tipo_credito            = responseFinancieroObject.prFinanciero.tipo_credito;
                prFinancieroObject.generales.moneda                  = responseFinancieroObject.prFinanciero.moneda;
                prFinancieroObject.generales.apply_cambio_moneda     = responseFinancieroObject.prFinanciero.apply_cambio_moneda;
                prFinancieroObject.generales.monto_minimo            = responseFinancieroObject.prFinanciero.monto_minimo;
                prFinancieroObject.generales.monto_maximo            = responseFinancieroObject.prFinanciero.monto_maximo;

                prFinancieroObject.generales.moneda_para_limite      = responseFinancieroObject.prFinanciero.moneda_para_limite;
                prFinancieroObject.generales.plazo_credito_minimo    = responseFinancieroObject.prFinanciero.plazo_credito_minimo;
                prFinancieroObject.generales.plazo_credito_maximo    = responseFinancieroObject.prFinanciero.plazo_credito_maximo;
                prFinancieroObject.generales.apply_cambio_plazo      = responseFinancieroObject.prFinanciero.apply_cambio_plazo;
                prFinancieroObject.generales.apply_fecha_vigencia    = responseFinancieroObject.prFinanciero.apply_fecha_vigencia;
                prFinancieroObject.generales.fecha_inicial           = responseFinancieroObject.prFinanciero.fecha_inicial;
                prFinancieroObject.generales.fecha_final             = responseFinancieroObject.prFinanciero.fecha_final;
                prFinancieroObject.generales.apply_producto          = responseFinancieroObject.prFinanciero.apply_producto;
                prFinancieroObject.generales.moneda_text             = responseFinancieroObject.prFinanciero.moneda_text;
                prFinancieroObject.generales.tipo_credito_text       = responseFinancieroObject.prFinanciero.tipo_credito_text;

                prFinancieroObject.tasa_interes.capital_base            = responseFinancieroObject.prFinanciero.capital_base;
                prFinancieroObject.tasa_interes.tipo_interes            = responseFinancieroObject.prFinanciero.tipo_interes;
                prFinancieroObject.tasa_interes.tipo_tasa               = responseFinancieroObject.prFinanciero.tipo_tasa;
                prFinancieroObject.tasa_interes.apply_cambio_tasa       = responseFinancieroObject.prFinanciero.apply_cambio_tasa;
                prFinancieroObject.tasa_interes.indice_referencia       = responseFinancieroObject.prFinanciero.indice_referencia;
                prFinancieroObject.tasa_interes.punto_sobre_tasa        = responseFinancieroObject.prFinanciero.punto_sobre_tasa;
                prFinancieroObject.tasa_interes.periodo_actualizacion_tasa = responseFinancieroObject.prFinanciero.periodo_actualizacion_tasa;
                prFinancieroObject.tasa_interes.periodicidad            = responseFinancieroObject.prFinanciero.periodicidad;

                prFinancieroObject.tasa_interes.tasa_fija_minima        = responseFinancieroObject.prFinanciero.tasa_fija_minima;
                prFinancieroObject.tasa_interes.tasa_fija_maxima        = responseFinancieroObject.prFinanciero.tasa_fija_maxima;

                $formGenerales.inputProductoId.val(prFinancieroObject.generales.clave);
                $formGenerales.inputNombre.val(prFinancieroObject.generales.nombre);
                $formGenerales.inputTipoCredito.val(prFinancieroObject.generales.tipo_credito);
                $formGenerales.inputMoneda.val(prFinancieroObject.generales.moneda);
                $formGenerales.inputMontoMinimo.val(btf.conta.miles(prFinancieroObject.generales.monto_minimo));
                $formGenerales.inputMontoMaximo.val(btf.conta.miles(prFinancieroObject.generales.monto_maximo));

                $formGenerales.inputTasaFijaMinima.val(prFinancieroObject.tasa_interes.tasa_fija_minima);
                $formGenerales.inputTasaFijaMaxima.val(prFinancieroObject.tasa_interes.tasa_fija_maxima);

                $formGenerales.inputMonedaLimites.val(btf.conta.miles(prFinancieroObject.generales.moneda_para_limite));
                $formGenerales.inputPlazoCreditoMinimo.val(prFinancieroObject.generales.plazo_credito_minimo);
                $formGenerales.inputPlazoCreditoMaximo.val(prFinancieroObject.generales.plazo_credito_maximo);
                $formGenerales.inputFechaInicial.val(prFinancieroObject.generales.fecha_inicial);
                $formGenerales.inputFechaFinal.val(prFinancieroObject.generales.fecha_final);


                $formTasaInteres.inputCapitalBase.val(prFinancieroObject.tasa_interes.capital_base);
                $formTasaInteres.inputTipoInteres.val(prFinancieroObject.tasa_interes.tipo_interes);
                $formTasaInteres.inputTipoTasa.val(prFinancieroObject.tasa_interes.tipo_tasa);
                $formTasaInteres.inputIndiceReferencia.val(prFinancieroObject.tasa_interes.indice_referencia);
                $formTasaInteres.inputPuntoSobreTasa.val(prFinancieroObject.tasa_interes.punto_sobre_tasa);
                $formTasaInteres.inputPeriodoActTasa.val(prFinancieroObject.tasa_interes.periodo_actualizacion_tasa);
                $formTasaInteres.inputPeriodicidad.val(prFinancieroObject.tasa_interes.periodicidad);



                if (prFinancieroObject.tasa_interes.apply_cambio_tasa == ON)
                    $formTasaInteres.inputApplyCambioTasa.prop("checked", true);
                else
                    $formTasaInteres.inputApplyCambioTasa.prop("checked", false);


                if (prFinancieroObject.tasa_interes.apply_cambio_tasa == ON || prFinancieroObject.tasa_interes.tipo_tasa == TASA_VARIABLE)
                    $('.container_config_tasa_variable').css({"opacity" : 1});
                else
                    $('.container_config_tasa_variable').css({"opacity" : 0.3});


                if (prFinancieroObject.generales.apply_cambio_moneda == ON)
                    $formGenerales.inputApplyCambioMoneda.prop("checked", true);
                else
                    $formGenerales.inputApplyCambioMoneda.prop("checked", false);

                if (prFinancieroObject.generales.apply_cambio_plazo == ON)
                    $formGenerales.inputApplyCambioPlazo.prop("checked", true);
                else
                    $formGenerales.inputApplyCambioPlazo.prop("checked", false);


                if (prFinancieroObject.generales.apply_fecha_vigencia == ON)
                    $formGenerales.inputApplyFechaVigencia.prop("checked", true);
                else
                    $formGenerales.inputApplyFechaVigencia.prop("checked", false);

                if (parseInt(prFinancieroObject.generales.apply_producto) == 200 ){
                    $formGenerales.inputApplyProductoOpt2.prop("checked", true);
                    $formGenerales.inputApplyProductoOpt1.prop("checked", false);
                }
                else{
                    $formGenerales.inputApplyProductoOpt1.prop("checked", true);
                    $formGenerales.inputApplyProductoOpt2.prop("checked", false);
                }


                $('.lbl_sistema_id').html(prFinancieroObject.generales.pr_financiero_id);
                $('.lbl_producto').html(prFinancieroObject.generales.nombre );
                $('.lbl_moneda').html(prFinancieroObject.generales.moneda_text);
                $('.lbl_tipo_producto').html(prFinancieroObject.generales.tipo_credito_text);

                $formGenerales.inputMontoMaximo.mask('000,000,000,000,000.00', {reverse: true});
                $formGenerales.inputMontoMinimo.mask('000,000,000,000,000.00', {reverse: true});
                $formGenerales.inputMonedaLimites.mask('000,000,000,000,000.00', {reverse: true});


                if ($formGenerales.inputApplyFechaVigencia.is(':checked')) {
                    $formGenerales.inputFechaFinal.attr("disabled", false);
                    $formGenerales.inputFechaInicial.attr("disabled", false);
                }else{
                    $formGenerales.inputFechaFinal.val(null).attr("disabled", true).trigger('change');
                    $formGenerales.inputFechaInicial.val(null).attr("disabled", true).trigger('change');
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
                if(!$formGenerales.inputProductoId.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  producto id es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputNombre.val()){
                    toast("PRODUCTO FINANCIERO", "El campo nombre es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputTipoCredito.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  tipo credito es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputMoneda.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  moneda es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputMontoMaximo.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  monto maximo es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputMontoMinimo.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  monto minimo de nacimiento es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputMonedaLimites.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  moneda para limites de nacimiento es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputPlazoCreditoMaximo.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  plazo maximo es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                if(!$formGenerales.inputPlazoCreditoMinimo.val()){
                    toast("PRODUCTO FINANCIERO", "El campo  plazo minimo de nacimiento es requerido, intenta nuevamente", "warning");
                    is_valid = false;
                }
                return is_valid;
        break;
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


var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}

var hide_loader = function(){
    $('#page_loader').remove();
}


window.addEventListener('beforeunload', (event) => {
    event.preventDefault();
    event.returnValue ='¿Estás seguro de abandonar el proceso del captura ?';
});

var funcLowerCase = function(input){
    return  $.trim($(input).val($(input).val().toUpperCase()));
}