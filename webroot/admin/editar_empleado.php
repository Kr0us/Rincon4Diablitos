<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    http_response_code(403); // Operación No Válida
    exit;
}

// Simulación de datos de empleado (en práctica, deberías obtenerlos por $_GET['id'] y consulta a BD)
$empleado = [
    "nombre"   => "Juan Pérez",
    "telefono" => "+56 9 1234 5678",
    "local"    => "Sucursal Peñalolén",
    "rol"      => "Cocinero"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Información de Empleado</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($empleado["nombre"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono Asociado</label>
                <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($empleado["telefono"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Local Correspondiente</label>
                <input type="text" name="local" class="form-control" value="<?= htmlspecialchars($empleado["local"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol dentro del Local</label>
                <input type="text" name="rol" class="form-control" value="<?= htmlspecialchars($empleado["rol"]) ?>" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                <a href="admin_empleados.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
