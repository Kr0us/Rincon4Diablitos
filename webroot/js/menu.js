document.addEventListener('DOMContentLoaded', function () {
    // === Botones de filtro ===
    const btnPrecio = document.getElementById('precio'); // Botón filtrar por precio
    const btnCategoria = document.getElementById('categoria'); // Botón filtrar por categoría
    const btnTamano = document.getElementById('tamano'); // Botón filtrar por tamaño
    const btnBuscar = document.querySelector('.busqueda-btn'); // Botón buscar producto
    const inputBuscar = document.getElementById('busqueda-input'); // Input de búsqueda
    const categoriaSelect = document.getElementById('categoria-select'); // Select de categorías

    // === Obtener todos los productos ===
    function getAllProducts() {
        return Array.from(document.querySelectorAll('.producto-card'));
    }

    // === Mostrar solo los productos que cumplen con el filtro ===
    function showFilteredProducts(filterFn) {
        getAllProducts().forEach(card => {
            card.style.display = filterFn(card) ? '' : 'none';
        });
    }

    // === Filtrar por precio (ejemplo: Normal <= $2500) ===
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

    // === Filtrar por categoría (ejemplo: "Completos") ===
    if (btnCategoria) {
        btnCategoria.addEventListener('click', () => {
            showFilteredProducts(card => {
                const categoria = card.closest('.menu-categoria')?.querySelector('.categoria-titulo')?.textContent || '';
                return categoria.toLowerCase().includes('completos');
            });
        });
    }

    // === Filtrar por tamaño (ejemplo: productos con XL) ===
    if (btnTamano) {
        btnTamano.addEventListener('click', () => {
            showFilteredProducts(card => {
                const xl = Array.from(card.querySelectorAll('.producto-precios div')).find(div => div.textContent.includes('XL'));
                return !!xl;
            });
        });
    }

    // === Buscar productos por nombre ===
    if (btnBuscar && inputBuscar) {
        btnBuscar.addEventListener('click', function(e) {
            e.preventDefault();
            const texto = inputBuscar.value.trim().toLowerCase();
    
            document.querySelectorAll('.menu-categoria').forEach(seccion => {
                const nombreCategoria = seccion.querySelector('.categoria-titulo')?.textContent.trim().toLowerCase() || '';
                let mostrarSeccion = false;
    
                // Si el texto buscado coincide con la categoría, mostrar todos los productos de esa categoría
                if (nombreCategoria.includes(texto) && texto.length > 0) {
                    seccion.style.display = '';
                    seccion.querySelectorAll('.producto-card').forEach(card => {
                        card.style.display = '';
                    });
                    mostrarSeccion = true;
                } else {
                    // Si no, buscar normalmente en los productos
                    let algunProductoVisible = false;
                    seccion.querySelectorAll('.producto-card').forEach(card => {
                        const contenido = card.textContent.toLowerCase();
                        const visible = contenido.includes(texto);
                        card.style.display = visible ? '' : 'none';
                        if (visible) algunProductoVisible = true;
                    });
                    seccion.style.display = algunProductoVisible ? '' : 'none';
                }
            });
        });
    }

    // === Filtrar por categoría usando el select ===
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

    // === Slider precios ===
    const slider = document.getElementById('precio-slider'); // Slider de precio máximo
    const valor = document.getElementById('precio-slider-valor'); // Valor mostrado del slider
    
    if (slider && valor) {
        // Asegura que el slider parte en el máximo
        slider.value = slider.max;
        valor.textContent = `$${slider.value}`;
        slider.addEventListener('input', function() {
            valor.textContent = `$${slider.value}`;
        });
    }

    // === Aplicar filtros combinados ===
    const aplicarBtn = document.querySelector('.aplicar-filtros'); // Botón aplicar filtros
    
    if (aplicarBtn && slider) {
        aplicarBtn.addEventListener('click', function(e) {
            e.preventDefault();
    
            const precioMax = parseInt(slider.value, 10);
            const categoriasSeleccionadas = Array.from(document.querySelectorAll('.filtro-categoria:checked'))
                .map(cb => cb.value.toLowerCase());
            const tamanosSeleccionados = Array.from(document.querySelectorAll('.filtro-tamano:checked'))
                .map(cb => cb.nextSibling.textContent.trim().toLowerCase());
    
            document.querySelectorAll('.menu-categoria').forEach(seccion => {
                const titulo = seccion.querySelector('.categoria-titulo')?.textContent.trim().toLowerCase().replace(/\s/g, '') || '';
                let mostrarSeccion = true;
    
                if (categoriasSeleccionadas.length > 0) {
                    mostrarSeccion = categoriasSeleccionadas.some(cat => titulo.includes(cat));
                }
    
                if (mostrarSeccion) {
                    seccion.querySelectorAll('.producto-card').forEach(card => {
                        // --- PRECIO ---
                        const precios = Array.from(card.querySelectorAll('.producto-precios span'))
                            .map(span => parseInt(span.textContent.replace(/\D/g, ''), 10));
                        const precioMin = Math.min(...precios);
    
                        // --- TAMAÑO ---
                        const tamanosProducto = Array.from(card.querySelectorAll('.producto-precios div'))
                            .map(div => div.childNodes[0].textContent.trim().toLowerCase());
    
                        let mostrar = true;
                        if (precioMin > precioMax) mostrar = false;
                        if (mostrar && tamanosSeleccionados.length > 0) {
                            mostrar = tamanosSeleccionados.some(tam => tamanosProducto.includes(tam));
                        }
                        card.style.display = mostrar ? '' : 'none';
                    });
    
                    // Mostrar la sección si al menos un producto está visible
                    const algunProductoVisible = Array.from(seccion.querySelectorAll('.producto-card'))
                        .some(card => card.style.display !== 'none');
                    seccion.style.display = algunProductoVisible ? '' : 'none';
                } else {
                    seccion.style.display = 'none';
                }
            });
        });
    }

    // === Botón Reset (limpiar filtros) ===
    const resetBtn = document.querySelector('.reset-filtros');
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            // Reset slider de precio
            const slider = document.getElementById('precio-slider');
            const valor = document.getElementById('precio-slider-valor');
            if (slider && valor) {
                slider.value = slider.max;
                valor.textContent = `$${slider.value}`;
            }

            // Desmarcar categorías y tamaños
            document.querySelectorAll('.filtro-categoria, .filtro-tamano').forEach(cb => cb.checked = false);

            // Mostrar todas las secciones de menú y todos los productos
            document.querySelectorAll('.menu-categoria').forEach(seccion => {
                seccion.style.display = '';
                seccion.querySelectorAll('.producto-card').forEach(card => card.style.display = '');
            });
        });
    }

    // === Filtros desplegables en móvil tipo sidebar ===
    const filtrosToggle = document.getElementById('filtros-toggle'); // Botón abrir filtros lateral
    const filtrosLateral = document.getElementById('filtros-lateral'); // Sidebar de filtros
    const filtrosOverlay = document.getElementById('filtros-overlay'); // Overlay para cerrar sidebar
    
    if (filtrosToggle && filtrosLateral && filtrosOverlay) {
        function abrirFiltros() {
            filtrosLateral.classList.add('abierto');
            filtrosOverlay.classList.add('activo');
            document.body.style.overflow = 'hidden';
        }
        function cerrarFiltros() {
            filtrosLateral.classList.remove('abierto');
            filtrosOverlay.classList.remove('activo');
            document.body.style.overflow = '';
        }
        filtrosToggle.addEventListener('click', abrirFiltros);
        filtrosOverlay.addEventListener('click', cerrarFiltros);
    
        // Opcional: cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') cerrarFiltros();
        });
    }

});
