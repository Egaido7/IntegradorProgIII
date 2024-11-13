<?php  

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
    $contraseña = trim($_POST['registroPwd']);
    $repeatcontraseña = trim($_POST['registroPwdConfirm']);

    // Verificar si el usuario ya existe
    if ($gestor->usuario_yaExiste($correo)) {
        $errorLogin = "El correo electrónico ya pertenece a una cuenta. Por favor inicie sesión.";
        $mostrarLogin = true;
    } else {
        // Insertar el nuevo usuario
        if ($gestor->insertar_usuario($nombre, $apellido, $dni, $correo, $contraseña)) {
            
            $idUsuario = $gestor->fetch_insert_id(); // Obtiene el último ID insertado en la conexión actual
            $_SESSION['usuario'] = $idUsuario; // Almacenar el idUsuario en la sesión
            header("refresh: 0");
            exit();
        } else {
            $errorRegistro = "Error al registrar el usuario.";
            $mostrarLogin = true;
        }
    }
} else if (isset($_POST['btnEnviarLoginphp'])) { // Manejar el inicio de sesión

    $correo = trim($_POST['loginEmail']);
    $contraseña = trim($_POST['loginPwd']);

    // Consulta para verificar las credenciales y obtener el idUsuario
    $resultado = $gestor->verificar_credenciales_usuario($correo, $contraseña);
    

    if ($resultado->num_rows == 1) {
        $fila = mysqli_fetch_assoc($resultado); // Obtener los resultados como un array asociativo
        $_SESSION['usuario'] = $fila["idUsuario"]; // Almacenar el idUsuario en la sesión
        header("refresh: 0");
        exit();
    } else {
        $errorLogin = "Usuario o contraseña incorrectos.";
        $mostrarLogin = true;
    }
}