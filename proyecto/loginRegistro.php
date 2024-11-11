<?php  
session_start(); // Inicia la sesión al comienzo del script

include_once "base de datos/gestorbd.php";

$gestor = new GestorVeryDeli();

// Configurar la conexión a la base de datos
$conexion = mysqli_connect('localhost', 'user_personas', '45382003', 'very_deli');
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, 'utf8mb4');

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
        $_SESSION['mensajeRegistro'] = "El correo electrónico ya pertenece a una cuenta. Por favor inicie sesión.";
    } else {
        // Insertar el nuevo usuario
        

        if ($gestor->insertar_usuario($nombre, $apellido, $dni, $correo, $contraseña)) {
            $idUsuario = $gestor->fetch_insert_id(); // Obtiene el último ID insertado en la conexión actual
            $_SESSION['id'] = $idUsuario; // Guardar el ID en la sesión
            header("Location: perfil.php"); // Redirigir solo si se crea con éxito
            exit();
        } else {
            $_SESSION['mensajeRegistro'] = "Error al registrar el usuario: " . mysqli_error($conexion);
        }
    }
}

// Manejar el inicio de sesión
if (isset($_POST['btnEnviarLoginphp'])) {
    $correo = trim($_POST['loginEmail']);
    $contraseña = trim($_POST['loginPwd']);

    // Consulta para verificar las credenciales y obtener el idUsuario
    $resultado = $gestor->verificar_credenciales_usuario($correo, $contraseña);
    

    if ($resultado->num_rows == 1) {
        $fila = mysqli_fetch_assoc($resultado); // Obtener los resultados como un array asociativo
        $_SESSION['id'] = $resultado->fetch_assoc()["idUsuario"]; // Almacenar el idUsuario en la sesión
        header("Location: perfil.php"); // Redirigir solo si el login es exitoso
        exit();
    } else {
        $_SESSION['mensajeLogin'] = "Usuario o contraseña incorrectos.";
    }
}