var $formPago = {
	inputPago 				: $('#pago-inputTotalPago'),
	inputApplyAjusteManual 	: $('#pago-apply_ajuste_manual'),
	inputCargoMora 			: $('#saldo-cargo_moratorios'),
	inputCargoOrdinario 	: $('#saldo-cargo_ordinario'),
	inputCargoVencido 		: $('#saldo-cargo_vencido'),
	inputCargoExigible 		: $('#saldo-cargo_exigible'),
	inputCargoAmortiza 		: $('#saldo-amortizacion_exigible'),
	inputCargoCapital 		: $('#saldo-cargo_capital'),
	inputCargoInsoluto 		: $('#saldo-cargo_insoluto'),
	inputCargoPagoAnt 		: $('#saldo-cargo_pago_anticipado'),
	inputCargoPagoAntIva 	: $('#saldo-cargo_pago_anticipado_iva'),
	inputCargoPagoVen 		: $('#saldo-cargo_pago_vencido'),
	inputCargoPagoVenIva 	: $('#saldo-cargo_pago_vencido_iva'),

	inputDespuesMora 			: $('#despues-cargo_moratorios'),
	inputDespuesOrdinario 		: $('#despues-cargo_ordinario'),
	inputDespuesVencido 		: $('#despues-cargo_vencido'),
	inputDespuesExigible 		: $('#despues-cargo_exigible'),
	inputDespuesAmortiza 		: $('#despues-amortizacion_exigible'),
	inputDespuesCapital 		: $('#despues-cargo_capital'),
	inputDespuesInsoluto 		: $('#despues-cargo_insoluto'),
	//inputDespuesPagoAnt 		: $('#despues-cargo_pago_anticipado'),
	//inputDespuesPagoVen 		: $('#despues-cargo_pago_vencido'),
};
pagoObject = {
	"credito_id"  	  						: $('#inputCreditoID').val(),
	"total_operacion" 						: 0,
	"apply_ajuste_manual"  					: null,
	"apply_comision_pago_anticipado" 		: 20,
	"apply_comision_pago_anticipado_iva"	: null,
	"apply_comision_pago_anticipado_tipo" 	: null,
	"apply_comision_pago_anticipado_valor"	: null,

	"apply_comision_pago_vencido" 		: 20,
	"cargo_pago_anticipado" 			: null,
	"cargo_pago_anticipado_iva" 		: null,
	"cargo_pago_vencido"  				: null,
	"cargo_pago_vencido_iva"  			: null,
	"cargo_mora"  						: null,
	"cargo_ordinario"  					: null,
	"cargo_vencido"  					: null,
	"cargo_exigible"  					: null,
	"amortizacion_exigible" 			: null,
	"cargo_capital"  					: null,
	"saldoInsoluto"  					: null,
	"adeudoTotal"  					: null,
},
ON 				= 10;
OFF 			= 20;
APLICA_MONTO_FIJO = 10;
APLICA_PORCENTAJE = 20;

saldosCredito 	= null;

VAR_PATH_URL            = $('body').data('url-root'),

$(function(){

	init();

	$formPago.inputPago.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoPagoAnt.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoPagoAntIva.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoPagoVen.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoPagoVenIva.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoAmortiza.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoMora.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoOrdinario.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoVencido.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoExigible.mask('$ 000,000,000,000,000.00', {reverse: true});
	$formPago.inputCargoCapital.mask('$ 000,000,000,000,000.00', {reverse: true});


	$formPago.inputApplyAjusteManual.change(function(){
		funct_activacionManual();
	});

	$formPago.inputPago.change(function(){
		totalOperacion = $formPago.inputPago.val() ? $formPago.inputPago.val().replaceAll(',','') : 0;
		if (parseFloat(totalOperacion) - funct_getComisionPago()  <= saldosCredito.saldo_insoluto ) {
			pagoObject.total_operacion = totalOperacion;
			if (!$formPago.inputApplyAjusteManual.is(':checked'))
				funct_dispersionPago();
		}else{
			toast2("PAGO", "LA CANTIDAD MAXIMA DE OPERACION ES " + btf.conta.money(saldosCredito.saldo_insoluto) , "warning");
			$formPago.inputPago.val(null);
			pagoObject.total_operacion = 0;
			funct_dispersionPago();
		}

	});
})

var init = function(){
	$.get(VAR_PATH_URL + "financiamiento/pagos/get-init-saldo", { credito_id :  $('#inputCreditoID').val() }, function(response){
        if (response.code == 202) {
            saldosCredito = response.saldo;
            pagoObject.apply_comision_pago_anticipado 		= response.apply_pago_anticipado;
            pagoObject.apply_comision_pago_anticipado_iva 	= response.apply_pago_anticipado_iva;
            pagoObject.apply_comision_pago_anticipado_tipo 	= response.apply_pago_anticipado_tipo;
            pagoObject.apply_comision_pago_anticipado_valor	= response.apply_pago_anticipado_valor;
            pagoObject.apply_comision_pago_vencido 			= response.apply_pago_vencido;
        }
    });
}

var funct_getComisionPago = function(){
	return (pagoObject.cargo_pago_anticipado ? pagoObject.cargo_pago_anticipado : 0 ) + ( pagoObject.cargo_pago_anticipado_iva ? pagoObject.cargo_pago_anticipado_iva : 0 ) + ( pagoObject.cargo_pago_vencido_iva ? pagoObject.cargo_pago_vencido_iva : 0 )  + ( pagoObject.cargo_pago_vencido ? pagoObject.cargo_pago_vencido : 0 );
}

var funct_activacionManual = function(){
	if ($formPago.inputApplyAjusteManual.is(':checked')) {
		$formPago.inputCargoPagoAnt.attr("disabled", false);
		$formPago.inputCargoPagoAntIva.attr("disabled", false);
		$formPago.inputCargoPagoVen.attr("disabled", false);
		$formPago.inputCargoPagoVenIva.attr("disabled", false);
		$formPago.inputCargoMora.attr("disabled", false);
		$formPago.inputCargoOrdinario.attr("disabled", false);
		$formPago.inputCargoVencido.attr("disabled", false);
		$formPago.inputCargoExigible.attr("disabled", false);
		$formPago.inputCargoAmortiza.attr("disabled", false);
		$formPago.inputCargoCapital.attr("disabled", false);

		pagoObject.apply_ajuste_manual = 10;
	}else{
		funct_dispersionPago();
		pagoObject.apply_ajuste_manual = null;
	}
}


var funct_dispersionPago = function(){


	funct_applyComisiones();


	$formPago.inputCargoPagoAnt.attr("disabled", true);
	$formPago.inputCargoPagoAntIva.attr("disabled", true);
	$formPago.inputCargoPagoVen.attr("disabled", true);
	$formPago.inputCargoPagoVenIva.attr("disabled", true);
	$formPago.inputCargoMora.attr("disabled", true);
	$formPago.inputCargoOrdinario.attr("disabled", true);
	$formPago.inputCargoVencido.attr("disabled", true);
	$formPago.inputCargoExigible.attr("disabled", true);
	$formPago.inputCargoAmortiza.attr("disabled", true);
	$formPago.inputCargoCapital.attr("disabled", true);

	/*P . ANTICIPADO*/
	residuo  = funct_PagoAnticipado(parseFloat(pagoObject.total_operacion));


	residuo  = funct_PagoAnticipadoIva(residuo);


	/*P . VENCIDO*/
	residuo  = funct_PagoVencido(residuo);

	/*MORATORIO*/
	residuo  = funct_Moratorio(residuo);

	/*ORDINARIOS*/
	residuo  = funct_ordinario(residuo);

	/*CAPITAL VENCIDO*/
	residuo  = funct_capitalVencido(residuo);

	/*AMORTIZACION EXIGIBLE*/
	residuo  = funct_amortizaExigible(residuo);

	/*CAPITAL EXIGIBLE*/
	residuo  = funct_capitalExigible(residuo);

	/*CAPITAL*/
	residuo  = funct_capital(residuo);

	render_inputValues();

}

var funct_applyComisiones = function(){
	if (pagoObject.apply_comision_pago_vencido == ON && !pagoObject.apply_ajuste_manual) {
		saldosCredito.pago_vencido 		= 0;

	}

	if (pagoObject.apply_comision_pago_anticipado == ON && !pagoObject.apply_ajuste_manual) {

		/*MORATORIO*/
		residuo  = funct_Moratorio(parseFloat(pagoObject.total_operacion));

		/*ORDINARIOS*/
		residuo  = funct_ordinario(residuo);

		/*CAPITAL VENCIDO*/
		residuo  = funct_capitalVencido(residuo);

		/*AMORTIZACION EXIGIBLE*/
		residuo  = funct_amortizaExigible(residuo);

		/*CAPITAL EXIGIBLE*/
		residuo  = funct_capitalExigible(residuo);

		pagoAnticipado = 0;

		if (pagoObject.apply_comision_pago_anticipado_tipo == APLICA_MONTO_FIJO) {
			pagoAnticipado = pagoObject.apply_comision_pago_anticipado_valor;
		}

		if (pagoObject.apply_comision_pago_anticipado_tipo == APLICA_PORCENTAJE) {
			pagoAnticipado  = residuo * pagoObject.apply_comision_pago_anticipado_valor ;
		}

		saldosCredito.pago_anticipado  		= pagoAnticipado;

		saldosCredito.pago_anticipado_iva	= saldosCredito.pago_anticipado * pagoObject.apply_comision_pago_anticipado_iva;

	}
}

var funct_PagoAnticipado = function(monto){
	if (saldosCredito.pago_anticipado > 0) {
		pagoObject.cargo_pago_anticipado = (monto > saldosCredito.pago_anticipado ? saldosCredito.pago_anticipado : monto );
	}

	return (monto > saldosCredito.pago_anticipado ? monto - saldosCredito.pago_anticipado : 0 );
}

var funct_PagoAnticipadoIva = function(monto){
	if (saldosCredito.pago_anticipado_iva > 0) {
		pagoObject.cargo_pago_anticipado_iva = (monto > saldosCredito.pago_anticipado_iva ? saldosCredito.pago_anticipado_iva : monto );
	}

	return (monto > saldosCredito.pago_anticipado ? monto - saldosCredito.pago_anticipado_iva : 0 );
}

var funct_PagoVencido = function(monto){
	if (saldosCredito.pago_vencido > 0) {
		pagoObject.cargo_pago_vencido = (monto > saldosCredito.pago_vencido ? saldosCredito.pago_vencido : monto );
	}

	return (monto > saldosCredito.pago_vencido ? monto - saldosCredito.pago_vencido : 0 );
}

var funct_Moratorio = function(monto){
	if (saldosCredito.interes_moratorio > 0) {
		pagoObject.cargo_mora = (monto > saldosCredito.interes_moratorio ? saldosCredito.interes_moratorio : monto );
	}

	return (monto > saldosCredito.interes_moratorio ? monto - saldosCredito.interes_moratorio : 0 );
}

var funct_ordinario = function(monto){
	if (saldosCredito.interes_ordinario_vigente > 0) {
		pagoObject.cargo_ordinario = (monto > saldosCredito.interes_ordinario_vigente ? saldosCredito.interes_ordinario_vigente : monto );
	}

	return (monto > saldosCredito.interes_ordinario_vigente ? monto - saldosCredito.interes_ordinario_vigente : 0 );
}

var funct_capitalVencido = function(monto){
	if (saldosCredito.principal_vencido > 0) {
		pagoObject.cargo_vencido = (monto > saldosCredito.principal_vencido ? saldosCredito.principal_vencido : monto );
	}

	return (monto > saldosCredito.principal_vencido ? monto - saldosCredito.principal_vencido : 0 );
}

var funct_amortizaExigible = function(monto){
	if (saldosCredito.amortizacion_exigible > 0) {
		pagoObject.amortizacion_exigible = (monto > saldosCredito.amortizacion_exigible ? saldosCredito.amortizacion_exigible : monto );
	}

	return (monto > saldosCredito.amortizacion_exigible ? monto - saldosCredito.amortizacion_exigible : 0 );
}

var funct_capitalExigible = function(monto){
	if (saldosCredito.principal_exigible > 0) {
		pagoObject.cargo_exigible = (monto > saldosCredito.principal_exigible ? saldosCredito.principal_exigible : monto );
	}

	return (monto > saldosCredito.principal_exigible ? monto - saldosCredito.principal_exigible : 0 );
}

var funct_capital = function(monto){
	if (saldosCredito.principal > 0) {
		pagoObject.cargo_capital = (monto > saldosCredito.principal ? saldosCredito.principal : monto );
	}

	return (monto > saldosCredito.principal ? monto - saldosCredito.principal : 0 );
}

var funct_calSaldoInsoluto = function(){
	let totalInsoluto =  parseFloat(saldosCredito.total_capital_saldo_insoluto) - (parseFloat((pagoObject.cargo_mora ? pagoObject.cargo_mora : 0)) + parseFloat((pagoObject.cargo_ordinario ? pagoObject.cargo_ordinario : 0)) + parseFloat((pagoObject.cargo_vencido ? pagoObject.cargo_vencido : 0)) + parseFloat((pagoObject.cargo_exigible ? pagoObject.cargo_exigible : 0)) + parseFloat((pagoObject.amortizacion_exigible ? pagoObject.amortizacion_exigible : 0)) +  parseFloat((pagoObject.cargo_capital ? pagoObject.cargo_capital : 0)));
	if(pagoObject.apply_comision_pago_anticipado == ON && !pagoObject.apply_ajuste_manual){
		let capitalVigente  			= parseFloat((pagoObject.cargo_capital ? pagoObject.cargo_capital : 0));
		let capitalVigenteComision 		= 0;

		if (pagoObject.apply_comision_pago_anticipado_tipo == APLICA_MONTO_FIJO)
			capitalVigenteComision = pagoObject.apply_comision_pago_anticipado_valor;

		if (pagoObject.apply_comision_pago_anticipado_tipo == APLICA_PORCENTAJE)
			capitalVigenteComision  = capitalVigente * pagoObject.apply_comision_pago_anticipado_valor ;

		let capitalVigenteComisionIva 	= capitalVigenteComision * pagoObject.apply_comision_pago_anticipado_iva;
		pagoObject.adeudoTotal 	= totalInsoluto  +  capitalVigenteComision + capitalVigenteComisionIva ;
	}


	return  totalInsoluto;
}

/*
$formPago.inputCargoPagoAnt.change(function(){
	funct_PagoAnticipado($formPago.inputCargoPagoAnt.val().replaceAll(',',''));
	render_inputValues();
});

$formPago.inputCargoPagoVen.change(function(){
	funct_PagoVencido($formPago.inputCargoPagoVen.val().replaceAll(',',''));
	render_inputValues();
});
*/
$formPago.inputCargoMora.change(function(){
	funct_Moratorio($formPago.inputCargoMora.val().replaceAll(',',''));
	render_inputValues();
});

$formPago.inputCargoOrdinario.change(function(){
	funct_ordinario($formPago.inputCargoOrdinario.val().replaceAll(',',''));
	render_inputValues();
});

$formPago.inputCargoVencido.change(function(){
	funct_capitalVencido($formPago.inputCargoVencido.val().replaceAll(',',''));
	render_inputValues();
});

$formPago.inputCargoAmortiza.change(function(){
	funct_amortizaExigible($formPago.inputCargoAmortiza.val().replaceAll(',',''));
	render_inputValues();
});

$formPago.inputCargoExigible.change(function(){
	funct_capitalExigible($formPago.inputCargoExigible.val().replaceAll(',',''));
	render_inputValues();
});


$formPago.inputCargoCapital.change(function(){
	funct_capital($formPago.inputCargoCapital.val().replaceAll(',',''));
	render_inputValues();
});

var render_inputValues = function(){

	/*SALDO INSOLUTO*/
	pagoObject.saldoInsoluto = funct_calSaldoInsoluto();

	$formPago.inputCargoPagoAnt.val(btf.conta.miles(pagoObject.cargo_pago_anticipado));
	$formPago.inputCargoPagoAntIva.val(btf.conta.miles(pagoObject.cargo_pago_anticipado_iva));
	$formPago.inputCargoPagoVen.val(btf.conta.miles(pagoObject.cargo_pago_vencido));
	$formPago.inputCargoPagoVenIva.val(btf.conta.miles(pagoObject.cargo_pago_vencido_iva));
	$formPago.inputCargoMora.val(btf.conta.miles(pagoObject.cargo_mora));
	$formPago.inputCargoOrdinario.val(btf.conta.miles(pagoObject.cargo_ordinario));
	$formPago.inputCargoVencido.val(btf.conta.miles(pagoObject.cargo_vencido));
	$formPago.inputCargoExigible.val(btf.conta.miles(pagoObject.cargo_exigible));
	$formPago.inputCargoAmortiza.val(btf.conta.miles(pagoObject.amortizacion_exigible));
	$formPago.inputCargoCapital.val(btf.conta.miles(pagoObject.cargo_capital));
	//$formPago.inputCargoInsoluto.val(btf.conta.miles(pagoObject.saldoInsoluto));


	//$formPago.inputDespuesPagoAnt.val(btf.conta.miles( saldosCredito.pago_anticipado  - convertNumber(pagoObject.cargo_pago_anticipado)));
	//$formPago.inputDespuesPagoVen.val(btf.conta.miles( saldosCredito.pago_vencido  - convertNumber(pagoObject.cargo_pago_vencido)));
	$formPago.inputDespuesMora.val(btf.conta.miles( saldosCredito.interes_moratorio  - convertNumber(pagoObject.cargo_mora)));
	$formPago.inputDespuesOrdinario.val(btf.conta.miles( saldosCredito.interes_ordinario_vigente  - convertNumber(pagoObject.cargo_ordinario)));
	$formPago.inputDespuesVencido.val(btf.conta.miles( saldosCredito.principal_vencido  - convertNumber(pagoObject.cargo_vencido)));
	$formPago.inputDespuesExigible.val(btf.conta.miles( saldosCredito.principal_exigible  - convertNumber(pagoObject.cargo_exigible)));
	$formPago.inputDespuesAmortiza.val(btf.conta.miles( saldosCredito.amortizacion_exigible  - convertNumber(pagoObject.amortizacion_exigible)));
	$formPago.inputDespuesCapital.val(btf.conta.miles( saldosCredito.principal  - convertNumber(pagoObject.cargo_capital)));
	$formPago.inputDespuesInsoluto.val(btf.conta.miles(convertNumber(pagoObject.saldoInsoluto)));
}

var confirmSavePago = function(){
	swal({

        title: "<h4>¿ DESEAS CONTINUAR CON EL PAGO?</h4>",
        text: '<strong style="font-size: 24px;font-weight: 700;color: #000;">'+ "El monto de la operacion es : "+  btf.conta.money(pagoObject.total_operacion)  +'</strong>',
        type: "warning",
        html: true,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "CONFIRMACION",
        closeOnConfirm: false
    }, function () {
    	if (valid_operacion()) {
    		funct_postOperacionPago();
    	}
    });
}


var valid_operacion= function(){

	if ( !pagoObject.total_operacion || pagoObject.total_operacion <= 0 ) {
        toast2("PAGO", "LA OPERACIÓN ES INVALIDO, VERIFICA TU INFORMACION", 'warning');
        return false;
    }


    if ( parseFloat(pagoObject.total_operacion) !=  (parseFloat((pagoObject.cargo_pago_anticipado ? pagoObject.cargo_pago_anticipado : 0)) + parseFloat((pagoObject.cargo_pago_anticipado_iva ? pagoObject.cargo_pago_anticipado_iva : 0))  + parseFloat((pagoObject.cargo_pago_vencido ? pagoObject.cargo_pago_vencido : 0)) + parseFloat((pagoObject.cargo_mora ? pagoObject.cargo_mora : 0)) + parseFloat((pagoObject.cargo_ordinario ? pagoObject.cargo_ordinario : 0)) + parseFloat((pagoObject.cargo_vencido ? pagoObject.cargo_vencido : 0)) + parseFloat((pagoObject.cargo_exigible ? pagoObject.cargo_exigible : 0)) +  parseFloat((pagoObject.cargo_capital ? pagoObject.cargo_capital : 0)))  ) {
        toast2("PAGO", "LA OPERACIÓN ES INCORRECTA, VERIFICA TU INFORMACION", 'warning');
        return false;
    }


    return true;

}

var funct_postOperacionPago = function()
{
	$.post(VAR_PATH_URL + "financiamiento/pagos/post-operacion",{ operacionPago : pagoObject }, function(response){
		if ( response.code == 202 ) {

			swal("CONFIRMACION ACEPTADA", "", "success");
			location.reload();
		}else{
			swal("ERROR AL PROCESAR LA OPERACIÓN", "", "warning");
		}


	});
}


var show_loader = function(){
    $('body').append('<div  id="page_loader" style="opacity: .8;z-index: 2040 !important;    position: fixed;top: 0;left: 0;z-index: 1040;width: 100vw;height: 100vh;background-color: #000;"><div class="spiner-example" style="position: fixed;top: 50%;left: 0;z-index: 2050 !important; width: 100%;height: 100%;"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div></div>');
}


var hide_loader = function(){
    $('#page_loader').remove();
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