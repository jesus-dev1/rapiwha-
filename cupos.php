<?php
if (isset($_POST['buscar_cupo'])) {
    include_once('conexion.php'); 

    $grado_solicitado = $_POST['grado'] ?? '';
    $nombre_estudiante = $_POST['nombre'] ?? '';
    $documento_estudiante = $_POST['documento'] ?? '';


    if (empty($grado_solicitado) || empty($nombre_estudiante) || empty($documento_estudiante)) {
        echo "Por favor complete todos los campos.";
        exit();
    }

    
    $stmt = $conn->prepare("INSERT INTO cupos (documento_estudiante, nombre_estudiante, grado_solicitado) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $documento_estudiante, $nombre_estudiante, $grado_solicitado);

    if ($stmt->execute()) {
        header("Location: matricula.html");
        exit();
    } else {
        echo "Error al guardar la información: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilos.css">
	<title>Busqueda de cupo</title>
</head>
<body>

<div class="formulario">
	<a class="volver" href="index.html">Cerrar sesión</a>

	<h1>Búsqueda de cupo</h1>
	<form method="post" action="cupos.php">
		<div class="grados">
			<select name="grado" required>
				<option value="" disabled selected>Elija el grado a cursar</option>
				<option value="kinder">Kinder</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
			</select>
		</div>
	
		<div class="usuario">
			<input type="text" name="nombre" placeholder="Nombre del estudiante" required>
		</div>
	
		<div class="usuario">
			<input type="text" name="documento" placeholder="Documento de identidad" required>
		</div>
	
		<input type="submit" name="buscar_cupo" value="Buscar cupo">
	</form>
</div>

</body>
</html>
