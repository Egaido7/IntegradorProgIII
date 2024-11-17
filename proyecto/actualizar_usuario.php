<?php
session_start();

// Verificar que los datos necesarios estén en la sesión
if (isset($_POST['actualizarLocalidad'], $_POST['actualizarDomicilio'], $_POST['actualizarPwd'])) {
    // Asigna los valores desde la sesión
  
    $localidad = $_POST['actualizarLocalidad'];
    $domicilio = $_POST['actualizarDomicilio'];
    $contraseña = $_POST['actualizarPwd'];
    require 'base de datos\gestorbd.php';
    $gestor = new GestorVeryDeli();
    // Llama a la función insertar_postulante;
    
    $idUsuario = $_SESSION['usuario']; // Obtiene el último ID insertado en la conexión actual

   $int = $gestor->actualizar_usuario( $idUsuario, $localidad, $domicilio, $contraseña);

   header("Location:perfil.php");
   exit();
}else{
    echo "<p>no se pudo cambiar los datos, ingrese nuevamente</p>";
}

    // Redirige de vuelta a publicacion.php;