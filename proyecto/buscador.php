<?php

include 'loginRegistro.php';

// Variables para almacenar resultados
$publicaciones = [];

// Verificar si se presionó el botón de filtro
if (isset($_POST['botonFiltrar'])) {
    // Obtener y limpiar filtros de provincia y peso
    $filtroProvincias = mysqli_real_escape_string($conexion, trim($_POST['select_provincias']));
    $filtroPeso = mysqli_real_escape_string($conexion, trim($_POST['select_descripcion']));

    // Consultar publicaciones aplicando los filtros de manera dinámica
    if (!empty($filtroProvincias) && !empty($filtroPeso)) {
        // Obtener publicaciones filtradas por provincia y peso
        $publicaciones = $gestor->fetch_publicaciones_filtradas($filtroProvincias, $filtroPeso);
    } elseif (!empty($filtroProvincias)) {
        $publicaciones = $gestor->fetch_publicaciones_por_origen($filtroProvincias);
    } elseif (!empty($filtroPeso)) {
        $publicaciones = $gestor->fetch_publicaciones_por_peso($filtroPeso);
    } else {
        // Si no hay filtros, obtener todas las publicaciones
        $publicaciones = $gestor->fetch_publicaciones();
    }
} else {
    // Si no se aplicaron filtros, obtener todas las publicaciones
    $publicaciones = $gestor->fetch_publicaciones();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Facebook Clone</title>
    <link rel="stylesheet" href="estilos.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<!-- header starts -->
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
            <a href="perfil.php" class="header__option">
                <span class="material-icons"> person </span>
                <span>Perfil</span>
            </a>
            <?php } else { ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar Sesión</button>
            <?php } ?>
        </div>
    </div>
<!-- header ends -->

<!-- main body starts -->
<div class="main__body">
    <!-- sidebar starts -->
    <div class="sidebar">
        <div class="sidebar">
            <h4>Filtros</h4>
        </div>
        <form action="buscador.php" method="POST">
            <label for ="select_provincias">Provincias que tienen envios disponibles</label>
            <select class="form-select" name="select_provincias" >
                <option value="" selected>Provincias Disponibles</option>
                <?php
                $conexion = mysqli_connect('localhost', 'user_personas', '45382003', 'very_deli');
                $consul = "SELECT nombreProvincia, idProvincia FROM provincia";
                $resultado = mysqli_query($conexion, $consul);
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='{$row['nombreProvincia']}'>{$row['nombreProvincia']}</option>";
                }
                mysqli_close($conexion);
                ?>
            </select><br>
            <label for="select_descripcion">Filtro por volumen</label>
            <select name="select_descripcion" class="form-select" >
                <option value="">Filtro por volumen</option>
                <option value="10">hasta 10  m³</option>
                <option value="100">hasta 100  m³</option>
                <option value="1000">hasta 1000  m³</option>
            </select><br>
            <input type="submit" class="btn btn-primary" value="filtrar" name="botonFiltrar">
        </form>
    </div>
    <!-- sidebar ends -->

    <!-- feed starts -->
    <div class="feed">
        <div class="post">
            <?php
            if (!empty($publicaciones)) {
                foreach ($publicaciones as $publicacion) { ?>
                    <div class="post__top">
                        <img class="user__avatar post__avatar" src="imagenes/<?php echo htmlspecialchars($publicacion['usuarioImagen']); ?>" alt="xd">
                        <div class="post__topInfo">
                            <h3><?= htmlspecialchars($publicacion['usuarioNombre']) ?> <?= htmlspecialchars($publicacion['usuarioApellido']) ?></h3>
                            <p> <?= date("d M Y H:i") ?></p>
                        </div>
                    </div>
                    <div class="post__details">
                        <p>Nombre de producto: <?= htmlspecialchars($publicacion['titulo']) ?></p>
                        <p>Descripción: <?= htmlspecialchars($publicacion['descripcion']) ?></p>
                        <p>Volumen: <?= htmlspecialchars($publicacion['volumen']) ?> m³</p>
                        <p>Peso: <?= htmlspecialchars($publicacion['peso']) ?> kg</p>
                        <p>Origen: <?= htmlspecialchars($publicacion['provinciaOrigen']) ?></p>
                        <p>Destino: <?= htmlspecialchars($publicacion['provinciaDestino']) ?></p>
                    </div>
                    <div class="post__image">
                        <?php if (!isset($publicacion['imagenPublicacion'])) { ?>
                            <img src="imagenes/publicacionDefault.jpg" alt="Imagen del producto">
                        <?php } else { ?>
                            <img src="<?= htmlspecialchars($publicacion['imagenPublicacion']); ?>" alt="Imagen del producto">
                        <?php } ?>
                    </div>
                    <div class="post__options">
                        <div class="post__option">
                            <span class="material-icons"> near_me </span>
                            <p>Postularse</p>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<p>No se encontraron publicaciones que coincidan con los filtros.</p>";
            }
            ?>
        </div>
    </div>
    <!-- feed ends -->
</div>
<!-- main body ends -->



  <div id="fb-root"></div>
  <script
    async
    defer
    crossorigin="anonymous"
    src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0"
    nonce="zUxEq08J"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    const barraBusquedaContainer = document.getElementById("header_busqueda");
    const barraBusqueda = document.getElementById("barraBusqueda");
    const headerMedio = document.getElementById("header_medio");

    barraBusqueda.addEventListener('focus', function() {
      headerMedio.classList.add("hidden");
      barraBusquedaContainer.classList.add("headerExpandido");
    })

    barraBusqueda.addEventListener('blur', function() {
      headerMedio.classList.remove('hidden');
      barraBusquedaContainer.classList.remove("headerExpandido");
    });
  </script>
    <?php 
    include 'modalLoginRegistro.php';
    include 'validarRegistro.php';
    ?>
</body>

</html>