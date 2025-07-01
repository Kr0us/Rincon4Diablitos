<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/footer_admin.css">
    
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">

        <div class="row">
            <div class="col-auto">
                <a href="../index.php">
                    <img src="../images/logo.png" alt="Logo del Local" class="logo-img">
                </a>
            </div>
        </div>

        <h1 class="text-center mb-4">Panel Principal del Administrador</h1>

        <div class="row g-4">

            <div class="col-md-6">
                <a href="admin_ingredientes.php" class="btn btn-danger w-100 p-4">
                    🧂 Ver y Editar Ingredientes del Menú
                </a>
            </div>

            <div class="col-md-6">
                <a href="admin_menu_listar.php" class="btn btn-warning w-100 p-4">
                    🧾 Ver y Editar Productos del Menú
                </a>
            </div>

            <div class="col-md-6">
                <a href="admin_empleados.php" class="btn btn-secondary w-100 p-4">
                    👨‍🍳 Gestión de Empleados
                </a>
            </div>

            <div class="col-md-6">
                <a href="ver_opiniones.php" class="btn btn-info w-100 p-4">
                    💬 Ver Opiniones de Clientes
                </a>
            </div>

            <div class="col-md-12">
                <a href="logout.php" class="btn btn-outline-light w-100 p-4">
                    🔒 Cerrar sesión
                </a>
            </div>

        </div>
    </div>

    
    <!-- FOOTER -->
    <?php include_once "../html/footer.html" ?>


</body>
</html>
