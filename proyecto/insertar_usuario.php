<?php
session_start();

// Verificar que los datos necesarios estén en la sesión
//if (isset($_SESSION['nombre'], $_SESSION['apellido'], $_SESSION['correo'], $_SESSION['contraseña'],$_SESSION['dni'])) {
    // Asigna los valores desde la sesión
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $correo = $_SESSION['correo'];
    $contraseña = $_SESSION['contraseña'];
    $dni = $_SESSION['dni'];
    require 'base de datos\gestorbd.php';
    $gestor = new GestorVeryDeli();
    // Llama a la función insertar_postulante;
    
  $gestor->insertar_usuario($nombre, $apellido, $dni, $correo, $contraseña);
            
            $idUsuario = $gestor->fetch_insert_id(); // Obtiene el último ID insertado en la conexión actual
            $_SESSION['usuario'] = $idUsuario; // Almacenar el idUsuario en la sesión
            
    // Limpia los datos de la sesión
    unset($_SESSION['nombre'], $_SESSION['apellido'], $_SESSION['correo'], $_SESSION['contraseña'],$_SESSION['dni']);
 
    header("Location:index.php");
            exit();

    // Redirige de vuelta a publicacion.php;
