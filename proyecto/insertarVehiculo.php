<?php
if (isset($_SESSION['patente'], $_SESSION['categoria'], $_SESSION['modelo'],)) {
    // Asigna los valores desde la sesión
    $patente = $_SESSION['patente'];
    $usuario_id = $_SESSION['usuario'];
    $modelo = $_SESSION['modelo'];
    $categoria = $_SESSION['categoria'];
    require 'base de datos\gestorbd.php';
    $publicacionControl = new GestorVeryDeli();
    // Llama a la función insertar_postulante
    $publicacionControl->insertar_vehiculo($patente,$usuario_id ,$modelo, $categoria);

    // Limpia los datos de la sesión
    unset($_SESSION['patente'], $_SESSION['categoria'], $_SESSION['modelo'],);

    // Redirige de vuelta a publicacion.php
    header("Location: perfil.php");
    exit();
} else {
    // Si no hay datos en la sesión, redirige a la página principal (o muestra un error)
    header("Location: perfil.php");
    exit();
}
?>