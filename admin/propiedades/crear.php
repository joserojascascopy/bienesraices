<?php
// Base de datos
require '../../includes/config/database.php';
$db = connectBD();

// Consultar a la base de datos

$consultaVendedores = "SELECT * FROM vendedores";
$resultadoVendedores = mysqli_query($db, $consultaVendedores);

// Arreglo con mensajes de errores

$errores = [];

// Inicializamos las variables para evitar errores, si la página se carga por primera vez, las variables estarán definidas como cadenas vacías

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

// Ejecutar el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // Para leer las imagenes y los archivos se usa el superglobal files
    
    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    // Validar y Sanitizar
    // La función mysqli_real_escape_string() en PHP se utiliza para escapar caracteres especiales en una cadena antes de usarla en una consulta SQL, lo que ayuda a prevenir inyecciones SQL

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('y/m/d');

    // Asignar files hacia una variable

    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "El precio es obligatorio";
    }

    if (strlen($descripcion < 50)) {
        $errores[] = "Debe tener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "El número de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores[] = "El número de baños es obligatorio";
    }

    if (!$estacionamiento) {
        $errores[] = "El número de estacionamiento es obligatorio";
    }

    if (!$vendedorId) {
        $errores[] = "Selecciona un vendedor";
    }

    if(!$imagen['name'] || $imagen['error']) { // PHP limita por default a 2 MB las imagenes, si tratamos de subir una imagen mas pesada, PHP retorna un tamaño cero pero tambien retorna que hay un error
        $errores[] = 'La imagen es obligatoria';
    }

    // Validar por el tamaño de img (1 mb máximo)

    $medida = 1000 * 1000;

    if($imagen['size'] > $medida) {
        $errores[] = "El tamaño de la imagen no puede ser mayor a 100 Kb";
    }

    // Revisar si el array de errores esta vacio

    if (empty($errores)) {
        // SUBIDA DE ARCHIVOS

        // Crear una carpeta

        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes); // Para crear un directorio
        }

        // Generar un nombre único para no sobre escribir las imagenes

        $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

        // Subir la imagen 

        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); // Valores: nombre temporal y la carpeta y nombre

        // Insertar a la base de datos

        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES
        ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redireccionar al usuario para que no vuelvan a enviar el mismo formulario, o duplicar entradas en la base de datos
            header('Location: /admin/?resultado=1');
        }
    }
}

// Header
require '../../includes/funciones.php';
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a class="boton boton-verde" href="../index.php">Volver</a>
    <!-- Mostrar mensaje de error en el DOM -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo "*" . $error ?>
        </div>
    <?php endforeach; ?>
    <!-- El atributo enctype="multipart/form-data" es necesario si queremos subir algun archivo al formulario, debemos habilitar cualquiera sea el lenguaje backend para poder leer los archivos  -->
    <form class="form" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo" value="<?php echo $titulo; ?>">

            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" placeholder="Precio" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <label for="habitaciones">Habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 1" min="1" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor">
                <option value="">-- Seleccione un vendedor --</option>
                <?php while($row = mysqli_fetch_assoc($resultadoVendedores)) : ?>
                    <option <?php echo $vendedorId === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id'] ?>"> 
                    <?php echo $row['nombre'] . " " . $row['apellido'] ?> </option>
                <?php endwhile; ?>

            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

</main> <!-- main -->

<?php
addTemplate('footer');
?>