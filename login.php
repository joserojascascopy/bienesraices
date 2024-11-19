<?php
require 'includes/app.php';
$db = connectBD();

// Autenticar el usuario

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = 'El email es obligatorio o no es válido';
    }

    if (!$password) {
        $errores[] = 'La contraseña es obligatoria';
    }

    if (empty($errores)) {
        // Revisar si el usuario existe

        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($db, $query);

        // Resultado de la consulta

        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario['email'] === $email) {
            // Revisar si el password es correcto o no

            $auth = password_verify($password, $usuario['password']);

            if ($auth) {
                // El usuario esta autenticado

                session_start();

                //Llenar el arreglo de la sesión

                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;


                header('Location: /admin/index.php');
            } else {
                // la contraseña es incorrecta

                $errores[] = "La contraseña es incorrecta";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}

// Include Header
addTemplate('header');
?>

<main class="contenedor-login seccion">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error) : ?>
        <p class="alerta error">*<?php echo $error; ?></p>
    <?php endforeach ?>

    <form method="POST" class="form" action="login.php"> <!-- Podemos agregar el atributo novalidate para sacar la validacion predeterminada del front -->
        <fieldset>
            <legend>Email y Contraseña</legend>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Tú e-mail" id="email" name="email"> <!-- Agregar el atributo required para que sea obligatorio los campos, parte de la validacion del front -->

            <label for="password">Nombre</label>
            <input type="password" placeholder="Tú contraseña" id="password" name="password">


        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton-contacto">
    </form>
</main> <!-- main -->

<?php
addTemplate('footer');

// Cerrar la conexión a la DB

mysqli_close($db);

?>