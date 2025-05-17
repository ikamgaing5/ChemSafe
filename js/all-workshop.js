document.addEventListener('DOMContentLoaded', function() {
    const scrollableRow = document.querySelector('.scrollable-row');
    const scrollIndicator = document.querySelector('.scroll-indicator');

    function checkScroll() {
        if (scrollableRow.scrollWidth > scrollableRow.clientWidth) {
            scrollIndicator.style.display = 'flex';
        } else {
            scrollIndicator.style.display = 'none';
        }
    }

    scrollableRow.addEventListener('scroll', function() {
        if (scrollableRow.scrollLeft > 0) {
            scrollIndicator.style.opacity = '0';
        } else {
            scrollIndicator.style.opacity = '1';
        }
    });

    window.addEventListener('resize', checkScroll);
    checkScroll(); // Vérifier au chargement initial
});
