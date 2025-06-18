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
    <?php include_once "html/header.html "?>
    
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
                        <img src="images/<?=$categoria["nombre_categoria"];?>/<?=trim(strtolower($categoria["nombre_categoria"]));?>.jpg" alt="<?= $plato["nombre_menu"]?>">
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
        </main>
    </section>

    <?php include_once "html/footer.html "?>
			
    <script src="js/script.js"></script>
    <script src="js/menu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>    
</body>
</html>