<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    echo "Pago realizado exitosamente.";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilos.css">
	<title>pagos</title>
	
<style type="text/css">
/*title{
	margin-bottom: 100px ;
}

h3{
 color: white;
 text-align: center;
}

#caja1{
	background-color: gray;
	width: 250px;
	border-radius: 10px;
	margin-left: 180px;
	}
#caja2{
	background-color: gray;
	width: 250px;
	border-radius: 10px;
	margin-left: 180px;
	}
	.volver{
		color: white;
	}
*/
</style>
</head>
<body>

<div class="formulario">

	<a class="volver" href="index.html">Volver</a>

	<h1>Pagos</h1>

	<form method="post">
						
		<input type="submit" value="Realizar pago"></input>	

</form>

</div>


</body>
</html>