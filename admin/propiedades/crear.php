<?php
require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

auth();

// Consultar a la base de datos

$consultaVendedores = "SELECT * FROM vendedores";
$resultadoVendedores = mysqli_query($db, $consultaVendedores);

$vendedorId = '';

// Arreglo con mensajes de errores

$errores = Propiedad::getErrores();

// Ejecutar el codigo despues de que el usuario envia el formulario

$propiedad = new Propiedad;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crea una nueva instancia al mandar el formulario

    $propiedad = new Propiedad($_POST['propiedad']);

    // SUBIDA DE ARCHIVOS

    // Crear una carpeta

    $carpetaImagenes = '../../imagenes/';

    if (!is_dir($carpetaImagenes)) {
        mkdir($carpetaImagenes); // Para crear un directorio
    }

    // Generar un nombre único para no sobre escribir las imagenes

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // Setear la imagen 

    // Realiza un resize a la imagen con la libreria "intervention/image"

    if ($_FILES['imagen']['tmp_name']) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($_FILES['imagen']['tmp_name'])->resize(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    // Validar

    $errores = $propiedad->validar();

    // Revisar si el array de errores esta vacio

    if (empty($errores)) {
        // Subir la imagen al servidor

        $resultado = $propiedad->guardar();

        $image->save($carpetaImagenes . $nombreImagen); 

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
        <?php include '../../includes/templates/form_propiedades.php'; ?>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

</main> <!-- main -->

<?php
addTemplate('footer');
?>