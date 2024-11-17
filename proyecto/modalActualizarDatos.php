<!-- MODAL ACTUALIZAR -->
<div class="modal fade" id="actualizarModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Actualizar Datos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formActualizar" method="POST" action="actualizar_usuario.php" novalidate>                    
                    <div class="form-group">
                        <label for="actualizarProvincia">Provincia de residencia: </label>
                        <select class="form-select" aria-label="actualizarProvincia" name="actualizarProvincia" id="actualizarProvincia" required>
                            <option value="">Selecciona la provincia</option>
                            <?php
                            $provincias = $gestor->fetch_provincias();

                            foreach($provincias as $row) { ?>
                            <option value= '<?= $row['idProvincia'] ?>'> <?= $row['nombre'] ?> </option>
                            <?php } ?>
                        </select>

                        <div class="invalid-feedback" id="regProvincia"></div>
                    </div>
                    <div class="form-group">
                        <label for="actualizarLocalidad">Localidad de residencia: </label>
                        <select class="form-select" aria-label="actualizarLocalidad" name="actualizarLocalidad" id="actualizarLocalidad" required title="debe seleccionar una opción válida">
                            <option value="">Selecciona la localidad</option>
                        </select>

                        <div class="invalid-feedback" id="regLocalidad"></div>
                    </div>
                    <div class="form-group">
                        <label for="actualizarDomicilio">Domicilio:</label>
                        <input type="text" class="form-control" name="actualizarDomicilio" id="actualizarDomicilio" pattern="^[a-zA-Z0-9\s]{5,}$" title="Su domicilio debe tener letras y números, mínimo 5 caracteres" required>
                        <div class="invalid-feedback" id="domicilioFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="actualizarPwd">Contraseña:</label>
                        <input type="password" class="form-control" name="actualizarPwd" id="actualizarPwd" required
                            minlength="8">
                        <div class="invalid-feedback" id="actPwdFeedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="actualizarPwdConfirm">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="actualizarPwdConfirm" name="actualizarPwdConfirm"
                            required>
                        <div class="invalid-feedback" id="actPwdConfirmFeedback"></div>
                    </div>
                    <div class="invalid-feedback d-block" id="msgErrorRegistro">
                        <?php if(isset($errorLogin)) {
                            echo $errorLogin;
                        } ?>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="btnEnviarActualizar" id="btnEnviarActualizarphp" class="btn btn-primary" value="Actualizar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>