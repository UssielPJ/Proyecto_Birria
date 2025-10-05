// Theme management for main site
(function() {
    const body = document.body;
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    // Aplicar tema inicial según preferencia guardada o sistema
    if (saved) {
        body.classList.toggle('dark', saved === 'dark');
    } else {
        body.classList.toggle('dark', prefersDark);
    }

    // Función para cambiar el tema
    const toggleTheme = () => {
        const toDark = !body.classList.contains('dark');
        body.classList.toggle('dark', toDark);
        localStorage.setItem('theme', toDark ? 'dark' : 'light');
        if (typeof feather !== 'undefined') feather.replace();
    };

    // Configurar botones de tema
    ['themeToggle', 'themeToggleSm'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', toggleTheme);
    });

    // Observar cambios en la preferencia del sistema
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.getItem('theme')) {
            body.classList.toggle('dark', e.matches);
            if (typeof feather !== 'undefined') feather.replace();
        }
    });
})();