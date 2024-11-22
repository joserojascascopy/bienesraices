<?php

define('TEMPLATES_URL', __DIR__ . '/templates/');
define('FUNCIONES_URL', __DIR__ .  'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function addTemplate(string $nombre, bool $inicio = false, int $limite = null) {
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