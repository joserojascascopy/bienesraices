<?php

define('TEMPLATES_URL', __DIR__ . '/templates/');
define('FUNCIONES_URL', __DIR__ .  'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function addTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "$nombre.php";
}

function auth(): bool {
    session_start();
    $auth = $_SESSION['login'];
    if ($auth) {
        return true;
    }
    return false;
}

// Funciones de Ayuda (Helper)

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido

function validarTipoContenido($tipo) {
    $tipos = ['propiedad', 'vendedor'];

    return in_array($tipo, $tipos);
}

// Mostrar mensajes y/o notificación 

function mostrarMensaje($resultado) {
    $mensaje = '';

    switch($resultado) {
        case 1:
            $mensaje = 'Anuncio Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Anuncio Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Anuncio Eliminado Correctamente';
            break;
        case 4:
            $mensaje = 'Vendedor Eliminado Correctamente';
            break;
        case 5:
            $mensaje = 'Vendedor Registrado Correctamente';
            break;
        case 6:
            $mensaje = 'Vendedor Actualizado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}