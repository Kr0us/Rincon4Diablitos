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

    <?php include_once "html/header.html"?>

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

    <?php include_once "html/footer.html"?>

    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    
</body>
</html>