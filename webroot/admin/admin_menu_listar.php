<?php
    require_once realpath(__DIR__."/..")."/conexion.php";

    $conn = create_conection("RINCON");
    if (is_null($conn)) {
        http_response_code(500);
        exit;
    }

    // Obtener tamaños disponibles
    $tamanos = execute_query($conn,"SELECT id_tamano, nombre_tamano FROM tamano;");
    // Obtener categorías disponibles
    $categorias = execute_query($conn,"SELECT id_categoria, nombre_categoria FROM categoria;");
    // Obtener menú con nombre y categoría
    $menu = execute_query($conn,"
                                SELECT m.nombre_menu, c.nombre_categoria 
                                FROM menu m
                                INNER JOIN categoria c ON m.id_categoria = c.id_categoria");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Productos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/test.css">
</head>
<body class="bg-dark text-light">

    <?php include_once "../html/header.html"?> <!-- Encabezado del sitio -->

    <!-- ---------- SECCIÓN PRINCIPAL / BANNER ---------- -->
    <section class="home" id="inicio">
        <div class="contenido">
            <img id="Foto" data-aos="fade-up" data-aos-delay="150" src="../images/logo-grande.png" alt="banner">
            <h3 data-aos="fade-up" data-aos-delay="300">Carta</h3>
            <p data-aos="fade-up" data-aos-delay="450"></p>
        </div>
        <!-- Buscador -->
        <div class="busqueda">
            <form action="#" class="busqueda-container">
                <input type="text" id="busqueda-input" placeholder="Buscar...">
                <button type="submit" class="busqueda-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </section>

    <!-- ---------- BOTÓN Y OVERLAY DE FILTROS ---------- -->
    <button id="filtros-toggle" class="filtros-toggle" aria-label="Mostrar filtros">
        <i class="fas fa-sliders-h"></i> Filtros
    </button>
    <div id="filtros-overlay" class="filtros-overlay"></div>

    <!-- ---------- CONTENEDOR PRINCIPAL DEL MENÚ Y FILTROS ---------- -->
    <section class="menu-contenedor">
        <!-- ---------- FILTROS LATERALES ---------- -->
        <aside class="filtros-lateral" id="filtros-lateral">
            <h3>Filtrar:</h3><br>
            <button type="button" class="reset-filtros">Reset</button><br>
            <!-- Filtro por precio -->
            <div class="filtro-bloque">
                <span class="filtro-titulo">Precio</span>
                <div class="filtro-precio-slider">
                    <div class="precio-valor" id="precio-slider-valor">$0</div>
                    <input type="range" id="precio-slider" min="0" max="6000" step="100" value="0">
                </div>
            </div>
            <!-- Filtro por categoría -->
            <div class="filtro-bloque">
                <span class="filtro-titulo">Categoría</span>
                <?php foreach($categorias as $categoria) { ?>
                    <label>
                        <input type="checkbox" class="filtro-categoria" value="<?= strtolower(str_replace(' ', '', $categoria["nombre_categoria"])) ?>">
                        <?= $categoria["nombre_categoria"];?>
                    </label>
                <?php } ?>
            </div>
            <!-- Filtro por tamaño -->
            <div class="filtro-bloque">
                <span class="filtro-titulo">Tamaño</span>
                <?php foreach($tamanos as $tam) { ?>
                    <label><input type="checkbox" class="filtro-tamano" value="normal"><?=$tam["nombre_tamano"];?></label>
                <?php } ?>
            </div>
            <button class="aplicar-filtros">Aplicar</button>
        </aside>
        
        <!-- ---------- MENÚ PRINCIPAL (PRODUCTOS) ---------- -->
        <main class="menu-principal">
            <?php foreach($categorias as $categoria) { ?>
            <section class="menu-categoria">
                <!-- Título de la categoría -->
                <h2 class="categoria-titulo"><?= $categoria["nombre_categoria"]?></h2>
                <div class="productos-lista">
                <?php  foreach($menu as $plato) {
                    // Mostrar solo los platos de la categoría actual
                    if(strcmp($plato["nombre_categoria"], $categoria["nombre_categoria"]) == 0) {
                    $nombre = $plato['nombre_menu'];
                    $cat = $categoria["nombre_categoria"];
                    // Obtener propiedades del menú (tamaños, precios, etc.)
                    $plato["propiedades"] = execute_query($conn, "CALL obtener_propiedades_de_menu('$nombre', '$cat');");     
                ?>
                <div class="producto-card d-flex align-items-stretch">
                    <div class="producto-img">
                        <!-- Imagen del producto según la categoría -->
                        <img src="../images/<?=$categoria["nombre_categoria"];?>/<?=trim(strtolower($categoria["nombre_categoria"]));?>.jpg" alt="<?= $plato["nombre_menu"]?>">
                    </div>
                    <div class="producto-info flex-grow-1">
                        <div class="producto-nombre"><?= $plato["nombre_menu"]?></div>
                        <div class="producto-precios">
                            <!-- Mostrar precios por tamaño -->
                            <?php foreach($plato["propiedades"] as $prop) { ?>
                                <div><?= $prop["nombre_tamano"]; ?><br><span>$<?= $prop["precio"]; ?></span></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-3 gap-2">
                        <a href="admin_menu_editar.php?nombre=<?=urlencode($plato["nombre_menu"])?>&categoria=<?=urlencode($categoria["nombre_categoria"])?>" class="btn btn-warning mb-2">Editar</a>
                        <a href="admin_menu_eliminar.php?nombre=<?=urlencode($plato["nombre_menu"])?>&categoria=<?=urlencode($categoria["nombre_categoria"])?>" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
                <?php }} ?>
                </div>
            </section>
            <?php } ?>  
        </main>
    </section>

    <?php include_once "../html/footer.html"?> <!-- Pie de página del sitio -->

    <!-- Bootstrap 5 JS (opcional) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
     <!-- ---------- SCRIPTS ---------- -->
    <script src="../js/script.js"></script>
    <script src="../js/menu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>                       

</body>
</html>
</body>
</html>
