document.addEventListener('DOMContentLoaded', function () {
    // Botones de filtro
    const btnPrecio = document.getElementById('precio');
    const btnCategoria = document.getElementById('categoria');
    const btnTamano = document.getElementById('tamano');
    const btnBuscar = document.querySelector('.busqueda-btn');
    const inputBuscar = document.getElementById('busqueda-input');
    const categoriaSelect = document.getElementById('categoria-select');

    // Obtener todos los productos
    function getAllProducts() {
        return Array.from(document.querySelectorAll('.producto-card'));
    }

    // Mostrar solo los productos que cumplen con el filtro
    function showFilteredProducts(filterFn) {
        getAllProducts().forEach(card => {
            card.style.display = filterFn(card) ? '' : 'none';
        });
    }

    // Filtrar por precio (ejemplo: Normal <= $2500)
    if (btnPrecio) {
        btnPrecio.addEventListener('click', () => {
            showFilteredProducts(card => {
                const normalPrice = card.querySelector('.producto-precios div:first-child span');
                if (!normalPrice) return false;
                const price = parseInt(normalPrice.textContent.replace(/\D/g, ''));
                return price <= 2500;
            });
        });
    }

    // Filtrar por categoría (ejemplo: "Completos")
    if (btnCategoria) {
        btnCategoria.addEventListener('click', () => {
            showFilteredProducts(card => {
                const categoria = card.closest('.menu-categoria')?.querySelector('.categoria-titulo')?.textContent || '';
                return categoria.toLowerCase().includes('completos');
            });
        });
    }

    // Filtrar por tamaño (ejemplo: productos con XL)
    if (btnTamano) {
        btnTamano.addEventListener('click', () => {
            showFilteredProducts(card => {
                const xl = Array.from(card.querySelectorAll('.producto-precios div')).find(div => div.textContent.includes('XL'));
                return !!xl;
            });
        });
    }

    // Buscar por nombre de producto
    if (btnBuscar && inputBuscar) {
        btnBuscar.addEventListener('click', () => {
            const texto = inputBuscar.value.trim().toLowerCase();
            showFilteredProducts(card => {
                const nombre = card.querySelector('.producto-nombre')?.textContent.toLowerCase() || '';
                return nombre.includes(texto);
            });
        });
    }

    // Filtrar por categoría usando el select
    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', () => {
            const value = categoriaSelect.value;
            if (!value) {
                // Mostrar todos si no hay filtro
                showFilteredProducts(() => true);
                return;
            }
            showFilteredProducts(card => {
                const categoria = card.closest('.menu-categoria')?.querySelector('.categoria-titulo')?.textContent.toLowerCase() || '';
                return categoria.includes(value);
            });
        });
    }
});