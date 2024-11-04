
function mostrarMensajeError(input, mensaje) {
    input.nextElementSibling.textContent = mensaje;
    input.classList.add('is-invalid');
}

function limpiarMensajeError(input) {
    input.classList.remove('is-invalid');
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

function validarRegistro() {
    let nombreValido = validarCampo(document.getElementById('registroNombre'), "Nombre obligatorio, solo letras");
    let apellidoValido = validarCampo(document.getElementById('registroApellido'), "Apellido obligatorio, solo letras");
    let emailValido = validarCampo(document.getElementById('registroEmail'), "Correo obligatorio y válido", /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
    let pwd = document.getElementById('registroPwd');
    let pwdConfirm = document.getElementById('registroPwdConfirm');
    let passwordValida = validarCampo(pwd, "Contraseña mínima de 8 caracteres", /^(?=.*\d).{8,}$/);
    let passwordConfirmValida = pwd.value === pwdConfirm.value;
    
    if (!passwordConfirmValida) mostrarMensajeError(pwdConfirm, "Las contraseñas no coinciden");
    else limpiarMensajeError(pwdConfirm);

    return nombreValido && apellidoValido && emailValido && passwordValida && passwordConfirmValida;
}

function validarLogin() {
    let emailValido = validarCampo(document.getElementById('loginEmail'), "Correo obligatorio y válido", /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
    let pwdValida = validarCampo(document.getElementById('loginPwd'), "Contraseña mínima de 8 caracteres", /^(?=.*\d).{8,}$/);
    return emailValido && pwdValida;
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formRegistro").addEventListener("submit", function(event) {
        event.preventDefault();
      
        if (validarRegistro()) {
            alert("Registro exitoso");
        }
    });
    document.getElementById("formLogin").addEventListener("submit", function(event) {
        event.preventDefault();
       
        if (validarLogin()) {
            alert("Inicio de sesión exitoso");
        }
    });
});
