<?php
require 'includes/funciones.php';
addTemplate('header');
?>

<main class="contenedor-anuncio">
    <h1>Casa en Venta con piscina</h1>
    <div class="auncio">
        <picture>
            <source srcset="./build/img/destacada.webp" type="image/webp">
            <source srcset="./build/img/destacada.jpg" type="image/jpeg">
            <img src="build/img/destacada.jpg" alt="Anuncio 3">
        </picture>
        <div class="contenido-anuncio">
            <p class="precio">$3.000.000</p>
            <ul class="iconos-anuncio">
                <li class="icono">
                    <img src="build/img/icono_wc.svg" alt="Icono WC">
                    <p>3</p>
                </li>
                <li class="icono">
                    <img src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                    <p>3</p>
                </li>
                <li class="icono">
                    <img src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                    <p>4</p>
                </li>
            </ul>
            <p>
                Proin consequat viverra sapien, malesuada tempor tortor feugiat vitae. In dictum felis et nunc
                aliquet molestie. Proin tristique commodo felis, sed auctor elit auctor pulvinar. Nunc porta, nibh
                quis convallis sollicitudin, arcu nisl semper mi, vitae sagittis lorem dolor non risus. Vivamus
                accumsan maximus est, eu mollis mi. Proin id nisl vel odio semper hendrerit. Nunc porta in justo
                finibus tempor. Suspendisse lobortis dolor quis elit suscipit molestie. Sed condimentum, erat at
                tempor finibus, urna nisi fermentum est, a dignissim nisi libero vel est. Donec et imperdiet augue.
                Curabitur malesuada sodales congue. Suspendisse potenti. Ut sit amet convallis nisi.
            </p>
            <p>
                Aliquam lectus magna, luctus vel gravida nec, iaculis ut augue. Praesent ac enim lorem. Quisque ac
                dignissim sem, non condimentum orci. Morbi a iaculis neque, ac euismod felis. Fusce augue quam,
                fermentum sed turpis nec, hendrerit dapibus ante. Cras mattis laoreet nibh, quis tincidunt odio
                fermentum vel. Nulla facilisi.
            </p>
        </div> <!-- .contenido-anuncio -->
    </div> <!-- .anuncio -->
</main> <!-- main -->

<?php
addTemplate('footer');
?>