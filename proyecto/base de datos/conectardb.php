<?php
$host = "localhost";
$bd = "very_deli";
$usuario = "user_personas";
$pwd = "45382003";

mysqli_report(MYSQLI_REPORT_OFF);
$conexion = new mysqli($host, $usuario, $pwd, $bd);
if($conexion->connect_errno) { 
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
}
mysqli_set_charset($conexion, 'utf8mb4');