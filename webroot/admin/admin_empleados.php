<?php
// ...no conexión a base de datos, solo plantilla...
// Empleados de prueba
$empleados = [
    [
        "nombre" => "Juan Pérez",
        "telefono" => "+56 9 1234 5678",
        "local" => "Sucursal Peñalolén",
        "rol" => "Cocinero"
    ],
    // ...puedes agregar más empleados aquí...
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Empleados</h1>
        <div class="mb-4">
            <a href="admin_panel.php" class="btn btn-outline-light">⬅️ Volver al Panel</a>
        </div>
        <?php foreach ($empleados as $emp): ?>
            <div class="d-flex justify-content-between align-items-center bg-secondary rounded p-3 mb-3">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($emp["nombre"]) ?></h5>
                    <div><strong>Teléfono:</strong> <?= htmlspecialchars($emp["telefono"]) ?></div>
                    <div><strong>Local:</strong> <?= htmlspecialchars($emp["local"]) ?></div>
                    <div><strong>Rol:</strong> <?= htmlspecialchars($emp["rol"]) ?></div>
                </div>
                <button class="btn btn-danger">Eliminar Empleado</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
