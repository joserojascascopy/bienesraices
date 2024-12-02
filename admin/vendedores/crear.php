<?php 

require '../../includes/app.php';
use App\Vendedor;

$auth = auth();

if(!$auth) {
    header('Location: /index.php');
}

// Instanciamos el objeto de "vendedor" vacío 

$vendedor = New Vendedor;

// Arreglo con mensajes de errores

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crea una nueva instancia al mandar el formulario

    $vendedor = new Vendedor($_POST['vendedor']);

    // Validar

    $errores = $vendedor->validar();

    // Revisar si el array de errores esta vacio

    if (empty($errores)) {
        // Subir la imagen al servidor

        $resultado = $vendedor->guardar();

        if ($resultado) {
            // Redireccionar al usuario para que no vuelvan a enviar el mismo formulario, o duplicar entradas en la base de datos
            header('Location: /admin/?resultado=5');
        }
    }
}

// Header
addTemplate('header');
?>

<main class="contenedor seccion">

    <h1>Registrar Vendedor/a</h1>
    <a class="boton boton-verde" href="../index.php">Volver</a>
    <!-- Mostrar mensaje de error en el DOM -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo "*" . $error ?>
        </div>
    <?php endforeach; ?>

    <form class="form" method="POST" action="/admin/vendedores/crear.php">
        <?php include '../../includes/templates/form_vendedores.php'; ?>
        <input type="submit" value="Registrar Vendedor/a" class="boton boton-verde">
    </form>

</main> <!-- main -->

<?php
addTemplate('footer');
?>