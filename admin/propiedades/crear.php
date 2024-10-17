<?php
// Base de datos
require '../../includes/config/database.php';
$db = connectBD();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    echo var_dump($_POST);
    echo "</pre>";

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedorId = $_POST['vendedor'];

    // Insertar a la base de datos

    $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id) VALUES
    ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedorId');";

    $resultado = mysqli_query($db, $query);

    if($resultado) {
        echo "Se agrego correctamente";
    }
}

// Header
require '../../includes/funciones.php';
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a class="boton boton-verde" href="../index.php">Volver</a>

    <form class="form" method="POST" action="/admin/propiedades/crear.php">

        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo">

            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" placeholder="Precio">

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">Descripcion</label>
            <textarea id="descripcion" name="descripcion"></textarea>

        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <label for="habitaciones">Habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1">

            <label for="wc">Baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1">

            <label for="estacionamiento">Estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 1" min="1">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="1">Jose Rojas</option>
                <option value="2">Gaby Araujo</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

</main> <!-- main -->

<?php
addTemplate('footer');
?>