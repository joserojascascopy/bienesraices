<?php
// Accedemos al id de la propiedad a mostrar, del enlace

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /');
}

// Importamos la DB

require 'includes/config/database.php';

// Guardamos la instancia de la conexión en una variable

$db = connectBD();

// Realizamos la consulta a la DB

$query = "SELECT * FROM propiedades WHERE id = $id";
$resultado = mysqli_query($db, $query);

if(!$resultado -> num_rows) {
    header('Location: /');
}

// Formateamos el resultado de la consulta a un objeto

$propiedad = mysqli_fetch_assoc($resultado);

require 'includes/funciones.php';
addTemplate('header');
?>

<main class="contenedor-anuncio">
    <h1><?php echo $propiedad['titulo']; ?></h1>
    <div class="auncio">
        <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio 3">
        <div class="contenido-anuncio">
            <p class="precio">$ <?php echo number_format($propiedad['precio']); ?></p>
            <ul class="iconos-anuncio">
                <li class="icono">
                    <img src="build/img/icono_wc.svg" alt="Icono WC">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li class="icono">
                    <img src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li class="icono">
                    <img src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>
            <p><?php echo $propiedad['descripcion']; ?></p>
        </div> <!-- .contenido-anuncio -->
    </div> <!-- .anuncio -->
</main> <!-- main -->

<?php
addTemplate('footer');

// Cerrar la conexión de la DB

mysqli_close($db);
?>