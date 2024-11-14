<?php
session_start();
unset($_SESSION['usuario']);
//session_destroy();

$llamador = $_SERVER["HTTP_REFERER"] ?? 'index.php';
header("Location: $llamador");
exit();
?>