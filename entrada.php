<?php
require 'includes/funciones.php';
addTemplate('header');
?>

<main class="contenedor-entrada seccion">
    <h1>Consejos para mantener la piscina limpia</h1>
    <picture>
        <source srcset="build/img/destacada2.webp" type="image/webp">
        <source srcset="build/img/destacada2.jpg" type="image/jpeg">
        <img src="build/img/destacada2.jpg" alt="Imagen Piscina">
    </picture>
    <div class="contenido-entrada">
        <p class="texto-entrada">Escrito el: <span>26/10/2024</span> por: <span>Admin</span></p>
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
    </div> <!-- .contenido-entrada -->
</main> <!-- main -->

<?php
addTemplate('footer');
?>