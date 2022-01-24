<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $correo = $_POST['email'];
    $clave = $_POST['password'];

    $message = '';

    if (empty($correo) or empty($clave)) {

        $message = '<i style="color: red;">Por favor rellenar todos los campos</i>';
    } else {
        session_start();

        require 'database.php';

        if ($message == '') {
            $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
            $records->bindParam(':email', $_POST['email']);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);

            if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
                $_SESSION['user_id'] = $results['id'];
                header("Location: aplicacion.php");
            } else {
                $message = '<i style="color: red;">Lo sentimos, sus credenciales no coinciden</i>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación | Smartbikes</title>
    <link rel="stylesheet" href="/login/css/estilos.css">
    <script src='/aplicacion/js/mqttws31.js' type='text/javascript'></script>
    <!--Para conectar con la nube-->
    <script src="https://kit.fontawesome.com/0ec3a0af1a.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.9.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.1/mapbox-gl.css" rel="stylesheet" />
    <script src="/aplicacion/js/load_file.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap" rel="stylesheet">
</head>

<body>
    <!--HEADER Y BARRA DE NAVEGACION-->
    <header>
        <nav>
            <section class="contenedor nav">
                <div class="logo2">
                    <a href="/index.php" target="_blank">
                        <span style="color:#EEE6E6">
                            <span style="color:hsl(221, 33%, 53%);">S M A R T </span>B I K E S
                        </span>
                    </a>
                </div>
                <div class="enlaces-header">
                    <a href="/index.php" class="menu1">INICIO</a>
                    <a href="/sensores.php" class="menu2">SENSORES</a>
                    <a href="/aplicacion.php" class="menu3">APLICACIÓN</a>
                    <a href="/login.php" class="menu5">LOGIN <i class="fas fa-user-circle"></i></a>
                    <a href="#foot" class="menu4">CONTACTO</a>
                </div>
                <div class="menu">
                    <i class="fas fa-bars"></i>
                </div>
            </section>
        </nav>
    </header>

    <!--PRIMERA SECCION-->
    <section class="seccion2">
        <div class="acceder-app">
            <h2>INICIAR SESIÓN</h2>
            <!--Falta href="signup.php" del a de abajo-->
            <span> o <a href="signup.php">Registrarse</a></span>
            <br>
            <?php if (!empty($message)) : ?>
            <p>
                <?= $message ?>
            </p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <input name="email" type="text" placeholder="Ingrese su email">
                <input name="password" type="password" placeholder="Ingrese su contraseña">
                <input type="submit" value="Ingresar">
            </form>
        </div>
    </section>
    <footer id="foot">
        <h3>CONTACTO </h3>
        <div class="linea"></div>
        <p>Cristhian Santiago Muñoz O.<br> cristhian_munoz@javeriana.edu.co<br>
        </p>
        <p> Juan Pablo Carvajal A.<br> carvajal_juan@javeriana.edu.co<br>
        </p>
        <p>Sergio Andres Rojas M.<br> s_rojas@javeriana.edu.co<br>
        </p>

    </footer>
    <script src="/login/js/main.js"></script>
</body>

</html>