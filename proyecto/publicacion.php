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
  $publicacion = $publicacionControl->fetch_publicacion(9);
  $postulantes = $publicacionControl->fetch_postulaciones_por_publicacion($publicacion['idPublicacion']);
  $comentarios = $publicacionControl->fetch_mensajes_por_publicacion($publicacion['idPublicacion']);

  $id = $publicacion['idPublicacion'];

  date_default_timezone_set('America/Argentina/San_Luis');

  if (isset($_SESSION["idUsuario"])) {
    $tipo = 0;
    //cambiar el 1 por session de la id de usuario
  } elseif (1 == $publicacion['idUsuario']) {
    $tipo = 1; //$_SESSION["idUsuario"]

  } elseif ($publicacion['postulanteElegido'] == 2) {
    $tipo = 2;
  } elseif ($publicacionControl->es_postulante(1, $publicacion['idPublicacion'])) {
    $tipo = 3;
  } else {
    $tipo = 4;
  }
  $control = 0;

  $tipo = 2;
  $error = 0;

  // control al postularse
  if (isset($btnpostularse)) {
    $vehiculo = $publicacionControl->tiene_vehiculo_por_usuario(1);
    $publicacionE = $publicacionControl->fetch_publicacion(4);
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
    } elseif (!$publicacionControl->usuario_puede_postularse(1)) {
      $errorm = "Debe tener el estado responsable para poder postularse a más de una publicación";
      $error = 1;
    } else {
      // No hay errores; redirigir a insertar_postulante.php

      //  Usar sesión para pasar los datos
      $_SESSION['id'] = $publicacion['idPublicacion'];
      $_SESSION['monto'] = floatval($monto);
      $_SESSION['usuario_id'] = 2;  // Cambiar 2 por el ID de usuario real
      $_SESSION['publicacion_id'] = 4; // Cambiar 4 por el ID de publicación real
      $_SESSION['estado'] = 0;

      // Redirige a insertar_postulante.php
      header("Location: insertar_postulante.php");
      exit();
    }
  }

  if (isset($enviarCalificacion)) {
    $fechaComentario = date('Y-m-d');
    if (1 == $publicacion['idUsuario']) {
      $calificado = $publicacion['idUsuario'];
    } else {
      $calificado = $publicacion['postulanteElegido'];
    }
    $calificacion = intval($calificacion);
    echo $calificacion;
    $publicacionControl->insertar_calificacion(1, $calificacion, $opinion, $calificado, $publicacion['idPublicacion'], $fechaComentario);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional  
  }

  if (isset($comentarioBtn)) {

    // Obtener la fecha y hora actual
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $publicacionControl->insertar_mensaje(1, $publicacion['idPublicacion'], $mensajeA, $fecha, $hora);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirige a la misma página sin datos en POST
    exit(); // Asegura que se detenga el procesamiento adicional    
  }

if(isset($finalizado)){
  $fecha= date('Y-m-d');
$publicacionControl->actualizar_publicacionFinalizada($publicacion['idPublicacion'],$fecha);
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

  ?>

  <div class=" row header">
    <div class="col-3 header__left">

      <img src="https://upload.wikimedia.org/wikipedia/commons
      /thumb/5/51/Facebook_f_logo_%282019%29.svg/1200px Facebook_f_logo_%282019%29.svg.png" alt="" />

      <img src="LogoVeryDeli.svg" alt="Logo" class="logo">
      <div class="header__input">
        <span class="material-icons"> search </span>
        <input type="text" placeholder="Search " />
      </div>
    </div>
    <div class="col header__middle">
      <div class="header__option active">
        <span class="material-icons"> home </span>
      </div>
      <div class=" header__option">
        <span class="material-icons"> storefront </span>
      </div>
      <div class="header__option">
        <span class="material-icons"> supervised_user_circle </span>
      </div>
    </div>

    <div class="col header__right">
      <div class="header__info">
        <img
          class="user__avatar"
          src="data:image/png;base64,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"
          alt="" />
        <h4>Somanath Goudar</h4>
      </div>
    </div>

    <div class="header__responsive">
      <a href="buscador.php" class="header__option">
        <span class="material-icons"> home </span>
        <span>Inicio</span>
      </a>
      <a href="#buscar" class="header__option">
        <span class="material-icons"> search </span>
        <span>Buscar Pedidos</span>
      </a>
      <a href="#favoritos" class="header__option">
        <span class="material-icons"> rocket_launch </span>
        <span>Mis pedidos</span>
      </a>
      <a href="#perfil" class="header__option">
        <span class="material-icons"> person </span>
        <span>Perfil</span>
      </a>
    </div>
  </div>


  <!--contenido del producto -->

  <div class="card d-flex flex-row flex-wrap container" style="width: 70%;">
    <img src="<?php echo $publicacion['imagenPublicacion'] ?>" class="card-img-top" alt="..." style="max-width: auto; height: 50%; flex: 1 1 auto;">
    <div class="card-body" style="flex: 1 1 300px; padding: 20px;">
      <class="card-title">
        <h1><?php echo $publicacion['titulo'] ?></h1>
        <p class="card-text">Origen: <?php echo $publicacion['Provinciaorigen']."/".$publicacion['localidadOrigen'];
        if($publicacion['estado'] != 0){echo "/".$publicacion['domicilioOrigen'];}?></p>
        <p class="card-text">destino <?php echo $publicacion['Provinciadestino']."/".$publicacion['localidadDestino'];
         if($publicacion['estado'] != 0){echo "/".$publicacion['domicilioDestino'];} ?></p>
        <p class="card-text">Peso: <?php echo $publicacion['peso'] ?>kg</p>
        <p class="card-text">Volumen: <?php echo $publicacion['volumen'] ?></p>
        <p class="card-text"><?php echo $publicacion['descripcion'] ?></p>
        <?php if($publicacion['estado'] != 0){ 
          $usuario = $publicacionControl->fetch_usuario_por_id($publicacion['postulanteElegido']);?>
        <p class="card-text"> Contacto:<?php echo $publicacion['contacto'] ?></p>
        <p class="card-text">Postulante Elegido:<?php echo $usuario['nombre']." ".$usuario['apellido'] ?></p>
        <p class="card-text"> nombre a recibir:<?php echo $publicacion['nombreRecibir'] ?></p>
        <?php }  
        ?>
        
        <?php if($tipo == 3 && $publicacion['estado'] == 0){?>
        <a href="#" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#postulacionModal">postularse</a>
       <?php
        }
        if($tipo == 2 && $publicacion['estado'] == 1){?>
          <form action="publicacion.php" method="post">
            <div class="modal-footer ">
              <button class="btn btn-primary" type="submit" name="finalizado">envio finalizado</button>
            </div>
          </form>
       <?php }
        if($tipo == 0){
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

    <div class="scrollable-div" style="overflow-y: auto;">
      <div class="comments-container" style="padding-left:0;">


        <ul id="comments-list" class="comments-list">
          <li>
            <?php foreach ($comentarios as $mensaje) {
              $usuario = $publicacionControl->fetch_usuario_por_id($mensaje['idUsuario']);

            ?>
              <div class="comment-main-level" style="margin-top: 20px; margin-bottom: 10px;">
                <!-- Avatar -->
                <div class="comment-avatar"><img src="imagenes/<?php echo $usuario['imagen'] ?>" alt=""></div>
                <!-- Contenedor del Comentario -->
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name <?php if ($usuario['idUsuario'] == $publicacion['idUsuario']) {
                                              echo "by-author";
                                            } ?>"><a href="http://creaticode.com/blog"><?php echo $usuario['nombre'] ?></a></h6>
                    <span><?php echo $mensaje['fechaComentario'] . " " . $mensaje['hora'] ?></span>
                  </div>
                  <div class="comment-content">
                    <?php echo $mensaje['comentario'] ?>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </li>
        </ul>
      </div>
      <div class="chat-form">

      </div>
    </div>
    <form method="post" action="publicacion.php" class="chat-form">
      <label></label><br>
      <input type="text" id="mensajeA" name="mensajeA" style="width: 80%; height: 30px; " required>
      <input type="submit" name="comentarioBtn" value="enviar" style="width: 18%;">
    </form>
  </div>
<?php
}
?>
<!-- Contenedor Principal -->
<?php  if($publicacion['estado'] == 2  && $tipo == 1 ||$tipo == 2){?>  

  <div class="container " style="padding-left: 50px;">
    <h1>Calificacion</h1>
  </div>
  <div class="card d-flex flex-wrap container" style="padding-bottom: 80px; padding-top: 20px; width: 70%; margin-bottom: 20px; display: flex; flex-direction: column; justify-content: center; max-height: 80vh;">
    <?php if ($publicacionControl->publicacion_calificada($publicacion['idPublicacion']) == 0 && $publicacionControl->usuario_califico(1, $publicacion['idPublicacion']) == 1) { ?>
      <form method="post" action="publicacion.php">
        <label>calificacion: <select name="calificacion">
            <option name="calificacion" value="1">1</option>
            <option name="calificacion" value="2">2</option>
            <option name="calificacion" value="3">3</option>
            <option name="calificacion" value="4">4</option>
            <option name="calificacion" value="5">5</option>
          </select>
        </label>

        <p><label>comentario<input type="text" name="opinion"></p>
        <p><input type="submit" name="enviarCalificacion"></p>
      </form>
  </div>


  <?php
    } else {
      $usuario1 = $publicacionControl->fetch_calificaciones_por_publicacion($publicacion['idUsuario'], $publicacion['idPublicacion']);
      $usuario2 = $publicacionControl->fetch_calificaciones_por_publicacion($publicacion['postulanteElegido'], $publicacion['idPublicacion']);
      if (empty($usuario1) || empty($usuario2)) {
        echo "<h3>espere a que el otro usuario publique si calificacion para poder ver su calificacion</h3>";
      } else {
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
</body>

</html>