function confirmDeleteProduct(id) {
      if (!confirm("¿Seguro que deseas eliminar este producto?")) return;
      fetch("eliminar_menu.php?id=" + id, { method: "GET" })
        .then(() => location.reload());
    }
    
function confirmDeleteCategory(catId) {
      if (!confirm("¿Eliminar esta categoría Y TODOS sus productos?")) return;
      fetch("eliminar_categoria.php?id_categoria=" + catId, { method: "GET" })
        .then(() => location.reload());
    }
