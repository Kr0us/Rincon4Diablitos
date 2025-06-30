<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");
if (is_null($conn)) {
    http_response_code(500);
    exit;
}

// 1) Query principal: traemos id_menu, id_categoria, nombre_categoria, foto, tamaños y precios
$data = execute_query($conn, "
  SELECT
    m.id_menu,
    m.id_categoria,
    m.nombre_menu,
    m.foto_menu,
    c.nombre_categoria,
    t.nombre_tamano,
    mt.precio
  FROM menu m
    INNER JOIN categoria    c  ON m.id_categoria = c.id_categoria
    LEFT  JOIN menu_tamano  mt ON m.id_menu       = mt.id_menu
    LEFT  JOIN tamano       t  ON mt.id_tamano     = t.id_tamano
  ORDER BY c.nombre_categoria, m.id_menu, t.id_tamano
");

// 2) Agrupamos por producto y guardamos también el id_categoria
$menu = [];
foreach ($data as $r) {
    $i = $r['id_menu'];
    if (!isset($menu[$i])) {
        $menu[$i] = [
            'cat_id'    => $r['id_categoria'],
            'categoria' => $r['nombre_categoria'],
            'nombre'    => $r['nombre_menu'],
            'foto'      => $r['foto_menu'],
            'precios'   => []
        ];
    }
    if ($r['nombre_tamano']) {
        $menu[$i]['precios'][$r['nombre_tamano']] = $r['precio'];
    }
}

// 3) Map de ingredientes por producto
$ings = execute_query($conn, "
  SELECT im.id_menu, i.nombre_ingrediente
  FROM ingredientes_menu im
  JOIN ingredientes i ON im.id_ingrediente = i.id_ingrediente
");
$mapIng = [];
foreach ($ings as $row) {
    $mapIng[$row['id_menu']][] = $row['nombre_ingrediente'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Menú</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function confirmDeleteProduct(id) {
      if (!confirm("¿Seguro que deseas eliminar este producto?")) return;
      fetch("eliminar_menu.php?id=" + id, { method: "GET" })
        .then(() => location.reload());
    }
    function confirmDeleteCategory(catId) {
      if (!confirm("¿Eliminar esta categoría Y TODOS sus productos?")) return;
      fetch("eliminar_categoria.php?id_categoria=" + catId, { method: "GET" })
        .then(() => location.reload());
    }
  </script>
</head>
<body class="bg-dark text-light">
  <div class="container mt-3">
    <h1 class="text-center mb-4">Menú Disponible</h1>

    <!-- Enlaces superiores -->
    <div class="d-flex justify-content-between mb-3">
      <div>
        <a href="admin_panel.php" class="btn btn-outline-light">⬅️ Volver al Panel</a>
      </div>
      <a href="admin_menu_agregar.php" class="btn btn-success">➕ Agregar producto</a>
    </div>

    <?php
    $catActual = "";
    foreach ($menu as $id => $p):
        // Si cambia la categoría, cerramos bloque anterior y abrimos uno nuevo
        if ($p['categoria'] !== $catActual):
            if ($catActual !== "") echo "</div>";
            $catActual = $p['categoria'];
            $catId      = $p['cat_id'];
            echo "
              <div class='border border-danger rounded p-4 mb-4'>
                <div class='d-flex justify-content-between align-items-center mb-3'>
                  <h3 class='text-light mb-0'>{$catActual}</h3>
                  <button class='btn btn-sm btn-outline-danger'
                          onclick='confirmDeleteCategory({$catId})'>
                    🗑️ Eliminar categoría
                  </button>
                </div>";
        endif;
    ?>

      <!-- Tarjeta del producto -->
      <div class="d-flex justify-content-between align-items-center bg-secondary rounded p-3 mb-3">
        <div class="d-flex align-items-center">
          <?php if ($p['foto']): ?>
            <img src="../<?=htmlspecialchars($p['foto'])?>"
                 style="width:80px;height:80px;object-fit:cover;border-radius:10px;margin-right:15px;">
          <?php endif; ?>
          <div>
            <h5><?=htmlspecialchars($p['nombre'])?></h5>
            <?php if (!empty($mapIng[$id])): ?>
              <p class="mb-2"><small>
                <strong>Ingredientes:</strong>
                <?=implode(", ", $mapIng[$id])?>
              </small></p>
            <?php endif; ?>
            <div class="d-flex gap-4">
              <?php foreach ($p['precios'] as $tam => $v): ?>
                <div class="text-center">
                  <div class="text-muted"><?=htmlspecialchars($tam)?></div>
                  <div><strong>$<?=number_format($v,0,',','.')?></strong></div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="d-flex flex-column gap-2">
          <a href="editar_menu.php?id=<?=$id?>" class="btn btn-outline-warning">✏️ Editar</a>
          <button onclick="confirmDeleteProduct(<?=$id?>)" class="btn btn-outline-danger">🗑️ Eliminar</button>
        </div>
      </div>

    <?php endforeach;
    if ($catActual !== "") echo "</div>";  // cierre último bloque
    ?>

  </div>
</body>
</html>
