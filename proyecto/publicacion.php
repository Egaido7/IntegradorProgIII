<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="estilos.css" />
        <link rel="stylesheet" href="estiloComentario.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
  <?php
  session_start();
  extract($_POST);

  require 'base de datos\gestorbd.php';
  $publicacionControl = new GestorVeryDeli();
  $idPublicacion = $_SESSION["publicacion"];
  $publicacion = $publicacionControl->fetch_publicacion($idPublicacion);
  $postulantes = $publicacionControl->fetch_postulaciones_por_publicacion($publicacion['idPublicacion']);
  $comentarios = $publicacionControl->fetch_mensajes_por_publicacion($publicacion['idPublicacion']);
  $fechap = date('Y-m-d');
  $id = $publicacion['idPublicacion'];
  date_default_timezone_set('America/Argentina/San_Luis');
  if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
  }
  if (!isset($_SESSION['usuario'])) {
    $tipo = 0;
    //cambiar el 1 por session de la id de usuario
  } elseif ($usuario == $publicacion['idUsuario']) {
    $tipo = 1;
  } elseif ($publicacion['postulanteElegido'] == $usuario) {
    $tipo = 2;
  } elseif ($publicacionControl->es_postulante($usuario, $publicacion['idPublicacion'])) {
    $tipo = 3;
  } else {
    $tipo = 4;
  }
  $control = 0;
  $error = 0;
  $er = 0;
  $aviso = "si";

  // control al postularse
  if (isset($btnpostularse)) {
    $vehiculo = $publicacionControl->tiene_vehiculo_por_usuario($usuario);
    $publicacionE = $publicacionControl->fetch_publicacion($publicacion['idPublicacion']);
    $error = 0;

    if (empty($monto)) {
      $errorm = "Ingrese monto";
      $error = 1;
    } elseif (!$vehiculo) {
      $errorm = "Debes tener al menos un vehículo registrado para poder postularse";
      $error = 1;
    } elseif ($publicacionE['estado'] != 0) {
      $errorm = "La publicación ya tiene un postulante elegido";
      $error = 1;
    } elseif (!$publicacionControl->usuario_puede_postularse($usuario)) {
      $errorm = "Debe tener el estado responsable para poder postularse a más de una publicación";
      $error = 1;
    } else {
      // No hay errores; redirigir a insertar_postulante.php

      //  Usar sesión para pasar los datos
      $_SESSION['monto'] = floatval($monto);
      $_SESSION['usuario_id'] = $usuario;  // Cambiar 2 por el ID de usuario real
      $_SESSION['publicacion_id'] = $publicacion['idPublicacion']; // Cambiar 4 por el ID de publicación real
      $_SESSION['estado'] = 0;

      // Redirige a insertar_postulante.php
      header("Location: insertar_postulante.php");
      exit();
    }
  }

  if (isset($enviarCalificaion)) {
    $fechaComentario = date('Y-m-d');
    if ($usuario == $publicacion['idUsuario']) {
      $calificado = $publicacion['postulanteElegido'];
    } else {
      $calificado = $publicacion['idUsuario'];
    }
    $calificacion = intval($calificacion);

    $publicacionControl->insertar_calificacion($usuario, $calificacion, $opinion, $calificado, $publicacion['idPublicacion'], $fechaComentario);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional  
  }

  if (isset($comentarioBtn)) {

    // Obtener la fecha y hora actual
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $publicacionControl->insertar_mensaje($usuario, $publicacion['idPublicacion'], $mensajeA, $fecha, $hora);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional    
  }

  if (isset($finalizado)) {
    $fecha = date('Y-m-d');
    $publicacionControl->actualizar_publicacionFinalizada($publicacion['idPublicacion'], $fecha);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional  
  }
  if (isset($btnElegir)) {

    $publicacionControl->actualizar_postulanteElegido($publicacion['idPublicacion'], $idElegido);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional    
  }

  if (isset($finalizado)) {
    $fecha = date('Y-m-d');
    $publicacionControl->actualizar_publicacionFinalizada($publicacion['id'], $fecha);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional  
  }
  if ($publicacion['estado'] == 2) {
    $fecha7 = date('Y-m-d', strtotime($publicacion['fechaPublicacion'] . '+ 7 days'));
  }
  if (isset($fecha7)) {
    if ($fechap > $fecha7) {
      if ($publicacionControl->publicacion_calificada($publicacion['idPublicacion']) == 0) {
        $usuario1 = $publicacionControl->fetch_calificaciones_por_publicacion($publicacion['idUsuario'], $publicacion['idPublicacion']);
        $usuario2 = $publicacionControl->fetch_calificaciones_por_publicacion($publicacion['postulanteElegido'], $publicacion['idPublicacion']);
        if (empty($usuario1)) {
          $publicacionControl->insertar_calificacion($publicacion['idUsuario'], -1, "no califico en mas de una semana", $publicacion['idUsuario'], $publicacion['idPublicacion'], $fechap);
        }
        if (empty($usuario2)) {
          $publicacionControl->insertar_calificacion($publicacion['postulanteElegido'], -1, "no califico en mas de una semana", $publicacion['postulanteElegido'], $publicacion['idPublicacion'], $fechap);
        }
      }
    }
  }
  ?>

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
      <div href="buscador.php" class="header__option active">
        <a href="buscador.php"><span class="material-icons"> storefront </span></a>
      </div>
      <div class="header__option">
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


  <!--contenido del producto -->

  <div class="card d-flex flex-row flex-wrap container" style="width: 70%;">
    <img src="<?php echo $publicacion['imagenPublicacion'] ?>" class="card-img-top" alt="..." style="max-width: auto; height: 50%; flex: 1 1 auto;">
    <div class="card-body" style="flex: 1 1 300px; padding: 20px;">
      <class="card-title">
        <h1><?= $publicacion['titulo'] ?></h1>
        <p class="card-text">Origen: </p>
        <ul>
          <li><?= $publicacionControl->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadOrigen"]) ?></li>
          <?php if ($publicacion['estado'] != 0) { ?>
            <li><?= $publicacion['domicilioOrigen'] ?></li> 
          <?php } ?>
        </ul>

        <p class="card-text">Destino: </p>
        <ul>
          <li><?= $publicacionControl->fetch_provinciaYLocalidad_por_idLocalidad($publicacion["localidadDestino"]) ?></li>
          <?php if ($publicacion['estado'] != 0) { ?>
            <li><?= $publicacion['domicilioDestino'] ?></li> 
          <?php } ?>
        </ul> 
        <p class="card-text">Peso: <?php echo $publicacion['peso'] ?>kg</p>
        <p class="card-text">Volumen: <?php echo $publicacion['volumen'] ?></p>
        <p class="card-text"><?php echo $publicacion['descripcion'] ?></p>
        <?php if ($publicacion['estado'] != 0) {
          $usuario = $publicacionControl->fetch_usuario_por_id($publicacion['postulanteElegido']); ?>
          <p class="card-text"> Contacto:<?php echo $publicacion['contacto'] ?></p>
          <p class="card-text">Postulante Elegido:<?php echo $usuario['nombre'] . " " . $usuario['apellido'] ?></p>
          <p class="card-text"> nombre a recibir:<?php echo $publicacion['nombreRecibir'] ?></p>
        <?php }
        ?>

        <?php if ($tipo == 4 && $publicacion['estado'] == 0) { ?>
          <a href="#" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#postulacionModal">postularse</a>
        <?php
        }
        if ($tipo == 2 && $publicacion['estado'] == 1) { ?>
          <form action="publicacion.php" method="post">
            <div class="modal-footer ">
              <button class="btn btn-primary" type="submit" name="finalizado">envio finalizado</button>
            </div>
          </form>
        <?php }
        if ($tipo == 0) {
          echo "inicie sesion para poder postularte";
        }
        ?>
    </div>
  </div>
  <!-- MODAL -->
  <!-- MODAL Login -->
  <div class="modal fade" id="postulacionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabel">ingrese monto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formpostulacion" method="post" action="publicacion.php">
            <div class="form-group">
              <label for="monto">Monto:</label>
              <input type="number" class="form-control" id="monto" name="monto" required>
              <div class="invalid-feedback" id="loginPwdFeedback"></div>
            </div>
            <?php
            if ($error == 1) {
              echo $errorm;
            }

            ?>
            <div class="modal-footer">
              <input type="submit" id="btnpostularse" name="btnpostularse" class="btn btn-primary"></input>

            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <?php
  if ($tipo == 1 && $publicacion['estado'] != 1) {
  ?>
    <div class="container" style="padding-bottom: 80px; padding-top: 20px; width: 70%; margin-bottom: 20px; display: flex; flex-direction: column; justify-content: center; max-height: 80vh;">
      <h1>Postulantes</h1>
      <div class="scrollable-div" style="overflow-y: auto; border: 1px solid #757575; padding: 10px; border-radius: 8px; background-color: rgb(255, 255, 255); height: 100%;">
        <?php foreach ($postulantes as $postulacion) {
          $usuario = $publicacionControl->fetch_usuario_por_id($postulacion['idUsuario']); ?>
          <div class="postulante-row" style="display: flex; align-items: center; justify-content: space-between; padding: 10px; border-bottom: 1px solid #ccc;">

            <!-- Avatar del usuario -->
            <img class="user__avatar" src="imagenes/<?php echo $usuario['imagen'] ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">

            <!-- Nombre del usuario -->
            <div style="flex: 1;">
              <h4 style="margin: 0;"><?php echo $usuario['nombre'] . ' ' . $usuario['apellido'] ?></h4>
            </div>

            <!-- Monto -->
            <div style="flex-shrink: 0; padding-right: 20px; white-space: nowrap;"><?php echo $postulacion['monto'] ?>$</div>

            <!-- Botón de elegir -->
            <form action="publicacion.php" method="post" style="flex-shrink: 0;">
              <input type="hidden" name="idElegido" value="<?php echo $usuario['idUsuario'] ?>">
              <?php
              if ($publicacion['estado'] == 0) {
              ?>
                <button type="submit" id="btnElegir" name="btnElegir" class="btn btn-primary">Elegir</button>
              <?php
              }
              ?>
            </form>

          </div>
        <?php } ?>
      </div>
    </div>
  <?php
  }
  ?>

  <!--div del row-->
  </div>

  <!-- div final del scroll-->
  </div>


  <?php
  if ($tipo == 1 || $tipo == 2 || $tipo == 3) {
  ?>
    <div class="container" style="padding-left: 60px;">
      <h1>Comentarios</h1> <a href="http://creaticode.com"></a>
    </div>
    <div class="card d-flex container" style="padding-bottom: 80px; width: 70%; margin-bottom: 100px; display: flex; flex-direction: column; justify-content: center; height: 400px;border: 1px solid #757575; padding: 10px; border-radius: 8px; background-color: rgb(255, 255, 255);">

      <div class="scrollable-div" style="overflow-y: auto; height: 100%;">
        <div class="comments-container" style="padding-left:0;">


          <ul id="comments-list" class="comments-list">
            <?php foreach ($comentarios as $mensaje) {
              $usuario = $publicacionControl->fetch_usuario_por_id($mensaje['idUsuario']);
            ?>
              <li>
                <div class="comment-main-level" style="margin-top: 20px; margin-bottom: 10px; display: flex; align-items: flex-start;">
                  <!-- Avatar -->
                  <div class="comment-avatar" style="margin-right: 15px;">
                    <img src="imagenes/<?php echo $usuario['imagen'] ?>" alt="perfil" style="width: 50px; height: 50px; border-radius: 50%;">
                  </div>
                  <!-- Contenedor del Comentario -->
                  <div class="comment-box" style="flex: 1;">
                    <div class="comment-head" style="display: flex; justify-content: space-between; align-items: center;">
                      <h6 class="comment-name <?php if ($usuario['idUsuario'] == $publicacion['idUsuario']) {
                                                echo "by-author";
                                              } ?>" style="margin: 0;">
                        <a href="http://creaticode.com/blog"><?php echo $usuario['nombre'] ?></a>
                      </h6>
                      <span style="font-size: 0.9em; color: #999;"><?php echo $mensaje['fechaComentario'] . " " . $mensaje['hora'] ?></span>
                    </div>
                    <div class="comment-content" style="margin-top: 5px;">
                      <?php echo $mensaje['comentario'] ?>
                    </div>
                  </div>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="chat-form">

        </div>
      </div>
      <?php if ($publicacion['estado'] != 2) { ?>
        <form method="post" action="publicacion.php" class="chat-form">
          <label></label><br>
          <input type="text" id="mensajeA" name="mensajeA" style="width: 80%; height: 30px; " required>
          <input type="submit" name="comentarioBtn" value="enviar" style="width: 18%;">
        </form>
      <?php } ?>
    </div>

  <?php

  }
  ?>
  <!-- Contenedor Principal -->
  <?php if ($publicacion['estado'] == 2  and ($tipo == 1 or $tipo == 2)) { 
     $usuario2 = $publicacionControl->fetch_calificaciones_por_publicacion($publicacion['postulanteElegido'], $publicacion['idPublicacion']); 
     $usuario1 = $publicacionControl->fetch_calificaciones_por_publicacion($publicacion['idUsuario'], $publicacion['idPublicacion']);
    ?>

  <div class="container " style="padding-left: 50px;">
    <h1>Calificacion</h1>
  </div>
  <div class="card container" style="padding-bottom: 80px; padding-top: 20px; width: 70%; margin-bottom: 20px; max-height: 80vh;">
    
  <?php
  $estado = $publicacionControl->usuario_califico(7,$publicacion['idPublicacion']);
   if (!$estado) { ?>

      <div class="card border-success" style="height: 120%; width: 100%;">
    <div class="card-body">
        <form id="form-calificacion" method="post" action="#">
            <!-- Contenedor de calificación -->
            <fieldset class="calificacion-container">
                <h5 id="valor-calificacion" class="card-subtitle"></h5>
                
                <!-- Estrellas de calificación -->
                <input type="radio" name="calificacion" id="star5" value="5" required>
                <label for="star5" aria-label="5 estrellas">
                    <span class="material-icons"> star </span>
                </label>
                
                <input type="radio" name="calificacion" id="star4" value="4">
                <label for="star4" aria-label="4 estrellas">
                    <span class="material-icons"> star </span>
                </label>
                
                <input type="radio" name="calificacion" id="star3" value="3">
                <label for="star3" aria-label="3 estrellas">
                    <span class="material-icons"> star </span>
                </label>
                
                <input type="radio" name="calificacion" id="star2" value="2">
                <label for="star2" aria-label="2 estrellas">
                    <span class="material-icons"> star </span>
                </label>
                
                <input type="radio" name="calificacion" id="star1" value="1">
                <label for="star1" aria-label="1 estrella">
                    <span class="material-icons"> star </span>
                </label>
            </fieldset>

            <!-- Campo de opinión -->
            <div class="form-group">
                <label for="opinion">Opinión</label>
                <input type="text" name="opinion" id="opinion" class="form-control" placeholder="Escribe tu opinión" required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-success mt-3">Enviar Calificación</button>
        </form>
    </div>
</div>
        <?php  ?>
    </div>

    <?php
      } else {
        
      
       
 
 

if (is_null($usuario1) || is_null($usuario2)) {
    echo "<h3>Espere a que el otro usuario publique su calificación para poder ver la calificación.</h3>";
    if (is_null($usuario1)) {
        echo "Usuario 1 no tiene calificación.<br>";
    }
    if (is_null($usuario2)) {
        echo "Usuario 2 no tiene calificación.<br>";
    }
} else{
          $info1 = $publicacionControl->fetch_usuario_por_id($usuario1['idCalifica']);

          $info2 = $publicacionControl->fetch_usuario_por_id($usuario2['idCalifica']);
    ?>

      <div class="container" style="padding-bottom: 80px; padding-top: 20px; width: 100%; margin-bottom: 20px; display: flex; flex-direction: column; justify-content: center; max-height: 80vh;">
        <div class="scrollable-div" style="overflow-y: auto; max-height: 400px; border: 1px solid #757575; padding: 10px; border-radius: 8px; background-color: rgb(255, 255, 255);">

          <!-- Usuario 1 -->
          <div class="postulante-row" style="display: flex; align-items: center; justify-content: space-between; padding: 10px; border-bottom: 1px solid #ccc;">
            <img class="user__avatar" src="imagenes/<?php echo $info1['imagen'] ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">

            <div style="flex: 1;">
              <h4 style="margin: 0;"><?php echo $info1['nombre'] . ' ' . $info1['apellido'] ?></h4>
            </div>

            <div style="flex-shrink: 0; padding-right: 20px; white-space: nowrap;">Calificación: <?php echo $usuario1['puntaje'] ?></div>
            <div style="flex: 2; white-space: normal; padding-left: 10px;"><?php echo $usuario1['comentario'] ?></div>
          </div>

          <!-- Usuario 2 -->
          <div class="postulante-row" style="display: flex; align-items: center; justify-content: space-between; padding: 10px; border-bottom: 1px solid #ccc;">
            <img class="user__avatar" src="imagenes/<?php echo $info2['imagen'] ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px;">

            <div style="flex: 1;">
              <h4 style="margin: 0;"><?php echo $info2['nombre'] . ' ' . $info2['apellido'] ?></h4>
            </div>

            <div style="flex-shrink: 0; padding-right: 20px; white-space: nowrap;">Calificación: <?php echo $usuario2['puntaje'] ?></div>

            <div style="flex: 2; white-space: normal; padding-left: 10px;"><?php echo $usuario2['comentario'] ?></div>
          </div>

        </div>
      </div>

<?php
        }
      }
    }
?>


 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

</html>