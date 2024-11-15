<?php
 extract($_GET);
 $_SESSION["publicacion"] = $idPublicacion;
 header("Location: publicacion.php");
    exit();
?>