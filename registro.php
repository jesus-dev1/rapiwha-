<?php
if (isset($_POST['submit'])) {
    include_once('conexion.php'); 
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    
    $documento_usuario = $_POST['documento'] ?? '';
    $nombres_completos = $_POST['nombres_completos'] ?? '';
    $correo = $_POST['email'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';
    $celular = $_POST['numero_de_telefono'] ?? '';
    $rol = $_POST['tipo_usuario'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $fecha_nacimiento = $_POST['fecha_de_nacimiento'] ?? '';

    if (empty($documento_usuario) || empty($nombres_completos) || empty($correo) || empty($contraseña) || empty($celular)) {
        echo "Por favor complete todos los campos.";
        exit();
    }

    if (!ctype_digit($documento_usuario)) {
        echo "El documento debe contener solo números.";
        exit();
    }

    
    if (!ctype_digit($celular)) {
        echo "El número de celular debe contener solo números.";
        exit();
    }

    if (!ctype_alpha(str_replace(' ', '', $nombres_completos))) {
        echo "El nombre solo debe contener letras.";
        exit();
    }

  
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

  
    $stmt = $conn->prepare("INSERT INTO usuarios (documento_usuario, nombres_completos, correo, contraseña, celular, rol, genero, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $documento_usuario, $nombres_completos, $correo, $contraseña_hash, $celular, $rol, $genero, $fecha_nacimiento);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
        header("Location: login.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <title>Registro</title>
</head>
<body>
  <!--  <style>
        .genero h1{
           text-align: left;
           color: white;
           font-size: 20px;
        }
        .usuario h1{
           text-align: left;
           color: white;
           font-size: 20px;
        }
        .fecha h1{
           text-align: left;
           color: white;
           font-size: 20px;
        }
        .genero{
            color: white;
            text-align: left;
        }
        .volver{
            
            color:white;

        }
    </style>-->

<div class="formulario">
    <a class="volver" href="index.html">Volver</a>

    <h1>Regístrate</h1>

    <form method="post" action="registro.php">
        
        <div class="usuario">
            <input type="text" name="documento" placeholder="Documento" required pattern="\d+" title="Solo se permiten números">
        </div>

       
        <div class="usuario">
            <input type="text" name="nombres_completos" placeholder="Nombres completos" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios">
        </div>

        <div class="usuario">
            <input type="email" name="email" placeholder="Correo electrónico" required>
        </div>

        <div class="usuario">
            <input type="password" name="contraseña" placeholder="Contraseña" required>
        </div>

        <div class="usuario">
            <input type="text" name="numero_de_telefono" placeholder="Número de teléfono" required pattern="\d+" title="Solo se permiten números">
        </div>

       
        <div class="genero">
            <h1>Género</h1>
            <input id="hombre" type="radio" name="genero" value="hombre">
            <label for="hombre">Hombre</label>
            <input id="mujer" type="radio" name="genero" value="mujer">
            <label for="mujer">Mujer</label>
        </div>

       
        <div class="usuario">
            <h1>Tipo de usuario</h1>
            <select name="tipo_usuario" required>
                <option value="">Seleccionar</option>
                <option value="administrador">Administrador</option>
                <option value="acudiente">Acudiente</option>
            </select>
        </div>

        
        <div class="fecha">
            <h1>Fecha de nacimiento</h1>
            <input type="date" name="fecha_de_nacimiento" required>
        </div>

        <input type="submit" name="submit" value="Registrarse">
    </form>
</div>

<script>
    
    document.querySelector('input[name="documento"]').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    document.querySelector('input[name="nombres_completos"]').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });
</script>

</body>
</html>