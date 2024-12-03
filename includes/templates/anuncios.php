<?php
use App\Propiedad;

if($_SERVER['SCRIPT_NAME'] === '/index.php') {
    $propiedades = Propiedad::getLimit(3);
}else {
    $propiedades = Propiedad::all();
}

?>

<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad) : ?>
        <div class="card">
            <img  loading="lazy" src="imagenes/<?php echo $propiedad->imagen; ?>" alt="Anuncio 2">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo; ?></h3>
                <p><?php echo $propiedad->descripcion; ?></p>
                <p class="precio">$ <?php echo number_format($propiedad->precio); ?></p>
                <ul class="iconos-caracteristicas">
                    <li class="icono">
                        <img src="build/img/icono_wc.svg" alt="Icono WC">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>
                    <li class="icono">
                        <img src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                    </li>
                    <li class="icono">
                        <img src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                    </li>
                </ul>
                <a href="anuncio.php?id=<?php echo $propiedad->id ?>" class="boton-amarillo-block">Ver Propiedades</a>
            </div> <!-- .contenido-anuncio -->
        </div> <!-- .card -->
    <?php endforeach; ?>
</div> <!-- .contenedor-auncios -->