<?php
session_start();

// Verificar que los datos necesarios estén en la sesión
//if (isset($_SESSION['nombre'], $_SESSION['apellido'], $_SESSION['correo'], $_SESSION['contraseña'],$_SESSION['dni'])) {
    // Asigna los valores desde la sesión
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $correo = $_SESSION['correo'];
    $localidad = $_SESSION['localidad'];
    $domicilio = $_SESSION['domicilio'];
    $contraseña = $_SESSION['contraseña'];
    $dni = $_SESSION['dni'];
    require 'base de datos\gestorbd.php';
    $gestor = new GestorVeryDeli();
    // Llama a la función insertar_postulante;
    
   $int = $gestor->insertar_usuario($nombre, $apellido, $dni, $correo, $contraseña, $localidad, $domicilio);
            
            $idUsuario = $gestor->fetch_insert_id(); // Obtiene el último ID insertado en la conexión actual
            $_SESSION['usuario'] = $idUsuario; // Almacenar el idUsuario en la sesión
            
    // Limpia los datos de la sesión
    unset($_SESSION['nombre'], $_SESSION['apellido'], $_SESSION['correo'], $_SESSION['contraseña'],$_SESSION['dni'], $_SESSION['localidad'], $_SESSION['domicilio']);
 
    header("Location:index.php");
            exit();

    // Redirige de vuelta a publicacion.php;
