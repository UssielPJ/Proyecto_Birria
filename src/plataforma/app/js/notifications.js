// Clase para manejar las notificaciones
class NotificationsManager {
    constructor() {
        this.unreadCount = 0;
        this.notifications = this.loadNotifications(); // Cargar desde localStorage
        this.initializeUI();
        this.startPolling();
    }

    // Cargar notificaciones desde localStorage
    loadNotifications() {
        const stored = localStorage.getItem('utsc_notifications');
        if (stored) {
            const parsed = JSON.parse(stored);
            // Calcular unread count
            this.unreadCount = parsed.filter(n => !n.is_read).length;
            return parsed;
        }
        // Notificaciones iniciales
        const sampleNotifications = [
            {
                id: 1,
                title: "Bienvenido a UTSC",
                message: "¡Gracias por unirte! Tu cuenta ha sido activada.",
                created_at: new Date().toISOString(),
                is_read: false
            },
            {
                id: 2,
                title: "Nuevo webinar disponible",
                message: "Accede al webinar de 'Tendencias en IA 2025'.",
                created_at: new Date(Date.now() - 86400000).toISOString(), // Ayer
                is_read: true
            }
        ];
        localStorage.setItem('utsc_notifications', JSON.stringify(sampleNotifications));
        this.unreadCount = 1; // Una no leída
        return sampleNotifications;
    }

    // Guardar notificaciones en localStorage
    saveNotifications() {
        localStorage.setItem('utsc_notifications', JSON.stringify(this.notifications));
    }

    initializeUI() {
        // Buscar el botón de notificaciones existente (campanita)
        const notificationBtn = document.querySelector('a[href*="anuncios"], a[href="#"].p-2.rounded-full.relative, a.p-2.rounded-full.relative');
        if (!notificationBtn) {
            console.warn('No se encontró el botón de notificaciones existente');
            return;
        }

        // Agregar el badge al botón existente
        if (!document.getElementById('notification-badge')) {
            const badge = document.createElement('span');
            badge.id = 'notification-badge';
            badge.className = 'notification-badge absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full min-w-[8px] h-2 flex items-center justify-center px-1';
            badge.style.display = 'none';
            notificationBtn.style.position = 'relative';
            notificationBtn.appendChild(badge);
        }

        // Agregar el dropdown de notificaciones
        if (!document.getElementById('notifications-dropdown')) {
            const dropdown = document.createElement('div');
            dropdown.id = 'notifications-dropdown';
            dropdown.className = 'notifications-dropdown absolute right-0 mt-2 w-80 bg-white dark:bg-neutral-800 rounded-lg shadow-lg border border-neutral-200 dark:border-neutral-700 hidden z-50';
            dropdown.innerHTML = `
                <div class="p-4 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">Notificaciones</h3>
                        <button id="mark-all-read" class="text-sm text-primary-600 hover:text-primary-700">Marcar todo como leído</button>
                    </div>
                </div>
                <div id="notifications-list" class="max-h-96 overflow-y-auto">
                    <div class="p-4 text-center text-neutral-500 dark:text-neutral-400">
                        No hay notificaciones nuevas
                    </div>
                </div>
            `;
            document.body.appendChild(dropdown);
        }

        // Event listeners
        notificationBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const dropdown = document.getElementById('notifications-dropdown');
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden')) {
                this.updateUI(); // Refrescar lista al abrir
            }
        });

        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('notifications-dropdown');
            const btn = document.querySelector('a[href*="anuncios"], a[href="#"].p-2.rounded-full.relative, a.p-2.rounded-full.relative');
            if (dropdown && btn && !dropdown.contains(e.target) && !btn.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.getElementById('mark-all-read').addEventListener('click', (e) => {
            e.stopPropagation();
            this.markAllAsRead();
        });
    }

    // Simular fetch de notificaciones (lógica real con localStorage y generación dinámica)
    async fetchNotifications() {
        try {
            // Simular llamada API - en producción, reemplazar con fetch real
            // Aquí usamos localStorage como backend simulado
            this.notifications = this.loadNotifications();
            this.unreadCount = this.notifications.filter(n => !n.is_read).length;

            // Lógica real: Generar notificación aleatoria cada cierto tiempo para demo
            if (Math.random() < 0.2 && this.notifications.length < 10) { // 20% chance
                const newNotif = {
                    id: Date.now(),
                    title: "Nueva actualización disponible",
                    message: `Recurso actualizado en ${new Date().toLocaleString('es-MX')}.`,
                    created_at: new Date().toISOString(),
                    is_read: false
                };
                this.notifications.unshift(newNotif);
                this.saveNotifications();
                this.unreadCount++;
            }

            this.updateUI();
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    }

    // Marcar como leída (lógica real en localStorage)
    async markAsRead(notificationId) {
        try {
            // Encontrar y actualizar
            const notif = this.notifications.find(n => n.id === notificationId);
            if (notif) {
                notif.is_read = true;
                this.saveNotifications();
                this.unreadCount = this.notifications.filter(n => !n.is_read).length;
                this.updateUI();
            }
            // En producción, POST a /api/notifications/read
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    // Marcar todas como leídas (lógica real en localStorage)
    async markAllAsRead() {
        try {
            this.notifications.forEach(n => n.is_read = true);
            this.saveNotifications();
            this.unreadCount = 0;
            this.updateUI();
            // En producción, POST a /api/notifications/read-all
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }

    updateUI() {
        const badge = document.getElementById('notification-badge');
        const list = document.getElementById('notifications-list');
        const dropdown = document.getElementById('notifications-dropdown');

        // Actualizar badge
        if (badge) {
            if (this.unreadCount > 0) {
                badge.style.display = 'flex';
                badge.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
                badge.classList.remove('w-2', 'min-w-[8px]');
                badge.classList.add('min-w-[18px]', 'h-5');
            } else {
                badge.style.display = 'none';
                badge.textContent = '';
                badge.classList.remove('min-w-[18px]', 'h-5');
                badge.classList.add('w-2', 'min-w-[8px]');
            }
        }

        // Actualizar lista
        if (this.notifications.length > 0) {
            list.innerHTML = this.notifications.map(notif => `
                <div class="notification-item p-4 border-b border-neutral-200 dark:border-neutral-700 ${notif.is_read ? 'opacity-60' : ''} hover:bg-neutral-50 dark:hover:bg-neutral-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 dark:text-white">${notif.title}</h4>
                            <p class="text-sm text-neutral-600 dark:text-neutral-300">${notif.message}</p>
                            <span class="text-xs text-neutral-500 dark:text-neutral-400">${new Date(notif.created_at).toLocaleString('es-MX')}</span>
                        </div>
                        ${!notif.is_read ? `
                            <button onclick="notifications.markAsRead(${notif.id})" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 p-1 rounded" title="Marcar como leída">
                                <i data-feather="check"></i>
                            </button>
                        ` : ''}
                    </div>
                </div>
            `).join('');
            feather.replace();
        } else {
            list.innerHTML = `
                <div class="p-4 text-center text-neutral-500 dark:text-neutral-400">
                    No hay notificaciones nuevas
                </div>
            `;
        }

        // Cerrar dropdown si no hay notificaciones
        if (this.notifications.length === 0 && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
        }
    }

    startPolling() {
        this.fetchNotifications();
        setInterval(() => this.fetchNotifications(), 30000); // Actualizar cada 30 segundos
    }
}

// Inicializar el manejador de notificaciones
const notifications = new NotificationsManager();