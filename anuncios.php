<?php
require 'includes/app.php';
addTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Casas y Departamentos en Venta</h1>

    <?php
    addTemplate('anuncios', false);
    ?>

</main> <!-- main -->

<?php
addTemplate('footer');

// Cerrar la conexión a la DB

mysqli_close($db);

?>