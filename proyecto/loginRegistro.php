<?php  
//Maneja del inicio de sesión y el registro de usuario para todas las páginas que tengan login y registro
session_start();

include_once 'base de datos/gestorbd.php';
$gestor = new GestorVeryDeli();


$mostrarLogin = false;

if(isset($_SESSION['usuario'])) {
    $usuario = $gestor->fetch_usuario_por_id($_SESSION['usuario']);
} else if (isset($_POST['btnEnviarRegistro'])) { // Manejar el registro de un nuevo usuario

    $nombre = trim($_POST['registroNombre']);
    $apellido = trim($_POST['registroApellido']);
    $dni = trim($_POST['registroDni']);
    $correo = trim($_POST['registroEmail']);
    $localidad = $_POST['Localidad'];
    $domicilio = trim($_POST['domicilio']);
    $contraseña = trim($_POST['registroPwd']);
    $repeatcontraseña = trim($_POST['registroPwdConfirm']);

    // Verificar si el usuario ya existe
    if ($gestor->usuario_yaExiste($correo)) {
        $errorLogin = "El correo electrónico ya pertenece a una cuenta. Por favor inicie sesión.";
        $mostrarLogin = true;
    } else {
        // Insertar el nuevo usuario
    $_SESSION['nombre'] = $nombre;
      $_SESSION['apellido'] = $apellido;  // Cambiar 2 por el ID de usuario real
      $_SESSION['dni'] = $dni; // Cambiar 4 por el ID de publicación real
      $_SESSION['correo'] = $correo;
      $_SESSION['localidad'] = $localidad;
      $_SESSION['domicilio'] = $domicilio;
      $_SESSION['contraseña'] = $contraseña;

      // Redirige a insertar_postulante.php
      header("Location: insertar_usuario.php");
      exit();
           
        }
} else if (isset($_POST['btnEnviarLoginphp'])) { // Manejar el inicio de sesión

    $correo = trim($_POST['loginEmail']);
    $contraseña = trim($_POST['loginPwd']);

    // Consulta para verificar las credenciales y obtener el idUsuario
    $resultado = $gestor->verificar_contraseña($correo, $contraseña);
    $resultado1 = $gestor->verificar_credenciales_usuario($correo, $contraseña);

    if ($resultado == 1) {
        $fila = mysqli_fetch_assoc($resultado1); // Obtener los resultados como un array asociativo
        $_SESSION['usuario'] = $fila["idUsuario"]; // Almacenar el idUsuario en la sesión
        header("refresh: 0");
        exit();
    } else {
        $errorLogin = "Usuario o contraseña incorrectos.";
        $mostrarLogin = true;
    }
}