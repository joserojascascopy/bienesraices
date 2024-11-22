<?php
require '../../includes/app.php';
$auth = auth();

if (!$auth) {
    header('Location: /index.php');
}
// Validar la URL por ID válido

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin/index.php');
}

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

$propiedad = Propiedad::find($id);

// Consulta para los vendedores
$consultaVendedores = "SELECT * FROM vendedores";
$resultadoVendedores = mysqli_query($db, $consultaVendedores);

$errores = Propiedad::getErrores();

// Ejecutar el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Asignar los atributos

    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    // Validacion

    $errores = $propiedad->validar();

    // Genera un nombre unico

    $carpetaImagenes = '../../imagenes/';

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }
    
    // Revisar si el array de errores esta vacio

    if (empty($errores)) {
        // Almacenar la imagen

        if(isset($image)){
            $image->save($carpetaImagenes . $nombreImagen);
        }

        $resultado = $propiedad->guardar();
    }
}

// Header
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a class="boton boton-verde" href="../index.php">Volver</a>
    <!-- Mostrar mensaje de error en el DOM -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo "*" . $error ?>
        </div>
    <?php endforeach; ?>
    <!-- El atributo enctype="multipart/form-data" es necesario si queremos subir algun archivo al formulario, debemos habilitar cualquiera sea el lenguaje backend para poder leer los archivos  -->
    <form class="form" method="POST" action="/admin/propiedades/actualizar.php?id=<?php echo $id ?>" enctype="multipart/form-data"> <!-- Action nos envia los datos del submit a la página (o archivo) para poder leerlas -->
        <?php include '../../includes/templates/form_propiedades.php' ?>
        <input type="submit" value="Actualizar" class="boton boton-verde">
    </form>

</main> <!-- main -->

<?php
addTemplate('footer');
?>