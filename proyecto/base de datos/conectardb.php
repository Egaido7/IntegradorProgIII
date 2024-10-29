<?php
$host = "localhost";
$bd = "very_deli";
$usuario = "user_personas";
$pwd = "45382003";

mysqli_report(MYSQLI_REPORT_OFF);
$conexion = new mysqli($host, $usuario, $pwd, $bd);
if($conexion->connect_errno) { ?>
    <script>
        alert("Error al conectar con la base de datos.\n<?= $conexion->connect_error?>.");
    </script>
<?php }