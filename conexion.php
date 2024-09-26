<?php
$host = 'localhost'; 
$usuario = 'root'; 
$contraseña = ''; 
$nombre_base_datos = 'colegio'; 


$conn = new mysqli($host, $usuario, $contraseña, $nombre_base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
