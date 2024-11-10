function mostrarMensajeError(input, mensaje) {
    input.nextElementSibling.textContent = mensaje;
    input.classList.add('is-invalid');
}

function limpiarMensajeError(input) {
    input.classList.remove('is-invalid');
    input.nextElementSibling.textContent = '';
}

function validarCampo(input, mensaje, pattern = null) {
    if (!input.value.trim()) {
        mostrarMensajeError(input, mensaje);
        return false;
    } else if (pattern && !pattern.test(input.value)) {
        mostrarMensajeError(input, mensaje);
        return false;
    } else {
        limpiarMensajeError(input);
        return true;
    }
}

// Validación de formulario de registro
function validarRegistro() {
    let nombreValido = validarCampo(document.getElementById('registroNombre'), "Nombre obligatorio, solo letras", /^[a-zA-Z]{2,}$/);
    let apellidoValido = validarCampo(document.getElementById('registroApellido'), "Apellido obligatorio, solo letras", /^[a-zA-Z]{2,}$/);
    let dniValido = validarCampo(document.getElementById('registroDni'), "DNI Obligatorio, solo números de 8 a 10 dígitos", /^[1-9]\d{7,9}$/);
    let emailValido = validarCampo(document.getElementById('registroEmail'), "Correo obligatorio y válido", /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
    let passwordValida = validarCampo(document.getElementById('registroPwd'), "Contraseña mínima de 8 caracteres", /^.{8,}$/);
    let pwdConfirm = document.getElementById('registroPwdConfirm');
    let passwordConfirmValida = pwdConfirm.value === document.getElementById('registroPwd').value;

    if (!passwordConfirmValida) {
        mostrarMensajeError(pwdConfirm, "Las contraseñas no coinciden");
    } else {
        limpiarMensajeError(pwdConfirm);
    }

    return nombreValido && apellidoValido && dniValido && emailValido && passwordValida && passwordConfirmValida;
}

// Validación de formulario de login
function validarLogin() {
    let emailValido = validarCampo(document.getElementById('loginEmail'), "Correo obligatorio y válido", /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
    let passwordValida = validarCampo(document.getElementById('loginPwd'), "Contraseña mínima de 8 caracteres", /^.{8,}$/);
    return emailValido && passwordValida;
}

document.addEventListener("DOMContentLoaded", function () {
    // Envío del formulario de registro
    document.getElementById("formRegistro").addEventListener("submit", function (event) {
        if (!validarRegistro()) {
            event.preventDefault(); // Prevenir el envío si hay errores de validación
        }
    });

    // Envío del formulario de login
    document.getElementById("formLogin").addEventListener("submit", function (event) {
        if (!validarLogin()) {
            event.preventDefault(); // Prevenir el envío si hay errores de validación
        }
    });
});


//VALIDACION PARA FORMULARIO DE REGISTRO
// Función para cerrar el modal usando Bootstrap si la validación es exitosa
function cerrarModalPublicacion() {
    const modalElement = document.getElementById('publicarModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    modal.hide();
}

// Función para mostrar mensaje de error
function mostrarMensajeError(input, mensaje) {
    if (input) {
        input.nextElementSibling.textContent = mensaje;
        input.classList.add('is-invalid');
    }
}

// Función para limpiar mensaje de error
function limpiarMensajeError(input) {
    if (input) {
        input.classList.remove('is-invalid');
    }
}

// Función de validación de campo con comprobación de existencia de input
function validarCampo(input, mensaje, pattern = null) {
    if (input && !input.value.trim()) {
        mostrarMensajeError(input, mensaje);
        return false;
    } else if (input && pattern && !pattern.test(input.value)) {
        mostrarMensajeError(input, mensaje);
        return false;
    } else if (input) {
        limpiarMensajeError(input);
        return true;
    }
    return false;
}

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
