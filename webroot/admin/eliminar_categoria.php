<?php
require_once realpath(__DIR__ . "/..") . "/conexion.php";
$conn = create_conection("RINCON");

$cat = isset($_GET['id_categoria']) ? (int)$_GET['id_categoria'] : null;
if ($cat) {
    // Borro todos los productos de esa categoría
    // Primero ingredientes y precios en cascada
    $conn->query("
      DELETE im 
      FROM ingredientes_menu im
      JOIN menu m ON im.id_menu = m.id_menu
      WHERE m.id_categoria = $cat
    ");
    $conn->query("
      DELETE mt 
      FROM menu_tamano mt
      JOIN menu m ON mt.id_menu = m.id_menu
      WHERE m.id_categoria = $cat
    ");
    // Luego borro los productos
    $conn->query("DELETE FROM menu WHERE id_categoria = $cat");
    // Finalmente borro la categoría
    $conn->query("DELETE FROM categoria WHERE id_categoria = $cat");
}

http_response_code(204);
