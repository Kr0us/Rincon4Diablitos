<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nombre_ingrediente"])) {
    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn_local = create_conection("RINCON");
    if (is_null($conn_local)) {
        http_response_code(500);
        exit;
    }

    $ingrediente = $_POST["nombre_ingrediente"];
    
    $stmt = $conn_local->prepare("INSERT INTO ingredientes(nombre_ingrediente)
                                  VALUES (?)");
    $stmt->bind_param("s", $ingrediente);
    
    $stmt->execute();
    $resultado = $stmt->get_result();

    header("Location: admin_ingredientes.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Ingrediente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="mb-4">➕ Agregar Ingrediente</h1>
        <form method="POST" action="agregar_ingrediente.php">
            <div class="mb-3">
                <label class="form-label">Nombre del Ingrediente</label>
                <input type="text" name="nombre_ingrediente" class="form-control" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="admin_ingredientes.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
