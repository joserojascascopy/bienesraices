<?php 

require '../../includes/app.php';
use App\Vendedor;

$auth = auth();

if(!$auth) {
    header('Location: /index.php');
}

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin/index.php');
}

// Traemos el registro de vendedor por su id 

$vendedor = Vendedor::find($id);

// Arreglo con mensajes de errores

$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $args = $_POST['vendedor'];

    // Sincronizar el objeto en memoria con lo que el usuario escribe en el formulario
    $vendedor->sincronizar($args);

    $errores = $vendedor->validar();

    if(empty($errores)) {
        $resultado = $vendedor->guardar();

        if ($resultado) {
            header('Location: /admin/?resultado=6');
        }
    }
}

// Header
addTemplate('header');
?>

<main class="contenedor seccion">

    <h1>Actualizar Vendedor/a</h1>
    <a class="boton boton-verde" href="../index.php">Volver</a>
    <!-- Mostrar mensaje de error en el DOM -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo "*" . $error ?>
        </div>
    <?php endforeach; ?>

    <form class="form" method="POST" action="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>">
        <?php include '../../includes/templates/form_vendedores.php'; ?>
        <input type="submit" value="Actualizar Vendedor/a" class="boton boton-verde">
    </form>

</main> <!-- main -->

<?php
addTemplate('footer');
?>