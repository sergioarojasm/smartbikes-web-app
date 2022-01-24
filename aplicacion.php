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
    <title>Aplicación | Smartbikes</title>
    <link rel="stylesheet" href="/aplicacion/css/estilos.css">
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
    <?php if (!empty($user)) : ?>
        <section class="seccion1">
        <!--<h1>MAPA - UNIVERSIDAD JAVERIANA</h1>-->
        <div class="contenedor-bienvenidos">
            <div>Bienvenido <i><?= $user['email']; ?></i>.</div>
            <br>Ha iniciado sesión correctamente.
            <br><a href="logout.php"> Cerrar Sesión</a>
        </div>
        <div class="titulo">
            <div class="parte1">Mapas</div>
        </div>
        <div class="linea-titulo"></div>
        <div class="contenedor-mapas">
            <div class="aside">
                <div class="nombre-mapa t1"><span>MAPA DE UBICACIÓN ACTUAL</span></div>
                <div class="datos">- Latitud: <a id="latitud">-</a><br /><br />- Longitud: <a id="longitud">-</a><br /><br />- Calidad de Aire: <a id="aire">-</a><br /><br />- Salida digital: <a id="salidaDigital">-</a></div>
                <p class="actuador">Actuador (LED)</p>
                <div class="botones">
                    <div type='button' class="boton1" onclick='OnOff("ON")'>
                        <p>ON</p>
                    </div>
                    <div type='button' class="boton2" onclick='OnOff("OFF")'>
                        <p>OFF</p>
                    </div>
                </div>
            </div>
            <div id="map" class="mapa"></div>
        </div>
        <div class="contenedor-mapas">
            <div class="aside">
                <div class="nombre-mapa t2"><span>MAPA DE CALOR DE CALIDAD DE AIRE</span></div>
                <div class="datos">Este mapa presenta la calidad del aire en la universidad tomada a partir de sensores MQ-135.
                <br>Mueva el marker a la zona de interes.
                </div>
            </div>
            <div id="map2" class="mapa"></div>
        </div>
        <div class="titulo">
            <div class="parte1">Analítica</div>
            <div class="parte2">de datos</div>
        </div>
        <div class="linea-titulo"></div>
        <div class="contenedor-analitica">
            <div class="thingspeak plot1">
                <iframe width="500" height="300" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1063398/charts/1?bgcolor=%23ffffff&color=%23d62020&days=1&dynamic=true&results=20&title=MEDIDA+CALIDAD+DEL+AIRE&type=line&xaxis=Hora&yaxis=Calidad+del+aire+%28PPM%29&yaxismax=1000&yaxismin=0"></iframe>
            </div>
            <div class="thingspeak plot2">
                <iframe width="455" height="265" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1063398/widgets/183560"></iframe>
            </div>
        </div>
        <div class="contenedor-analitica">
            <div class="thingspeak plot3">
                <iframe width="500" height="300" style="border: 1px solid #cccccc;" src="https://thingspeak.com/apps/matlab_visualizations/348950"></iframe>
            </div>
            <div class="thingspeak plot4">
                <iframe width="500" height="300" style="border: 1px solid #cccccc;" src="https://thingspeak.com/apps/matlab_visualizations/348964"></iframe> </div>
        </div>
        <div class="contenedor-analitica">
            <div class="thingspeak plot5">
                <div class="titulo-desc">CALIDAD DE AIRE POR ZONA</div>
                <div class="descripcion">En la zona (100m alrededor del marker) en la que se encuentra el marker del
                    <span>mapa de calor de calidad de aire</span> se tiene un promedio de:
                </div>
                <p id="promedio">
                    -
                </p>
            </div>
        </div>
    </section>
    <?php else :?>
        <section class="seccion2">
        <div class="acceder-app">
            <h1>BIENVENIDO</h1>
            <p>Para acceder a la aplicación debe:</p>
            <a href="login.php">Iniciar Sesión</a> ¿No tiene cuenta?
            <a href="signup.php">Regístrese</a>
        </div>
    </section>
    <?php endif; ?>
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
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-analytics.js"></script>
    <script src="/aplicacion/js/haversine.js"></script>
    <script src="/aplicacion/js/main.js"></script>
    <script src="/aplicacion/js/mapbox.js"></script>
</body>

</html>