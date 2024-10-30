async function getUsuarioSegunEmail(valorEmail) {
   //traer desde base de datos
}

function logearUsuarioConNombre() {
   //va la sesion

}

function cargarDatosRegistro() {
    let nombre = document.getElementById("registroNombre");
    let apellido = document.getElementById("registroApellido");
    let email = document.getElementById("registroEmail");
    let password1 = document.getElementById("registroPwd");
    let passwordConfirm = document.getElementById("registroPwdConfirm");

   
}

function msgErrorLogin_mostrar() {
    let msg = document.getElementById("msgErrorLogin");
    msg.style.display = "block";
}

function msgErrorLogin_ocultar() {
    let msg = document.getElementById("msgErrorLogin");
    msg.style.display = "none";
}

function email_esValido(input, feedback) {
    let estadoValidacion = input.validity;
    if(estadoValidacion.valueMissing) {
        feedback.textContent = "Este campo es obligatorio";
    } else if(estadoValidacion.typeMismatch) {
        feedback.textContent = "Ingrese un email válido";
    } else {
        input.classList.remove('is-invalid');
        return true;
    }
    input.classList.add('is-invalid');
    return false;
}

function pwd_esValida(input, feedback) {
    let estadoValidacion = input.validity;
    if(estadoValidacion.valueMissing) {
        feedback.textContent = "Este campo es obligatorio";
    } else if (estadoValidacion.tooShort || estadoValidacion.patternMismatch) {
        feedback.textContent = "La contraseña debe tener un mínimo de 8 caracteres y algún caracter numérico";
    } else {
        input.classList.remove('is-invalid');
        return true;
    }
    input.classList.add('is-invalid');
    return false;
}

function nombreApellido_esValido(input, feedback) {
    let control = input.validity;
    if(control.valueMissing) {
        feedback.textContent = "Este campo es obligatorio";
    } else if(control.patternMismatch) {
        feedback.textContent = "El campo no debe contener números o caracteres especiales";
    } else {
        input.classList.remove('is-invalid');
        return true;
    }
    input.classList.add('is-invalid');
    return false;
}

function pwd_coinciden(input, inputConfirm, feedback) {
    let control = inputConfirm.validity;
    if(control.valueMissing) {
        feedback.textContent = "Este campo es obligatorio";
    } else if(input.value != inputConfirm.value) {
        feedback.textContent = "Las contraseñas no coinciden";
    } else {
        inputConfirm.classList.remove('is-invalid');
        return true;
    }
    inputConfirm.classList.add('is-invalid');
    return false;
}

async function email_yaExiste(input, feedback) {
   //llamar a bd para validar
    let hayCoincidencia = false;

    for(let i = 0; i < datosUsuarios.length; i++) {
        if(input.value == datosUsuarios[i].Email) {
            hayCoincidencia = true;
            break;
        }
    }
    if(hayCoincidencia) {
        feedback.textContent = "Esta dirección de correo electrónico ya pertenece a un usuario";
        input.classList.add('is-invalid');
        return true;
    } else {
        input.classList.remove('is-invalid');
        return false;
    }
}

async function login_CoincideConUsuario(inputEmail, inputPwd) {
    //conectar con bd
    let hayCoincidencia = false;

    for(let i = 0; i < datosUsuarios.length; i++) {
        if(inputEmail.value == datosUsuarios[i].Email &&
           inputPwd.value == datosUsuarios[i].Contraseña) {
            hayCoincidencia = true;
            break;
        }
    }
    if(hayCoincidencia) {
        msgErrorLogin_ocultar();
        return true;
    } else {
        msgErrorLogin_mostrar();
        return false;
    }
}

function validarLogin() {
    let email = document.getElementById("loginEmail");
    let pwd = document.getElementById("loginPwd");
    let pwdFeedback = document.getElementById("loginPwdFeedback");
    let emailFeedback = document.getElementById("loginEmailFeedback");

    if(email_esValido(email, emailFeedback) & pwd_esValida(pwd, pwdFeedback)) {
        return true;
    }
    else {
        return false;
    }
}

function validarRegistro() {
    let nombre = document.getElementById("registroNombre");
    let nombreFeedback = document.getElementById("regNombreFeedback");
    let apellido = document.getElementById("registroApellido");
    let apellidoFeedback = document.getElementById("regApellidoFeedback");
    let email = document.getElementById("registroEmail");
    let emailFeedback = document.getElementById("regEmailFeedback");
    let pwd = document.getElementById("registroPwd");
    let pwdFeedback = document.getElementById("regPwdFeedback");
    let pwdConfirm = document.getElementById("registroPwdConfirm");
    let pwdConfirmFeedback = document.getElementById("regPwdConfirmFeedback");

    if(nombreApellido_esValido(nombre, nombreFeedback) &
       nombreApellido_esValido(apellido, apellidoFeedback) &
       email_esValido(email, emailFeedback) &
       pwd_esValida(pwd, pwdFeedback) &
       pwd_coinciden(pwd, pwdConfirm, pwdConfirmFeedback)) {
        return true;
    } else {
        return false;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    let btnEnviarRegistro = document.getElementById("btnEnviarRegistro");
    let btnEnviarLogin = document.getElementById("btnEnviarLogin");
    let login = document.getElementById("formLogin");
    let reg = document.getElementById("formRegistro");
    const modalLogin = new bootstrap.Modal('#loginModal');
    const modalReg = new bootstrap.Modal('#registroModal');
    

    if(sessionStorage.getItem("Logeado")) {
        logearUsuarioConNombre();
    }
    login.addEventListener("submit", function(event){
        event.preventDefault();
    });

    reg.addEventListener("submit", function(event){
        event.preventDefault();
    });

    btnEnviarLogin.addEventListener("click", async function(){
        if(validarLogin()) {
            let email = document.getElementById("loginEmail");
            let pwd = document.getElementById("loginPwd");

            let usuarioCorrecto = await login_CoincideConUsuario(email, pwd);

            if(usuarioCorrecto) {
                //llamar a base de datos
            }
        }
    });

    btnEnviarRegistro.addEventListener("click", async function(){
        if(validarRegistro()){
            emailUsuario = document.getElementById("registroEmail");
            emailFeedback = document.getElementById("regEmailFeedback");
            let emailExiste = await email_yaExiste(emailUsuario, emailFeedback);
            if(!emailExiste) {
                let nombre = document.getElementById("registroNombre");
                let apellido = document.getElementById("registroApellido");
                let email = document.getElementById("registroEmail");
                //guardarlo en la base de datos
            }
        }
    });
});
