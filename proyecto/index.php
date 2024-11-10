<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Facebook Clone</title>
    <link rel="stylesheet" href="estilos.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  </head>
  <body>
    <!-- header starts -->
    <div class="header">
      <div class="header__left">
        <img
          src="https://upload.wikimedia.org/wikipedia/commons
    /thumb/5/51/Facebook_f_logo_%282019%29.svg/1200px Facebook_f_logo_%282019%29.svg.png"alt="" />
        
        <img src="LogoVeryDeli.svg" alt="Logo" class="logo">
        <div class="header__input">
          <span class="material-icons"> search </span>
          <input type="text" placeholder="Search Facebook" />
        </div>
      </div>
      <div class="header__middle">
        <div class="header__option active">
          <span class="material-icons"> home </span>
        </div>
        <div class="header__option">
          <span class="material-icons"> storefront </span>
        </div>
        <div class="header__option">
          <span class="material-icons"> supervised_user_circle </span>
        </div>
      </div>

      <div class="header__right">
        <div class="header__info">
          <img src="LogoVeryDeli.svg" alt="Logo" class="user__avatar"/>
          
          <h4>Somanath Goudar</h4>
        </div>
        <span class="material-icons"> forum </span>
        <span class="material-icons"> notifications_active </span>
        <span class="material-icons"> expand_more </span>
      </div>
    </div>
    <!-- header ends -->

    <!-- main body starts -->
    <div class="main__body">
      <!-- sidebar starts -->
      <div class="sidebar">
        <div class="sidebarRow">
          <img src="LogoVeryDeli.svg" alt="Logo" class="user__avatar">
          <h4>Somanath Goudar</h4>
        </div>

        <div class="sidebarRow">
          <span class="material-icons"> emoji_flags </span>
          <h4>Historial</h4>
        </div>

        <div class="sidebarRow">
          <span class="material-icons"> people </span>
          <h4>Calificaciones</h4>
        </div>

        <div class="sidebarRow">
          <span class="material-icons"> chat </span>
          <h4>Mensajes</h4>
        </div>

      </div>
      <!-- sidebar ends -->

      <!-- feed starts -->
      <div class="feed">
        

        <!-- message sender starts -->
        <div class="messageSender">
          <div class="messageSender__top">
            <img src="LogoVeryDeli.svg" alt="Logo" class="user__avatar post__avatar">
            <form>
              <input class="messageSender__input" placeholder="Publica acá abajo" type="text" disabled />
            </form>
          </div>

          <div class="messageSender__bottom">
            <div class="messageSender__option">
              <span style="color: red" class="material-icons"> publish </span>
              <button data-bs-toggle="modal" data-bs-target="#publicarModal" style="background: none; border: none; padding: 0; color: inherit; font: inherit; cursor: pointer;" >publicar</button>
            </div>

            
          </div>
        </div>
        <!-- message sender ends -->

        <!-- post starts -->
        <div class="post">
          <div class="post__top">
            <img src="LogoVeryDeli.svg" alt="Logo" class="user__avatar post__avatar">
            <div class="post__topInfo">
              <h3>Somanath Goudar</h3>
              <p>25 April at 20:30</p>
            </div>
          </div>

          <div class="post__bottom">
            <p>Message</p>
          </div>

          <div class="post__image">
            <img
              src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8Y2Fyc3xlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&w=1000&q=80"
              alt=""
            />
          </div>

          <div class="post__options">

            <div class="post__option">
              <span class="material-icons"> chat_bubble_outline </span>
              <p>Postularse</p>
            </div>

            <div class="post__option">
              <span class="material-icons"> near_me </span>
              <p>Compartir</p>
            </div>
          </div>
        </div>
        <!-- post ends -->

        <!-- post starts -->
        <div class="post">
          <div class="post__top">
            <img src="LogoVeryDeli.svg" alt="Logo" class="user__avatar post__avatar">
            <div class="post__topInfo">
              <h3>Somanath Goudar</h3>
              <p>25 April at 20:30</p>
            </div>
          </div>

          <div class="post__bottom">
            <p>Post Without Image</p>
          </div>

          <div class="post__options">

            <div class="post__option">
              <span class="material-icons"> chat_bubble_outline </span>
              <p>Postularse>
            </div>

            <div class="post__option">
              <span class="material-icons"> near_me </span>
              <p>Compartir</p>
            </div>
          </div>
        </div>
        <!-- post ends -->

        <!-- post starts -->
        <div class="post">
          <div class="post__top">
            <img src="LogoVeryDeli.svg" alt="Logo" class="user__avatar post__avatar">
            <div class="post__topInfo">
              <h3>Somanath Goudar</h3>
              <p>25 April at 20:30</p>
            </div>
          </div>

          <div class="post__bottom">
            <p>Message</p>
          </div>

          <div class="post__image">
            <img src="https://wallpapercave.com/wp/wp7357832.jpg" alt="" />
          </div>

          <div class="post__options">

            <div class="post__option">
              <span class="material-icons"> chat_bubble_outline </span>
              <p>Postularse</p>
            </div>

            <div class="post__option">
              <span class="material-icons"> near_me </span>
              <p>Compartir</p>
            </div>
          </div>
        </div>
        <!-- post ends -->
      </div>
      <!-- feed ends -->

      <div style="flex: 0.20" class="widgets">
        
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

          <form id="FormPublicacion" method = "POST" ACTION = "" novalidate>
            <div class="form-group">
              <label for="PubliNombre">Nombre Del Producto: </label>
              <input type="text" class="form-control" id="PubliNombre" min="1" pattern="^[1-9][0-9]*$" required>
              <div class="invalid-feedback" id="pubNombreProductoFeedback"></div>
            </div>

            <div class="form-group">
              <label for="PubliDescripcion">Descripcion Del Producto: </label>
              <input type="text" class="form-control" id="PubliDescripcion" min="5" max="40" pattern="^[1-9][0-9]*$" required>
              <div class="invalid-feedback" id="pubDescripcionFeedback"></div>
            </div>

            <div class="form-group">
              <label for="PubliVolumen">Volumen: </label>
              <select class="form-select" aria-label="PubliVolumen">
                <option selected>Elegi el volumen de tu paquete</option>
                <option value="10">Chico (hasta 10kg)</option>
                <option value="100">Mediano (hasta 100kg)</option>
                <option value="1000">Grande (hasta 1000kg)</option>
              </select>

              <div class="invalid-feedback" id="pubVolumenFeedback"></div>
            </div>
            <div class="form-group">
              <label for="PubliPeso">Peso: </label>
              <input type="number" class="form-control" id="PubliPeso" min="1" pattern="^[1-9][0-9]*$" required>
              <div class="invalid-feedback" id="pubPesoFeedback"></div>
            </div>
            <div class="form-group">
              <label for="ProvinciaOrigen">Provincia de Origen: </label>
              <select class="form-select" aria-label="ProvinciaOrigen" id="ProvinciaOrigen" required>
                <option selected>Selecciona la provincia</option>
                <?php
            $conexion = mysqli_connect('localhost', 'user_personas', '45382003','very_deli');
           if (!$conexion) {
           die("Conexión fallida: " . mysqli_connect_error());
            }

            // Configurar la conexión para usar UTF-8
            mysqli_set_charset($conexion, 'utf8mb4');
             $consul = "SELECT nombreProvincia, idProvincia FROM provincia";
            $resultado = mysqli_query($conexion,$consul);

            while($row = mysqli_fetch_assoc($resultado)){   
            echo "<option value= '{$row['idProvincia']}'> {$row['nombreProvincia']} </option>";
          }
    ?>
              </select>

              <div class="invalid-feedback" id="pubProvinciaOrigen"></div>
            </div>

            <div class="form-group">
              <label for="LocalidadOrigen">Localidad de Origen: </label>
              <select class="form-select" aria-label="LocalidadOrigen" id="LocalidadOrigen">
                <option selected>Selecciona la localidad</option>
                <option value="localidad1">localidad1</option>
                <option value="localidad2">localidad3</option>
                <option value="localidad3">localidad3</option>
              </select>

              <div class="invalid-feedback" id="pubLocalidadOrigen"></div>
            </div>

            <div class="form-group">
                <label for="PubliDomicilio_Origen">Domicilio Origen:</label>
                <input type="text" class="form-control" id="PubliDomicilio_Origen" required>
                <div class="invalid-feedback" id="pubDomicilio_OrigenFeedback"></div>
            </div>

            <div class="form-group">
              <label for="ProvinciaDestino">Provincia de Destino: </label>
              <select class="form-select" aria-label="ProvinciaDestino" id = "ProvinciaDestino">
                <option selected>Selecciona la provincia</option>
                <?php
                
            // Configurar la conexión para usar UTF-8
            mysqli_set_charset($conexion, 'utf8mb4');
            $consul = "SELECT nombreProvincia, idProvincia FROM provincia";
           $resultado = mysqli_query($conexion,$consul);

           while($row = mysqli_fetch_assoc($resultado)){   
           echo "<option value= '{$row['idProvincia']}'> {$row['nombreProvincia']} </option>";
         }
                ?>
              </select>

              <div class="invalid-feedback" id="pubProvinciaDestino"></div>
            </div>

            <div class="form-group">
              <label for="Localidad_Destino">Localidad de Destino: </label>
              <select class="form-select" aria-label="Localidad_Destino" id="Localidad_Destino">
                <option selected>Selecciona la localidad</option>
                <option value="localidad1">localidad1</option>
                <option value="localidad2">localidad3</option>
                <option value="localidad3">localidad3</option>
              </select>

              <div class="invalid-feedback" id="pubLocalidad_Destino"></div>
            </div>

            <div class="form-group">
              <label for="PubliDomicilio_Destino">Domicilio Destino:</label>
              <input type="text" class="form-control" id="PubliDomicilio_Destino" required>
              <div class="invalid-feedback" id="pubDomicilio_DestinoFeedback"></div>
          </div>
            <div class="form-group">
              <label for="PubliArchivo">Inserte la foto(opcional):</label>
              <input type="file" class="form-control" id="PubliArchivo" required>
              <div class="invalid-feedback" id="pubArchivoFeedback"></div>
          </div>
            
          <div class="modal-footer">
            <button type="submit" id="btnEnviarPublicacion" class="btn btn-primary" >Publicar</button>
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
      nonce="zUxEq08J"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="validarPublicacion.js" defer></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const selectProvincia = document.getElementById("ProvinciaOrigen");
    const selectLocalidad = document.getElementById("LocalidadOrigen");
    

    selectProvincia.addEventListener("change", function () {
        const idProvincia = selectProvincia.value;

        // Limpia las opciones actuales de localidad
        selectLocalidad.innerHTML = "<option selected>Selecciona la localidad</option>";

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
});
</script>
  </body>
</html>