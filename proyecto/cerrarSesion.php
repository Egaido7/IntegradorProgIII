<?php
session_start();
session_unset();
session_destroy();

$llamador = $_SERVER["HTTP_REFERER"] ?? 'index.php';
header("Location: $llamador");
exit();
?>