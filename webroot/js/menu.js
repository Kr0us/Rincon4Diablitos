document.addEventListener('DOMContentLoaded', function () {
    // Elementos de filtros
    const slider = document.getElementById('precio-slider');
    const valor = document.getElementById('precio-slider-valor');
    const aplicarBtn = document.querySelector('.aplicar-filtros');
    const resetBtn = document.querySelector('.reset-filtros');
    const inputBuscar = document.getElementById('busqueda-input');
    const btnBuscar = document.querySelector('.busqueda-btn');
    const filtrosToggle = document.getElementById('filtros-toggle');
    const filtrosLateral = document.getElementById('filtros-lateral');
    const filtrosOverlay = document.getElementById('filtros-overlay');

    // Actualiza el valor del slider de precio
    if (slider && valor) {
        slider.value = slider.max;
        valor.textContent = `$${slider.value}`;
        slider.addEventListener('input', function () {
            valor.textContent = `$${slider.value}`;
        });
    }

    // Función para filtrar productos
    function filtrarProductos() {
        const precioMax = slider ? parseInt(slider.value, 10) : Infinity;
        const categoriasSeleccionadas = Array.from(document.querySelectorAll('.filtro-categoria:checked'))
            .map(cb => cb.nextSibling.textContent.trim().toLowerCase());
        const tamanosSeleccionados = Array.from(document.querySelectorAll('.filtro-tamano:checked'))
            .map(cb => cb.nextSibling.textContent.trim().toLowerCase());
        const textoBusqueda = inputBuscar ? inputBuscar.value.trim().toLowerCase() : '';

        document.querySelectorAll('.menu-categoria').forEach(seccion => {
            const nombreCategoria = seccion.querySelector('.categoria-titulo')?.textContent.trim().toLowerCase() || '';
            let mostrarSeccion = false;

            seccion.querySelectorAll('.producto-card').forEach(card => {
                // --- FILTRO POR PRECIO ---
                const precios = Array.from(card.querySelectorAll('.producto-precios span'))
                    .map(span => parseInt(span.textContent.replace(/\D/g, ''), 10));
                const precioMin = precios.length ? Math.min(...precios) : 0;
                let mostrar = precioMin <= precioMax;

                // --- FILTRO POR CATEGORÍA ---
                if (mostrar && categoriasSeleccionadas.length > 0) {
                    mostrar = categoriasSeleccionadas.includes(nombreCategoria);
                }

                // --- FILTRO POR TAMAÑO ---
                if (mostrar && tamanosSeleccionados.length > 0) {
                    const tamanosProducto = Array.from(card.querySelectorAll('.producto-precios div'))
                        .map(div => div.childNodes[0].textContent.trim().toLowerCase());
                    mostrar = tamanosSeleccionados.some(tam => tamanosProducto.includes(tam));
                }

                // --- FILTRO POR BÚSQUEDA ---
                if (mostrar && textoBusqueda.length > 0) {
                    const contenido = card.textContent.toLowerCase();
                    mostrar = contenido.includes(textoBusqueda) || nombreCategoria.includes(textoBusqueda);
                }

                card.style.display = mostrar ? '' : 'none';
                if (mostrar) mostrarSeccion = true;
            });

            // Mostrar la sección solo si tiene productos visibles
            seccion.style.display = mostrarSeccion ? '' : 'none';
        });
    }

    // Botón aplicar filtros
    if (aplicarBtn) {
        aplicarBtn.addEventListener('click', function (e) {
            e.preventDefault();
            filtrarProductos();
            // Cierra el sidebar en móvil
            if (window.innerWidth < 992 && filtrosLateral && filtrosLateral.classList.contains('abierto')) {
                filtrosLateral.classList.remove('abierto');
                filtrosOverlay.classList.remove('activo');
                document.body.style.overflow = '';
            }
        });
    }

    // Botón buscar
    if (btnBuscar && inputBuscar) {
        btnBuscar.addEventListener('click', function (e) {
            e.preventDefault();
            filtrarProductos();
        });
        inputBuscar.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filtrarProductos();
            }
        });
    }

    // Cambios en filtros de checkbox actualizan en tiempo real
    document.querySelectorAll('.filtro-categoria, .filtro-tamano').forEach(cb => {
        cb.addEventListener('change', filtrarProductos);
    });

    // Slider de precio en tiempo real
    if (slider) {
        slider.addEventListener('change', filtrarProductos);
    }

    // Botón reset
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            // Reset slider de precio
            if (slider && valor) {
                slider.value = slider.max;
                valor.textContent = `$${slider.value}`;
            }
            // Desmarcar categorías y tamaños
            document.querySelectorAll('.filtro-categoria, .filtro-tamano').forEach(cb => cb.checked = false);
            // Limpiar búsqueda
            if (inputBuscar) inputBuscar.value = '';
            // Mostrar todas las secciones y productos
            document.querySelectorAll('.menu-categoria').forEach(seccion => {
                seccion.style.display = '';
                seccion.querySelectorAll('.producto-card').forEach(card => card.style.display = '');
            });
        });
    }

    // Sidebar de filtros para móvil
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
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') cerrarFiltros();
        });
    }
});