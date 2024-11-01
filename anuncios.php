<?php
require 'includes/funciones.php';
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Casas y Departamentos en Venta</h1>

    <?php
    $limite = 6;
    addTemplate('anuncios', false, $limite);

    ?>

</main> <!-- main -->

<?php
addTemplate('footer');

// Cerrar la conexión a la DB

mysqli_close($db);

?>