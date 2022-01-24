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
<?php if (!empty($user)) : ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensores | Smartbikes</title>
    <link rel="stylesheet" href="/sensores/css/estilos.css">
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
                    <a href="/logout.php" class="menu5">LOGOUT <i class="fas fa-sign-out-alt"></i></a>
                    <a href="#foot" class="menu4">CONTACTO</a>
                </div>
                <div class="menu">
                    <i class="fas fa-bars"></i>
                </div>
            </section>
        </nav>
    </header>
    <!--DIAGRAMA EN BLOQUES-->
    <section class="diagrama-bloques">
        <section class="descripcion">
            <div class="ventana">
                <div class="titulo2">
                    <h3>DIAGRAMA EN</h3>
                    <h4>BLOQUES</h4>
                </div>
                <p>El diagrama en bloques representa la arquitectura IoT de smartbikes a partir de la cual se diseño la solución propuesta. La arquitectura consta de cuatro capas: capa de dispositivos o nodos, gateway y comunicación, servicios
                    en la nube, y finalmente aplicación.
                </p>
            </div>
        </section>
        <div class="contenedor-diagrama">
            <img src="index/png/Diagrama en bloques-2.png" alt="rdsrg">
        </div>
    </section>
    <div class="info">SENSORES</div>
    <div class="separador"></div>
    <!--PRIMERA SECCION-->
    <section class="seccion1">
        <section class="descripcion-bloques">
            <div class="ventana">
                <div class="titulo2">
                    <h1>SENSORES Y </h1>
                    <h2>MICROCONTROLADORES</h2>
                </div>
                <p id="subtitulo1" class="subtitulo"> &rsaquo; Sensor MQ-135</p>
                <p id="item1" class="item-sub"> Sensor de calidad de aire MQ-135</p>
                <p id="item2" class="item-sub"> Esquemático del sensor</p>
                <p id="item3" class="item-sub"> Calibración del sensor</p>
                <p id="subtitulo2" class="subtitulo"> &rsaquo; Modúlo GPS</p>
                <p id="item4" class="item-sub"> Módulo GSP NEO-6M</p>
                <p id="item5" class="item-sub"> Especificaciones</p>
                <p id="subtitulo3" class="subtitulo"> &rsaquo; Microcontrolador ESP8266</p>
                <p id="subtitulo4" class="subtitulo"> &rsaquo; Raspberry Pi3</p>
            </div>
        </section>
        <div class="contendor-slider">
            <div class="slider">
                <div class="MQ135 slide">
                    <h2 class="tit1">SENSOR DE CALIDAD DE AIRE MQ-135</h2>
                    <section>
                        <article>
                            <p>
                                El sensor de calidad del aire MQ135 permite detectar algunos gases peligrosos como Amoniaco, Dioxido de Nitrógeno, Alcohol, Benzeno, Dioxido y Monoxido de carbono. El sensor puede detectar concentraciones de gas entre 10 y 1000 ppm y es de utilidad para
                                detección de gases nocivos para la salud en la industria principalmente. Su velocidad de respuesta es bastante buena, por lo que puede activar cualquier dispositivo de manera oportuna. La presentación es en un módulo que
                                puede conectarse a un microcontrolador muy fácilmente y se incluye la electrónica básica para realizar la interfaz con el sensor, disponemos de salidas del tipo analógica y digital.
                                <br> <br>En este proyecto lo calibraremos y usaremos únicamente para la medición de CO2.
                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/MQ135.jpg" alt="">
                            <img src="/sensores/Img/MQ_pinout.jpg" alt="">
                        </aside>
                    </section>
                </div>
                <div class="MQ135-2 slide">
                    <h2 class="tit1">ESQUEMÁTICO DEL SENSOR</h2>
                    <section>
                        <article>
                            <img src="/sensores/Img/MQ_esq.jpg" alt="">
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/grafica_MQ135.png" alt="">
                        </aside>
                    </section>
                </div>
                <div class="MQ135-3 slide">
                    <h2 class="tit1">CALIBRACIÓN DEL SENSOR</h2>
                    <section>
                        <article>
                            <p>
                                Tomando varios puntos Xi, Yi a partir de la curva de la gráfica correspondiente al CO2 y haciendo una aproximación por mínimos cuadrados podemos obtener el factor de escala y el exponente para el gas que queríamos medir.<br>                                a = 5.5973021420, b = -0.365425824.</p>
                            <div class="ecuaciones">
                                <img src="/sensores/Img/ec1.jpg" alt="">
                                <img src="/sensores/Img/ec2.jpg" alt="">
                            </div>
                            <div class="ecuaciones">
                                <img src="/sensores/Img/ec3.jpg" alt="">
                            </div>
                            <p class="texto">
                                Para calibrar el sensor se requiere una cantidad conocida del gas con una concentración especifica, a fin de leer el valor de la salida analógica y calcular la resistencia del sensor (Rs), con la que podemos calcular el valor de Ro calibrado. </p>
                            <p> Para obtener la resistencia media del sensor pasado el tiempo de precalentamiento calcularemos la resistencia del sensor cada segundo durante 5 minutos y el valor medio obtenido nos sirve para calcular la resistencia de salida
                                del sensor sabiendo la cantidad conocida de gas CO2.
                            </p>
                        </article>
                    </section>
                </div>
                <div class="GPS slide">
                    <h2 class="tit1">MÓDULO GPS NEO-6M</h2>
                    <section>
                        <article>
                            <p>
                                Es un modulo GPS ideal para controlarlo con un microcontrolador, y está basado en el chip receptor NEO 6M. Cuenta con una antena cerámica lista para instalarse en el PCB del chip. La PCB viene provista de conectores para la alimentación y la trasmisión
                                de datos (Vcc, Tx, Rx y GND). Cuenta con una interfaz de comunicaciones asíncrona (UART). Los datos se obtienen en el formato del protocolo NMEA.
                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/GPS.jpg" alt="">
                        </aside>
                    </section>
                </div>
                <div class="GPS2 slide">
                    <h2 class="tit1">ESPECIFICACIONES</h2>
                    <section>
                        <img src="/sensores/Img/GPS_esp1.jpg" alt="">
                        <img src="/sensores/Img/GPS_esp2.jpg" alt="">
                    </section>
                </div>
                <div class="ESP8266 slide">
                    <h2 class="tit1">MODÚLO ESP8266</h2>
                    <section>
                        <article>
                            <p>
                                El ESP8266 es un chip de bajo costo Wi-Fi con un stack TCP/IP completo y un microcontrolador, fabricado por Espressif. El primer chip se hizo conocido en los mercados alrededor de agosto de 2014 con el módulo ESP-01, desarrollado por la empresa AI-Thinker.
                                <br> <br> Se alimenta con 3.3v y dispone de un procesador Tensilica Xtensa LX106 de 80 Mhz, memoria RAM de 64 KB para instrucciones y 96 KB para datos, 16 pines GPIO, pines dedicados UART, e interfaz SPI y I2C.
                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/ESP8266.jpg" alt="">
                        </aside>
                    </section>
                </div>
                <div class="Raspberry slide">
                    <h2 class="tit1">RASPBERRY PI3</h2>
                    <section>
                        <article>
                            <p>
                                Raspberry Pi es un ordenador de placa reducida, ordenador de placa única u ordenador de placa simple (SBC) de bajo costo desarrollado en el Reino Unido por la Raspberry Pi Foundation.
                                <br> <br> La Raspberry Pi esta compuesta por un SoC, CPU, memoria RAM, puertos de entrada y salida de audio y vídeo, conectividad de red, ranura SD para almacenamiento, reloj, una toma para la alimentación, conexiones para
                                periféricos de bajo nivel, entre otros.
                            </p>
                        </article>
                        <aside class="">
                            <img src="/sensores/Img/rasberrypi3.jpg" alt="">
                        </aside>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <footer id="foot">
        <h5>CONTACTO </h5>
        <div class="linea"></div>
        <p>Cristhian Santiago Muñoz O.<br> cristhian_munoz@javeriana.edu.co<br>
        </p>
        <p> Juan Pablo Carvajal A.<br> carvajal_juan@javeriana.edu.co<br>
        </p>
        <p>Sergio Andres Rojas M.<br> s_rojas@javeriana.edu.co<br>
        </p>

    </footer>
    <script src="/sensores/js/main.js"></script>
</body>

</html>
<?php else : 
        header('Location: login.php');
    ?>
    
<?php endif; ?>