<?php
session_start(); // Inicia la sesión para manejar variables de sesión

$error = ""; // Inicializa la variable de error para evitar warnings


// Verifica si el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"]; // Obtiene el usuario ingresado
    $password = $_POST["password"]; // Obtiene la contraseña ingresada

    
    require_once realpath(__DIR__."/..")."/conexion.php";
    
    $conn = create_conection("USER");
    if (is_null($conn)) {
        http_response_code(500);
        exit;
    }

    $user_info = execute_query($conn,"SELECT nombre_usuario, contrasena FROM usuarios WHERE nombre_usuario = '$username';");

    // Validación de Usuario
    if (!empty($user_info)) {
        $passwd_hash = $user_info[0]["contrasena"];
        if (password_verify($password, $passwd_hash)) {
            $_SESSION[$user_info[0]["nombre_usuario"]] = true; // Marca la sesión como autenticada
            header("Location: admin_panel2.php"); // Redirige al dashboard de administración
            exit();
        } else {
            $error = "*Contraseña Incorrecta.*"; // Mensaje de error
        }
    } else {
        $error = "*El Usuario no Existe.*";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Configuración de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive -->
    <!-- Enlaces a hojas de estilo y fuentes externas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="../image/png" href="../images/logo.png">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Rincon De Los 4 Diablitos</title>
</head>
<body>

    <?php include_once "../html/header.html"?> <!-- Encabezado del sitio -->

    <section class="login-section">
        <h2>Iniciar Sesión Administrador</h2>
        <!-- Formulario de inicio de sesión -->
        <form action="admin.php" method="POST" class="login-form">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Ingresar</button>
        </form>
        <?php
        // Muestra el mensaje de error si existe
        if (isset($error)) {
            echo "<p style='color:red;font-size:22px;'>$error</p>";
        }
        ?>
    </section>

    <?php include_once "../html/footer.html"?> <!-- Pie de página del sitio -->

    <!-- Scripts JS -->
    <script src="../js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</body>
</html>