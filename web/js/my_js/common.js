$btnActPT.click(function(){

    if(confirm("¿Desea continuar con la edicion del PT?")){

        $formPerfilTransaccional.inputCredito.attr("disabled", false);
        $formPerfilTransaccional.inputFrecuencia.attr("disabled", false);
        $formPerfilTransaccional.inputMontoPago.attr("disabled", false);
        $formPerfilTransaccional.inputInstrumento.attr("disabled", false);
        $formPerfilTransaccional.inputMoneda.attr("disabled", false);
        $formPerfilTransaccional.inputOperacionesMin.attr("disabled", false);
        $formPerfilTransaccional.inputOperacionesMax.attr("disabled", false);

        $formPerfilTransaccionalOtro.inputCredito.attr("disabled", false);
        $formPerfilTransaccionalOtro.inputFrecuencia.attr("disabled", false);
        $formPerfilTransaccionalOtro.inputMontoPago.attr("disabled", false);
        $formPerfilTransaccionalOtro.inputInstrumento.attr("disabled", false);
        $formPerfilTransaccionalOtro.inputMoneda.attr("disabled", false);
        $formPerfilTransaccionalOtro.inputOperacionesMin.attr("disabled", false);
        $formPerfilTransaccionalOtro.inputOperacionesMax.attr("disabled", false);

        document.getElementById("fechaActPT").style.display = "block";

        }else{
       
        }
   
});

