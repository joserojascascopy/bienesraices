<?php
require '../includes/app.php';

$auth = auth();

if(!$auth) {
    header('Location: /index.php');
}

// Importar clases
use App\Propiedad;
use App\Vendedor;

// Implementar un método para obtener todas las propiedades y vendedores

$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

// Muestra un mensaje condicional

$resultado = intval($_GET['resultado'] ?? null);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validar id
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    $tipo = $_POST['tipo'];

    if(validarTipoContenido($tipo)) {
        // Comparar el tipo para la acción del metodo
        if($tipo == 'propiedad') {
            $propiedad = Propiedad::find($id);

            $propiedad->eliminar();

            if($resultado) {
                header('Location: /admin/?resultado=3');
            }
        } else if($tipo == 'vendedor') {
            $vendedor = Vendedor::find($id);

            $vendedor->eliminar();

            if($resultado) {
                header('Location: /admin/?resultado=4');
            }
        }
    }
}

// Include un template
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php 
        $mensaje = mostrarMensaje($resultado);

        if($mensaje) : ?>
            <p class="alerta exito"><?php echo s($mensaje); ?></p>
        <?php endif ?>

    <h2>Propiedades</h2>
    <a class="boton boton-verde" href="./propiedades/crear.php">Nueva Propiedad</a>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($propiedades as $propiedad) : ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo ?> </td>
                    <td> <?php echo "$ " . $propiedad->precio; ?> </td>
                    <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"> </td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="./propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Vendedores</h2>
    <a class="boton boton-verde" href="./vendedores/crear.php">Nuevo/a Vendedor/a</a>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vendedores as $vendedor) : ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td> <?php echo $vendedor->telefono; ?> </td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="./vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</main> <!-- main -->

<?php
addTemplate('footer');
?>