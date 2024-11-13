<!-- MODAL Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Iniciar Sesión</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formLogin" method="POST" action="" novalidate>
                    <div class="form-group">
                        <label for="loginEmail">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail" required>
                        <div class="invalid-feedback" id="loginEmailFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="loginPwd">Contraseña:</label>
                        <input type="password" class="form-control" name="loginPwd" id="loginPwd" required
                            minlength="8">
                        <div class="invalid-feedback" id="loginPwdFeedback"></div>
                    </div>
                    <div class="invalid-feedback d-block" id="msgErrorLogin">
                        <?php if(isset($errorLogin)) {
                            echo $errorLogin;
                        } ?>    
                    </div>
                    <div class="modal-footer"> 
                        <input type="submit" id="btnEnviarLogin" name="btnEnviarLoginphp" class="btn btn-primary" value="Iniciar Sesión">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal"
                            data-bs-target="#registroModal">Crear nueva cuenta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL Registro -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Crear nueva cuenta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRegistro" method="POST" action="" novalidate>
                    <div class="form-group">
                        <label for="registroNombre">Nombre:</label>
                        <input type="text" class="form-control" id="registroNombre" name="registroNombre" required
                            pattern="[a-zA-Z]{2,}">
                        <div class="invalid-feedback" id="regNombreFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="registroApellido">Apellido:</label>
                        <input type="text" class="form-control" id="registroApellido" name="registroApellido" required
                            pattern="[a-zA-Z]{2,}">
                        <div class="invalid-feedback" id="regApellidoFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="registroDni">DNI:</label>
                        <input type="text" class="form-control" id="registroDni" name="registroDni" required
       pattern="^[0-9]{8}$" maxlength="8" title="El DNI debe tener exactamente 8 dígitos" />


                        <div class="invalid-feedback" id="regDniFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="registroEmail">Correo Electrónico:</label>
                        <input type="email" class="form-control" name="registroEmail" id="registroEmail" required>
                        <div class="invalid-feedback" id="regEmailFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="registroPwd">Contraseña:</label>
                        <input type="password" class="form-control" name="registroPwd" id="registroPwd" required
                            minlength="8">
                        <div class="invalid-feedback" id="regPwdFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="registroPwdConfirm">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="registroPwdConfirm" name="registroPwdConfirm"
                            required>
                        <div class="invalid-feedback" id="regPwdConfirmFeedback"></div>
                    </div>
                    <div class="invalid-feedback d-block" id="msgErrorRegistro">
                        <?php if(isset($errorLogin)) {
                            echo $errorLogin;
                        } ?>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="btnEnviarRegistro" id="btnEnviarRegistrophp" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>