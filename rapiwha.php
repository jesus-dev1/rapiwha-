<?php
$apiKey = 'IKYJ8UK696OXZX33251Q';
$numero_destino = $_POST['telefono'];


$estado = $_POST['estado'];
if ($estado === 'aprobado') {
    $mensaje = 'El estudiante fue aprobado para la matricula,por favor realizar el pago';
} elseif ($estado === 'rechazado') {
    $mensaje = 'Su solicitud ha sido denegada,Por favor,contactarse con el colegio.';
} else {
    die("Estado no válido");
}
$url = 'https://panel.rapiwha.com/send_message.php';

$datos = [
    'apikey' => $apiKey,
    'number' => $numero_destino,
    'text' => $mensaje,
];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);

$respuesta = curl_exec($ch);
curl_close($ch);
echo $respuesta;
?>