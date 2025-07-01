function eliminarIngrediente() {
    if (confirm("¿Seguro que desea continuar?")) {
        // Si presiona "Aceptar" (Sí)
        window.location.href = "eliminar_ingrediente.php?id=<?=htmlspecialchars($ing['id_ingrediente'])?>";
    }
}
