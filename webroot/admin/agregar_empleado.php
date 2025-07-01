<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nombre_empleado"])) {
    $nombre = $_POST["nombre_empleado"];
    $apellido = $_POST["apellido_empleado"];
    $telefono = $_POST["telefono"];
    $id_rol = $_POST["id_rol"];
    $id_local = $_POST["id_local"];

    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn = create_conection("RINCON");
    if (is_null($conn)) {
        http_response_code(500);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO empleados(nombre_empleado,apellido_empleado,telefono,id_rol,id_local)
                                  VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $nombre, $apellido, $telefono, $id_rol, $id_local);
    
    $stmt->execute();
    $resultado = $stmt->get_result();

    header("Location: admin_empleados.php");
    exit;
}

require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn_local = create_conection("RINCON");
if (is_null($conn_local)) {
    http_response_code(500);
    exit;
}

$roles = execute_query($conn_local, "SELECT id_rol, nombre_rol FROM roles WHERE id_rol > 0;");
$locales = execute_query($conn_local, "SELECT id_local, direccion FROM locales WHERE id_local > 0;");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="mb-4">➕ Agregar Empleado</h1>
        <form method="POST" action="agregar_empleado.php">
            <div class="mb-3">
                <label class="form-label">Nombre del Empleado</label>
                <input type="text" name="nombre_empleado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido del Empleado</label>
                <input type="text" name="apellido_empleado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Número de Teléfono</label>
                <input type="text" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="id_rol" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    <?php foreach($roles as $rol) {?>
                    <option value="<?=$rol['id_rol']?>"><?=$rol['nombre_rol']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Local</label>
                <select name="id_local" class="form-select" required>
                    <option value="">Seleccione un local</option>
                    <?php foreach($locales as $local) {?>
                    <option value="<?=$local['id_local']?>"><?=$local['direccion']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="admin_empleados.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>