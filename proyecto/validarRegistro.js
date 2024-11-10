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





