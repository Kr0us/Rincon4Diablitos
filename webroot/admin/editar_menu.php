<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");

// 1) Validación de ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) die("ID inválido.");

// 2) Cargo datos del menú
$stmt = $conn->prepare("SELECT * FROM menu WHERE id_menu = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$menu = $stmt->get_result()->fetch_assoc();
if (!$menu) die("Producto no encontrado.");

// 3) Cargo listas para selects y checkboxes
$tamanos      = execute_query($conn, "SELECT id_tamano, nombre_tamano FROM tamano");
$categorias   = execute_query($conn, "SELECT id_categoria, nombre_categoria FROM categoria");
$ingredientes = execute_query($conn, "SELECT id_ingrediente, nombre_ingrediente FROM ingredientes");

// 4) Precios actuales
$pre_rows = execute_query($conn, "SELECT id_tamano, precio FROM menu_tamano WHERE id_menu = $id");
$precios_sel = [];
foreach ($pre_rows as $r) $precios_sel[$r['id_tamano']] = $r['precio'];

// 5) Ingredientes actuales
$ing_rows = execute_query($conn, "SELECT id_ingrediente FROM ingredientes_menu WHERE id_menu = $id");
$ings_sel = array_column($ing_rows, 'id_ingrediente');

// 6) Proceso el POST (actualización)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre    = $_POST['nombre_menu'];
    $categoria = (int)$_POST['id_categoria'];
    $precios   = $_POST['precios']     ?? [];
    $ings_new  = $_POST['ingredientes'] ?? [];

    // ——— Manejamos la foto ———
    // Carpeta absoluta de destino
    $uploadDir = realpath(__DIR__ . "/../images/") . "/";
    // Por defecto usamos la ruta anterior
    $foto_path = $menu['foto_menu'];

    //   Si llega un archivo nuevo y no hubo error:
    if (!empty($_FILES['foto_menu']['name']) && $_FILES['foto_menu']['error'] === UPLOAD_ERR_OK) {
        $tmp  = $_FILES['foto_menu']['tmp_name'];
        // Nombre único
        $name = uniqid() . "-" . basename($_FILES['foto_menu']['name']);
        $dest = $uploadDir . $name;
        if (move_uploaded_file($tmp, $dest)) {
            $foto_path = "images/" . $name;
        }
    }
    // ————— fin foto —————

    // 7) Actualizo tabla menu
    $u = $conn->prepare("
        UPDATE menu
        SET nombre_menu = ?, foto_menu = ?, id_categoria = ?
        WHERE id_menu = ?
    ");
    $u->bind_param("ssii", $nombre, $foto_path, $categoria, $id);
    $u->execute();

    // 8) Refresco precios
    $conn->query("DELETE FROM menu_tamano WHERE id_menu = $id");
    $pi = $conn->prepare("
        INSERT INTO menu_tamano (id_menu, id_tamano, precio)
        VALUES (?, ?, ?)
    ");
    foreach ($precios as $tid => $val) {
        if (is_numeric($val)) {
            $pi->bind_param("iii", $id, $tid, $val);
            $pi->execute();
        }
    }

    // 9) Refresco ingredientes
    $conn->query("DELETE FROM ingredientes_menu WHERE id_menu = $id");
    $qi = $conn->prepare("
        INSERT INTO ingredientes_menu (id_menu, id_ingrediente)
        VALUES (?, ?)
    ");
    foreach ($ings_new as $iid) {
        $qi->bind_param("ii", $id, $iid);
        $qi->execute();
    }

    header("Location: admin_menu_listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

  <div class="container mt-5">
    <h2>✏️ Editar Producto</h2>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
      
      <!-- Nombre y categoría -->
      <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre_menu" class="form-control"
               value="<?=htmlspecialchars($menu['nombre_menu'])?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Categoría</label>
        <select name="id_categoria" class="form-select" required>
          <?php foreach($categorias as $c): ?>
            <option value="<?=$c['id_categoria']?>"
              <?= $c['id_categoria']==$menu['id_categoria']?'selected':''?>>
              <?=htmlspecialchars($c['nombre_categoria'])?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Foto actual y subir nueva foto -->
      <div class="col-12">
        <label class="form-label">Foto actual</label><br>
        <?php if ($menu['foto_menu']): ?>
          <img src="../<?=htmlspecialchars($menu['foto_menu'])?>"
               style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
        <?php endif; ?>
      </div>
      <div class="col-12">
        <label class="form-label">Subir nueva foto</label>
        <input type="file" name="foto_menu" class="form-control" accept="image/*">
      </div>

      <!-- Ingredientes -->
      <div class="col-12">
        <label class="form-label">Ingredientes</label><br>
        <?php foreach($ingredientes as $ing): ?>
          <div class="form-check form-check-inline text-light">
            <input class="form-check-input" type="checkbox"
                   name="ingredientes[]" id="ing<?=$ing['id_ingrediente']?>"
                   value="<?=$ing['id_ingrediente']?>"
                   <?= in_array($ing['id_ingrediente'],$ings_sel)?'checked':''?>>
            <label class="form-check-label" for="ing<?=$ing['id_ingrediente']?>">
              <?=htmlspecialchars($ing['nombre_ingrediente'])?>
            </label>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Precios por tamaño -->
      <?php foreach($tamanos as $tam): ?>
        <?php $v = $precios_sel[$tam['id_tamano']] ?? ''; ?>
        <div class="col-md-4">
          <label class="form-label"><?=htmlspecialchars($tam['nombre_tamano'])?></label>
          <input type="number" name="precios[<?=$tam['id_tamano']?>]"
                 class="form-control" min="0" step="100" value="<?=$v?>">
        </div>
      <?php endforeach; ?>

      <!-- Botones -->
      <div class="col-12 text-end mt-3">
        <button class="btn btn-warning">Actualizar</button>
        <a href="admin_menu_listar.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</body>
</html>
