<?php
require_once("conexion.php");
$conn = create_conection("RINCON");
if (is_null($conn)) {
    http_response_code(500);
    exit;
}

// Traer categorías y tamaños para los filtros
$categorias = execute_query($conn, "SELECT * FROM categoria WHERE id_categoria != 0 ORDER BY nombre_categoria");
$tamanos = execute_query($conn, "SELECT * FROM tamano ORDER BY id_tamano");

// Traer productos, categorías, tamaños y precios en una sola consulta
$data = execute_query($conn, "
  SELECT
    m.id_menu,
    m.nombre_menu,
    m.foto_menu,
    c.id_categoria,
    c.nombre_categoria,
    t.nombre_tamano,
    mt.precio
  FROM menu m
    INNER JOIN categoria    c  ON m.id_categoria = c.id_categoria
    LEFT  JOIN menu_tamano  mt ON m.id_menu       = mt.id_menu
    LEFT  JOIN tamano       t  ON mt.id_tamano     = t.id_tamano
  WHERE m.id_categoria != 0
  ORDER BY c.nombre_categoria, m.id_menu, t.id_tamano
");

// Calcular el precio máximo
$precioMax = 0;
foreach ($data as $r) {
    if (isset($r['precio']) && $r['precio'] > $precioMax) {
        $precioMax = $r['precio'];
    }
}
// Si no hay productos, pon un valor por defecto
if ($precioMax < 1000) $precioMax = 10000;

// Agrupar productos por categoría y por producto
$productosPorCategoria = [];
foreach ($data as $r) {
    $cat = $r['nombre_categoria'];
    $id  = $r['id_menu'];
    if (!isset($productosPorCategoria[$cat])) $productosPorCategoria[$cat] = [];
    if (!isset($productosPorCategoria[$cat][$id])) {
        $productosPorCategoria[$cat][$id] = [
            'nombre_menu'   => $r['nombre_menu'],
            'foto_menu'     => $r['foto_menu'],
            'precios'       => []
        ];
    }
    if ($r['nombre_tamano']) {
        $productosPorCategoria[$cat][$id]['precios'][] = [
            'nombre_tamano' => $r['nombre_tamano'],
            'precio'        => $r['precio']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ---------- METADATOS Y ESTILOS ---------- -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Librerías externas y hojas de estilo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title>Carta</title>
</head>

<body class="bg-dark text-light">
    <!-- ---------- HEADER ---------- -->
    <?php include_once "html/header.html"?>
    
    <!-- ---------- SECCIÓN PRINCIPAL / BANNER ---------- -->
    <section class="home" id="inicio">
        <div class="contenido">
            <img id="Foto" data-aos="fade-up" data-aos-delay="150" src="./images/logo-grande.png" alt="banner">
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
                    <input type="range" id="precio-slider" min="0" max="<?= $precioMax ?>" step="100" value="<?= $precioMax ?>">
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
                <h2 class="categoria-titulo"><?= $categoria["nombre_categoria"]?></h2>
                <div class="productos-lista">
                <?php
                    $catName = $categoria["nombre_categoria"];
                    if (isset($productosPorCategoria[$catName])) {
                        foreach($productosPorCategoria[$catName] as $plato) {
                ?>
                    <div class="producto-card">
                        <div class="producto-img">
                            <?php if ($plato["foto_menu"]): ?>
                                <img src="<?= htmlspecialchars($plato["foto_menu"]) ?>" alt="<?= htmlspecialchars($plato["nombre_menu"]) ?>">
                            <?php else: ?>
                                <img src="images/no-image.png" alt="Sin imagen">
                            <?php endif; ?>
                        </div>
                        <div class="producto-info">
                            <div class="producto-nombre"><?= htmlspecialchars($plato["nombre_menu"]) ?></div>
                            <div class="producto-precios">
                                <?php foreach($plato["precios"] as $prop) { ?>
                                    <div><?= htmlspecialchars($prop["nombre_tamano"]); ?><br><span>$<?= number_format($prop["precio"],0,',','.') ?></span></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                ?>
                </div>
            </section>
            <?php } 
            ?>
        </main>
    </section>

    <!-- ---------- FOOTER ---------- -->
    <?php include_once "html/footer.html"?>
            
    <!-- ---------- SCRIPTS ---------- -->
    <script src="js/script.js"></script>
    <script src="js/menu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>    
</body>
</html>