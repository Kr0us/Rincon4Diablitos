<?php
session_start();

$error = ""; // Inicializa la variable para evitar warnings

// Usuario y contraseña de ejemplo
$usuario_valido = "admin";
$contrasena_valida = "1234";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $usuario_valido && $password === $contrasena_valida) {
        $_SESSION["admin"] = true;
        header("Location: dashboard.php"); // Redirige a la página de administración
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/admin.css">
    <title>Rincon De Los 4 Diablitos</title>
</head>
<body>

    <header class="sitio-header">
        <div id="menu-btn" class="fas fa-bars icono"></div>
        <!--<div id="search-btn" class="fas fa-search icono"></div>-->
        <span></span><!--Espacio-->
        <a href="index.php" class="logo"><img src="images/logo.png"></a>

        <!--Barra principal de menu-->
       <nav class="navbar">
            <a href="index.php">inicio</a>
            <a href="menu.php">Menu</a>
            <a href="#acercade">Acerca de</a>
            <a href="#ubicacion">Ubicacion</a>
            <a href="blog.php">Blog</a>
            <a href="opinion.php">Opiniones</a>
        </nav> 
        <div class="iconosSuperior">
            <a href="https://wa.me/56979592806" class="fab fa-whatsapp icono"></a>
            <a href="https://www.instagram.com/el_rincon_de_los_4_diablitos/" class="fab fa-instagram icono"></a>
        </div>
       
        <form action="" class="busqueda-form">
                <input type="search" name="" placeholder="search here..." id="caja-busqueda">
                <label for="#caja-busqueda" class="fas fa-search icono"></label>
        </form>
    </header>

	<section class="login-section">
        <h2>Iniciar Sesión Administrador</h2>
        <form action="admin.php" method="POST" class="login-form">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Ingresar</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
    </section>

    <footer class="sitio-footer">
        <div class="footer-container">
            <div class="footer-logo">
                <a href="index.php"><img src="images/logo.png" alt="Rincon De Los 4 Diablitos" style="height:60px;"></a>
            </div>
            <div class="footer-links">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="menu.php">Menú</a></li>
                    <li><a href="#acercade">Acerca de</a></li>
                    <li><a href="#ubicacion">Ubicación</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="opinion.php">Opiniones</a></li>
                    <li><a href="admin.php">Admin</a></li>
                </ul>
            </div>
            <div class="footer-contacto">
                <h4>Contacto</h4>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Esmeralda 6367, Peñalolén</li>
                    <li><i class="fas fa-phone"></i> <a href="tel:+56979592806">+56 9 7959 2806</a></li>
                    <li><i class="fab fa-whatsapp"></i> <a href="https://wa.me/56979592806" target="_blank" rel="noopener">WhatsApp</a></li>
                    <li><i class="fab fa-instagram"></i> <a href="https://www.instagram.com/el_rincon_de_los_4_diablitos/" target="_blank" rel="noopener">@el_rincon_de_los_4_diablitos</a></li>
                </ul>
            </div>
            <div class="footer-horario">
                <h4>Horario</h4>
                <ul>
                    <li>Domingo a Jueves: 19:00 - 01:00</li>
                    <li>Viernes y Sábado: 19:00 - 03:00</li>
                </ul>
            </div>
        </div>
        <div class="footer-creditos">
            <p>&copy; 2024 Rincon De Los 4 Diablitos. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    
</body>
</html>