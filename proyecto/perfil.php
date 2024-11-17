<?php
include 'loginRegistro.php';

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
} else {
    extract($_POST);
    $error = 0;
    $us = $_SESSION["usuario"];
    $info = $gestor->tiene_maximo_vehiculos_para_Ingresar($us);
    $idLocalidad = $usuario['idLocalidad']; // Supongamos que este dato ya está disponible
    $localidadCompleta = $gestor->fetch_provinciaYLocalidad_por_idLocalidad($idLocalidad);
    if (isset($_POST['BtnImagen2'])) {
        // Llamar a la función insertarImagen para subir la imagen y obtener la ruta
        $rutaImagen = $gestor->insertarImagen();
    
        // Llamar a la función guardarImagenUsuario para actualizar la ruta de imagen en la base de datos
        $gestor->guardarImagenUsuario($us, $rutaImagen);
    
        echo "<script>alert('Imagen de perfil actualizada correctamente');</script>";
    }


    $usuario = $gestor->fetch_usuario_por_id($us);

    if ($info == true) {
        $errorm = "tienes el maximo de vehiculos permitidos";
        $error = 1;
    }else{
        if (isset($enviarVehiculo)) {
            $_SESSION['patente'] = $patente;
            $_SESSION['modelo'] = $modelo;
            $_SESSION['categoria'] = $categoria;
            //Redirige a insertar_postulante.php
            header("Location: insertarVehiculo.php");
            exit();
        }
    }

    
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Perfil Usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="estilos.css" />
        <link rel="stylesheet" href="estilosPerfil.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="header">
            <div class="header__left">
                <a href="index.php">
                    <img src="LogoVeryDeli.svg" alt="Logo" class="logo">
                </a>
                <div class="header__input" id="header_busqueda">
                    <span class="material-icons"> search </span>
                    <input type="text" placeholder="Buscar publicaciones" id="barraBusqueda" />
                </div>
            </div>

            <div class="header__middle" id="header_medio">
                <div class="header__option">
                    <a href="index.php"><span class="material-icons"> home </span></a>
                </div>
                <div href="buscador.php" class="header__option">
                    <a href="buscador.php"><span class="material-icons"> storefront </span></a>
                </div>
                <div class="header__option active">
                    <a href="perfil.php"><span class="material-icons"> account_circle </span></a>
                </div>
            </div>

            <div class="header__right">
                <div class="header__info">
                    <?php if (isset($_SESSION["usuario"])) { ?>
                        <form action="cerrarSesion.php" method="post">
                            <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
                        </form>
                    <?php } else { ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
                    <?php } ?>
                </div>
            </div>

            <div class="header__responsive">
                <?php if (isset($_SESSION["usuario"])) { ?>
                    <a href="index.php" class="header__option">
                        <span class="material-icons"> home </span>
                        <span>Inicio</span>
                    </a>
                    <a href="buscador.php" class="header__option">
                        <span class="material-icons"> search </span>
                        <span>Buscar Pedidos</span>
                    </a>
                    <a href="perfil.php?tab=calificaciones" class="header__option">
                        <span class="material-icons"> star </span>
                        <span>Calificaciones</span>
                    </a>
                    <a href="perfil.php?tab=publicaciones" class="header__option">
                        <span class="material-icons"> person </span>
                        <span>Perfil</span>
                    </a>
                <?php } else { ?>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
                <?php } ?>
            </div>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-sm-4" style="margin-top: 50px;">
                    <div class="text-center">
                        <?php if (!isset($usuario['imagen'])) { ?>
                            <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar rounded-circle img-fluid border"
                                alt="avatar">
                        <?php } else { ?>
                            <img src="imagenes/<?= $usuario["imagen"] ?>" alt="avatar" class="avatar rounded-circle img-fluid border">
                        <?php } ?>
                        <h3><?= ucfirst($usuario["nombre"]) . " " . ucfirst($usuario["apellido"]) ?></h3>
                        <div class="form-group">
                        <form action="perfil.php" method="POST" enctype="multipart/form-data">
                        <label for="UserImagen">Inserte la foto(opcional):</label>
                        <input type="file" class="form-control" name="UserImagen" id="UserImagen" required>
                        <input type="submit" class="form-control" name="BtnImagen2" id="BtnImagen2" value="Cambiar foto de perfil">
                        </form>
            
              <div class="invalid-feedback" name="pubArchivoFeedback" id="pubArchivoFeedback"></div>
            </div>
                    </div>
                    </hr><br>



                    <ul class="list-group">
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong>Calificación:</strong>
                            </span>
                            <?= $gestor->fetch_promedio_calificaciones_por_usuario($usuario["idUsuario"]) ?>
                            <span class="text-muted"> - Total: <?= $gestor->fetch_num_calificaciones_por_usuario($usuario["idUsuario"]) ?></span>
                        </li>
                        <?php if ($gestor->fetch_usuario_es_responsable($usuario["idUsuario"])) { ?>
                            <li class="list-group-item text-right">
                                <span class="pull-left">
                                    <strong class="text-success">Usuario Responsable</strong>
                                </span>
                                <span class="material-icons text-success"> check_circle </span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col-sm-8" style="margin-top: 50px;">
                    <ul class="nav nav-tabs" id="secciones" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="postulaciones-tab" data-bs-toggle="tab" href="#postulaciones" role="tab" aria-controls="postulaciones" aria-selected="true">Postulaciones </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="publicaciones-tab" data-bs-toggle="tab" href="#publicaciones" role="tab" aria-controls="profile" aria-selected="false">Mis Publicaciones (<?= $gestor->fetch_num_publicaciones_activas_por_usuario($usuario["idUsuario"]) ?>)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="personal-tab" data-bs-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">Datos Personales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="calificaciones-tab" data-bs-toggle="tab" href="#calificaciones" role="tab" aria-controls="calificaciones" aria-selected="false">Calificaciones</a>
                        </li>
                    </ul>


                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="postulaciones" role="tabpanel" aria-labelledby="postulaciones-tab">
                            <?php $postulaciones = $gestor->fetch_postulaciones_por_usuario($usuario["idUsuario"]);
                            foreach ($postulaciones as $p) {
                                $publicacion = $gestor->fetch_publicacion($p['idPublicacion']);
                            ?>
                          <a href="irPublicacion.php?idPublicacion=<?= $publicacion['idPublicacion'] ?>"class="text-decoration-none">
                                
                                <div class="card border-secondary">
                                    <div class="card-body card-publicacion">
                                        <h5 class="card-title">Postulación a "<?= $publicacion["titulo"] ?>"</h5>
                                        <?php if ($publicacion["postulanteElegido"] == $usuario["idUsuario"]) { ?>
                                            <h6 class="card-subtitle mb-2 text-secondary">
                                                <?= ($publicacion["estado"] == 2) ? "Entrega finalizada" : "Entrega pendiente" ?>
                                            </h6>
                                        <?php } else if ($publicacion["postulanteElegido"] == 0) { ?>
                                            <h6 class="card-subtitle mb-2 text-muted">Elección pendiente</h6>
                                        <?php } else { ?>
                                            <h6 class="card-subtitle mb-2 text-muted">No elegido</h6>
                                        <?php } ?>


                                        <h6 class="card-subtitle mb-2 text-muted">Origen: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadOrigen"]) ?></h6>
                                        <h6 class="card-subtitle mb-2 text-muted">Destino: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadDestino"]) ?></h6>
                                        <h5 class="card-subtitle"><strong>Monto: <?= $p["monto"] ?></strong></h5>
                                    </div>
                                </div>
                                        </a>
                            <?php } ?>

                        </div>
                        <div class="tab-pane fade" id="publicaciones" role="tabpanel" aria-labelledby="publicaciones-tab">
                            <?php $publicaciones = $gestor->fetch_publicaciones_por_usuario($usuario["idUsuario"]);
                            foreach ($publicaciones as $pub) {
                                if ($pub["estado"] != 2) { ?>
                                    <a href="irPublicacion.php?idPublicacion=<?= $pub['idPublicacion'] ?>" class="text-decoration-none">
                                        <div class="card border-success">
                                            <div class="card-body card-publicacion">
                                                <h5 class="card-title"><?= htmlspecialchars($pub["titulo"]) ?></h5>
                                                <h6 class="card-subtitle mb-2 text-success">
                                                    <?= ($pub["estado"] == 0) ? "Disponible" : "En espera" ?>
                                                </h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Origen: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($pub["localidadOrigen"]) ?></h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Destino: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($pub["localidadDestino"]) ?></h6>
                                                <p class="card-text">Descripción: <?= htmlspecialchars($pub["descripcion"]); ?></p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } else { ?>
                                    <a href="irPublicacion.php?idPublicacion=<?php echo $pub['idPublicacion'] ?>" class="text-decoration-none">
                                        <div class="card border-muted">
                                            <div class="card-body card-publicacion">
                                                <h5 class="card-title"><?= htmlspecialchars($pub["titulo"]) ?></h5>
                                                <h6 class="card-subtitle mb-2 text-muted">Finalizada</h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Origen: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($pub["localidadOrigen"]) ?></h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Destino: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($pub["localidadDestino"]) ?></h6>
                                                <p class="card-text">Descripción: <?= htmlspecialchars($pub["descripcion"]) ?></p>
                                            </div>
                                        </div>
                                    </a>
                            <?php }
                            }
                            ?>


                        </div>
                        <!-- MODELO PARA VISTA DE AUTO-->
                        <div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroVehiculo">
                             Registrar Vehiculo
                            </button>
                            <?php
$vehiculos = $gestor->obtener_vehiculos_por_usuario($us);
?>
                            <?php foreach ($vehiculos as $vehiculo): ?>
        <div class="card border-success" style="margin-top: 15px;">
            <img class="card-img-top" src="imagenes/publicacionDefault.jpg" alt="Imagen de vehículo">
            <div class="card-body">
                <h5 class="card-title">Modelo: <?= htmlspecialchars($vehiculo['modelo']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Nro Patente: <?= htmlspecialchars($vehiculo['patente']) ?></h6>
                <p class="card-text">Categoría: <?= htmlspecialchars($vehiculo['categoria']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
                             <!-- FIN MODELO PARA VISTA DE AUTO-->
                            <form class="form" action="##" method="post" id="registrationForm">
                            <div class="form-group">
        <div class="col-xs-6">
            <label for="nombre">
                <h4>Nombre</h4>
            </label>
            <input type="text" class="form-control" name="nombre" id="nombre" 
                   placeholder="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>"readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <label for="apellidos">
                <h4>Apellido</h4>
            </label>
            <input type="text" class="form-control" name="apellidos" id="apellidos" 
                   placeholder="apellidos" value="<?= htmlspecialchars($usuario['apellido']) ?>"readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <label for="dni">
                <h4>DNI</h4>
            </label>
            <input type="text" class="form-control" name="dni" id="dni" 
                   placeholder="46260606" value="<?= htmlspecialchars($usuario['dni']) ?>"readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <label for="localidad">
                <h4>Localidad</h4>
            </label>
            <input type="text" class="form-control" name="localidad" id="localidad" 
                   placeholder="introduce tu localidad"  value="<?= htmlspecialchars($localidadCompleta) ?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <label for="domicilio">
                <h4>Domicilio</h4>
            </label>
            <input type="text" class="form-control" name="domicilio" id="domicilio" 
                   placeholder="domicilio" value="<?= htmlspecialchars($usuario['domicilio']) ?>"readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <label for="email">
                <h4>Email</h4>
            </label>
            <input type="email" class="form-control" name="email" id="email" 
                   placeholder="you@email.com" value="<?= htmlspecialchars($usuario['email']) ?>"readonly>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-6">
            <label for="password">
                <h4>Contraseña</h4>
            </label>
            <input type="password" class="form-control" name="password" id="password" 
                   placeholder="contraseña" value="<?= htmlspecialchars($usuario['contraseña']) ?>"readonly>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-xs-12">
            <br>
            <input type="button" class="btn btn-primary" value = "Actualizar Datos" name = "btnActualizar"  data-bs-toggle="modal" data-bs-target="#actualizarModal">
        </div>
    </div>
                            </form>

                            <hr>

                        </div>
                        <div class="tab-pane fade" id="publicaciones" role="tabpanel" aria-labelledby="publicaciones-tab">
                            <?php $publicaciones = $gestor->fetch_publicaciones_por_usuario($usuario["idUsuario"]);
                            foreach ($publicaciones as $pub) {
                                if ($pub["estado"] != 2) { ?>
                                    <a href="#">
                                        <div class="card border-success">
                                            <div class="card-body card-publicacion">
                                                <h5 class="card-title"><?= $pub["titulo"] ?></h5>
                                                <h6 class="card-subtitle mb-2 text-success">
                                                    <?= ($pub["estado"] == 0) ? "Disponible" : "En espera" ?>
                                                </h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Origen: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadOrigen"]) ?></h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Destino: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadDestino"]) ?></h6>
                                                <p class="card-text">Descripción: <?= $pub["descripcion"] ?></p>
                                            </div>
                                        </div>
                                    </a>
                                <?php } else { ?>
                                    <a href="#">
                                        <div class="card border-muted">
                                            <div class="card-body card-publicacion">
                                                <h5 class="card-title"><?= $pub["titulo"] ?></h5>
                                                <h6 class="card-subtitle mb-2 text-muted">Finalizada</h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Origen: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadOrigen"]) ?></h6>
                                                <h6 class="card-subtitle mb-2 text-muted">Destino: <?= $gestor->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadDestino"]) ?></h6>
                                                <p class="card-text">Descripción: <?= $pub["descripcion"] ?></p>
                                            </div>
                                        </div>
                                    </a>
                            <?php }
                            }
                            ?>


                        </div>
                        

                      
                    <div class="tab-pane fade" id="calificaciones" role="tabpanel" aria-labelledby="calificaciones-tab">
                        <?php $calificaciones = $gestor->fetch_calificaciones_hechas_por_usuario($usuario["idUsuario"]);
                        foreach ($calificaciones as $c) {
                            $calificado = $gestor->fetch_nombre_usuario_por_id($c["idCalificado"]);
                        ?>

                            <div class="card border-success">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $calificado["apellido"] . " " . $calificado["nombre"] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Fecha: <?= $c["fecha"] ?></h6>
                                    <form id="form-calificacion" method="post" action="#">
                                        <fieldset class="calificacion-container">
                                            <h5 id="valor-calificacion" class="card-subtitle"></h5>
                                            <input type="radio" name="calificacion" id="star5" value="5" required >
                                            <label for="star5"><span class="material-icons"> star </span></label>
                                            <input type="radio" name="calificacion" id="star4" value="4">
                                            <label for="star4"><span class="material-icons"> star </span></label>
                                            <input type="radio" name="calificacion" id="star3" value="3">
                                            <label for="star3"><span class="material-icons"> star </span></label>
                                            <input type="radio" name="calificacion" id="star2" value="2">
                                            <label for="star2"><span class="material-icons"> star </span></label>
                                            <input type="radio" name="calificacion" id="star1" value="1">
                                            <label for="star1"><span class="material-icons"> star </span></label>
                                        </fieldset>

                                        <label for="opinion">opinion</label>
                                        <input type="text" name="opinion" id="opinion">
                                        <input type="submit" name="enviarCalificaion" value="Calificar">
                                    </form>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>

            </div>
        </div>

        <!-- Modal VEHICULO -->
<div class="modal fade" id="registroVehiculo" tabindex="-1" aria-labelledby="registroVehiculoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="registroVehiculoLabel">Registar Vehiculo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="perfil.php">
                    <label for="patente" class="form-label">patente:</label>
                     <input type="text" name ="patente" id="patente" class="form-control" placeholder="escribe la patente SIN ESPACIOS (LLLNNN O LLNNLL)"  pattern="^[A-Za-z]{2}[0-9]{3}[A-Z]{2}$|^[A-Z]{3}[0-9]{3}$" 
           title="Debe ser LLLNNN o LLNNNLL" 
           maxlength="7"  required>
                    <label for="modelo" class="form-label">modelo(marca):</label>
                  <input type="text" name="modelo" id="modelo" class="form-control" placeholder="escribe el modelo Y la marca del auto " pattern="^[A-Za-z0-9 ]{5,30}$" 
                  title="Debe contener entre 5 y 30 caracteres, solo letras, números y espacios"  maxlength="30" required>
                  <label for="categoria" class="form-label">Clasificacion:</label>
                  <select name="categoria" name = "categoria"id="categoria" class="form-select" title = "debe elegir una opcion" required>
                  <option value="" selected>Seleccione una opcion</option>
                        <option value="liviano">liviano(auto)</option>
                         <option value="mediano">mediano(utilitario/camioneta)</option>
                         <option value="pesado">pesado(camion)</option>
                 </select>
         <?php if ($error != 0): ?>
    <p style = "color:red"><?= $errorm ?></p>
    <input type='submit' class='btn btn-primary' name='enviarVehiculo' disabled value='Inscribir Vehiculo' 
    style = "background-color: #52b04c;
    color: #eff2f5; border: 1px solid #eff2f5;">
<?php else: ?>
    <input type='submit' class='btn btn-primary' name='enviarVehiculo' value='Inscribir Vehiculo'>
<?php endif; ?>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
         </form>
      </div>
      <div class="modal-footer">
     
      </div>
    </div>
  </div>
</div>

        <script type="text/javascript">
            $(document).ready(function() {
                var readURL = function(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('.avatar').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $(".file-upload").on('change', function() {
                    readURL(this);
                });
            });
        </script>
        </div>
        <?php
        include 'modalLoginRegistro.php';
        include 'modalActualizarDatos.php';
        include 'validarRegistro.php';
        include 'validarActualizacion.php';
        ?>
        </div>
        </div>
        </div>


        <script>
            window.onload = function() {
                // Obtiene el valor del parámetro 'tab' en la URL
                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab');

                // Si existe el parámetro 'tab' y corresponde a 'publicaciones', activa la tab
                if (tab === 'publicaciones') {
                    const publicacionesTab = new bootstrap.Tab(document.getElementById('publicaciones-tab'));
                    publicacionesTab.show(); // Activa la tab 'publicaciones'
                } else if (tab === 'calificaciones') {
                    const calificacionesTab = new bootstrap.Tab(document.getElementById('calificaciones-tab'));
                    calificacionesTab.show(); // Activa la tab 'publicaciones'
                }
            };
        </script>
        
        <!-- Script para manejar las calificaciones -->
        <script>
            let textoCalificacion = document.getElementById("valor-calificacion");
            let radiosCalif = document.querySelectorAll('input[name="calificacion"]');
            let form = document.getElementById("form-calificacion");

            radiosCalif.forEach(radio => {
                radio.addEventListener("change", function() {
                    textoCalificacion.classList.remove('text-error');
                    textoCalificacion.textContent = this.value + '.0';
                });
            });
        </script>
    </body>
<?php  ?>

    </html>