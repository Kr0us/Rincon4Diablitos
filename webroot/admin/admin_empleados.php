<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn_local = create_conection("RINCON");
if (is_null($conn_local)) {
    http_response_code(500);
    exit;
}

$empleados = execute_query($conn_local, "SELECT e.id_empleado, e.nombre_empleado, e.apellido_empleado, e.telefono, r.nombre_rol, l.direccion FROM empleados e 
                                        INNER JOIN roles r ON r.id_rol = e.id_rol 
                                        INNER JOIN locales l ON l.id_local = e.id_local 
                                        WHERE e.id_empleado > 0;");


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
        <div class="d-flex justify-content-between mb-4">
            <a href="admin_panel.php" class="btn btn-outline-light">⬅️ Volver al Panel</a>
            <a href="agregar_empleado.php" class="btn btn-success">➕ Agregar Empleado</a>
        </div>
        <?php foreach ($empleados as $emp): ?>
            <div class="d-flex justify-content-between align-items-center bg-secondary rounded p-3 mb-3">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($emp["nombre_empleado"]." ".$emp["apellido_empleado"]) ?></h5>
                    <div><strong>Teléfono:</strong> <?= htmlspecialchars("+".$emp["telefono"]) ?></div>
                    <div><strong>Local:</strong> <?= htmlspecialchars($emp["direccion"]) ?></div>
                    <div><strong>Rol:</strong> <?= htmlspecialchars($emp["nombre_rol"]) ?></div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="editar_empleado.php?id=<?=htmlspecialchars($emp['id_empleado'])?>" class="btn btn-warning mb-2">Editar Información</a>
                    <button class="btn btn-danger">Eliminar Empleado</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
