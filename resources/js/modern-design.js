// Modern Design JavaScript - CALZADO STORE

document.addEventListener('DOMContentLoaded', function() {
    initializeSearch();
    initializeAnimations();
    initializeResponsive();
});

// SEARCH FUNCTIONALITY
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value;
            if (query.length >= 2) {
                // Aquí puedes hacer una búsqueda en tiempo real si lo deseas
                console.log('Buscando:', query);
            }
        });
    }
}

// ANIMATIONS
function initializeAnimations() {
    // Animar tarjetas de productos en scroll
    const cards = document.querySelectorAll('.product-card');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeIn 0.5s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => {
            observer.observe(card);
        });
    }
}

// RESPONSIVE
function initializeResponsive() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        // Cerrar sidebar al hacer click en un link en móvil
        const links = sidebar.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('show');
                }
            });
        });
    }
}

// TOGGLE SIDEBAR
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
}

// ADD TO CART BUTTON ANIMATION
function addToCart(productId) {
    const btn = event.target;
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-check"></i> ¡Agregado!';
    btn.style.background = '#10b981';
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.background = '';
    }, 2000);
}

// SMOOTH SCROLL
function smoothScroll(target) {
    document.querySelector(target).scrollIntoView({
        behavior: 'smooth'
    });
}
