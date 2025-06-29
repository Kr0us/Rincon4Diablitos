<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Panel Principal del Administrador</h1>

        <div class="row g-4">

            <div class="col-md-6">
                <a href="admin_menu_agregar.php" class="btn btn-danger w-100 p-4">
                    ➕ Agregar nuevo producto al menú
                </a>
            </div>

            <div class="col-md-6">
                <a href="admin_menu_listar.php" class="btn btn-warning w-100 p-4">
                    🧾 Ver y editar productos del menú
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="btn btn-secondary w-100 p-4 disabled">
                    👨‍🍳 Gestión de empleados (próximamente)
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="btn btn-secondary w-100 p-4 disabled">
                    🧂 Gestión de ingredientes (próximamente)
                </a>
            </div>

            <div class="col-md-6">
                <a href="ver_opiniones.php" class="btn btn-info w-100 p-4">
                    💬 Ver opiniones de clientes
                </a>
            </div>

            <div class="col-md-6">
                <a href="logout.php" class="btn btn-outline-light w-100 p-4">
                    🔒 Cerrar sesión
                </a>
            </div>

        </div>
    </div>

</body>
</html>
