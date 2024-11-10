<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'user_personas', '45382003', 'very_deli');
mysqli_set_charset($conexion, 'utf8mb4');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['idProvincia'])) {
    $idProvincia = mysqli_real_escape_string($conexion, $_GET['idProvincia']);
    $consulta = "SELECT idLocalidad, Nombrelocalidad FROM localidad WHERE idProvincia = '$idProvincia'";
    $resultado = mysqli_query($conexion, $consulta);

    $localidades = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $localidades[] = $fila;
    }

    echo json_encode($localidades); // Devuelve las localidades en formato JSON
}

mysqli_close($conexion);
?>
