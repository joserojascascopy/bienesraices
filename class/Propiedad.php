<?php

namespace App;

class Propiedad
{
    // DB

    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    // Conexión a la DB

    public static function setDB($database)
    {
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

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar()
    {
        if (isset($this->id) && !$this->id == '') {
            // Actualizar
            return $this->actualizar();
        } else {
            // Creando un nuevo registro
            return $this->crear();
        }
    }

    public function crear()
    {
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

        return $resultado;
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al usuario para que no vuelvan a enviar el mismo formulario, o duplicar entradas en la base de datos
            header('Location: /admin/?resultado=2');
        }
    }

    // Eliminar un registro

    public function eliminar()
    {
        // Eliminar la
        $query = "DELETE FROM propiedades WHERE id = ";
        $query .= self::$db->escape_string($this->id);

        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->eliminarImagen();
            header('Location: /admin/?resultado=3');
        }
    }

    // Identificar y unir los atributos de la BD

    public function atributos()
    {
        $atributos = [];

        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Subida de archivos

    public function setImagen($imagen)
    {
        // Eliminar la imagen previa

        if (isset($this->id)) {
            // Comprobar si existe el archivo (si existe id estamos actualizando)

            $this->eliminarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar Imagen

    public function eliminarImagen()
    {
        if (isset($this->id)) {
            // Comprobar si existe el archivo (si existe id estamos actualizando/eliminando)

            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if ($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
    }

    // Validación

    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
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

        if (!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria';
        }

        return self::$errores;
    }

    // Lista todas las propiedades

    public static function all()
    {
        $query = 'SELECT * FROM propiedades';

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Actualizar propiedades por su id

    public static function find($id)
    {
        // Consulta a la DB por id de la propiedad
        $query = "SELECT * FROM propiedades WHERE id = {$id}";
        $resultado = self::consultarSQL($query);

        // return $resultado[0];
        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // Consultar la DB

        $consulta = self::$db->query($query);

        // Iterar los resultados

        $array = [];

        while ($registro = $consulta->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        // Liberar la memoria

        $consulta->free();

        // Retornar los resultados

        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincronizar el objeto en memoria con los cambios realizados por el usuario

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}

// Active Record es un patrón de arquitectura que se utiliza para aplicaciones que almacenan datos en Bases de Datos y hay un CRUD
// Cada Tabla en la base de datos tiene una clase que contiene los mismos atributos que columnas en la BD