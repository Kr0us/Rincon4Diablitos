<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");
if (is_null($conn)) {
    http_response_code(500);
    exit;
}

// Traigo las opiniones junto a empleado y local (si existen)
$data = execute_query($conn, "
  SELECT
    o.id_opinion,
    o.nombre_cliente,
    o.correo,
    o.estrellas,
    o.comentario,
    e.nombre_empleado,
    l.direccion AS local
  FROM opiniones o
  LEFT JOIN empleados e ON o.id_empleado = e.id_empleado
  LEFT JOIN locales   l ON o.id_local    = l.id_local
  ORDER BY o.id_opinion DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Opiniones de Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-dark text-light">

    <div class="container mt-3">
        <div class="row">
            <div class="col-auto">
                <a href="admin_panel.php">
                    <img src="../images/logo.png" alt="Logo del Local" class="logo-img">
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-danger">Opiniones de Clientes</h1>
            <a href="admin_panel.php" class="btn btn-outline-light">⬅️ Volver al Panel</a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered text-light">
                <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>⭐ Estrellas</th>
                    <th>Comentario</th>
                    <th>Empleado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $row): ?>
                <tr>
                    <td><?= $row['id_opinion'] ?></td>
                    <td><?= htmlspecialchars($row['nombre_cliente']) ?></td>
                    <td><?= htmlspecialchars($row['correo']) ?></td>
                    <td><?= (int)$row['estrellas'] ?></td>
                    <td><?= nl2br(htmlspecialchars($row['comentario'])) ?></td>
                    <td><?= htmlspecialchars($row['nombre_empleado'] ?? '-') ?></td>
                    <td>
                    <button 
                        class="btn btn-outline-danger btn-sm"
                        onclick="confirmDelete(<?= $row['id_opinion'] ?>)">
                        Eliminar
                    </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
  </div>

  <script src="../js/opiniones.js"></script>
</body>
</html>