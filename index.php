<?php
session_start();

require 'database.php';

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Smartbikes</title>
    <link rel="stylesheet" href="index/css/estilos.css">
    <script src="https://kit.fontawesome.com/0ec3a0af1a.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <?php if (!empty($user)) : ?>
                    <a href="/logout.php" class="menu5">LOGOUT <i class="fas fa-sign-out-alt"></i></a>
                    <?php else :?>
                    <a href="/login.php" class="menu4">LOGIN <i class="fas fa-user-circle"></i></a>
                    <?php endif; ?>
                    <a href="#foot" class="menu4">CONTACTO</a>
                </div>
                <div class="menu">
                    <i class="fas fa-bars"></i>
                </div>
            </section>
        </nav>
    </header>

    <!--PRIMERA SECCION-->
    <div class="contenedor-seccion1">
        <section class="introduccion">
            <div class="contenedor-parrafo">
                <section class="slide-parrafo slides">
                    <div class="slide1">
                        <h1 class="glicthed">¿QUE ES SMARTBIKES?</h1>
                        <p>Smartbikes es una aplicación de IoT (Internet of Things), que permitirá monitorear, registrar, y medir la calidad del aire en distintos puntos de la Pontificia Universidad Javeriana conociendo su ubicación GPS, a fin de tener una
                            base de datos que permita analizar la calidad del aire en la universidad en diferentes horarios y zonas a traves de una red sensores (WSN).</p>
                    </div>
                    <div class="slide1">
                        <h1 class="glicthed">¿COMO FUNCIONA?</h1>
                        <p>Se instalará un dispositivo en la parte frontal de la bicleta. Éste permitira conocer la calidad del aire alrededor, a traves de un sensor de calidad de aire MQ-135, y generará una alerta al usuario cuando la calidad de aire se encuentra
                            en un rango nocivo para su salud. Además, registrará la calidad de aire en cada punto de la universidad que visite cada usuario y generará un "mapa de calor" a traves de de una aplicación web, en donde se vera reflejada la calidad
                            de aire en distintas zonas de la universidad junto a algunos datos adicionales.
                        </p>
                    </div>
                </section>
            </div>
            <div class="contenedor-imagen">
                <section class="slide-imagen slides">
                    <div class="slide2">
                        <img src="index/Img/IoT-2.png" alt="">
                        <p>Arquitectura general de una aplicación IoT</p>
                    </div>
                    <div class="slide2">
                        <img src="index/png/bike-nodoc.png" alt="">
                        <p>Dispositivo smartbike </p>
                    </div>
                </section>
            </div>
        </section>
        <div class="slidebutton">
            <div class="bar"></div>
        </div>
        <div class="smooth-button"></div>
    </div>
    <div class="separador"></div>
    <section class="seccion2">
        <div class="contenendor-titulo">
            <div class="titulo">Nuestros servicios</div>
            <div class="linea-titulo"></div>
        </div>
        <div class="contenedor-servicios">
            <div class="servicio s1">
                <div class="descripcion">
                    Ubicación en tiempo real
                </div>
                <img src="/index/Img/ubicacion.JPG" alt="">
            </div>
            <div class="servicio s2">
                <div class="descripcion">
                    Mapa de calor de calidad de aire
                </div>
                <img src="/index/Img/heatmap.JPG" alt="">
            </div>
        </div>
        <div class="contenedor-servicios">
            <div class="servicio s3">
                <div class="descripcion">
                    Analítica
                </div>
                <img src="/index/Img/graficas.JPG" alt="">
            </div>
            <div class="servicio s4">
                <div class="descripcion">
                    Consultar calidad de aire por zona
                </div>
                <img src="/index/Img/buscar.JPG" alt="">
            </div>
        </div>
        <div class="acceder-app">
            <span>Para acceder a nuestros servicios o conocer mas sobre Smartbikes <a href="login.php">inicie sesión</a> o <a href="signup.php">registrese</a>.</span>
        </div>
    </section>
    <footer id="foot">
        <h4>CONTACTO </h4>
        <div class="linea"></div>
        <p>Cristhian Santiago Muñoz O.<br> cristhian_munoz@javeriana.edu.co<br>
        </p>
        <p> Juan Pablo Carvajal A.<br> carvajal_juan@javeriana.edu.co<br>
        </p>
        <p>Sergio Andres Rojas M.<br> s_rojas@javeriana.edu.co<br>
        </p>

    </footer>
    <script src="index/js/main.js"></script>
</body>

</html>