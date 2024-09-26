<?php
session_start();
include_once('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];


    $query = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = mysqli_query($conexion, $query);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);

       
        if (password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

        
            if ($usuario['rol'] == 'administrador') {
                header('Location: administrador.php');
            } elseif ($usuario['rol'] == 'acudiente') {
                header('Location: matriculas.php');
            } else {
                echo "Rol no definido.";
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Matrículas Colegio Nuestra Señora de la Paz</title>
    <script>
    function validarFormulario() {
        var correo = document.getElementById("correo").value;
        var contraseña = document.getElementById("contraseña").value;

        if (correo == "" || contraseña == "") {
            alert("Todos los campos son obligatorios.");
            return false;
        }

     
        var correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!correoRegex.test(correo)) {
            alert("Por favor, introduce un correo electrónico válido.");
            return false;
        }

        return true; 
    }
    </script>
</head>
<body>

<div class="formulario">
    <h1>Inicio de Sesión</h1>
    <form method="post" action="login.php" onsubmit="return validarFormulario()">
        
        <br>
        <input type="submit" class="btn" value="Iniciar Sesión">
    </form>
    
    <div class="botones">
        <a href="registro.html" class="btn">Registrarse</a>
        <br><br>
    </div>

    <div class="contact-info">
        <p>Dirección: Carrera 27 Nº 29-65 Sur. Barrio Santander, (Bogotá - Cundinamarca)</p>
        <p>Teléfonos: 203 57 81 - 203 86 22</p>
    </div>
</div>

</body>
</html>