var $inputFindClienteID 	= $('#creditosolicituddisposicion-find_cliente_id');
$inputFindClienteBP     	= $('#creditosolicituddisposicion-bp_number');
$inputSelectCliente     	= $('#creditosolicituddisposicion-cliente_text');
VAR_PATH_URL            	= $('body').data('url-root');
$containerSolicitudes 		= $('.container-solicitudes');
$btnGenerarSolicitud 		= $('#btnGenerarSolicitud');
$btnCloseSolicitud 			= $('#btnCloseSolicitud');
$containerFormDisposicion 	= $('.control-formSolicitudDisposicion');
$formDisposicion            = {
    inputMonto          : $('#disposicion-monto_dispuesto'),
    inputFecha          : $('#disposicion-fecha_disposicion'),
};
disposicionObject       = {
            "disposicion_id"                : $('#creditosolicituddisposicion-id').val() ? $('#creditosolicituddisposicion-id').val() : null,
            "credito_id"                    : null,
            "cliente_id"                    : null,
            "cliente_bp"                    : null,
            "cliente_text"                  : null,
            "cliente_status"                : null,
            "solicitud_id"                	: null,
            "monto"                         : 0,
            "fecha"                         : null,
 };
 ON                     = 10;
 OFF                    = 20;
 SOLICITUDES_ARRAY 		= [];

$(function () {


    $formDisposicion.inputMonto.mask('$ 000,000,000,000,000.00', {reverse: true});

    $('.control-formSolicitudDisposicion :input').on('change', function(){
        if (disposicionObject.solicitud_id) {
            disposicionObject.monto                    = $formDisposicion.inputMonto.val() ?  $formDisposicion.inputMonto.val().replaceAll(',','') : 0;
            disposicionObject.fecha                    = $formDisposicion.inputFecha.val();
        }else
            funct_clear_form_disposicion();

        funct_validaTotalDisponer();
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
});

var funct_get_cliente = function(params_id, tipo){
    funct_form_clean();
    if (params_id) {
        show_loader();
        $.get(VAR_PATH_URL+ "financiamiento/disposicion/get-cliente",{ cliente_id_and_bp : params_id, tipo : tipo }, function(response){
            if (response.code == 202) {

                disposicionObject.cliente_id = response.cliente.id;

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



                funct_getSolicitud();
                //$inputSelectCliente.val();
            }else{
                toast2("SOLICITUD DE DISPOSICION", "VERIFICA TU INFORMACION", "warning");
            }
            hide_loader();
        }).fail(function() {
            toast2("SOLICITUD DE DISPOSICION", "ERROR EN EL SERVIDOR", "danger");
            hide_loader();
        });
    }
}


var funct_getSolicitud = function(){
    $containerSolicitudes.html(loader_table());
    setTimeout(1000);
    $.get(VAR_PATH_URL + "financiamiento/disposicion/get-solicitudes", { cliente_id: disposicionObject.cliente_id }, function(response){

        if (response.disposicion.apply_disposicion == ON) {

            toast2("SOLICITUD DE DISPOSICIÓN", "BUSQUEDA CORRECTA", "success");

            SOLICITUDES_ARRAY = response.disposicion.solicitudes;
        }else{
            toast2("AVISO", "OPERACION NO PERMITIDA, EL CLIENTE CUENTA CON UNA SOLICITUD DE DISPOSICIÓN EN PROCESO", "warning");
        }

        funct_renderSolicitud();
    });
}


var funct_renderSolicitud = function(){

    containerSolicitudHtml = "";

    $.each(SOLICITUDES_ARRAY,function(key, item_solicitud){
    	if (disposicionObject.solicitud_id) {
    		if (disposicionObject.solicitud_id == item_solicitud.id) {
    			containerSolicitudHtml += "<tr style='background: #1c84c6'>"+
		            '<td style= "font-size:16px; font-weight:400; color: #fff; text-align:center">'+ item_solicitud.id +'</td>'+
		            '<td style= "font-size:16px; font-weight:bold; color: #fff" class="text-center">'+ item_solicitud.credito_id +'</td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-center">'+ item_solicitud.cliente +'</td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-right">'+ item_solicitud.actividadEconomica +'</td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-right">'+ btf.conta.money(item_solicitud.monto) + item_solicitud.moneda_abrev +'</td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-right">'+ btf.conta.money(item_solicitud.total_dispuesto) + item_solicitud.moneda_abrev +'</td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-right"><p style="text-decoration:underline">'+ btf.conta.money(item_solicitud.monto - item_solicitud.total_dispuesto ) + item_solicitud.moneda_abrev +'</p></td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-center">'+ item_solicitud.fecha_vencimiento +'</td>'+
		            '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-center">'+ item_solicitud.fecha_max_disposicion +' </td>'+
                    '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-center">'+ item_solicitud.status_credito +' </td>'+
                    '<td style= "font-size:16px; font-weight:400; color: #fff" class="text-center">'+ item_solicitud.etapa +' </td>'+
					'<td style= "font-size:16px; font-weight:400; color: #fff" class="text-center"></td>'+
		         "</tr>";

                 $('.lbl-maximo-disponible').html("MAXIMO A DISPONER: " + btf.conta.money(item_solicitud.monto - item_solicitud.total_dispuesto ) +  item_solicitud.moneda_abrev);
		         $containerFormDisposicion.show();
    		}
    	}else{
	        containerSolicitudHtml += "<tr>"+
	            '<td style= "font-size:14px; font-weight:400; color: #000; text-align:center">'+ item_solicitud.id +'</td>'+
	            '<td style= "font-size:14px; font-weight:bold; color: #000" class="text-center">'+ item_solicitud.credito_id +'</td>'+
	            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_solicitud.cliente +'</td>'+
	            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right">'+ item_solicitud.actividadEconomica +'</td>'+
	            '<td style= "font-size:14px; font-weight:400;" class="text-right">'+ btf.conta.money(item_solicitud.monto) + item_solicitud.moneda_abrev  +'</td>'+
	            '<td style= "font-size:14px; font-weight:400;" class="text-right">'+ btf.conta.money(item_solicitud.total_dispuesto) + item_solicitud.moneda_abrev +'</td>'+
	            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-right"><p style="text-decoration:underline">'+ btf.conta.money(item_solicitud.monto - item_solicitud.total_dispuesto ) + item_solicitud.moneda_abrev +'</p></td>'+
	            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_solicitud.fecha_vencimiento +'</td>'+
	            '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_solicitud.fecha_max_disposicion +' </td>'+
                '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_solicitud.status_credito +' </td>'+
                '<td style= "font-size:14px; font-weight:400; color: #000" class="text-center">'+ item_solicitud.etapa +' </td>'+
				'<td style= "font-size:14px; font-weight:400; color: #000" class="text-center"><button class="btn btn-success"  onclick="funct_selectSolicitud('+ item_solicitud.id +','+ item_solicitud.credito_id +')" type="button">SOLICITAR</button></td>'+
	         "</tr>";
    	}
    });

    $containerSolicitudes.html(containerSolicitudHtml);
}

var funct_selectSolicitud = function(solicitudID, creditoID)
{
	disposicionObject.solicitud_id = solicitudID;
    disposicionObject.credito_id   = creditoID;
	funct_renderSolicitud();
}


var funct_validaTotalDisponer = function(){

}


var funct_form_clean = function(){

    $(".container-solicitudes").html(null);
    $(".lbl-tipo_credito").html('-------- --------------');
    $(".label-text").html(' ---------------- ');
    $inputFindClienteID.val(null);
    $inputFindClienteBP.val(null);
    $inputSelectCliente.val(null);
    $inputSelectCliente.html(null);
    disposicionObject.solicitud_id = null;
    $containerFormDisposicion.hide();

}

var funct_clear_form_disposicion = function(){
    disposicionObject.monto                    = null;
    disposicionObject.fecha                    = null;
    $formDisposicion.inputMonto.val(null);
    $formDisposicion.inputFecha.val(null);
}

$btnCloseSolicitud.click(function(){
	funct_form_clean();
	funct_get_cliente(disposicionObject.cliente_id,10);

});


$btnGenerarSolicitud.click(function(){
    show_loader();
    $('#modal-confirm-save-disposicion').modal({backdrop: 'static', keyboard: false});
});

var confirmSaveSolicitud = function()
{
    if (valid_form_create()) {


        $.post(VAR_PATH_URL + "financiamiento/disposicion/post-registro-disposicion", { disposicionObject : disposicionObject }, function(responseRegistro){
            if (responseRegistro.code == 202 ) {

                toast2Bold('DISPOSICIÓN','FOLIO DE OPERACION #' + responseRegistro.folio_id , 'success');

                $('#modal-confirm-save-disposicion').modal('hide');

                setTimeout(() => {
                  window.location.href  = VAR_PATH_URL + "financiamiento/disposicion/index";
                }, 2000);

            }else{
                toast2Bold('DISPOSICIÓN','OCURRIO UN ERROR, INTENTA NUEVAMENTE', 'warning');
            }
        });
    }else{
        hide_loader();
    }
}


var valid_form_create = function()
{
    if (Number.isNaN(parseFloat(disposicionObject.monto))) {
        toast2("AVISO", "EL MONTO ES INVALIDO", "warning");
        return false;
    }

    if (!disposicionObject.monto  || parseFloat(disposicionObject.monto) == 0 ) {
        toast2("AVISO", "EL MONTO ES REQUERIDO", "warning");
        return false;
    }

    if (!disposicionObject.fecha) {
        toast2("AVISO", "LA FECHA ES REQUERIDO", "warning");
        return false;
    }

    if (!disposicionObject.solicitud_id) {
        toast2("AVISO", "LA SOLICITUD ES REQUERIDO", "warning");
        return false;
    }

    if (disposicionObject.monto) {
        montoMaximo = 0;
        $.each(SOLICITUDES_ARRAY, function(key, item_solicitud){
            if (disposicionObject.solicitud_id == item_solicitud.id ) {
                montoMaximo = parseFloat(item_solicitud.monto - item_solicitud.total_dispuesto);
            }

        });

        if (parseFloat(disposicionObject.monto) > montoMaximo ) {
            toast2("AVISO", "EL MONTO MAXIMO ES : " + btf.conta.money(montoMaximo), "warning");
            return false;
        }
    }

    return true;

}

var closeSaveProducto = function()
{
    $('#modal-confirm-save-disposicion').modal('hide');
    hide_loader();
}


var loader_table = function(){
    return '<tr>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
        '<td><div class="spiner-example" style="height: 100%;padding-top: 0px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div></div></td>'+
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