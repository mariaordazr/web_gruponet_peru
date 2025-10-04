document.addEventListener('DOMContentLoaded', function() {

    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    if (sidebar && sidebarToggle) {
        // Revisa si el estado 'minimizado' fue guardado en el navegador
        if (localStorage.getItem('sidebar_collapsed') === 'true') {
            sidebar.classList.add('sidebar--collapsed');
        }

        sidebarToggle.addEventListener('click', () => {
            // Añade o quita la clase al hacer clic
            sidebar.classList.toggle('sidebar--collapsed');
            
            // Guarda la preferencia en el navegador
            const isCollapsed = sidebar.classList.contains('sidebar--collapsed');
            localStorage.setItem('sidebar_collapsed', isCollapsed);
        });
    }


    // --- Lógica para cambiar entre vista de lista y cuadrícula ---
    const btnViewList = document.getElementById('btn-view-list');
    const btnViewGrid = document.getElementById('btn-view-grid');
    const contentPanel = document.querySelector('.content-panel');

    if (btnViewList && btnViewGrid && contentPanel) {
        btnViewList.addEventListener('click', () => {
            contentPanel.classList.remove('view-grid');
            contentPanel.classList.add('view-list');
            btnViewGrid.classList.remove('is-active');
            btnViewList.classList.add('is-active');
        });

        btnViewGrid.addEventListener('click', () => {
            contentPanel.classList.remove('view-list');
            contentPanel.classList.add('view-grid');
            btnViewList.classList.remove('is-active');
            btnViewGrid.classList.add('is-active');
        });
    }

    // --- Lógica para el filtrado automático ---
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        // Envía el formulario automáticamente si se cambia un <select> o el checkbox
        filterForm.querySelectorAll('select, input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', () => {
                filterForm.submit();
            });
        });

        // El formulario ya se envía al presionar Enter en el campo de búsqueda por defecto
    }

    
});