var $inputClienteID 						= $('#ventanilla-cliente_id'),
	$inputFindClienteID     				= $('#ventanilla-find_cliente_id');
    $inputFindClienteBP     				= $('#ventanilla-bp_number');
    $inputSelectCliente     				= $('#ventanilla-cliente_text');
	ON 										= 10,
	OFF 									= 20,
	VAR_PATH_URL 							= $('body').data('url-root');

$(function($){

	$('.page-heading').remove();

	$('body').addClass('mini-navbar');


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
		funct_form_clean();
	    if (params_id) {
	        show_loader();
	        $.get(VAR_PATH_URL+ "financiamiento/ventanilla/get-socio-cuentas",{ cliente_id_and_bp : params_id, tipo : tipo }, function(response){
	            if (response.code == 202) {
	                toast2("DESEMBOLSO", "BUSQUEDA CORRECTA", "success");
	                $(".label-riesgo").html(response.cliente.riesgo_text);
	                $(".label-status").html(response.cliente.status_text);
	                $(".label-grupo-riesgo").html(response.cliente.grupo_riesgo);

	                $inputFindClienteID.val(response.cliente.id);
	                $inputFindClienteBP.val(response.cliente.uidx);
	                $inputClienteID.val(response.cliente.id);

	                if (response.cliente.tipo == 10 || response.cliente.tipo == 30) {
	                    var newOption       = new Option(response.cliente.nombreCompleto, response.cliente.id, false, true);
	                    $inputSelectCliente.append(newOption);
	                }

	                if (response.cliente.tipo == 20 || response.cliente.tipo == 40) {
	                    var newOption       = new Option(response.cliente.razon_social, response.cliente.id, false, true);
	                    $inputSelectCliente.append(newOption);
	                }

					hide_loader();

	            }else{
	                toast2("DESEMBOLSO", "VERIFICA TU INFORMACION", "warning");
	            }
	            hide_loader();
	        }).fail(function() {
	            toast2("DESEMBOLSO", "ERROR EN EL SERVIDOR", "danger");
	            hide_loader();
	        });
	    }
	}

});

var funct_form_clean = function(){
    $(".label-text").html(' ---------------- ');
    $inputFindClienteID.val(null);
    $inputFindClienteBP.val(null);
    $inputSelectCliente.val(null);
    $inputSelectCliente.html(null);

}


var funct_confirmOperacionDesembolso = function(disposicionID, importeAdisponer, apply_comision, comision, comision_iva, total_neto_disponer) {
	swal({
        title: "<h4>¿ DESEAS CONTINUAR CON EL DESEMBOLSO?</h4>",
        text: '<strong style="font-size: 24px;font-weight: 700;color: #000;">'+ "El monto a desembolsar es : "+  btf.conta.money(importeAdisponer)  +'</strong><table class="table"> <tr><td>COMISION</td><td style="color:#000; font-weight: 600;">'+ btf.conta.money(comision) +'</td></tr> <tr><td>COMISION - IVA </td><td style="color:#000; font-weight: 600;">'+ btf.conta.money(comision_iva) +'</td></tr> <tr><td>NETO</td><td style="color:#000; font-weight: 600;">'+ btf.conta.money(total_neto_disponer) +'</td></tr></table>',
        type: "warning",
        html: true,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "CONFIRMACION",
        closeOnConfirm: false
    }, function () {

    	funct_postOperacionDesembolso(disposicionID);

    });
}

var funct_postOperacionDesembolso = function(disposicionID){

	$.post(VAR_PATH_URL + "financiamiento/ventanilla/post-operacion",{ disposicionID : disposicionID }, function(response){
		if ( response.code == 202 ) {

			swal("CONFIRMACION ACEPTADA", "", "success");
		}else{
			swal("ERROR AL PROCESAR LA OPERACIÓN", "", "warning");
		}

        bttBuilder.refresh();
	});
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

var toast2 = function(title, message, tipo){

    if (tipo == 'warning')
        swal({
            title: title,
            type: tipo,
            text: message
        });

    if (tipo == 'success')
        swal({
            title: title,
            type: tipo,
            text: message
        });

    if (tipo == 'danger')
        swal({
            title: title,
            type: tipo,
            text: message
        });
}

var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}


var hide_loader = function(){
    $('#page_loader').remove();
}