<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if ($id) {
    // Borro ingredientes y precios asociados
    $conn->query("DELETE im FROM ingredientes_menu im WHERE im.id_menu = $id");
    $conn->query("DELETE mt FROM menu_tamano mt WHERE mt.id_menu = $id");
    // Borro producto
    $conn->query("DELETE FROM menu WHERE id_menu = $id");
}

// Devuelvo 204 para que fetch lo sepa
http_response_code(204);
