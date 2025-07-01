/**
 * Pide confirmación y, si aceptas, llama al script PHP para eliminar la opinión.
 * @param {number} id ID de la opinión a borrar.
 */
function confirmDelete(id) {
  if (!confirm("¿Seguro que deseas eliminar esta opinión?")) return;
  fetch("eliminar_opinion.php?id_opinion=" + id, { method: "GET" })
    .then(() => location.reload());
}