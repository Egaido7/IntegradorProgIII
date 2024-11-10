<?php
session_start();

// Verificar que los datos necesarios estén en la sesión
if (isset($_SESSION['monto'], $_SESSION['usuario_id'], $_SESSION['publicacion_id'], $_SESSION['estado'])) {
    // Asigna los valores desde la sesión
    $monto = $_SESSION['monto'];
    $usuario_id = $_SESSION['usuario_id'];
    $publicacion_id = $_SESSION['publicacion_id'];
    $estado = $_SESSION['estado'];
    require 'base de datos\gestorbd.php';
    $publicacionControl = new GestorVeryDeli();
    // Llama a la función insertar_postulante
    $publicacionControl->insertar_postulante($usuario_id, $monto, $publicacion_id, $estado);

    // Limpia los datos de la sesión
    unset($_SESSION['monto'], $_SESSION['usuario_id'], $_SESSION['publicacion_id'], $_SESSION['estado'],$_SESSION['id']);

    // Redirige de vuelta a publicacion.php
    header("Location: publicacion.php");
    exit();
} else {
    // Si no hay datos en la sesión, redirige a la página principal (o muestra un error)
    header("Location: publicacion.php");
    exit();
}