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
</head>

<body>
  <!-- header starts -->
  <div class="header">
    <div class="header__left">
      <img src="LogoVeryDeli.svg" alt="Logo" class="logo">
      <div class="header__input" id="header_busqueda">
        <span class="material-icons"> search </span>
        <input type="text" placeholder="Buscar publicaciones" id="barraBusqueda" />
      </div>
    </div>

    <div class="header__middle" id="header_medio">
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
        <img
          class="user__avatar"
          
          alt="" />
          <?php if(isset($_SESSION["id"])) { 
    echo "<h1>Bienvenido a su sesion " ($_SESSION['id']) . "</h1>";
}
?>
<h4>hola</h4>
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
  <!-- header ends -->

  <!-- main body starts -->
  <div class="main__body">
    <!-- sidebar starts -->
    <div class="sidebar">
      <div class="sidebarRow">
        <img
          class="user__avatar"
          src = "";
          alt="" />
        <h4>Somanath Goudar</h4>
      </div>

      <div class="sidebarRow">

        <h4>Filtros</h4><br>

      </div>
      <div class="sidebarRow">
        <h5>Provincias Filtro</h5><br>
      </div>

      <div class="sidebarRow">

        <select class="form-select" aria-label="Default select example">
          <option selected>Provincias Disponibles</option>
          <option value="1">San Luis</option>
          <option value="2">Buenos Aires</option>
          <option value="3">Mendoza</option>
        </select>
      </div>




    </div>
    <!-- sidebar ends -->

    <!-- feed starts -->
    <div class="feed">

      <!-- message sender ends -->

      <!-- post starts -->
      <div class="post">
        <?php
        require 'base de datos\gestorbd.php';

        $publicacionController = new GestorVeryDeli();
        $publicacionController->mostrar_publicaciones();
        ?>
        <div class="post__top">
          <img
            class="user__avatar post__avatar"
            src = "";
            alt="" />
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
          src = "";
            alt="" />
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
          <img
            class="user__avatar post__avatar"
            src = "";
            alt="" />
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
          <img
            class="user__avatar post__avatar"
            src = "";
            alt="" />
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
</body>

</html>