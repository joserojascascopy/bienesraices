<?php
namespace App;

class Propiedad {
    // DB

    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    // Conexión a la DB

    public static function setDB($database) {
        self::$db = $database;
    }

    // Errores

    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // $string = join(', ', array_keys($atributos)); // join(): crea un string apartir de un arreglo (parametros: separador y el arreglo)
        // $values = join(', ', array_values($atributos));
        
        // Insertar a la base de datos

        $query = "INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos)); 
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);
    }

    // Identificar y unir los atributos de la BD

    public function atributos() {
        $atributos = [];

        foreach(self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Validación

    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
    
        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }
    
        if (strlen($this->descripcion < 50)) {
            self::$errores[] = "Debe tener al menos 50 caracteres";
        }
    
        if (!$this->habitaciones) {
            self::$errores[] = "El número de habitaciones es obligatorio";
        }
    
        if (!$this->wc) {
            self::$errores[] = "El número de baños es obligatorio";
        }
    
        if (!$this->estacionamiento) {
            self::$errores[] = "El número de estacionamiento es obligatorio";
        }
    
        if (!$this->vendedores_id) {
            self::$errores[] = "Selecciona un vendedor";
        }
        return self::$errores;
    }
}

// Active Record es un patrón de arquitectura que se utiliza para aplicaciones que almacenan datos en Bases de Datos y hay un CRUD
// Cada Tabla en la base de datos tiene una clase que contiene los mismos atributos que columnas en la BD