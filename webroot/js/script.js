document.addEventListener('DOMContentLoaded', function() {
    let searchBtn = document.querySelector("#search-btn");
    let searchForm = document.querySelector(".sitio-header .busqueda-form");
    let menuBtn = document.getElementById('menu-btn');
    let navbar = document.querySelector('.navbar');

    if (searchBtn && searchForm) {
        searchBtn.onclick = () => {
            searchBtn.classList.toggle("fa-times");
            searchForm.classList.toggle('active');
            menuBtn.classList.remove("fa-times");
            navbar.classList.remove('active');
        };
    }

    if (menuBtn && navbar) {
        menuBtn.onclick = () => {
            navbar.classList.toggle('active');
            menuBtn.classList.toggle("fa-times");
            if (searchBtn && searchForm) {
                searchBtn.classList.remove("fa-times");
                searchForm.classList.remove('active');
            }
        };

        // Cerrar menú al hacer click en un enlace
        document.querySelectorAll('.navbar a').forEach(link => {
            link.onclick = () => {
                navbar.classList.remove('active');
                menuBtn.classList.remove('fa-times');
            };
        });
    }

    window.onscroll = () => {
        if (searchBtn && searchForm) {
            searchBtn.classList.remove("fa-times");
            searchForm.classList.remove('active');
        }
        if (menuBtn && navbar) {
            menuBtn.classList.remove("fa-times");
            navbar.classList.remove('active');
        }
    };

    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
        });
    }
});