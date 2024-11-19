<?php

function connectBD() : mysqli {
    $db = new mysqli('localhost', 'root', 'admin', 'bienesraices_crud');

    if(!$db) {
        echo "Error, no se pudo conectar con la Base de Datos";
        exit;
    }

    return $db;
}