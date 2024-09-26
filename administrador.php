<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'administrador') {
    header("Location: login.php");
    exit();
}

require 'conexion.php';

echo "Bienvenido, Administrador!";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <style>
        body {
            background-image: url("img/fondo.jpg");
            background-size: cover; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            margin: 0;
            font-family: Arial, sans-serif; 
            color: white;
        }

        .banner {
            background-color: #00ebee; 
            padding: 20px;
            text-align: center;
        }

        .banner h1 {
            color: rgba(0, 0, 0, 0.7); 
            font-size: 36px; 
            margin: 0;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); 
            padding: 20px;
            border-radius: 8px; 
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ffffff;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        button {
            margin: 5px;
            padding: 10px;
            background-color: rgba(0,255,0,0.5);
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Banner -->
    <div class="banner">
        <h1>Administrador - Gestión de Matrículas</h1>
    </div>

    <!-- Contenedor principal -->
    <div class="container">
        <h2>Lista de Estudiantes Pendientes</h2>

        <!-- Tabla para listar los datos de los estudiantes -->
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Documento Identidad Estudiante</th>
                    <th>Documento Identidad Acudiente</th>
                    <th>Historial Médico</th>
                    <th>Certificado EPS</th>
                    <th>Certificado Escolar</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT nombre_estudiante, apellido_estudiante, correo_estudiante, telefono, documento_identidad_estudiante, documento_identidad_acudiente, historial_medico, certificado_eps, certificado_escolar, foto FROM matricula WHERE estado = 'pendiente'");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['nombre_estudiante']}</td>";
                    echo "<td>{$row['apellido_estudiante']}</td>";
                    echo "<td>{$row['correo_estudiante']}</td>";
                    echo "<td>{$row['telefono']}</td>";
                    echo "<td><a href='{$row['documento_identidad_estudiante']}' target='_blank'>Ver Documento</a></td>";
                    echo "<td><a href='{$row['documento_identidad_acudiente']}' target='_blank'>Ver Documento</a></td>";
                    echo "<td><a href='{$row['historial_medico']}' target='_blank'>Ver Historial</a></td>";
                    echo "<td><a href='{$row['certificado_eps']}' target='_blank'>Ver Certificado EPS</a></td>";
                    echo "<td><a href='{$row['certificado_escolar']}' target='_blank'>Ver Certificado Escolar</a></td>";
                    echo "<td><a href='{$row['foto']}' target='_blank'>Ver Foto</a></td>";
                    echo "<td>
                            <form action='rapiwha.php' method='post' style='display:inline;'>
                                <input type='hidden' name='telefono' value='{$row['telefono']}'>
                                <input type='hidden' name='estado' value='aprobado'>
                                <button type='submit'>Aprobar</button>
                            </form>
                            <form action='rapiwha.php' method='post' style='display:inline;'>
                                <input type='hidden' name='telefono' value='{$row['telefono']}'>
                                <input type='hidden' name='estado' value='rechazado'>
                                <button type='submit'>Rechazar</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>