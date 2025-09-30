$(function () {
    $wizard             = $("#wizard");

    $wizard.steps({
        onInit : function(event, currentIndex){
            $inputFindClienteID     = $('#lineacredito-find_cliente_id');
            $inputFindClienteBP     = $('#lineacredito-bp_number');
            $inputSelectCliente     = $('#lineacredito-cliente_text');
            $containerAperturaLinea = $('.container_apertura_linea');
             $formLineaCredito = {
                inputClienteID              : $('#lineacredito-cliente_id'),
                inputPromotor               : $('#lineacredito-promotor_id'),
                inputRegion                 : $('#lineacredito-region_id'),
                inputPlaza                  : $('#lineacredito-plaza_id'),
                inputSucursal               : $('#lineacredito-sucursal_id'),
                inputFechaCredito           : $('#lineacredito-fecha_credito'),
                inputLoanNumber             : $('#lineacredito-loan_number'),
                inputProductoFinanciero     : $('#lineacredito-producto_financiero'),
                inputProductoScian          : $('#lineacredito-producto_scian'),
                inputDestinoCredito         : $('#lineacredito-destino_credito'),
                inputMonto                  : $('#lineacredito-monto'),
                inputTasaFija               : $('#lineacredito-tasa_fija'),
                inputTasaVariable           : $('#lineacredito-tasa_variable'),
                inputTasaVariableIndicador  : $('#lineacredito-tasa_variable_indicador'),
                inputTasaVariablePuntoAdicional  : $('#lineacredito-tasa_variable_punto_adicionales'),
            },
            VAR_PATH_URL        = $('body').data('url-root'),

            solicitudObject         = {
                "linea_credito_id"              : $('#solicitud-id').val() ? $('#solicitud-id').val() : null,
                "cliente_id"                    : null,
                "cliente_bp"                    : null,
                "cliente_text"                  : null,
                "cliente_status"                : null,
                "config_producto_financiero_id" : null,
                "config_producto_financiero_text" : null,
                "promotor_id"                   : null,
                "promotor_text"                 : null,
                "region_id"                     : null,
                "region_text"                   : null,
                "plaza_id"                      : null,
                "plaza_text"                    : null,
                "sucursal_id"                   : null,
                "sucursal_text"                 : null,
                "fecha_credito"                 : null,
                "loan_number"                   : null,
                "destino_credito"               : null,
                "monto"                         : null,
                "descripcion"                   : null,
                "actividad_economica_id"        : null,
                "actividad_economica_text"      : null,
                "moneda"                        : null,
                "moneda_text"                   : null,

            },



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

        },

        labels: {
          finish: "GUARDAR Y SALIR",
          next: "GUARDAR Y CONTINUAR",
          previous: "ATRAS",
          cancel: "No"
        }
    });
});


var funct_get_cliente = function(params_id, tipo){
    clear_form();
    if (params_id) {
        show_loader();
        $.get(VAR_PATH_URL+ "productofinanciero/linea-credito/get-cliente",{ cliente_id_and_bp : params_id, tipo : tipo }, function(response){
            if (response.code == 202) {
                toast("LINEA DE CREDITO", "BUSQUEDA CORRECTA", "success");
                $(".label-rfc").html(response.cliente.rfc);
                $(".label-curp").html(response.cliente.rfc);
                $(".label-riesgo").html(response.cliente.riesgo_text);

                $(".label-tipo").html(response.cliente.tipo_text);
                $(".label-status").html(response.cliente.status_text);

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

                $containerAperturaLinea.fadeIn( 9000, function() {
                    $containerAperturaLinea.css({"opacity": "1"}).fadeIn( 100 );
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


var clear_form = function(){
    $(".label-text").html(' ---------------- ');
    $inputFindClienteID.val(null);
    $inputFindClienteBP.val(null);
    $inputSelectCliente.val(null);
    $inputSelectCliente.html(null);
    $containerAperturaLinea.css({"opacity": "0.3"}).first().fadeIn( 4000 );
}

var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}

var hide_loader = function(){
    $('#page_loader').remove();
}
