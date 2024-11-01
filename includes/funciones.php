<?php

require 'app.php';

function addTemplate(string $nombre, bool $inicio = false, int $limite = null ) {
    include TEMPLATES_URL . "$nombre.php";
}