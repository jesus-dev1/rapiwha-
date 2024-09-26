<?php
session_start();
require 'conexion.php';

$mensaje = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['usuario_id']; 

    $nombre_estudiante = $_POST['nombre_estudiante'];
    $apellido_estudiante = $_POST['apellido_estudiante'];
    $correo_estudiante = $_POST['correo_estudiante'];
    $telefono = $_POST['telefono']; 

    $uploadDir = 'uploads/';
    $uploadFiles = [];

    $files = [
        'doc_estudiante' => 'documento_identidad_estudiante',
        'doc_acudiente' => 'documento_identidad_acudiente',
        'historial_medico' => 'historial_medico',
        'certificado_eps' => 'certificado_eps',
        'certificado_escolar' => 'certificado_escolar',
        'foto' => 'foto'
    ];

    foreach ($files as $key => $name) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$key]['tmp_name'];
            $fileName = $_FILES[$key]['name'];
            $filePath = $uploadDir . basename($fileName);

            if (move_uploaded_file($fileTmpPath, $filePath)) {
                $uploadFiles[$name] = $filePath;
            } else {
                die("Error al subir el archivo: " . $_FILES[$key]['name']);
            }
        } else {
            die("Error en la carga del archivo: " . $_FILES[$key]['error']);
        }
    }

    $stmt = $conn->prepare("INSERT INTO matricula (id_usuario, nombre_estudiante, apellido_estudiante, correo_estudiante, telefono, documento_identidad_estudiante, documento_identidad_acudiente, historial_medico, certificado_eps, certificado_escolar, foto, fecha, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pendiente')");
    
    $stmt->bind_param("issssssssss", $id_usuario, $nombre_estudiante, $apellido_estudiante, $correo_estudiante, $telefono, $uploadFiles['documento_identidad_estudiante'], $uploadFiles['documento_identidad_acudiente'], $uploadFiles['historial_medico'], $uploadFiles['certificado_eps'], $uploadFiles['certificado_escolar'], $uploadFiles['foto']);

    if (!$stmt->execute()) {
        die("Error en la inserción en la base de datos: " . $stmt->error);
    }

    $mensaje = "El estudiante está pendiente para matricularse, le llegará un mensaje a su WhatsApp para realizar el pago.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <title>Matrícula</title>
    <style type="text/css">
        .usuario {
            margin-bottom: 10px; 
        }
        .usuario h4 {
            color: #ffffff;
            display: inline; 
            margin: 0 10px 0 0;
        }
        .usuario input {
            display: inline;
            margin-right: 20px;
        }
        .volver {
            color: white;
        }
    </style>
</head>
<body>
<div class="formulario">
    <a class="volver" href="index.html">Volver</a>
    <h1>Matrícula</h1>
    <form method="post" action="matricula.php" enctype="multipart/form-data">
        <div class="usuario">
            <h4>Nombre:</h4>
            <input type="text" name="nombre_estudiante" required>
            <h4>Apellido:</h4>
            <input type="text" name="apellido_estudiante" required>
            <h4>Correo Electrónico:</h4> 
            <input type="email" name="correo_estudiante" required>
            <h4>Teléfono:</h4> 
            <input type="text" name="telefono" required>
        </div>
        
        <div class="usuario">
            <h4>Documento de identidad estudiante:</h4>
            <input type="file" name="doc_estudiante" required>
        </div>

        <div class="usuario">
            <h4>Documento de identidad acudiente:</h4>
            <input type="file" name="doc_acudiente" required>
        </div>

        <div class="usuario">
            <h4>Historial médico:</h4>
            <input type="file" name="historial_medico" required>
        </div>

        <div class="usuario">
            <h4>Certificado Afiliación EPS:</h4>
            <input type="file" name="certificado_eps" required>
        </div>

        <div class="usuario">
            <h4>Certificado Escolar:</h4>
            <input type="file" name="certificado_escolar" required>
        </div>

        <div class="usuario">
            <h4>Foto:</h4>
            <input type="file" name="foto" required>
        </div>

        <input type="submit" value="Subir Archivos">
    </form>

    <?php if ($mensaje): ?>
        <p style='color: white;'><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
</div>
</body>
</html>