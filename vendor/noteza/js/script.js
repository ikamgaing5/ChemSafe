document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const dashboardLink = document.getElementById('dashboardLink');

    function adjustNavbar() {
        if (sidebar.classList.contains('compacted')) {
            mainContent.style.marginLeft = '80px';
        } else {
            mainContent.style.marginLeft = '280px';
        }
    }

    toggleSidebar.addEventListener('click', function () {
        sidebar.classList.toggle('compacted');
        adjustNavbar();
    });

    dashboardLink.addEventListener('click', function () {
        sidebar.classList.add('compacted');
        adjustNavbar();
    });

    adjustNavbar();
});
