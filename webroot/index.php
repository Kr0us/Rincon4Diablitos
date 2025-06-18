<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="css/footer.css">
    <title>Rincon De Los 4 Diablitos</title>
</head>
<body>

    <?php include_once "html/header.html "?>

    <section class="home" id="inicio">
        <div class="contenido">
            <img data-aos="fade-up" data-aos-delay="150" src="./images/logo-grande.png" alt="banner">
            <h3 data-aos="fade-up" data-aos-delay="300">El Rincon de los 4 Diablitos</h3>
            <p data-aos="fade-up" data-aos-delay="450"></p>
            <a data-aos="fade-up" data-aos-delay="600" href="menu.php" class="btn">Ver menu</a>
        </div>
    </section>

    <section class="servicio">
        <div class="caja" data-aos="fade-up" data-aos-delay="150">
            <i class="fas fa-pizza-slice"></i>
            <h3>La mejor calidad</h3>
            <p></p>
        </div>

        <div class="caja" data-aos="fade-up" data-aos-delay="450">
            <i class="fas fa-headset"></i>
            <h3>Domingo a Jueves de 19:00 a 01:00
                <p></p>
                Viernes y Sabado de 19:00 a 03:00</h3>
            <p></p>
        </div>
    </section>

    <section class="about" id="acercade">
        <div class="imagen" data-aos="fade-right" data-aos-delay="150">
            <img src="./images/about-img.png" alt="">
        </div>

        <div class="contenido" data-aos="fade-left" data-aos-delay="150">
            <h3 class="titulo">Prueba nuestras mejores recetas</h3>
            <p></p>
            <div class="iconos">
                <h3><i class="fas fa-check"></i> Los mejores precios </h3>
                <h3><i class="fas fa-check"></i> El mejor servicio </h3>
                <h3><i class="fas fa-check"></i> Rapidas entregas </h3>
                <h3><i class="fas fa-check"></i> Ingredientes frescos </h3>
                <h3><i class="fas fa-check"></i> Productos naturales</h3>
                <h3><i class="fas fa-check"></i> Veganos y no veganos</h3>
        </div>
            <!--<a href="#" class="btn">Leer mas</a>-->
        </div>
    </section>

    <section class="ubicacion" ">
        <div class="heading" id="separador">
            <img src="./images/titulo-encabezado.png" alt="encabezado">
            <h3 id="ubicacion">Ubicacion</h3>
        </div>

        <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3327.78928514629!2d-70.57324232355414!3d-33.480836399070235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662d11280f468cb%3A0xb82336b550fd371b!2sel%20rinc%C3%B3n%20de%20los%204%20diablitos!5e0!3m2!1sen!2scl!4v1749165353498!5m2!1sen!2scl" width="1000" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            <div class="form">
                <div class="iconos-container">
                    <div class="iconos" data-aos="fade-up" data-aos-delay="150">
                        <a href="https://maps.app.goo.gl/8NvsjcprEHpqshRaA" target="_blank" rel="noopener noreferrer"><i class="fas fa-map"></i></a>
                        <h3>Como llegar</h3>
                        <p>Esmeralda 6367, Penalolen</p>
                    </div>

                    <div class="iconos" data-aos="fade-up" data-aos-delay="300">
                        <a href="https://www.instagram.com/el_rincon_de_los_4_diablitos/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                        <h3>Instagram</h3>
                        <p>@el_rincon_de_los_4_diablitos</p>
                    </div>

                    <div class="iconos" data-aos="fade-up" data-aos-delay="450">
                        <a href="https://wa.me/56979592806" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a>
                        <h3>Whatsapp</h3>
                        <p>+569 79592806</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <h1>test</h1>

    <section class="blogs" id="blog">
        <div class="heading" id="separador">
            <img src="./images/titulo-encabezado.png" alt="encabezado">
            <h3>Nuestras publicaciones</h3>
        </div>
        <div class="caja-container">
            <div class="caja" data-aos="fade-up" data-aos-delay="150">
                <div class="imagen">
                    <img src="./images/Hamburguesas/chacarero.png" alt="blog">
                    <div class="iconos">
                        <a href="#"><i class="fas fa-calendar"> 18 Septiembre 2023</i></a>
                        <a href="#"><i class="fas fa-user"> por: Chef Guille</i></a>
                    </div>
                </div>
                <div class="contenido">
                    <h3>Hamburguesas</h3>
                    <p></p>
                    <!--<a href="#" class="btn">Leer mas</a>-->
                </div>
            </div>

            <div class="caja" data-aos="fade-up" data-aos-delay="300">
                <div class="imagen">
                    <img src="./images/pizzas/pizzeta.png" alt="blog">
                    <div class="iconos">
                        <a href="#"><i class="fas fa-calendar"> 18 Septiembre 2023</i></a>
                        <a href="#"><i class="fas fa-user"> por: Chef Guille</i></a>
                    </div>
                </div>
                <div class="contenido">
                    <h3>Pizzetas</h3>
                    <p></p>
                    <!--<a href="#" class="btn">Leer mas</a>-->
                </div>
            </div>

            <div class="caja" data-aos="fade-up" data-aos-delay="450">
                <div class="imagen">
                    <img src="./images/Completos/completos.jpg" alt="blog">
                    <div class="iconos">
                        <a href="#"><i class="fas fa-calendar"> 18 Septiembre 2023</i></a>
                        <a href="#"><i class="fas fa-user"> por: Chef Guille</i></a>
                    </div>
                </div>
                <div class="contenido">
                    <h3>Completos</h3>
                    <p></p>
                    <!--<a href="#" class="btn">Leer mas</a>-->
                </div>
            </div>
        </div>
    </section>

    <?php include_once "html/footer.html "?>

    
    
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>


</body>
</html>

