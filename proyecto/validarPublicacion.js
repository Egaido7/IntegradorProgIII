// Validaciones específicas para el formulario de publicación
function validarPublicacion() {
    const nombreProducto = document.getElementById("PubliNombre");
    const descripcionProducto = document.getElementById("PubliDescripcion");
    const volumen = document.querySelector("[aria-label='PubliVolumen']");
    const peso = document.getElementById("PubliPeso");
    const provinciaOrigen = document.querySelector("[aria-label='ProvinciaOrigen']");
    const localidadOrigen = document.querySelector("[aria-label='LocalidadOrigen']");
    const domicilioOrigen = document.getElementById("PubliDomicilio_Origen");
    const provinciaDestino = document.querySelector("[aria-label='ProvinciaDestino']");
    const localidadDestino = document.querySelector("[aria-label='Localidad_Destino']");
    const domicilioDestino = document.getElementById("PubliDomicilio_Destino");

    // Validación para cada campo según los requisitos
    let nombreValido = validarCampo(nombreProducto, "Nombre debe ser mayor a 5 caracteres sin caracteres especiales", /^[a-zA-Z\s]{5,}$/);
    let descripcionValida = validarCampo(descripcionProducto, "Descripción debe ser mayor a 10 caracteres", /^.{10,}$/);
    
    let volumenValido = volumen && volumen.value !== "Elegi el volumen de tu paquete";
    if (!volumenValido) mostrarMensajeError(volumen, "Debe seleccionar un volumen");
    
    let pesoValido = validarCampo(peso, "Peso debe ser un valor positivo", /^[1-9][0-9]*$/);
    
    let provinciaOrigenValida = provinciaOrigen && provinciaOrigen.value !== "Selecciona la provincia";
    if (!provinciaOrigenValida) mostrarMensajeError(provinciaOrigen, "Debe seleccionar una provincia de origen");

    let localidadOrigenValida = localidadOrigen && localidadOrigen.value !== "Selecciona la localidad";
    if (!localidadOrigenValida) mostrarMensajeError(localidadOrigen, "Debe seleccionar una localidad de origen");

    let domicilioOrigenValido = validarCampo(domicilioOrigen, "Domicilio de origen debe ser mayor a 5 caracteres sin caracteres especiales", /^[a-zA-Z\s]{5,}$/);
    
    let provinciaDestinoValida = provinciaDestino && provinciaDestino.value !== "Selecciona la provincia";
    if (!provinciaDestinoValida) mostrarMensajeError(provinciaDestino, "Debe seleccionar una provincia de destino");

    let localidadDestinoValida = localidadDestino && localidadDestino.value !== "Selecciona la localidad";
    if (!localidadDestinoValida) mostrarMensajeError(localidadDestino, "Debe seleccionar una localidad de destino");

    let domicilioDestinoValido = validarCampo(domicilioDestino, "Domicilio de destino debe ser mayor a 5 caracteres sin caracteres especiales", /^[a-zA-Z\s]{5,}$/);

    const formularioValido = nombreValido && descripcionValida && volumenValido && pesoValido &&
                             provinciaOrigenValida && localidadOrigenValida && domicilioOrigenValido &&
                             provinciaDestinoValida && localidadDestinoValida && domicilioDestinoValido;

    if (formularioValido) {
        cerrarModalPublicacion(); // Cierra el modal solo si es válido
    } else {
        console.warn("Formulario contiene errores.");
    }

    return formularioValido;
}

// Evento de validación para el formulario de publicación
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("FormPublicacion").addEventListener("submit", function(event) {
        event.preventDefault();

        if (validarPublicacion()) {
            //alert("Publicación exitosa");
        }
    });
});