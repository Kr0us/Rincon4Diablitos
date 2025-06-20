document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    let searchBtn = document.querySelector("#search-btn"); // Botón de búsqueda
    let searchForm = document.querySelector(".sitio-header .busqueda-form"); // Formulario de búsqueda
    let menuBtn = document.getElementById('menu-btn'); // Botón del menú
    let navbar = document.querySelector('.navbar'); // Barra de navegación

    // Evento click en el botón de búsqueda
    if (searchBtn && searchForm) {
        searchBtn.onclick = () => {
            searchBtn.classList.toggle("fa-times"); // Alternar icono de cerrar
            searchForm.classList.toggle('active'); // Mostrar/ocultar formulario
            menuBtn.classList.remove("fa-times"); // Asegura que el menú no esté activo
            navbar.classList.remove('active'); // Oculta la barra de navegación
        };
    }

    // Evento click en el botón del menú
    if (menuBtn && navbar) {
        menuBtn.onclick = () => {
            navbar.classList.toggle('active'); // Mostrar/ocultar barra de navegación
            menuBtn.classList.toggle("fa-times"); // Alternar icono de cerrar
            if (searchBtn && searchForm) {
                searchBtn.classList.remove("fa-times"); // Asegura que la búsqueda no esté activa
                searchForm.classList.remove('active'); // Oculta el formulario de búsqueda
            }
        };

        // Cerrar menú al hacer click en un enlace de la barra de navegación
        document.querySelectorAll('.navbar a').forEach(link => {
            link.onclick = () => {
                navbar.classList.remove('active'); // Oculta la barra de navegación
                menuBtn.classList.remove('fa-times'); // Restablece el icono del menú
            };
        });
    }

    // Evento al hacer scroll en la ventana
    window.onscroll = () => {
        if (searchBtn && searchForm) {
            searchBtn.classList.remove("fa-times"); // Oculta icono de cerrar búsqueda
            searchForm.classList.remove('active'); // Oculta formulario de búsqueda
        }
        if (menuBtn && navbar) {
            menuBtn.classList.remove("fa-times"); // Oculta icono de cerrar menú
            navbar.classList.remove('active'); // Oculta barra de navegación
        }
    };

    // Inicializar animaciones si AOS está disponible
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800, // Duración de la animación en ms
        });
    }
});