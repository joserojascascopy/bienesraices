<?php

require 'app.php';

function addTemplate(string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php";
}