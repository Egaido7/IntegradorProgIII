<?php  

session_start(); // Inicia la sesión al comienzo del script
header('Content-Type: application/json');
$response = ["success" => false, "debug" => []];

include_once "base de datos/gestorbd.php";
$gestor = new GestorVeryDeli();



// Manejar el registro de un nuevo usuario
if (isset($_POST['btnEnviarRegistro'])) {
    $nombre = trim($_POST['registroNombre']);
    $apellido = trim($_POST['registroApellido']);
    $dni = trim($_POST['registroDni']);
    $correo = trim($_POST['registroEmail']);
    $contraseña = trim($_POST['registroPwd']);
    $repeatcontraseña = trim($_POST['registroPwdConfirm']);

    // Verificar si el usuario ya existe
    if ($gestor->usuario_yaExiste($correo)) {
        $response["error"] = "El correo electrónico ya pertenece a una cuenta. Por favor inicie sesión.";
    } else {
        // Insertar el nuevo usuario
        

        if ($gestor->insertar_usuario($nombre, $apellido, $dni, $correo, $contraseña)) {
            $idUsuario = $gestor->fetch_insert_id(); // Obtiene el último ID insertado en la conexión actual
            $_SESSION['id'] = $idUsuario; // Guardar el ID en la sesión
            $_SESSION['logeado'] = true;
            $response["success"] = true;
        } else {
            $response["error"] = "Error al registrar el usuario.";
        }
    }
}

// Manejar el inicio de sesión
if (isset($_POST['btnEnviarLoginphp'])) {

    $response["debug"][] = "Procesando el inicio de sesión";

    $correo = trim($_POST['loginEmail']);
    $contraseña = trim($_POST['loginPwd']);

    // Consulta para verificar las credenciales y obtener el idUsuario
    $resultado = $gestor->verificar_credenciales_usuario($correo, $contraseña);
    

    if ($resultado->num_rows == 1) {
        $fila = mysqli_fetch_assoc($resultado); // Obtener los resultados como un array asociativo
        $_SESSION['id'] = $resultado->fetch_assoc()["idUsuario"]; // Almacenar el idUsuario en la sesión

        $response["debug"][] = "Inicio de sesión exitoso para ID de usuario: " . $fila["idUsuario"];

        $_SESSION['logeado'] = true;
        $response["success"] = true;
    } else {
        $response["error"] = "Usuario o contraseña incorrectos.";
        $response["debug"][] = "Credenciales incorrectas o usuario no encontrado";
    }
}

echo json_encode($response);