<?php
// Configuración de Supabase
$SUPABASE_URL = "db.oebyxhffvgkatfnqjkfy.subabase.co";
$SUPABASE_KEY = "$$Mentana2025";

// Recibir datos del formulario
$usuario = $_POST['usuario'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$edad = $_POST['edad'] ?? '';
$genero = $_POST['genero'] ?? '';
$educacion = $_POST['educacion'] ?? '';
$estado_civil = $_POST['estado_civil'] ?? '';
$region = $_POST['region'] ?? '';
$comuna = $_POST['comuna'] ?? '';

// Validar
if (!$usuario || !$email || !$password) {
    die("Faltan campos obligatorios.");
}

// Preparar datos para enviar a Supabase
$data = [
    'usuario' => $usuario,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'edad' => $edad,
    'genero' => $genero,
    'educacion' => $educacion,
    'estado_civil' => $estado_civil,
    'region' => $region,
    'comuna' => $comuna
];

// Enviar datos a Supabase (tabla 'usuarios')
$ch = curl_init("$SUPABASE_URL/rest/v1/usuarios");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Prefer: return=minimal"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$data]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code >= 200 && $http_code < 300) {
    echo "<script>alert('Registro exitoso 🎉'); window.location.href='login.html';</script>";
} else {
    echo "Error al registrar: " . $response;
}
?>
