<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/test.css">
    <link rel="icon" type="image/png" href="images/logo.png">
</head>

<body>
    <?php include_once "html/header.html"?>

    <section class="home" id="inicio">
            <div class="contenido">
                <img id="Foto" data-aos="fade-up" data-aos-delay="150" src="./images/logo-grande.png" alt="banner">
                <h3 data-aos="fade-up" data-aos-delay="300">Opiniones</h3>
                <p data-aos="fade-up" data-aos-delay="450"></p>
            </div>
    </section>

    <!-- Seccion de opiniones -->
    <section class="opinion" id="opinion">
        <div class="row">
            <div class="form">
                <form action="php/contacto.php" method="POST" >
                    <input data-aos="fade-up" data-aos-delay="150" type="text" name="nombre" placeholder="Nombre completo" class="cajas" required>
                    <input data-aos="fade-up" data-aos-delay="300" type="email" name="email" placeholder="Correo electronico" class="cajas" required>
                    <input data-aos="fade-up" data-aos-delay="450" type="number" name="telefono" placeholder="Telefono" class="cajas" required>
                    <textarea data-aos="fade-up" data-aos-delay="600" name="mensaje" placeholder="Escriba un mensaje" class="cajas" cols="30" rows="10" required></textarea>
                    <input data-aos="fade-up" data-aos-delay="750" type="submit" value="Enviar mensaje" class="btn">
                </form>
            </div> 
        </div>
    </section>

    <?php include_once "html/footer.html"?>

    <!--Scripts-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

