<?php
// Importar la base de datos 

// require 'includes/config/database.php'; // La ruta debe ser relativa al index.php
$db = connectBD(); // Instancia de la conexión

// Consulta a la BD

$query = "SELECT * FROM propiedades LIMIT $limite";

// Resultado de la consulta

$resultadoConsulta = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">
    <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)) : ?>
        <div class="card">
            <img  loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio 2">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio">$ <?php echo number_format($propiedad['precio']); ?></p>
                <ul class="iconos-caracteristicas">
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
                <a href="anuncio.php?id=<?php echo $propiedad['id'] ?>" class="boton-amarillo-block">Ver Propiedades</a>
            </div> <!-- .contenido-anuncio -->
        </div> <!-- .card -->
    <?php endwhile; ?>
</div> <!-- .contenedor-auncios -->

<?php

mysqli_close($db); // Finalizara la conexión a la DB

?>