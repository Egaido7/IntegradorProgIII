<?php  
session_start(); // Inicia la sesión al comienzo del script

// Configurar la conexión a la base de datos
$conexion = mysqli_connect('localhost', 'user_personas', '45382003', 'very_deli');
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, 'utf8mb4');

// Manejar el registro de un nuevo usuario
if (isset($_POST['btnEnviarRegistrophp'])) {
    $nombre = trim($_POST['registroNombre']);
    $apellido = trim($_POST['registroApellido']);
    $dni = trim($_POST['registroDni']);
    $correo = trim($_POST['registroEmail']);
    $contraseña = trim($_POST['registroPwd']);
    $repeatcontraseña = trim($_POST['registroPwdConfirm']);

    // Escapar las entradas para prevenir inyección SQL
    $nombre_escapado = mysqli_real_escape_string($conexion, $nombre);
    $apellido_escapado = mysqli_real_escape_string($conexion, $apellido);
    $dni_escapado = mysqli_real_escape_string($conexion, $dni);
    $correo_escapado = mysqli_real_escape_string($conexion, $correo);
    $contraseña_escapado = mysqli_real_escape_string($conexion, $contraseña);

    // Verificar si el usuario ya existe
    $consulta = "SELECT email FROM usuario WHERE email = '$correo_escapado'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
      $mensajeRegistro = "Usuario ya creado. Por favor inicie sesión.";
    } else {
        // Insertar el nuevo usuario
        $consulta = "INSERT INTO usuario(nombre, apellido, dni, email, contraseña) 
                     VALUES('$nombre_escapado', '$apellido_escapado', '$dni_escapado', '$correo_escapado', '$contraseña_escapado')";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            $_SESSION['email'] = $correo;
            header("Location: index.html");
            exit();
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($conexion);
        }
    }
}

// Manejar el inicio de sesión
if (isset($_POST['btnEnviarLoginphp'])) {
    $correo = trim($_POST['loginEmail']);
    $contraseña = trim($_POST['loginPwd']);

    // Escapar entradas para prevenir inyección SQL
    $correo_escapado = mysqli_real_escape_string($conexion, $correo);
    $contraseña_escapado = mysqli_real_escape_string($conexion, $contraseña);

    // Consulta para verificar las credenciales
    $consulta = "SELECT email FROM usuario WHERE email = '$correo_escapado' AND contraseña = '$contraseña_escapado'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $_SESSION['email'] = $correo;
        header("Location: buscador.php");
        exit();
      } else {
        // Aquí se muestra el mensaje de "usuario incorrecto"
        $errorMensaje = "Usuario incorrecto. Por favor, intente nuevamente.";
    }
}

// Cerrar la conexión
mysqli_close($conexion);
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
  </head>
<body>
  <button id="botoninicial" type="button" data-bs-toggle="modal" data-bs-target="#loginModal" style="border: none;">
    <img class="user__avatar" 
    alt="Ingresar"
  />
</button>

<!-- MODAL Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel">Iniciar Sesión</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formLogin"  method = "POST" action= "" novalidate>
          <div class="form-group">
            <label for="loginEmail">Correo Electrónico:</label>
            <input type="email" class="form-control" id="loginEmail" name = "loginEmail" required>
            <div class="invalid-feedback" id="loginEmailFeedback"></div>
          </div>
          <div class="form-group">
            <label for="loginPwd">Contraseña:</label>
            <input type="password" class="form-control" name ="loginPwd" id="loginPwd" required minlength="8">
            <div class="invalid-feedback" id="loginPwdFeedback"></div>
          </div>
          <div class="invalid-feedback" id="msgErrorLogin">
          <?php 
        if (!empty($errorMensaje)) {
            echo $errorMensaje;
        }
    ?>
          </div>

          <div class="modal-footer">
            <button type="submit" id="btnEnviarLogin" name= "btnEnviarLoginphp" class="btn btn-primary">Iniciar Sesión</button>
            <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">Crear nueva cuenta</button>
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
        <form id="formRegistro" method = "POST" action= "" novalidate>
          <div class="form-group">
            <label for="registroNombre">Nombre:</label>
            <input type="text" class="form-control" id="registroNombre" name = "registroNombre" required pattern="[a-zA-Z]{2,}">
            <div class="invalid-feedback" id="regNombreFeedback"></div>
          </div>
          <div class="form-group">
            <label for="registroApellido">Apellido:</label>
            <input type="text" class="form-control" id="registroApellido" name= "registroApellido" required pattern="[a-zA-Z]{2,}">
            <div class="invalid-feedback" id="regApellidoFeedback"></div>
          </div>
          <div class="form-group">
            <label for="registroDni">DNI:</label>
            <input type="text" class="form-control" id="registroDni" name= "registroDni" required pattern="^[1-9]\d{7,9}">
            <div class="invalid-feedback" id="regDniFeedback" ></div>
          </div>
          <div class="form-group">
            <label for="registroEmail">Correo Electrónico:</label>
            <input type="email" class="form-control"  name = "registroEmail" id="registroEmail" required>
            <div class="invalid-feedback" id="regEmailFeedback"></div>
          </div>
          <div class="form-group">
            <label for="registroPwd">Contraseña:</label>
            <input type="password" class="form-control" name = "registroPwd" id="registroPwd" required minlength="8">
            <div class="invalid-feedback" id="regPwdFeedback"></div>
          </div>
          <div class="form-group">
            <label for="registroPwdConfirm">Confirmar Contraseña:</label>
            <input type="password" class="form-control" id="registroPwdConfirm"  name = "registroPwdConfirm"required>
            <div class="invalid-feedback" id="regPwdConfirmFeedback"></div>
          </div>
          <div class="invalid-feedback" id="msgErrorRegistro">
          <?php 
        if (!empty($errorMensaje)) {
            echo $errorMensaje;
        }
    ?>
        </div>
          <div class="modal-footer">
            <button type="submit" name = "btnEnviarRegistro" id="btnEnviarRegistrophp" class="btn btn-primary">Registrarme</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="validarRegistro.js" defer></script>


    

  
</body>
</html>