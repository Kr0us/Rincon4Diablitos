<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["id"])) {
    
    require_once realpath(__DIR__ . "/..") . "/conexion.php";
    $conn_local = create_conection("RINCON");
    if (is_null($conn_local)) {
        http_response_code(500);
        exit;
    }

    $id_ingrediente = $_GET["id"];
    $stmt = $conn_local->prepare("DELETE FROM ingredientes
                                  WHERE id_ingrediente = ?;");
    $stmt->bind_param("i", $id_ingrediente);
    $stmt->execute();

    header("Location: admin_ingredientes.php");
}

?>