<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["id_ingrediente"])) {
    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn_local = create_conection("RINCON");
    if (is_null($conn_local)) {
        http_response_code(500);
        exit;
    }

    $id_ingrediente = $_GET["id_ingrediente"];

    $nombre_ingrediente = execute_query($conn_local, "SELECT nombre_ingrediente FROM ingredientes 
                                          WHERE id_ingrediente = $id_ingrediente;")[0]["nombre_ingrediente"];

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id_ingrediente"]) && isset($_POST["nombre_ingrediente"])){
    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn_local = create_conection("RINCON");
    if (is_null($conn_local)) {
        http_response_code(500);
        exit;
    }

    $id_ingrediente = (int)$_POST["id_ingrediente"];
    $nombre_ingrediente = $_POST["nombre_ingrediente"];
    
    $stmt = $conn_local->prepare("UPDATE ingredientes
                                  SET nombre_ingrediente = ?
                                  WHERE id_ingrediente = ?");
    $stmt->bind_param("si", $nombre_ingrediente, $id_ingrediente);
    $stmt->execute();

    header("Location: admin_ingredientes.php");
} else {
    http_response_code(403);
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
        <form method="POST" action="editar_ingrediente.php">
            <input type="hidden" name="id_ingrediente" value="<?=$id_ingrediente;?>">
            <div class="mb-3">
                <label class="form-label">Nombre del Ingrediente</label>
                <input type="text" name="nombre_ingrediente" value="<?=$nombre_ingrediente;?>" class="form-control" required>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="admin_ingredientes.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
