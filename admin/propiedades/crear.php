<?php
require '../../includes/app.php';
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

auth();

// Base de datos

$db = connectBD();

// Consultar a la base de datos

$consultaVendedores = "SELECT * FROM vendedores";
$resultadoVendedores = mysqli_query($db, $consultaVendedores);

// Arreglo con mensajes de errores

$errores = Propiedad::getErrores();

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
    // Crea una nueva instancia al mandar el formulario

    $propiedad = new Propiedad($_POST);
    
    // SUBIDA DE ARCHIVOS

    // Crear una carpeta

    $carpetaImagenes = '../../imagenes/';

    if(!is_dir($carpetaImagenes)) {
         mkdir($carpetaImagenes); // Para crear un directorio
    }

    // Generar un nombre único para no sobre escribir las imagenes

    $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

    // Setear la imagen 

    // Realiza un resize a la imagen con la libreria "intervention/image"

    if($_FILES['imagen']['tmp_name']) {
        $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
        $propiedad->setImagen($nombreImagen);
    }

    // Validar

    $errores = $propiedad -> validar();

    // Revisar si el array de errores esta vacio

    if (empty($errores)) {
        // Subir la imagen al servidor

        $image->save($carpetaImagenes . $nombreImagen);

        $resultado = $propiedad -> guardar();

        // Mensaje 

        if ($resultado) {
            // Redireccionar al usuario para que no vuelvan a enviar el mismo formulario, o duplicar entradas en la base de datos
            header('Location: /admin/?resultado=1');
        }
    }
}

// Header
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
            <select name="vendedores_id">
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