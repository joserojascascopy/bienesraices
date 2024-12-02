<?php

namespace App;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    // Validacion

    public function validar() {
        if (!$this->nombre) {
            self::$errores[] = "Ingrese un nombre";
        }

        if (!$this->apellido) {
            self::$errores[] = "Ingrese un apellido";
        }

        if (!$this->telefono) {
            self::$errores[] = "Ingrese un número de telefono";
        }

        if(!preg_match('/[0-9]{10}/', $this->telefono)) { // preg_match() = Funcion regular
            self::$errores[] = "Ingrese un número de telefono válido";
        }

        return self::$errores;
    }
}