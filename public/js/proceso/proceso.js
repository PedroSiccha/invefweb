function vuelto() {
    var importeRecibido = $("#impoRecibido").val();
    var importePago = $("#impoPagar").val();

    var vuelto = parseFloat(importeRecibido) - parseFloat(importePago);

    $("#vuelto").val(vuelto);
    
}


function Detalle(id, nombre, dni, garantia, fecinicio, fecfin, dias, monto, interes, mora, total, estado) {
    $('#detalle').modal('show');

    document.getElementById("detId").innerHTML="<p>" +id+"</p>";
    document.getElementById("detNombre").innerHTML="<p>"+nombre+"</p>";
    document.getElementById("detDni").innerHTML="<p>"+dni+"</p>";
    document.getElementById("detGarantia").innerHTML="<p style='text-align:right;'>"+garantia+"</p>";
    document.getElementById("detFecInicio").innerHTML="<p style='text-align:right;'>"+fecinicio+"</p>";
    document.getElementById("detFecFin").innerHTML="<p style='text-align:right;'>"+fecfin+"</p>";
    document.getElementById("detDias").innerHTML="<p style='text-align:right;'>"+dias+"</p>";
    document.getElementById("detMonto").innerHTML="<p style='text-align:right;'>S/. "+monto+"</p>";
    document.getElementById("detInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
    document.getElementById("detMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
    document.getElementById("detTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
}

function Pagar(id, monto, interes, mora, total, dia, diafin, estado) {
            
    $('#pagar').modal('show');
    $('#pagoInteres').val(interes);
    $('#pagoPrestamo').val(monto);
    document.getElementById("pagarPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
    document.getElementById("pagarInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
    document.getElementById("pagarMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
    document.getElementById("pagarTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
    document.getElementById("idPagar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoP' value='" +id+"'>";
    document.getElementById("diaPagar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='diaPago' value='" +dia+"'>";
    document.getElementById("diaMora").innerHTML="<input hidden style='font-size: large;' type='text' class='form-control text-success' id='pagoMora' value='" +mora+"'>";
        
}

function Renovar(id, monto, interes, mora, total, dia, diafin, estado) {
    $('#renovar').modal('show');
    $('#renPrestamo').val(monto);
    pagoMinimo = parseInt(interes) + parseInt(mora);
    document.getElementById("idRenovar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoR' value='" +id+"'>";
    document.getElementById("diaRenovar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='diaReno' value='" +dia+"'>";
    document.getElementById("envInteres").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renInteres' value='" +interes+"'>";
    document.getElementById("envMora").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renMora' value='" +mora+"'>";
    document.getElementById("renovarPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
    document.getElementById("renovarInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
    document.getElementById("renovarMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
    document.getElementById("renovarTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
    document.getElementById("renovarMinimo").innerHTML="<p style='text-align:right;'>S/. "+pagoMinimo+"</p>";
}

function correo(nombre, apellido, correo) {
    $('#mCorreo').modal('show');

    
    document.getElementById("corNombreT").innerHTML="<p>"+nombre+" "+apellido+"</p>";
    document.getElementById("corDetalle").innerHTML="<p>"+correo+"</p>";
    
}



function Numeros(id, nombre, dni, telefono, whatsapp, referencia) {
    $('#mTelefonos').modal('show');

    //document.getElementById("detId").innerHTML="<p>" +id+"</p>";
    document.getElementById("detNombreT").innerHTML="<p>"+nombre+"</p>";
    document.getElementById("detDniT").innerHTML="<p>"+dni+"</p>";
    document.getElementById("telefono").innerHTML="<p style='text-align:right;'>"+telefono+"</p>";
    document.getElementById("whatsapp").innerHTML="<p style='text-align:right;'>"+whatsapp+"</p>";
    document.getElementById("numReferencia").innerHTML="<p style='text-align:right;'>"+referencia+"</p>";
}