<?php
session_start();

// Obtener y validar el parámetro idPublicacion
$idPublicacion = filter_input(INPUT_GET, 'idPublicacion', FILTER_SANITIZE_NUMBER_INT);

if (!$idPublicacion) {
    die("ID de publicación no válido.");
}

// Asignar a la sesión
$_SESSION["publicacion"] = $idPublicacion;

// Redirigir a la página de publicación
header("Location: publicacion.php");
exit();
?>