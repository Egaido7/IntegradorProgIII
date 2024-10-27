<?php
require 'proyecto\base de datos\gestorbd.php';  // Asegúrate de ajustar la ruta a la clase

$conn = new mysqli('localhost', 'user_personas', '45382003', 'very_deli');
$publicacionController = new GestorVeryDeli($conn);
$publicacionController->mostrar_publicaciones();
?>
