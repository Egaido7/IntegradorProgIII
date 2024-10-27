<?php
$host = "localhost";
$bd = "very_deli";
$usuario = "user_personas"; //faltan datos de usuario
$pwd = "45382003"; //faltan datos de usuario

mysqli_report(MYSQLI_REPORT_OFF);
$conexion = new mysqli($host, $usuario, $pwd, $db);
if($conexion->connect_errno) { ?>
    <script>
        alert("Error al conectar con la base de datos.\n<?= $conexion->connect_error?>.");
    </script>
<?php }