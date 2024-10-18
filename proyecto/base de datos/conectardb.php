<?php
$host = "localhost";
$bd = "very_deli.sql";
$usuario = ""; //faltan datos de usuario
$pwd = ""; //faltan datos de usuario

mysqli_report(MYSQLI_REPORT_OFF);
$conexion = new mysqli($host, $usuario, $pwd, $db);
if($conexion->connect_errno) { ?>
    <script>
        alert("Error al conectar con la base de datos.\n<?= $conexion->connect_error?>.");
    </script>
<?php }