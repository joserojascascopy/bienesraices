<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Propiedad;

// Conexión a la DB

$db = connectBD();

Propiedad::setDB($db);