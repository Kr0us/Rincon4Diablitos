<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["id_empleado"])) {
    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn_local = create_conection("RINCON");
    if (is_null($conn_local)) {
        http_response_code(500);
        exit;
    }

    $roles = execute_query($conn_local, "SELECT id_rol, nombre_rol FROM roles WHERE id_rol > 0;");
    $locales = execute_query($conn_local, "SELECT id_local, direccion FROM locales WHERE id_local > 0;");

    $id_empleado = (int)$_GET["id_empleado"];

    $datos = execute_query($conn_local, "SELECT nombre_empleado, apellido_empleado, telefono, id_rol, id_local FROM empleados 
                                          WHERE id_empleado = $id_empleado;")[0];

    $nombre = $datos["nombre_empleado"];
    $apellido = $datos["apellido_empleado"];
    $telefono = $datos["telefono"];
    $id_rol = (int)$datos["id_rol"];
    $id_local = (int)$datos["id_local"];

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id_empleado"])){
    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn_local = create_conection("RINCON");
    if (is_null($conn_local)) {
        http_response_code(500);
        exit;
    }

    $id_empleado = (int)$_POST["id_empleado"];
    $nombre = $_POST["nombre_empleado"];
    $apellido = $_POST["apellido_empleado"];
    $telefono = $_POST["telefono"];
    $id_rol = (int)$_POST["id_rol"];
    $id_local = (int)$_POST["id_local"];
    
    $stmt = $conn_local->prepare("UPDATE empleados
                                  SET nombre_empleado = ?, apellido_empleado = ?, telefono = ?, id_rol = ?, id_local = ?
                                  WHERE id_empleado = ?");
    $stmt->bind_param("sssiii", $nombre, $apellido, $telefono, $id_rol, $id_local, $id_empleado);
    $stmt->execute();

    header("Location: admin_empleados.php");
    exit;
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

        <h1 class="mb-4">➕ Editar Información de Empleado</h1>
        <form method="POST" action="editar_empleado.php">
            <input type="hidden" name="id_empleado" value="<?=$id_empleado;?>">
            <div class="mb-3">
                <label class="form-label">Nombre del Empleado</label>
                <input value="<?=$nombre;?>" type="text" name="nombre_empleado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido del Empleado</label>
                <input value="<?=$apellido;?>" type="text" name="apellido_empleado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Número de Teléfono</label>
                <input value="<?=$telefono?>" type="text" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="id_rol" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    <?php foreach($roles as $rol) {?>
                    <option value="<?= $rol['id_rol'] ?>" <?= ($rol['id_rol'] == $id_rol) ? 'selected' : '' ?>><?= $rol['nombre_rol'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Local</label>
                <select name="id_local" class="form-select" required>
                    <option value="">Seleccione un local</option>
                    <?php foreach($locales as $local) {?>
                    <option value="<?=$local['id_local']?>" <?= ($local['id_local'] == $id_local) ? 'selected' : '' ?>><?=$local['direccion']?></option>
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
