<?php

function cerrar_sesion() {
    session_start();
    session_destroy();
    header("Location: admin.php");
    exit;
}

?>