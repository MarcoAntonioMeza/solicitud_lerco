var $btnAddComision             = $('#btnAddComision'),
	$containerList              = $('.container-list'),
    $containerSolicitud         = $('.container-solicitud'),
    $comisionID         		= $('#catalogoplancomision-id'),
    $formComision 				= {
    	inputCodigo 	 			: $('#inputCodigo'),
    	inputNombre 	 			: $('#inputNombre'),
    	inputDescripcion 			: $('#inputDescripcion'),
    	inputAplicaPorMonto 		: $('#inputAplicaPorMonto'),
    	inputAplicaPorPorcentaje 	: $('#inputAplicaPorPorcentaje'),
    	inputValorFijo 				: $('#inputValorFijo'),
    	inputValorPorcentaje 	    : $('#inputValorPorcentaje'),
    	inputRequiereAutorizacion   : $('#inputRequiereAutorizacion'),
    	inputUserAutorizadoID   	: $('#inputUserAutorizadoID'),
        inputImpuesto               : $('#inputImpuesto'),
        inputAplicaPor              : $('#inputAplicaPor'),
        inputPeriodicidadCobro      : $('#inputPeriodicidadCobro'),
        inputBaseCobro              : $('#inputBaseCobro'),
    };
    $inputPlanComisionClave        = $('#catalogoplancomision-clave');
    $inputPlanComisionTitulo       = $('#catalogoplancomision-titulo');
    $inputPlanComisionDescripcion  = $('#catalogoplancomision-descripcion');
    ON                          = 10;
    OFF                         = 20;
    COMISION_ACTIVO             = 10;
    COMISION_BAJA               = 20;
    VAR_POR_MONTO               = 10;
    VAR_POR_PORCENTAJE          = 20;
    solicitudArray              = [];
    VAR_PATH_URL                = $('body').data('url-root');
    planComisionObject          = {
        "id"            : $comisionID.val(),
        "clave"         : null,
        "titulo"        : null,
        "descripcion"   : null,
        "comisionList"  : []
    };

$(function(){

	$formComision.inputValorFijo.mask('$ 000,000,000,000,000.00', {reverse: true});

    $('.control-formPlanComision :input').on('change', function(){
        planComisionObject.clave       = $inputPlanComisionClave.val();
        planComisionObject.titulo      = $inputPlanComisionTitulo.val();
        planComisionObject.descripcion = $inputPlanComisionDescripcion.val();
    });

	$btnAddComision.click(function(){
	    if(validation_form())
	        return false;
	    add_itemContainer();
	});

    init();
})

var funct_validCondicional = function(){

	$('#inputTitleValor').html("----------");
	$formComision.inputUserAutorizadoID.attr("disabled", true);
	$formComision.inputUserAutorizadoID.val(null);
	$('.inputValorFijo').hide();
	$('.divinputValorPorcentaje').hide();
	if ($formComision.inputAplicaPorMonto.is(':checked')) {
		$('#inputTitleValor').html("MONTO FIJO");
		$('.inputValorFijo').show();
	}

	if ($formComision.inputAplicaPorPorcentaje.is(':checked')) {
		$('#inputTitleValor').html("PORCENTAJE %");
		$('.divinputValorPorcentaje').show();
	}

	if ($formComision.inputRequiereAutorizacion.is(':checked')) {
		$formComision.inputUserAutorizadoID.attr("disabled", false);
	}
}

var add_itemContainer = function(){

    itemElement = {
        "item_id"               : 100000 + (planComisionObject.comisionList.length + 1),
        "codigo"                : $formComision.inputCodigo.val(),
        "nombre"                : $formComision.inputNombre.val(),
        "descripcion"           : $formComision.inputDescripcion.val(),
        "apply_monto"           : $formComision.inputValorFijo.val().replaceAll(',',''),
        "apply_porcentaje"      : $formComision.inputValorPorcentaje.val(),
        "apply_aplica_por"      : $formComision.inputAplicaPorPorcentaje.is(':checked') ? VAR_POR_PORCENTAJE: VAR_POR_MONTO,
        "impuesto"              : $formComision.inputImpuesto.val(),
        "impuesto_text"         : $('option:selected', $formComision.inputImpuesto).text(),
        "aplica_por"            : $formComision.inputAplicaPor.val(),
        "aplica_por_text"           : $('option:selected', $formComision.inputAplicaPor).text(),
        "periodicidad_cobro"        : $formComision.inputPeriodicidadCobro.val(),
        "periodicidad_cobro_text"   : $('option:selected', $formComision.inputPeriodicidadCobro).text(),
        "base_cobro"                : $formComision.inputBaseCobro.val(),
        "base_cobro_text"           : $('option:selected', $formComision.inputBaseCobro).text(),
        "apply_autorizacion"        : $formComision.inputRequiereAutorizacion.is(':checked') ? ON : OFF,
        "autorizador_id"            : $formComision.inputRequiereAutorizacion.is(':checked') ? $formComision.inputUserAutorizadoID.val() : null,
        "autorizador_id_text"       : $formComision.inputRequiereAutorizacion.is(':checked') ? $('option:selected', $formComision.inputUserAutorizadoID).text() : null,
        "update"         : 20,
        "status"         : 10,
        "create"         : 10
    }

    planComisionObject.comisionList.push(itemElement);
    funct_clear_form();
    render_container();
}

var funct_clear_form = function(){
	$formComision.inputCodigo.val(null);
    $formComision.inputNombre.val(null);
    $formComision.inputDescripcion.val(null);
    $formComision.inputAplicaPorMonto.val(null);
    $formComision.inputValorFijo.val(null);
    $formComision.inputValorPorcentaje.val(null);
    $formComision.inputImpuesto.val(null);
    $formComision.inputAplicaPor.val(null);
    $formComision.inputPeriodicidadCobro.val(null);
    $formComision.inputBaseCobro.val(null);
    $formComision.inputUserAutorizadoID.val(null);
    $formComision.inputRequiereAutorizacion.attr("checked", false).change();
}

var render_container = function()
{
    $containerList.html("");
    item_count = 0;
    template_producto  = "";
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

                if (element.status == COMISION_ACTIVO && element.create == ON )
                    template_producto +=  '<td  class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="drop_comision('+ element.item_id +')"><i class="fa fa-trash"></i></button></td>';

                if (element.status == COMISION_ACTIVO && element.create == OFF )
                    template_producto +=  '<td  class="text-center"><button type="button" class="btn btn-warning btn-xs" onclick="baja_comision('+ element.item_id +')"><i class="fa fa-level-down"></i></button></td>';
                 //'<td><i class="fa fa-trash btn btn-danger btn-xs" onclick="refreshItem('+ element.item_id +')"></i></td>'+
            template_producto += '</tr>';
        }
    });

    $containerList.html(template_producto);

    //$inputCompraDetalleArray.val(JSON.stringify(planComisionObject.comisionList));
};


var refreshItem = function(element_id)
{

    $.each(planComisionObject.comisionList, function(key, element){
        if (element) {
            if (element.item_id == element_id ){
                //planComisionObject.comisionList.splice(key, 1 );
                element.status = 1;
            }
        }
    });


    render_container();
}


var funct_confirmPlanComision = function() {
    swal({
        title: "<h4>¿ DESEAS CONTINUAR CON EL REGISTRO?</h4>",
        text: '',
        type: "warning",
        html: true,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "CONFIRMACION",
        closeOnConfirm: false
    }, function () {

        funct_postOperacionPlanComision();
    });
}

var funct_postOperacionPlanComision = function(){
    if (validation_registro()) {

        $.post(VAR_PATH_URL + "configuracion/comision/post-plan-comision",{ comisionObject : planComisionObject }, function(response){

            if ( response.code == 202 ) {
                toast2Bold('DISPOSICIÓN','FOLIO DE OPERACION #' + response.folio_id , 'success');


                setTimeout(() => {
                  window.location.href  = VAR_PATH_URL + "configuracion/comision/index";
                }, 2000);



            }else{
                toast2Bold('DISPOSICIÓN','OCURRIO UN ERROR, INTENTA NUEVAMENTE', 'warning');
            }
        });
    }

}

var drop_comision = function(item_id){

    $.each(planComisionObject.comisionList, function(key_comision, item_comision){
        if (item_comision.item_id == item_id )
            planComisionObject.comisionList.splice(key_comision,1);
    });

    render_container();
};


var baja_comision = function(item_id){

    $.each(planComisionObject.comisionList, function(key_comision, item_comision){
        if (item_comision.item_id == item_id )
            planComisionObject.comisionList[key_comision].status = COMISION_BAJA;
    });

    render_container();
};


var validation_form = function()
{
	switch(true){
        case !$formComision.inputCodigo.val() :
            toast2("PLAN COMISIONES", "CODIGO ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;

        case !$formComision.inputNombre.val() :
            toast2("PLAN COMISIONES", "NOMBRE ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;

        case !$formComision.inputDescripcion.val() :
            toast2("PLAN COMISIONES", "DESCRIPCION ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;

        case !$formComision.inputImpuesto.val() :
            toast2("PLAN COMISIONES", "IMPUESTO ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;

        case !$formComision.inputAplicaPor.val() :
            toast2("PLAN COMISIONES", "APLICAR POR ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;

        case !$formComision.inputPeriodicidadCobro.val() :
            toast2("PLAN COMISIONES", "PERIODICIDAD ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;

        case !$formComision.inputBaseCobro.val() :
            toast2("PLAN COMISIONES", "BASE COBRO ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
            return true;
        break;


        case $formComision.inputAplicaPorPorcentaje.is(':checked'):
            if (!$formComision.inputValorPorcentaje.val()) {
                toast2("PLAN COMISIONES", "EL PORCENTAJE ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
                return true;
            }
        break;
        case $formComision.inputAplicaPorMonto.is(':checked'):

            if (!$formComision.inputValorFijo.val()) {
                toast2("PLAN COMISIONES", "EL MONTO FIJO ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
                return true;
            }
        break;
    }
}


var validation_registro = function(){
    if (!planComisionObject.clave) {
        toast2("PLAN COMISIONES", "CODIGO ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
        return false;
    }

    if (!planComisionObject.descripcion) {
        toast2("PLAN COMISIONES", "DESCRIPCION ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
        return false;
    }

    if (!planComisionObject.titulo) {
        toast2("PLAN COMISIONES", "NOMBRE ES REQUERIDO, VERIFICA TU INFORMACION", "warning");
        return false;
    }

    if (planComisionObject.comisionList == 0 ) {
        toast2("PLAN COMISIONES", "INGRESA UNA COMISION, VERIFICA TU INFORMACION", "warning");
        return false;
    }

    return true;
}


var init = function(){
    if ($comisionID.val()) {
        $.get(VAR_PATH_URL + "configuracion/comision/get-plan-comision", {'plan_comision_id' : $comisionID.val() }, function(response) {
            if ( response.code == 202 )
                planComisionObject = response.planComisionObject;

            render_container();
        }, 'json');
    }
}
