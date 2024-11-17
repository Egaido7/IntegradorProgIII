<?php
session_start();

// Verificar que los datos necesarios estén en la sesión
if (isset($_POST['actualizarNombre'], $_POST['actualizarApellido'], $_POST['actualizarLocalidad'], $_POST['actualizarDomicilio'], $_POST['actualizarPwd'])) {
    // Asigna los valores desde la sesión
  
    $nombre = $_POST['actualizarNombre'];
    $apellido = $_POST['actualizarApellido'];
    $localidad = $_POST['actualizarLocalidad'];
    $domicilio = $_POST['actualizarDomicilio'];
    $contraseña = $_POST['actualizarPwd'];
    require 'base de datos\gestorbd.php';
    $gestor = new GestorVeryDeli();
    // Llama a la función insertar_postulante;
    
    $idUsuario = $_SESSION['usuario']; // Obtiene el último ID insertado en la conexión actual
    $userdata = $gestor->fetch_nombre_usuario_por_id($idUsuario);
    
    $int = $gestor->actualizar_usuario( $idUsuario, $localidad, $domicilio, $contraseña, $nombre, $apellido);
    $userdataNuevo = $gestor->fetch_nombre_usuario_por_id($idUsuario);
    if($userdata["nombre"] != $userdataNuevo["nombre"] || $userdata["apellido"] != $userdataNuevo["apellido"]) {
        $gestor->usuario_quitar_responsable($idUsuario);
    }

    header("Location:perfil.php");
    exit();
}else{
    echo "<p>no se pudo cambiar los datos, ingrese nuevamente</p>";
}

    // Redirige de vuelta a publicacion.php;