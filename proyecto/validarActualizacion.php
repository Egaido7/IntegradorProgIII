<script>

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



function validarActualizar() {
    let passwordValida = validarCampo(document.getElementById('actualizarPwd'), "Contraseña mínima de 8 caracteres", /^.{8,}$/);
    let pwdConfirm = document.getElementById('actualizarPwdConfirm');
    let passwordConfirmValida = pwdConfirm.value === document.getElementById('actualizarPwd').value;
    let domicilio = validarCampo(document.getElementById('actualizarDomicilio'),"domicilio minimo 5 caracteres",/^.{5,}$/);

    if (!passwordConfirmValida) {
        mostrarMensajeError(pwdConfirm, "Las contraseñas no coinciden");
    } else {
        limpiarMensajeError(pwdConfirm);
    }

    return passwordValida && passwordConfirmValida && domicilio;
}

document.addEventListener("DOMContentLoaded", function () {
    // Configuración de localidades
    const selectProvincia = document.getElementById("actualizarProvincia");
    const selectLocalidad = document.getElementById("actualizarLocalidad");

    selectProvincia.addEventListener("change", function() {
        const idProvincia = selectProvincia.value;

        // Limpia y establece la opción predeterminada
        selectLocalidad.innerHTML = '<option value="" selected disabled>Selecciona la localidad</option>';

        if (idProvincia) {
            fetch(`getLocalidades.php?idProvincia=${idProvincia}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(localidad => {
                const option = document.createElement("option");
                option.value = localidad.idLocalidad;
                option.textContent = localidad.Nombrelocalidad;
                selectLocalidad.appendChild(option);
                });
            })
            .catch(error => console.error("Error al cargar localidades:", error));
        }
    });


    document.getElementById("formActualizar").addEventListener("submit", function (event) {
        if (!validarActualizar()) {
            console.log("no se envia");
            event.preventDefault(); // Prevenir el envío si hay errores de validación
        } else {
            var mostrarLogin = <?php echo json_encode($mostrarLogin); ?>;
            if (mostrarLogin) {
                var loginModal = new bootstrap.Modal(document.getElementById('formActualizar'));
                loginModal.show();
            }
        }
    });
});
</script>




