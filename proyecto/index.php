<?php
include 'loginRegistro.php';

if (isset($_POST['btnEnviarPublicacion'])) {
  // Usar una ruta absoluta para la carpeta de destino
  $carpetaDestinoAbsoluta = $_SERVER['DOCUMENT_ROOT'] . "/Integrador/IntegradorProgIII/proyecto/imagenes/";

  // Verificar que la carpeta de destino exista, si no, crearla
  if (!is_dir($carpetaDestinoAbsoluta)) {
    mkdir($carpetaDestinoAbsoluta, 0777, true); // Crear la carpeta con permisos adecuados
  }

  // Ruta por defecto para la imagen
  $rutaImagen = 'imagenes/publicacionDefault.jpg';

  // Verificar si se subió una imagen
  if (isset($_FILES['PubliArchivo']) && $_FILES['PubliArchivo']['error'] === UPLOAD_ERR_OK) {
    // Crear un nombre único para la imagen
    $nombreImagenGuardada = uniqid() . "_" . basename($_FILES['PubliArchivo']['name']);
    $rutaFinalAbsoluta = $carpetaDestinoAbsoluta . $nombreImagenGuardada;

    // Intentar mover la imagen a la carpeta de destino
    if (move_uploaded_file($_FILES['PubliArchivo']['tmp_name'], $rutaFinalAbsoluta)) {
      // Guardar la ruta relativa en la variable para la base de datos
      $rutaImagen = 'imagenes/' . $nombreImagenGuardada;
    } else {
      echo "<script>alert('Error al mover el archivo de imagen');</script>";
    }
  }


  // Datos del formulario, escapados
  $nombreProducto = $gestor->fetch_escape_string(trim($_POST['PubliNombre']));
  $descripcionProducto = $gestor->fetch_escape_string(trim($_POST['PubliDescripcion']));
  $volumenProducto = $gestor->fetch_escape_string(trim($_POST['PubliVolumen']));
  $pesoProducto = $gestor->fetch_escape_string(trim($_POST['PubliPeso']));
  $provinciaOrigenID = $gestor->fetch_escape_string(trim($_POST['ProvinciaOrigen']));
  $provinciaDestinoID = $gestor->fetch_escape_string(trim($_POST['ProvinciaDestino']));
  $localidadOrigenID = $gestor->fetch_escape_string(trim($_POST['LocalidadOrigen']));
  $localidadDestinoID = $gestor->fetch_escape_string(trim($_POST['Localidad_Destino']));
  $domicilioOrigen = $gestor->fetch_escape_string(trim($_POST['PubliDomicilio_Origen']));
  $domicilioDestino = $gestor->fetch_escape_string(trim($_POST['PubliDomicilio_Destino']));
  $nombreRecibir = $gestor->fetch_escape_string(trim($_POST['PubliRecibir']));
  $nombreContacto = $gestor->fetch_escape_string(trim($_POST['PubliContacto']));
  
  // Guardar la publicación
  $idUsuario = $_SESSION['usuario'];
  $fechaPublicacion = date('Y-m-d');
  $resultado = $gestor->insertar_publicacion(
    $idUsuario,
    $volumenProducto,
    $pesoProducto,
    $fechaPublicacion,
    $rutaImagen,
    $descripcionProducto,
    $nombreRecibir,
    $nombreContacto,
    $nombreProducto,
    $localidadOrigenID, // Guarda el id de la localidad
    $localidadDestinoID, // Guarda el id de la localidad
    $domicilioOrigen,
    $domicilioDestino
  );

  if ($resultado > 0) { ?>
    <script>
      console.log('Publicación insertada exitosamente');
    </script>
  <?php } else { ?>
    <script>
      console.log('Error al insertar la publicación');
    </script>
<?php }
}

if (isset($_POST['verPublicacion'])) {
  //  id de la publicacion
  $_SESSION['publicacion'] = $_POST['Publicacion'];
  // Redirige a publicacion.php
  header("Location: publicacion.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>Inicio - Very Deli</title>
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
        <form action="buscador.php" method= "GET">
                <input type="text" name="buscar" placeholder="Buscar localidad o provincia" id="barraBusqueda" />
        <button type="submit" name="botonBuscar" class="btn btn-link p-0" style="display: none;"></button>

                </form>
      </div>
    </div>

    <div class="header__middle" id="header_medio">
      <div class="header__option active">
        <a href="index.php"><span class="material-icons"> home </span></a>
      </div>
      <div href="buscador.php" class="header__option">
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
  <!-- header ends -->

  <!-- main body starts -->
  <div class="main__body">
    <!-- sidebar starts -->
    <?php if (isset($_SESSION["usuario"])) { ?>
    <div class="sidebar">
      <div class="sidebarRow">
        <a href="perfil.php?tab=publicaciones" class="text-decoration-none">
          <?php if ($usuario['imagen']) { ?>
            <img src="imagenes/<?= $usuario["imagen"] ?>" alt="avatar" class="avatar rounded-circle img-fluid border">
          <?php } else { ?>
              <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar rounded-circle img-fluid border"
              alt="avatar">
          <?php } ?>  
          <h4><?= ucfirst($usuario["nombre"]) . " " . ucfirst($usuario["apellido"]) ?></h4>
        </a>
      </div>
      
      <div class="sidebarRow">
        <a href="buscador.php" class="text-decoration-none">
          <span class="material-icons"> search </span>
          <h4>Buscar Publicaciones</h4>
        </a>
      </div>

      <div class="sidebarRow">
        <a href="perfil.php?tab=publicaciones" class="text-decoration-none">
          <span class="material-icons"> storefront </span>
          <h4>Mis Publicaciones</h4>
        </a>
      </div>
      
      <div class="sidebarRow">
        <a href="perfil.php?tab=calificaciones" class="text-decoration-none">
          <span class="material-icons"> star </span>
          <h4>Calificaciones</h4>
        </a>
      </div>
      
    </div>
    <?php } ?>
    <!-- sidebar ends -->

    <!-- feed starts -->
    <div class="feed">
      <!-- message sender starts -->
      <div class="messageSender">
        <div class="messageSender__top">
          <img class="user__avatar post__avatar" src="imagenes/<?php echo $_SESSION['imagenU'] ?>" alt="fotoUser">
          <form>
            <input class="messageSender__input" placeholder="Publica acá abajo" type="text" disabled />
          </form>
        </div>

        <div class="messageSender__bottom">
          <?php if (isset($_SESSION["usuario"])) {
            echo "<div class='messageSender__option'>";
            echo "<span style='color: #52b04c' class='material-icons'> publish </span>";
            echo "<button data-bs-toggle='modal' data-bs-target='#publicarModal' style='background: none; border: none; padding: 0; color: inherit; font: inherit; cursor: pointer;' >publicar</button> ";
            echo "</div>";
          } else {
            echo "<div class='messageSender__option'>";
            echo "<button data-bs-toggle='modal' data-bs-target='#loginModal' style='background: none; border: none; padding: 0; color: #52b04c; font: inherit; cursor: pointer;'>Inicie sesión para publicar una solicitud</button>";
            echo "</div>";
          }
          ?>


        </div>
      </div>
      <!-- message sender ends -->

      <!-- post starts -->
      <div class="post">
        <?php
        $gestor->mostrar_publicaciones();
        ?>
      </div>
      <!-- post ends -->
    </div>
  </div>
  <!-- main body ends -->

  <!-- Modal Publicacion -->
  <div class="modal fade" id="publicarModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabel">Publicar Necesidad</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form id="FormPublicacion" method="POST" ACTION="index.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="PubliNombre">Nombre Del Producto: </label>
              <input type="text" class="form-control" name="PubliNombre" id="PubliNombre" min="1" pattern="^[a-zA-Z0-9\s]{4,}$" required title="Nombre debe ser mayor a 5 caracteres sin caracteres especiales">
              <div class="invalid-feedback" id="pubNombreProductoFeedback"></div>
            </div>

            <div class="form-group">
              <label for="PubliDescripcion">Descripcion Del Producto: </label>
              <input type="text" class="form-control" name="PubliDescripcion" id="PubliDescripcion" min="5" max="40" pattern="^[a-zA-Z0-9\s]{5,}$" required title="Descripción debe ser mayor a 5 caracteres">
              <div class="invalid-feedback" id="pubDescripcionFeedback"></div>
            </div>

            <div class="form-group">
              <label for="PubliVolumen">Volumen: </label>
              <select class="form-select" aria-label="PubliVolumen" name="PubliVolumen" id="PubliVolumen" required title="se debe seleccionar una opcion">
                <option value="">Elegi el volumen de tu paquete</option>
                <option value="10">Chico (hasta 10kg)</option>
                <option value="100">Mediano (hasta 100kg)</option>
                <option value="1000">Grande (hasta 1000kg)</option>
              </select>

              <div class="invalid-feedback" id="pubVolumenFeedback"></div>
            </div>
            <div class="form-group">
              <label for="PubliPeso">Peso: </label>
              <input type="number" class="form-control" name="PubliPeso" id="PubliPeso" min="1" pattern="^[1-9][0-9]*$" title="el peso debe ser un numero postivo" required>
              <div class="invalid-feedback" id="pubPesoFeedback"></div>
            </div>
            <div class="form-group">
              <label for="ProvinciaOrigen">Provincia de Origen: </label>
              <select class="form-select" aria-label="ProvinciaOrigen" name="ProvinciaOrigen" id="ProvinciaOrigen" required>
                <option value="">Selecciona la provincia</option>
                <?php
                $provincias = $gestor->fetch_provincias();

                foreach($provincias as $row) { ?>
                  <option value= '<?= $row['idProvincia'] ?>'> <?= $row['nombre'] ?> </option>
                <?php } ?>
              </select>

              <div class="invalid-feedback" id="pubProvinciaOrigen"></div>
            </div>

            <div class="form-group">
              <label for="LocalidadOrigen">Localidad de Origen: </label>
              <select class="form-select" aria-label="LocalidadOrigen" name="LocalidadOrigen" id="LocalidadOrigen" required title="debe seleccionar una opcion valida">
                <option value="">Selecciona la localidad</option>
              </select>

              <div class="invalid-feedback" id="pubLocalidadOrigen"></div>
            </div>

            <div class="form-group">
              <label for="PubliDomicilio_Origen">Domicilio Origen:</label>
              <input type="text" class="form-control" name="PubliDomicilio_Origen" id="PubliDomicilio_Origen" pattern="^[a-zA-Z0-9\s]{5,}$" title="Domicilio de origen debe tener letras y números, mínimo 5 caracteres" required>
              <div class="invalid-feedback" id="pubDomicilio_OrigenFeedback"></div>
            </div>

            <div class="form-group">
              <label for="ProvinciaDestino">Provincia de Destino: </label>
              <select class="form-select" aria-label="ProvinciaDestino" name="ProvinciaDestino" id="ProvinciaDestino" required title="debe seleccionar una opcion valida">
                <option value="">Selecciona la provincia</option>
                <?php
                $provincias = $gestor->fetch_provincias();
                foreach($provincias as $row) {
                  echo "<option value= '{$row['idProvincia']}'> {$row['nombre']} </option>";
                }
                ?>
              </select>

              <div class="invalid-feedback" id="pubProvinciaDestino"></div>
            </div>

            <div class="form-group">
              <label for="Localidad_Destino">Localidad de Destino: </label>
              <select class="form-select" aria-label="Localidad_Destino" name="Localidad_Destino" id="Localidad_Destino" required title="debe seleccionar una opcion valida">
                <option value="">Selecciona la localidad</option>
              </select>

              <div class="invalid-feedback" id="pubLocalidad_Destino"></div>
            </div>

            <div class="form-group">
              <label for="PubliDomicilio_Destino">Domicilio Destino:</label>
              <input type="text" class="form-control" name="PubliDomicilio_Destino" id="PubliDomicilio_Destino" required pattern="^[a-zA-Z0-9\s]{5,}$" title="Domicilio de destino debe tener letras y números, mínimo 5 caracteres">
              <div class="invalid-feedback" id="pubDomicilio_DestinoFeedback"></div>
            </div>


            <div class="form-group">
              <label for="PubliRecibir">Nombre de persona a recibir el paquete:</label>
              <input type="text" class="form-control" name="PubliRecibir" id="PubliRecibir" required pattern="^[a-zA-Z\s]{5,}$" title="El nombre de la persona debe tener letras solamente, mínimo 5 caracteres">
              <div class="invalid-feedback" id="pubRecibir_Feedback"></div>
            </div>
            <div class="form-group">
              <label for="PubliContacto">telefono de persona a recibir el paquete:</label>
              <input type="text" class="form-control" name="PubliContacto" id="PubliContacto" required pattern="^[0-9]{9,13}$" title="El telefono de la persona debe tener numeros solamente, entre 10 y 12 numeros">
              <div class="invalid-feedback" id="pubRecibir_Feedback"></div>
            </div>


            <div class="form-group">
              <label for="PubliArchivo">Inserte la foto(opcional):</label>
              <input type="file" class="form-control" name="PubliArchivo" id="PubliArchivo">
              <div class="invalid-feedback" name="pubArchivoFeedback" id="pubArchivoFeedback"></div>
            </div>

            <div class="modal-footer">
              <input type="submit" name="btnEnviarPublicacion" id="btnEnviarPublicacion" class="btn btn-primary" value="Publicar">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <script
    async
    defer
    crossorigin="anonymous"
    src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0"
    nonce="zUxEq08J"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const selectProvinciaOrigen = document.getElementById("ProvinciaOrigen");
      const selectLocalidadOrigen = document.getElementById("LocalidadOrigen");

      const selectProvinciaDestino = document.getElementById("ProvinciaDestino");
      const selectLocalidadDestino = document.getElementById("Localidad_Destino");

      // Configuración de localidades de origen
      selectProvinciaOrigen.addEventListener("change", function() {
        const idProvincia = selectProvinciaOrigen.value;

        // Limpia y establece la opción predeterminada
        selectLocalidadOrigen.innerHTML = '<option value="" selected disabled>Selecciona la localidad</option>';

        if (idProvincia) {
          fetch(`getLocalidades.php?idProvincia=${idProvincia}`)
            .then(response => response.json())
            .then(data => {
              data.forEach(localidad => {
                const option = document.createElement("option");
                option.value = localidad.idLocalidad;
                option.textContent = localidad.Nombrelocalidad;
                selectLocalidadOrigen.appendChild(option);
              });
            })
            .catch(error => console.error("Error al cargar localidades:", error));
        }
      });

      // Configuración de localidades de destino
      selectProvinciaDestino.addEventListener("change", function() {
        const idProvincia = selectProvinciaDestino.value;

        // Limpia y establece la opción predeterminada
        selectLocalidadDestino.innerHTML = '<option value="" selected disabled>Selecciona la localidad</option>';

        if (idProvincia) {
          fetch(`getLocalidades.php?idProvincia=${idProvincia}`)
            .then(response => response.json())
            .then(data => {
              data.forEach(localidad => {
                const option = document.createElement("option");
                option.value = localidad.idLocalidad;
                option.textContent = localidad.Nombrelocalidad;
                selectLocalidadDestino.appendChild(option);
              });
            })
            .catch(error => console.error("Error al cargar localidades:", error));
        }
      });
    });
  </script>
  <?php
  include 'modalLoginRegistro.php';
  include 'validarRegistro.php';
  ?>
</body>

</html>