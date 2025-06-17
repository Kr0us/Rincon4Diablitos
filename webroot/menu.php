<?php
	function execute_query($conn, $sql) {
        $datos = [];

        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    while ($fila = $result->fetch_assoc()) {
                        $datos[] = $fila;
                    }
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            throw new Exception("Error ejecutando consulta: " . $conn->error);
        }

        return $datos;
    }


	require_once("conexion.php");

	$conn = create_conection();
	if (is_null($conn)) {
		http_response_code(500);
		exit;
	}


    $tamanos = execute_query($conn,"SELECT id_tamano, nombre_tamano FROM tamano;");
	$categorias = execute_query($conn,"SELECT id_categoria, nombre_categoria FROM categoria;");
	$menu = execute_query($conn,"
                                SELECT m.nombre_menu, c.nombre_categoria 
                                FROM menu m
                                INNER JOIN categoria c ON m.id_categoria = c.id_categoria");
    
    for ($i=0; $i<count($menu); $i++) {
        
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
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
	<link rel="icon" type="image/png" href="images/logo.png">
    <title>Carta</title>

</head>

<body>
    <header class="sitio-header">
        <div id="menu-btn" class="fas fa-bars icono"></div>
        <!--<div id="search-btn" class="fas fa-search icono"></div>-->
        <span></span><!--Espacio-->
        <a href="index.php" class="logo"><img src="images/logo.png"></a>

        <!--Barra principal de menu-->
       <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="menu.php">Menu</a>
            <a href="index.php">Acerca de</a>
            <a href="index.php">Ubicacion</a>
            <a href="blog.php">Blog</a>
            <a href="opinion.php">Opiniones</a>
        </nav> 

        <!--Iconos de redes sociales-->
        <div class="iconosSuperior">
            <a href="https://wa.me/56979592806" class="fab fa-whatsapp icono"></a>
            <a href="https://www.instagram.com/el_rincon_de_los_4_diablitos/" class="fab fa-instagram icono"></a>
        </div>
    </header>
    
    <section class="home" id="inicio">
        <div class="contenido">
            <img id="Foto" data-aos="fade-up" data-aos-delay="150" src="./images/logo-grande.png" alt="banner">
            <h3 data-aos="fade-up" data-aos-delay="300">Carta</h3>
            <p data-aos="fade-up" data-aos-delay="450"></p>
        </div>
        <div class="busqueda">
            <form action="#" class="busqueda-container">
                <input type="text" id="busqueda-input" placeholder="Buscar...">
                <button type="submit" class="busqueda-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </section>

    <section class="menu-contenedor">
        <aside class="filtros-lateral">
            <h3>Filtrar:</h3><br>
            <button type="button" class="reset-filtros">Reset</button><br>
            <div class="filtro-bloque">
                <span class="filtro-titulo">Precio</span>
                <div class="filtro-precio-slider">
                    <div class="precio-valor" id="precio-slider-valor">$0</div>
                    <input type="range" id="precio-slider" min="0" max="6000" step="100" value="0">
                </div>
            </div>
            <div class="filtro-bloque">
                <span class="filtro-titulo">Categoría</span>
                <?php foreach($categorias as $categoria) { ?>
                    <label><input type="checkbox" class="filtro-categoria" value="completos"><?=$categoria["nombre_categoria"];?></label>
                <?php } ?>
            </div>
            <div class="filtro-bloque">
                <span class="filtro-titulo">Tamaño</span>
                <?php foreach($tamanos as $tam) { ?>
                    <label><input type="checkbox" class="filtro-tamano" value="normal"><?=$tam["nombre_tamano"];?></label>
                <?php } ?>
            </div>
            <button class="aplicar-filtros">Aplicar</button>
        </aside>
        
        <main class="menu-principal">
			<?php foreach($categorias as $categoria) { ?>
			<section class="menu-categoria">
				<h2 class="categoria-titulo"><?= $categoria["nombre_categoria"]?></h2>
				<?php  foreach($menu as $plato) {
                    if(strcmp($plato["nombre_categoria"], $categoria["nombre_categoria"]) == 0) {
                    $nombre = $plato['nombre_menu'];
                    $cat = $categoria["nombre_categoria"];
                    $plato["propiedades"] = execute_query($conn, "CALL obtener_propiedades_de_menu('$nombre', '$cat');");     
                ?>
				<div class="productos-lista">
				<div class="producto-card">
					<div class="producto-img">
						<img src="images/completos.png" alt="<?= $plato["nombre_menu"]?>">
					</div>
					<div class="producto-info">
						<div class="producto-nombre"><?= $plato["nombre_menu"]?></div>
						<div class="producto-precios">
                            <?php foreach($plato["propiedades"] as $prop) { ?>
							    <div><?= $prop["nombre_tamano"]; ?><br><span>$<?= $prop["precio"]; ?></span></div>
                            <?php } ?>
						</div>
					</div>
				</div>
				<?php }} ?>
				</div>
			</section>
			<?php } ?>  
			
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
    <script src="js/menu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>    
</body>
</html>