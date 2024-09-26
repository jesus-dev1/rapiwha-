<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] == 'administrador') {
    header("Location: login.php");
    exit();
}

echo "Bienvenido, Usuario!";
?>
