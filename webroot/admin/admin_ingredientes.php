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

$ingredientes = execute_query($conn_local, "SELECT id_ingrediente, nombre_ingrediente
                                            FROM ingredientes
                                            WHERE id_ingrediente > 1;");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Ingredientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Ingredientes</h1>
        <div class="d-flex justify-content-between mb-4">
            <a href="admin_panel.php" class="btn btn-outline-light">⬅️ Volver al Panel</a>
            <a href="agregar_ingrediente.php" class="btn btn-success">➕ Agregar Ingrediente</a>
        </div>
        <?php foreach ($ingredientes as $ing): ?>
            <div class="d-flex justify-content-between align-items-center bg-secondary rounded p-3 mb-3">
                <div>
                    <h5 class="mb-0"><?= htmlspecialchars($ing["nombre_ingrediente"]) ?></h5>
                </div>
                <div class="d-flex flex-column gap-2">
                    <a href="editar_ingrediente.php?id_ingrediente=<?=htmlspecialchars($ing['id_ingrediente'])?>" class="btn btn-warning mb-2">Editar</a>
                    <script>
                        function eliminarIngrediente() {
                            if (confirm("¿Seguro que desea continuar?")) {
                                // Si presiona "Aceptar" (Sí)
                                window.location.href = "eliminar_ingrediente.php?id=<?=htmlspecialchars($ing['id_ingrediente'])?>";
                            }
                        }
                    </script>
                    <button onclick="eliminarIngrediente()" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
