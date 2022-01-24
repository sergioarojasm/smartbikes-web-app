<?php 
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $correo = $_POST['email'];
        $clave = $_POST['password'];
        $clave2 = $_POST['confirm_password'];
                
        $message = '';
        
        if (empty($correo) or empty($clave) or empty($clave2)){
            
            $message = '<i style="color: red;">Por favor rellenar todos los campos</i>';
            
        }else{
            
            require 'database.php';
            
            $sql = "SELECT * FROM users WHERE email = '$correo'";
            $stmt = $conn->prepare($sql);
            $stmt -> execute();
            $result = $stmt -> fetch();
            
            if ($result != false){
                $message = '<i style="color: red;">Este usuario ya existe</i>';
            }
            
            if ($clave != $clave2){
                $message = '<i style="color: red;"> Las contraseñas no coinciden</i>';
            }    
            
        }
        
        if ($message == ''){
            $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
              $message = '<i style="color: green;">Nuevo usuario registrado exitosamente</i>';
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
            <h2>REGISTRARSE</h2>
            <span> o <a href="login.php">Iniciar Sesión</a></span>
            <br>
            <?php if(!empty($message)): ?>
             <p><?= $message ?></p>
           <?php endif; ?>

            <form action="signup.php" method="POST">
                <input name="email" type="text" placeholder="Ingrese su email">
                <input name="password" type="password" placeholder="Ingrese su contraseña">
                <input name="confirm_password" type="password" placeholder="Confirme su contraseña">
                <input type="submit" value="Registrarse">
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