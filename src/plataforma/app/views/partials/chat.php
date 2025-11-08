<?php
// Componente de chat flotante
?>
<!-- Botón de chat flotante -->
<div id="chat-button" class="fixed bottom-6 right-6 z-50">
  <button id="chat-toggle" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 group">
    <i data-feather="message-circle" class="w-6 h-6"></i>
    <span id="chat-badge" class="absolute top-0 right-0 h-3 w-3 bg-red-500 rounded-full hidden"></span>
  </button>
</div>

<!-- Ventana de chat -->
<div id="chat-container" class="fixed bottom-24 right-6 w-96 h-[500px] bg-white dark:bg-neutral-800 rounded-t-2xl shadow-2xl z-50 hidden flex flex-col transition-all duration-300 transform">
  <!-- Cabecera del chat -->
  <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-t-2xl flex items-center justify-between">
    <div class="flex items-center gap-3">
      <i data-feather="message-circle" class="w-6 h-6"></i>
      <h3 class="font-semibold text-lg">Chat UTSC</h3>
    </div>
    <button id="chat-close" class="text-white hover:bg-white/20 rounded-full p-1 transition-colors">
      <i data-feather="x" class="w-5 h-5"></i>
    </button>
  </div>

  <!-- Lista de contactos o conversación -->
  <div id="chat-view" class="flex-1 flex flex-col overflow-hidden">
    <!-- Vista de lista de contactos -->
    <div id="contacts-list" class="flex-1 overflow-y-auto p-4">
      <!-- Barra de búsqueda -->
      <div class="relative mb-4">
        <input type="text" id="chat-search" placeholder="Buscar por nombre o matrícula..." 
               class="w-full px-4 py-2 pl-10 bg-neutral-100 dark:bg-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <i data-feather="search" class="absolute left-3 top-2.5 w-5 h-5 text-neutral-400"></i>
      </div>

      <!-- Lista de contactos -->
      <div id="contacts-container" class="space-y-2">
        <!-- Los contactos se cargarán dinámicamente -->
      </div>
    </div>

    <!-- Vista de conversación -->
    <div id="conversation-view" class="flex-1 flex flex-col hidden">
      <!-- Cabecera de conversación -->
      <div class="bg-neutral-100 dark:bg-neutral-700 p-3 flex items-center gap-3 border-b border-neutral-200 dark:border-neutral-600">
        <button id="back-to-contacts" class="lg:hidden">
          <i data-feather="arrow-left" class="w-5 h-5"></i>
        </button>
        <div id="chat-user-avatar" class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
          <i data-feather="user" class="text-blue-600 dark:text-blue-400"></i>
        </div>
        <div>
          <p id="chat-user-name" class="font-medium">Nombre de usuario</p>
          <p id="chat-user-status" class="text-xs text-green-500">En línea</p>
        </div>
      </div>

      <!-- Mensajes -->
      <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3">
        <!-- Los mensajes se cargarán dinámicamente -->
      </div>

      <!-- Input de mensaje -->
      <div class="p-3 border-t border-neutral-200 dark:border-neutral-600">
        <form id="message-form" class="flex gap-2">
          <input type="text" id="message-input" placeholder="Escribe un mensaje..." 
                 class="flex-1 px-4 py-2 bg-neutral-100 dark:bg-neutral-700 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-full p-2 transition-colors">
            <i data-feather="send" class="w-5 h-5"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar iconos de feather
  if (window.feather) feather.replace();

  // Elementos del DOM
  const chatButton = document.getElementById('chat-button');
  const chatToggle = document.getElementById('chat-toggle');
  const chatContainer = document.getElementById('chat-container');
  const chatClose = document.getElementById('chat-close');
  const contactsList = document.getElementById('contacts-list');
  const conversationView = document.getElementById('conversation-view');
  const backToContacts = document.getElementById('back-to-contacts');
  const chatSearch = document.getElementById('chat-search');
  const contactsContainer = document.getElementById('contacts-container');
  const chatMessages = document.getElementById('chat-messages');
  const messageForm = document.getElementById('message-form');
  const messageInput = document.getElementById('message-input');
  const chatUserName = document.getElementById('chat-user-name');
  const chatUserAvatar = document.getElementById('chat-user-avatar');
  const chatUserStatus = document.getElementById('chat-user-status');
  const chatBadge = document.getElementById('chat-badge');

  // Estado del chat
  let currentChatUser = null;
  let chatOpen = false;

  // Event listeners
  chatToggle.addEventListener('click', toggleChat);
  chatClose.addEventListener('click', closeChat);
  backToContacts.addEventListener('click', showContactsList);
  chatSearch.addEventListener('input', filterContacts);
  messageForm.addEventListener('submit', sendMessage);

  // Funciones
  function toggleChat() {
    chatOpen = !chatOpen;
    if (chatOpen) {
      chatContainer.classList.remove('hidden');
      loadContacts();
    } else {
      chatContainer.classList.add('hidden');
    }
  }

  function closeChat() {
    chatContainer.classList.add('hidden');
    chatOpen = false;
  }

  function showContactsList() {
    contactsList.classList.remove('hidden');
    conversationView.classList.add('hidden');
  }

  function showConversation(userId, userName, userAvatar, isOnline) {
    currentChatUser = userId;

    // Actualizar información del usuario
    chatUserName.textContent = userName;
    chatUserStatus.textContent = isOnline ? 'En línea' : 'Desconectado';
    chatUserStatus.className = isOnline ? 'text-xs text-green-500' : 'text-xs text-neutral-500';

    // Mostrar conversación
    contactsList.classList.add('hidden');
    conversationView.classList.remove('hidden');

    // Cargar mensajes
    loadMessages(userId);

    // Enfocar input de mensaje
    messageInput.focus();
  }

  function loadContacts() {
    // Simular carga de contactos
    const contacts = [
      { id: 1, name: 'Juan Pérez', role: 'Estudiante', avatar: null, online: true, lastMessage: 'Hola, ¿cómo estás?' },
      { id: 2, name: 'María González', role: 'Maestra', avatar: null, online: false, lastMessage: 'Gracias por la información' },
      { id: 3, name: 'Carlos Rodríguez', role: 'Estudiante', avatar: null, online: true, lastMessage: '¿Podemos revisar la tarea?' },
      { id: 4, name: 'Ana López', role: 'Maestra', avatar: null, online: true, lastMessage: 'Nos vemos mañana' },
      { id: 5, name: 'Luis Martínez', role: 'Administrador', avatar: null, online: false, lastMessage: 'Por favor envía los documentos' }
    ];

    // Limpiar contenedor
    contactsContainer.innerHTML = '';

    // Agregar contactos
    contacts.forEach(contact => {
      const contactElement = createContactElement(contact);
      contactsContainer.appendChild(contactElement);
    });

    // Actualizar iconos
    if (window.feather) feather.replace();
  }

  function createContactElement(contact) {
    const div = document.createElement('div');
    div.className = 'flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors contact-item';
    div.dataset.userId = contact.id;
    div.dataset.userName = contact.name;
    div.dataset.userOnline = contact.online;

    // Avatar
    const avatarDiv = document.createElement('div');
    avatarDiv.className = 'w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center flex-shrink-0';

    if (contact.avatar) {
      const img = document.createElement('img');
      img.src = contact.avatar;
      img.alt = contact.name;
      img.className = 'w-full h-full rounded-full object-cover';
      avatarDiv.appendChild(img);
    } else {
      const icon = document.createElement('i');
      icon.setAttribute('data-feather', 'user');
      icon.className = 'text-blue-600 dark:text-blue-400';
      avatarDiv.appendChild(icon);
    }

    // Info
    const infoDiv = document.createElement('div');
    infoDiv.className = 'flex-1 min-w-0';

    const nameP = document.createElement('p');
    nameP.className = 'font-medium truncate';
    nameP.textContent = contact.name;

    const roleP = document.createElement('p');
    roleP.className = 'text-xs text-neutral-500 dark:text-neutral-400 truncate';
    roleP.textContent = contact.role;

    const messageP = document.createElement('p');
    messageP.className = 'text-sm text-neutral-600 dark:text-neutral-400 truncate';
    messageP.textContent = contact.lastMessage;

    infoDiv.appendChild(nameP);
    infoDiv.appendChild(roleP);
    infoDiv.appendChild(messageP);

    // Estado en línea
    const statusDiv = document.createElement('div');
    statusDiv.className = 'flex flex-col items-end gap-1';

    const onlineIndicator = document.createElement('div');
    onlineIndicator.className = `w-3 h-3 rounded-full ${contact.online ? 'bg-green-500' : 'bg-neutral-400'}`;

    statusDiv.appendChild(onlineIndicator);

    // Ensamblar
    div.appendChild(avatarDiv);
    div.appendChild(infoDiv);
    div.appendChild(statusDiv);

    // Event listener
    div.addEventListener('click', () => {
      showConversation(contact.id, contact.name, contact.avatar, contact.online);
    });

    return div;
  }

  function filterContacts() {
    const searchTerm = chatSearch.value.toLowerCase();

    document.querySelectorAll('.contact-item').forEach(item => {
      const userName = item.dataset.userName.toLowerCase();
      if (userName.includes(searchTerm)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  }

  function loadMessages(userId) {
    // Simular carga de mensajes
    const messages = [
      { id: 1, sender: 'other', content: 'Hola, ¿cómo estás?', timestamp: '10:30 AM' },
      { id: 2, sender: 'me', content: 'Hola, bien gracias. ¿Y tú?', timestamp: '10:32 AM' },
      { id: 3, sender: 'other', content: 'Todo bien por aquí. ¿Ya revisaste la tarea?', timestamp: '10:35 AM' },
      { id: 4, sender: 'me', content: 'Sí, ya la terminé. ¿Cuándo la entregamos?', timestamp: '10:40 AM' },
      { id: 5, sender: 'other', content: 'Mañana en clase. No olvides imprimirla', timestamp: '10:42 AM' }
    ];

    // Limpiar contenedor
    chatMessages.innerHTML = '';

    // Agregar mensajes
    messages.forEach(message => {
      const messageElement = createMessageElement(message);
      chatMessages.appendChild(messageElement);
    });

    // Scroll al final
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function createMessageElement(message) {
    const div = document.createElement('div');
    div.className = `flex ${message.sender === 'me' ? 'justify-end' : 'justify-start'}`;

    const messageBubble = document.createElement('div');
    messageBubble.className = `max-w-[70%] px-4 py-2 rounded-2xl ${
      message.sender === 'me' 
        ? 'bg-blue-500 text-white rounded-br-none' 
        : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200 rounded-bl-none'
    }`;

    const contentP = document.createElement('p');
    contentP.textContent = message.content;

    const timestampP = document.createElement('p');
    timestampP.className = `text-xs mt-1 ${message.sender === 'me' ? 'text-blue-100' : 'text-neutral-500 dark:text-neutral-400'}`;
    timestampP.textContent = message.timestamp;

    messageBubble.appendChild(contentP);
    messageBubble.appendChild(timestampP);
    div.appendChild(messageBubble);

    return div;
  }

  function sendMessage(e) {
    e.preventDefault();

    const content = messageInput.value.trim();
    if (!content || !currentChatUser) return;

    // Crear mensaje
    const message = {
      id: Date.now(),
      sender: 'me',
      content: content,
      timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    };

    // Agregar mensaje al chat
    const messageElement = createMessageElement(message);
    chatMessages.appendChild(messageElement);

    // Limpiar input
    messageInput.value = '';

    // Scroll al final
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Simular respuesta
    setTimeout(() => {
      const response = {
        id: Date.now() + 1,
        sender: 'other',
        content: 'Gracias por tu mensaje. Te responderé pronto.',
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
      };

      const responseElement = createMessageElement(response);
      chatMessages.appendChild(responseElement);
      chatMessages.scrollTop = chatMessages.scrollHeight;

      // Mostrar notificación
      showNotification(chatUserName.textContent, response.content);
    }, 1000 + Math.random() * 2000);
  }

  function showNotification(title, message) {
    // Mostrar badge en el botón de chat
    chatBadge.classList.remove('hidden');

    // Crear notificación (simplificado)
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification(title, {
        body: message,
        icon: '/src/plataforma/app/img/UT.jpg'
      });
    }
  }

  // Solicitar permiso para notificaciones
  if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
  }

  // Simular recepción de mensajes
  setInterval(() => {
    if (chatOpen || Math.random() > 0.1) return; // 10% de probabilidad de recibir mensaje

    const randomContact = Math.floor(Math.random() * 5) + 1;
    const messages = [
      '¿Podemos hablar sobre el proyecto?',
      '¿Cuándo es la próxima clase?',
      'Necesito ayuda con la tarea',
      '¿Ya viste el anuncio nuevo?',
      'Gracias por tu ayuda'
    ];

    const randomMessage = messages[Math.floor(Math.random() * messages.length)];

    // Mostrar badge
    chatBadge.classList.remove('hidden');

    // Mostrar notificación
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification('Nuevo mensaje', {
        body: randomMessage,
        icon: '/src/plataforma/app/img/UT.jpg'
      });
    }
  }, 30000); // Cada 30 segundos
});
</script>

<style>
/* Estilos adicionales para el chat */
#chat-container {
  transform: translateY(0);
  transition: transform 0.3s ease, opacity 0.3s ease;
}

#chat-container.hidden {
  transform: translateY(20px);
  opacity: 0;
}

#chat-button {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
  }
  70% {
    box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
  }
}

/* Estilos para mensajes */
#chat-messages {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f1f5f9;
}

#chat-messages::-webkit-scrollbar {
  width: 6px;
}

#chat-messages::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

#chat-messages::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

.dark #chat-messages {
  scrollbar-color: #4b5563 #1f2937;
}

.dark #chat-messages::-webkit-scrollbar-track {
  background: #1f2937;
}

.dark #chat-messages::-webkit-scrollbar-thumb {
  background: #4b5563;
}

/* Responsive */
@media (max-width: 768px) {
  #chat-container {
    width: calc(100vw - 2rem);
    right: 1rem;
    left: 1rem;
    height: calc(100vh - 8rem);
    bottom: 4rem;
  }
}
</style>
