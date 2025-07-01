<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");
$id = isset($_GET['id_opinion']) ? (int)$_GET['id_opinion'] : 0;
if ($id) {
    $conn->query("DELETE FROM opiniones WHERE id_opinion = $id");
}
http_response_code(204);
