<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="estilos.css">
  <link rel="stylesheet" href="estiloComentario.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
  <?php
  session_start();
  extract($_GET);
  require 'base de datos/gestorbd.php';
  $publicacionControl = new GestorVeryDeli();
  $publicacion = $publicacionControl->fetch_publicacion($idPublicacion);
  $postulantes = $publicacionControl->fetch_postulaciones_por_publicacion($publicacion['idPublicacion']);
  $comentarios = $publicacionControl->fetch_mensajes_por_publicacion($publicacion['idPublicacion']);
  $fechap = date('Y-m-d');
  $id = $publicacion['idPublicacion'];

  date_default_timezone_set('America/Argentina/San_Luis');
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
                <div class="header__option active">
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

  <!-- contenido del producto -->
  <div class="card d-flex flex-row flex-wrap container" style="width: 70%;">
    <img src="<?php echo $publicacion['imagenPublicacion']; ?>" class="card-img-top" alt="..." style="max-width: auto; height: 50%; flex: 1 1 auto;">
    <div class="card-body" style="flex: 1 1 300px; padding: 20px;">
      <h1><?php echo $publicacion['titulo']; ?></h1>
      <p class="card-text">Origen: <?php echo $publicacion['Provinciaorigen'] . "/" . $publicacion['localidadOrigen'];
      if ($publicacion['estado'] != 0) {
          echo "/" . $publicacion['domicilioOrigen'];
      } ?></p>
      <p class="card-text">Destino: <?php echo $publicacion['Provinciadestino'] . "/" . $publicacion['localidadDestino'];
      if ($publicacion['estado'] != 0) {
          echo "/" . $publicacion['domicilioDestino'];
      } ?></p>
      <p class="card-text">Peso: <?php echo $publicacion['peso']; ?> kg</p>
      <p class="card-text">Volumen: <?php echo $publicacion['volumen']; ?></p>
      <p class="card-text">Descripción: <?php echo $publicacion['descripcion']; ?></p>
      <?php if ($publicacion['estado'] != 0) {
          $usuario = $publicacionControl->fetch_usuario_por_id($publicacion['postulanteElegido']); ?>
          <p class="card-text">Contacto: <?php echo $publicacion['contacto']; ?></p>
          <p class="card-text">Postulante Elegido: <?php echo $usuario['nombre'] . " " . $usuario['apellido']; ?></p>
          <p class="card-text">Nombre a recibir: <?php echo $publicacion['nombreRecibir']; ?></p>
      <?php } ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
