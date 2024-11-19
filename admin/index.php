<?php
require '../includes/app.php';

$auth = auth();

if(!$auth) {
    header('Location: /index.php');
}

// Conexión a la DB

$db = connectBD();

// Escribir el query
$query = "SELECT * FROM propiedades";

// Consultar la BD

$resultadoConsulta = mysqli_query($db, $query);

// Muestra un mensaje condicional

$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        // Eliminar el archivo
        $query = "SELECT imagen FROM propiedades WHERE id = $id";
        $resultado = mysqli_query($db, $query);
        $nombreImagen = mysqli_fetch_assoc($resultado);

        $carpetaImagenes = '../imagenes/';
        unlink($carpetaImagenes . $nombreImagen['imagen']);

        // Elimina la propiedad 
        $query = "DELETE FROM propiedades WHERE id = $id";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin/?resultado=3');
        }
    }
}

// Include un template
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if (intval($resultado) === 1) : ?>
        <p class="alerta exito">Anuncio Creado Correctamente</p>
    <?php elseif (intval($resultado) === 2) : ?>
        <p class="alerta exito">Anuncio Actualizado Correctamente</p>
    <?php elseif (intval($resultado) === 3) : ?>
        <p class="alerta exito">Anuncio Eliminado Correctamente</p>
    <?php endif; ?>
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
            <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td> <?php echo $propiedad['id']; ?> </td>
                    <td> <?php echo $propiedad['titulo']; ?> </td>
                    <td> <?php echo "$ " . $propiedad['precio']; ?> </td>
                    <td> <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla"> </td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">

                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="./propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
</main> <!-- main -->

<?php
// Cerrar la conexión a la BD

mysqli_close($db);

addTemplate('footer');
?>