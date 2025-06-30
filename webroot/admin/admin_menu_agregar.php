<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");
if (is_null($conn)) {
    die("Error de conexión.");
}

// traigo datos para selects y checkboxes
$categorias   = execute_query($conn, "SELECT id_categoria, nombre_categoria FROM categoria");
$tamanos      = execute_query($conn, "SELECT id_tamano, nombre_tamano   FROM tamano");
$ingredientes = execute_query($conn, "SELECT id_ingrediente, nombre_ingrediente FROM ingredientes");

// carpeta absoluta para subir imágenes
$uploadDir = realpath(__DIR__ . "/../images/") . "/";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre      = $_POST["nombre_menu"];
    $cat_existente = isset($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : 0;
    $cat_nueva     = trim($_POST['nueva_categoria'] ?? '');
    $precios     = $_POST["precios"]     ?? [];
    $ings_sel    = $_POST["ingredientes"] ?? [];

    // —————— 1) Creo categoría nueva si viene ——————
    // valida que haya una u otra
// 2) Valida que al menos una venga
  if ($cat_existente === 0 && $cat_nueva === '') {
      die("<p class='text-danger'>Debes seleccionar o crear una categoría.</p>");
  }

  // 3) Si hay nueva, calcula manualmente el próximo ID y la inserta
  if ($cat_nueva !== '') {
      // calcula next id
      $row = execute_query($conn, "SELECT COALESCE(MAX(id_categoria),0)+1 AS nextid FROM categoria")[0];
      $next = (int)$row['nextid'];

      // inserta con ID explícito
      $ic = $conn->prepare(
        "INSERT INTO categoria (id_categoria, nombre_categoria) VALUES (?, ?)"
      );
      $ic->bind_param("is", $next, $cat_nueva);
      $ic->execute();

      $categoria = $next;
  } else {
      // usa la existente
      $categoria = $cat_existente;
  }

    // —————— 2) Subida de la foto ——————
    $foto_path = null;
    if (!empty($_FILES['foto_menu']['name']) && $_FILES['foto_menu']['error'] === UPLOAD_ERR_OK) {
        $tmp  = $_FILES['foto_menu']['tmp_name'];
        $name = uniqid() . "-" . basename($_FILES['foto_menu']['name']);
        $dest = $uploadDir . $name;
        if (move_uploaded_file($tmp, $dest)) {
            $foto_path = "images/" . $name;
        } else {
            echo "<p class='text-danger'>Error al subir la imagen.</p>";
        }
    }

    // —————— 3) Inserto el producto ——————
    $stmt = $conn->prepare("
      INSERT INTO menu (nombre_menu, foto_menu, id_categoria)
      VALUES (?, ?, ?)
    ");
    $stmt->bind_param("ssi", $nombre, $foto_path, $categoria);
    if ($stmt->execute()) {
        $id_menu = $stmt->insert_id;

        // precios por tamaño
        $p = $conn->prepare("
            INSERT INTO menu_tamano (id_menu, id_tamano, precio)
            VALUES (?, ?, ?)
        ");
        foreach ($precios as $id_tam => $valor) {
            if (is_numeric($valor)) {
                $p->bind_param("iii", $id_menu, $id_tam, $valor);
                $p->execute();
            }
        }

        // ingredientes seleccionados
        $q = $conn->prepare("
            INSERT INTO ingredientes_menu (id_menu, id_ingrediente)
            VALUES (?, ?)
        ");
        foreach ($ings_sel as $id_ing) {
            $q->bind_param("ii", $id_menu, $id_ing);
            $q->execute();
        }

        header("Location: admin_menu_listar.php");
        exit;
    } else {
        echo "<p class='text-danger'>Error al guardar el producto.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
  <h2>➕ Agregar Producto</h2>
  <form method="POST" enctype="multipart/form-data" class="row g-3">
    
    <!-- Nombre -->
    <div class="col-md-6">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre_menu" class="form-control" required>
    </div>
    
    <!-- Categoría existente -->
    <div class="col-md-6">
      <label>Categoría existente (Si va agregar una nueva categoría, seleccione --ninguna--)</label>
      <select name="id_categoria" class="form-select">
        <option value="0">-- ninguna --</option>
        <?php foreach($categorias as $c): ?>
          <option value="<?=$c['id_categoria']?>">
            <?=htmlspecialchars($c['nombre_categoria'])?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Nueva categoría -->
    <div class="col-md-6">
      <label>Nueva categoría</label>
      <input type="text" name="nueva_categoria" class="form-control" placeholder="Escribe aquí">
    </div>
    
    
    <!-- Foto -->
    <div class="col-12">
      <label class="form-label">Subir foto del producto</label>
      <input type="file" name="foto_menu" class="form-control" accept="image/*">
    </div>
    
    <!-- Ingredientes -->
    <div class="col-12">
      <label class="form-label">Ingredientes</label><br>
      <?php foreach($ingredientes as $ing): ?>
        <div class="form-check form-check-inline text-light">
          <input class="form-check-input" type="checkbox"
                 name="ingredientes[]" id="ing<?=$ing['id_ingrediente']?>"
                 value="<?=$ing['id_ingrediente']?>">
          <label class="form-check-label" for="ing<?=$ing['id_ingrediente']?>">
            <?=htmlspecialchars($ing['nombre_ingrediente'])?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>
    
    <!-- Precios por tamaño -->
    <?php foreach($tamanos as $tam): ?>
      <div class="col-md-4">
        <label class="form-label"><?=htmlspecialchars($tam['nombre_tamano'])?></label>
        <input type="number" 
               name="precios[<?=$tam['id_tamano']?>]"
               class="form-control" min="0" step="100">
      </div>
    <?php endforeach; ?>
    
    <!-- Botones -->
    <div class="col-12 text-end mt-3">
      <button class="btn btn-success">Guardar</button>
      <a href="admin_menu_listar.php" class="btn btn-secondary">Cancelar</a>
    </div>
    
  </form>
</div>
</body>
</html>
