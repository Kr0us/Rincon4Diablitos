<?php
require_once __DIR__ . '/conexion.php';
$conn = create_conection("RINCON");
if (!$conn) { /* manejar error */ }

// 1) Listado de empleados
$empleados = execute_query($conn, "SELECT id_empleado, nombre_empleado FROM empleados");

// 2) Si vino POST, haz el INSERT en opiniones:
if ($_SERVER['REQUEST_METHOD']==='POST') {
    // ... recopilar nombre, email, estrellas, mensaje, id_empleado ...
    $stmt = $conn->prepare(
      "INSERT INTO opiniones (nombre_cliente, correo, estrellas, comentario, id_empleado)
       VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param('ssisi', $nombre, $correo, $estrellas, $comentario, $id_empleado);
    $stmt->execute();
    header("Location: opinion.php?ok=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadatos y enlaces a hojas de estilo y fuentes -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Iconos FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Animaciones AOS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <!-- Fuente Raleway de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <!-- Hojas de estilo personalizadas -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" href="css/opinion.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/logo.png">
</head>

<body>
    <!-- Header del sitio -->
    <?php include_once "html/header.html"?>

    <!-- Sección principal (banner y título) -->
    <section class="home" id="inicio">
            <div class="contenido">
                <!-- Imagen principal del banner -->
                <img id="Foto" data-aos="fade-up" data-aos-delay="150" src="./images/logo-grande.png" alt="banner">
                <!-- Título de la sección -->
                <h3 data-aos="fade-up" data-aos-delay="300">Opiniones</h3>
                <!-- Espacio para descripción o mensaje -->
                <p data-aos="fade-up" data-aos-delay="450"></p>
            </div>
    </section>

    <!-- Sección de opiniones (formulario de contacto) -->
    <section class="opinion" id="opinion">
        <div class="row">
            <div class="form">
                <!-- Formulario para enviar opiniones -->
                <form action="opinion.php" method="POST" >
                    <!-- Campo para nombre -->
                    <input data-aos="fade-up" data-aos-delay="150" type="text" name="nombre" placeholder="Nombre completo" class="cajas" required>
                    <!-- Campo para email -->
                    <input data-aos="fade-up" data-aos-delay="300" type="email" name="email" placeholder="Correo electronico" class="cajas" required>
                    <!-- Campo para puntuacion -->
                    <input data-aos="fade-up" data-aos-delay="400" type="number" name="estrellas" min="1" max="5" placeholder="Puntuacion (1-5 estrellas)" class="cajas" required>
                    <!-- Selector de empleado que atendió -->
                    <select data-aos="fade-up" data-aos-delay="600" name="id_empleado" class="cajas" required>
                        <option value="">Selecciona el empleado</option>
                        <?php foreach($empleados as $emp): ?>
                        <option value="<?= $emp['id_empleado'] ?>">
                        <?= htmlspecialchars($emp['nombre_empleado']) ?> 
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Campo para mensaje -->
                    <textarea data-aos="fade-up" data-aos-delay="600" name="mensaje" placeholder="Escriba un mensaje" class="cajas" cols="30" rows="10" required></textarea>
                    <!-- Botón de envío -->
                    <input data-aos="fade-up" data-aos-delay="400" type="submit" value="Enviar mensaje" class="btn">
                </form>
            </div> 
        </div>
    </section>

    <!-- Footer del sitio -->
    <?php include_once "html/footer.html"?>

    <!-- Scripts para animaciones y funcionalidades -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
