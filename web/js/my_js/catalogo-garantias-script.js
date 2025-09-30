
var     VAR_PATH_URL            = $('body').data('url-root'),
        $inpuClienteID          = $('#catalogogarantia-cliente_id');
        $inputFindClienteID     = $('#garantia-find_cliente_id');
        $inputFindClienteBP     = $('#garantia-bp_number');
        $inputSelectCliente     = $('#garantia-cliente_text');
        $COLONIA_ARRRAY          = [];
        $formGarantia = {
            Uni           : $('#catalogogarantia-unidad'),
            NumUni        : $('#catalogogarantia-numero_unidad'),
            UniVal        : $('#catalogogarantia-unidad_valor'),
            sumaAsegurada : $('#catalogogarantia-aseguradora_suma_asegurada'),
            UniValTotal   : $('#catalogogarantia-unidad_valor_total'),
            Valor         : $('#catalogogarantia-valor'),
            MontoVal      : $('#catalogogarantia-monto_valuado'),
            RequiredVal   : $('#catalogogarantia-requiere_valuacion'),
            Pais           : $('#catalogogarantia-pais_id'),
            DireccionCp           : $('#catalogogarantia-codigo_postal'),
            DireccionEstaID       : $('#catalogogarantia-estado_id'),
            DireccionMuncID       : $('#catalogogarantia-municipio_id'),
            DireccionCuidad       : $('#catalogogarantia-cuidad_id'),
            DireccionColonia      : $('#catalogogarantia-codigo_postal_id'),
            DireccionDireccion    : $('#catalogogarantia-direccion'),
            DireccionNoExterior   : $('#catalogogarantia-num_ext'),
            DireccionNoInterior   : $('#catalogogarantia-num_int'),
            DireccionReferencia   : $('#catalogogarantia-referencia'),
            GeoreferenciaLatitud  : $('#catalogogarantia-lat'),
            GeoreferenciaLongitud : $('#catalogogarantia-lng'),
        };

$(function(){
    $formGarantia.UniVal.mask('$ 000,000,000,000,000.00', {reverse: true});
    $formGarantia.UniValTotal.mask('$ 000,000,000,000,000.00', {reverse: true});
    $formGarantia.Valor.mask('$ 000,000,000,000,000.00', {reverse: true});
    $formGarantia.MontoVal.mask('$ 000,000,000,000,000.00', {reverse: true});
    $formGarantia.sumaAsegurada.mask('$ 000,000,000,000,000.00', {reverse: true});
    if ($inpuClienteID.val())
        funct_get_cliente($inpuClienteID.val(),10);

})

$(document).on("keydown", "input", function(e) {
  if (e.which==13) e.preventDefault();
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


var funct_get_cliente = function(params_id, tipo){

    if (params_id) {
        show_loader();
        $.get(VAR_PATH_URL+ "configuracion/garantia/get-cliente",{ cliente_id_and_bp : params_id, tipo : tipo }, function(response){
            if (response.code == 202) {
                toast("LINEA DE CREDITO", "BUSQUEDA CORRECTA", "success");
                $(".label-riesgo").html(response.cliente.riesgo_text);
                $(".label-status").html(response.cliente.status_text);
                $(".label-grupo-riesgo").html(response.cliente.grupo_riesgo);

                $inputFindClienteID.val(response.cliente.id);
                $inputFindClienteBP.val(response.cliente.uidx);
                $inpuClienteID.val(response.cliente.id);

                if (response.cliente.tipo == 10 || response.cliente.tipo == 30) {
                    var newOption       = new Option(response.cliente.nombreCompleto, response.cliente.id, false, true);
                    $inputSelectCliente.append(newOption);
                }

                if (response.cliente.tipo == 20 || response.cliente.tipo == 40) {
                    var newOption       = new Option(response.cliente.razon_social, response.cliente.id, false, true);
                    $inputSelectCliente.append(newOption);
                }

                $('.form-garantia-content').fadeIn( 9000, function() {
                    $('.form-garantia-content').css({"opacity": "1"}).fadeIn( 100 );
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

$('.form-garantia-content :input').on('change', function(){
    funct_valid_garantia_required();
});


$formGarantia.RequiredVal.change(function(){
    $('.garantia_tipo_hipotecaria_requiere_valuacion_si').hide();
    if ($formGarantia.RequiredVal.val() == 10) {
        $('.garantia_tipo_hipotecaria_requiere_valuacion_si').show();
    }
});

 $formGarantia.UniVal.change(function(){
    funct_calculaTotalHipoteca();
})

$formGarantia.NumUni.change(function(){
    funct_calculaTotalHipoteca();
})

var functInputCondiccionPais = function()
{
    $('.div_content_direccion_mx').show();
    $('.div_content_direccion_otro').hide();

    if ($('option:selected', $formGarantia.Pais ).text() !== 'MÉXICO') {
        $('.div_content_direccion_mx').hide();
        $('.div_content_direccion_otro').show();
    }
}

var funct_valid_garantia_required  = function(){

    funct_clear_garantia_required();

    if(!$formGarantia.UniVal.val())
        $formGarantia.UniVal.parent().parent().addClass("has-error");

    if(!$formGarantia.UniValTotal.val())
        $formGarantia.UniValTotal.parent().parent().addClass("has-error");

    if(!$formGarantia.DireccionCp.val())
        $formGarantia.DireccionCp.parent().addClass("has-error");
    if(!$formGarantia.DireccionEstaID.val())
        $formGarantia.DireccionEstaID.parent().addClass("has-error");
    if(!$formGarantia.DireccionMuncID.val())
        $formGarantia.DireccionMuncID.parent().addClass("has-error");
    if(!$formGarantia.DireccionColonia.val())
        $formGarantia.DireccionColonia.parent().addClass("has-error");
    if(!$formGarantia.DireccionDireccion.val())
        $formGarantia.DireccionDireccion.parent().addClass("has-error");
    if(!$formGarantia.DireccionNoExterior.val())
        $formGarantia.DireccionNoExterior.parent().addClass("has-error");
    if(!$formGarantia.DireccionNoInterior.val())
        $formGarantia.DireccionNoInterior.parent().addClass("has-error");
    if(!$formGarantia.DireccionReferencia.val())
        $formGarantia.DireccionReferencia.parent().addClass("has-error");

}

var funct_clear_garantia_required = function(){

    $formGarantia.Uni.parent().removeClass("has-error");
    $formGarantia.NumUni.parent().removeClass("has-error");
    $formGarantia.UniVal.parent().parent().removeClass("has-error");
    $formGarantia.UniValTotal.parent().parent().removeClass("has-error");
    $formGarantia.DireccionCp.parent().removeClass("has-error");
    $formGarantia.DireccionEstaID.parent().removeClass("has-error");
    $formGarantia.DireccionMuncID.parent().removeClass("has-error");
    $formGarantia.DireccionColonia.parent().removeClass("has-error");
    $formGarantia.DireccionDireccion.parent().removeClass("has-error");
    $formGarantia.DireccionNoExterior.parent().removeClass("has-error");
    $formGarantia.DireccionNoInterior.parent().removeClass("has-error");
    $formGarantia.DireccionReferencia.parent().removeClass("has-error");

}

var funct_calculaTotalHipoteca = function(){

    $formGarantia.UniValTotal.val(0);
    if ($formGarantia.UniVal.val() && $formGarantia.NumUni.val())
        $formGarantia.UniValTotal.val(btf.conta.miles(parseFloat($formGarantia.UniVal.val().replaceAll(',','')) * parseFloat($formGarantia.NumUni.val())));
}


var funcLowerCase = function(input){
    return  $.trim($(input).val($(input).val().toUpperCase()));
}



function onEstadoChange() {
    var estado_id = $formGarantia.DireccionEstaID.val();
    municipioSelected = estado_id == 0 ? null : municipioSelected;

   $formGarantia.DireccionMuncID.html('');

    if (estado_id ||  municipioSelected) {
        $.get(VAR_PATH_URL  + 'municipio/municipios-ajax', {'estado_id' : estado_id}, function(json) {
            $.each(json, function(key, value){
               $formGarantia.DireccionMuncID.append("<option value='" + key + "'>" + value + "</option>\n");
            });


           $formGarantia.DireccionMuncID.val(municipioSelected); // Select the option with a value of '1'
           $formGarantia.DireccionMuncID.trigger('change');


        }, 'json');
    }
}


$formGarantia.DireccionMuncID.change(function(){
    if ($formGarantia.DireccionEstaID.val() != 0 && $formGarantia.DireccionMuncID.val() != 0 && $formGarantia.DireccionCp.val() == "" ) {
        $formGarantia.DireccionColonia.html('');
        if ($formGarantia.DireccionMuncID.val()) {
            $.get(VAR_PATH_URL  +'municipio/colonia-ajax', {'estado_id' : $formGarantia.DireccionEstaID.val(), "municipio_id": $formGarantia.DireccionMuncID.val(), 'codigo_postal' : $formGarantia.DireccionColonia.val()}, function(json) {
                if(json.length > 0){
                    /*$.each(json, function(key, value){
                        $formGarantia.DireccionColonia.append("<option value='" + value.id + "'>" + value.colonia + "</option>\n");
                    });*/
                    $COLONIA_ARRRAY = json;
                    render_cuidad();
                }
                else
                    municipioSelected  = null;

                $formGarantia.DireccionColonia.val(null).trigger("change");

            }, 'json');
        }
    }
});

$formGarantia.DireccionCp.change(function() {
    $formGarantia.DireccionColonia.html('');
    $formGarantia.DireccionEstaID.val(null).trigger("change");

    var codigo_search = $formGarantia.DireccionCp.val();
    if (codigo_search) {
        $.get( VAR_PATH_URL + 'municipio/codigo-postal-ajax', {'codigo_postal' : codigo_search}, function(json) {
        if(json.length > 0){


            $COLONIA_ARRRAY = json;
            render_cuidad();

            /*$formGarantia.DireccionEstaID.val(json[0].estado_id).trigger('change'); // Select the option with a value of '1'


            municipioSelected = json[0].municipio_id;

            $.each(json, function(key, value){
                $formGarantia.DireccionColonia.append("<option value='" + value.id + "'>" + value.colonia + "</option>\n");
            });*/
        }
        else
            municipioSelected  = null;


        $formGarantia.DireccionColonia.val(null).trigger("change");

    }, 'json');
    }
});


var render_cuidad = function(){

    cuidadArray = [];

    if ($formGarantia.DireccionCp.val()) {
        $formGarantia.DireccionEstaID.val($COLONIA_ARRRAY[0].estado_id).trigger('change'); // Select the option with a value of '1'
        municipioSelected = $COLONIA_ARRRAY[0].municipio_id;
    }

    $.each($COLONIA_ARRRAY, function(key, item_colonia){

        is_add = true;
        $.each(cuidadArray, function(key, item_cuidad){
            if (item_cuidad.cuidad_id == item_colonia.cuidad_id)
                is_add = false;
        });

        if (is_add) {
            if (item_colonia.cuidad_id) {
                cuidadArray.push(item_colonia);
            }else{
                cuidadArray.push({
                    "codigo_postal": item_colonia.codigo_postal,
                    "colonia": item_colonia.colonia,
                    "cuidad": "NO APLICA",
                    "cuidad_id": null,
                    "estado": item_colonia.estado,
                    "estado_id": item_colonia.estado_id,
                    "id": item_colonia.id,
                    "municipio": item_colonia.municipio,
                    "municipio_id": item_colonia.municipio_id,
                });
            }
        }

    });

    $.each(cuidadArray, function(key, value){
        $formGarantia.DireccionCuidad.append("<option value='" + value.cuidad_id + "'>" + value.cuidad + "</option>\n");
    });

    render_colonia();

}

var render_colonia = function(){
    $formGarantia.DireccionColonia.html('');
    if ($formGarantia.DireccionCuidad.val()) {
        $.each($COLONIA_ARRRAY, function(key, item_colonia){
            if ($formGarantia.DireccionCuidad.val() == item_colonia.cuidad_id){
                $formGarantia.DireccionColonia.append("<option value='" + item_colonia.id + "'>" + item_colonia.colonia + "</option>\n");
            }



        });
    }else{
        $.each($COLONIA_ARRRAY, function(key, item_colonia){
            $formGarantia.DireccionColonia.append("<option value='" + item_colonia.id + "'>" + item_colonia.colonia + "</option>\n");
        });
    }
}




var funct_loadMaps = function(){
    $('#modal-maps').modal('show');
    $(".div_spiner_maps").show();
    $("#map_solicitud_view").css({"height" : "auto" });
    setTimeout( 2000);
    if ($formGarantia.GeoreferenciaLatitud.val() && $formGarantia.GeoreferenciaLongitud.val()) {
        $("#map_solicitud_view").css({"height" : "300px" });
        $(".mapboxgl-canvas").css({"height" : "300px", "width" : "748px"});
        $(".div_spiner_maps").hide();

        popup = new tt.Popup({
            offset: 35
        });

        map = tt.map({
            key: 'DhvUV3dfzRR1KyTOixQ8H7fPtZolRBCr',
            container: 'map_solicitud_view',
            //dragPan: !isMobileOrTablet(),
            center: [ parseFloat($formGarantia.GeoreferenciaLongitud.val()), parseFloat($formGarantia.GeoreferenciaLatitud.val())],
            zoom: 14
        });
        map.addControl(new tt.FullscreenControl());


        marker = new tt.Marker({
            draggable: true
        }).setLngLat([ parseFloat($formGarantia.GeoreferenciaLongitud.val()), parseFloat($formGarantia.GeoreferenciaLatitud.val())]).addTo(map);

        setTimeout(() => {
          map.resize()
        }, 2000);

    }else{
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 5000
        };

        toastr.warning("LA LONGITUD Y LATITUD ES REQUERIDO, INTENTA NUEVAMENTE", "GARANTIAS");
    }
}

var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}

var hide_loader = function(){
    $('#page_loader').remove();
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
