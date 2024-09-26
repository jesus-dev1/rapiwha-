<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_rol'] = $usuario['rol'];  

            if ($usuario['rol'] == 'administrador') {
                header("Location: administrador.php"); 
            } else {
                header("Location: cupos.php"); 
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="formulario">
    <h1>Inicio de Sesión</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="usuario">
            <input type="text" name="correo" placeholder="Correo electrónico" required>
        </div>
        <div class="usuario">
            <input type="password" name="contraseña" placeholder="Contraseña" required>
        </div>
        <input type="submit" value="Iniciar Sesión">
    </form>
</div>

</body>
</html>