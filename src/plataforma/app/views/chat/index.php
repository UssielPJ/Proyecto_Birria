<?php
// Verificar sesión
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
  header('Location: /src/plataforma/login'); 
  exit;
}

// Obtener información del usuario actual
$currentUser = $_SESSION['user'];
$userRole = $currentUser['roles'][0] ?? 'student';

// Determinar qué layout usar según el rol
$layoutFile = '';
switch ($userRole) {
  case 'admin':
    $layoutFile = __DIR__ . '/../layouts/admin.php';
    break;
  case 'teacher':
    $layoutFile = __DIR__ . '/../layouts/teacher.php';
    break;
  case 'capturista':
    $layoutFile = __DIR__ . '/../layouts/capturista.php';
    break;
  case 'student':
  default:
    $layoutFile = __DIR__ . '/../layouts/student.php';
    break;
}

// Incluir el layout
include $layoutFile;
?>

<!-- Contenido principal de la vista de chat -->
<div class="flex h-full">
  <!-- Panel izquierdo - Lista de conversaciones -->
  <div class="w-80 bg-white dark:bg-neutral-800 border-r border-neutral-200 dark:border-neutral-700 flex flex-col">
    <!-- Encabezado -->
    <div class="p-4 border-b border-neutral-200 dark:border-neutral-700">
      <div class="flex items-center gap-3">
        <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 w-auto rounded">
        <div>
          <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-200">Chat UTSC</h2>
          <p class="text-sm text-neutral-500 dark:text-neutral-400">Conecta con tu comunidad</p>
        </div>
      </div>

      <!-- Barra de búsqueda -->
      <div class="relative mt-4">
        <input type="text" id="chat-search" placeholder="Buscar conversaciones o contactos..." 
               class="w-full px-4 py-2 pl-10 bg-neutral-100 dark:bg-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        <i data-feather="search" class="absolute left-3 top-2.5 w-5 h-5 text-neutral-400"></i>
      </div>
    </div>

    <!-- Pestañas -->
    <div class="flex border-b border-neutral-200 dark:border-neutral-700">
      <button id="chats-tab" class="flex-1 py-3 text-center font-medium text-primary-600 dark:text-primary-400 border-b-2 border-primary-600 dark:border-primary-400">
        Chats
      </button>
      <button id="contacts-tab" class="flex-1 py-3 text-center font-medium text-neutral-500 dark:text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-300">
        Contactos
      </button>
    </div>

    <!-- Lista de conversaciones -->
    <div id="conversations-list" class="flex-1 overflow-y-auto">
      <!-- Las conversaciones se cargarán dinámicamente -->
    </div>

    <!-- Lista de contactos -->
    <div id="contacts-list" class="flex-1 overflow-y-auto hidden">
      <!-- Los contactos se cargarán dinámicamente -->
    </div>
  </div>

  <!-- Panel derecho - Conversación activa -->
  <div id="chat-panel" class="flex-1 flex flex-col bg-neutral-50 dark:bg-neutral-900">
    <!-- Vista de bienvenida (sin conversación seleccionada) -->
    <div id="welcome-view" class="flex-1 flex items-center justify-center">
      <div class="text-center max-w-md p-6">
        <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-20 w-auto mx-auto mb-4 rounded-lg">
        <h3 class="text-2xl font-bold text-neutral-800 dark:text-neutral-200 mb-2">Bienvenido al Chat UTSC</h3>
        <p class="text-neutral-600 dark:text-neutral-400 mb-6">Selecciona una conversación para empezar a chatear con tu comunidad académica.</p>
        <button id="new-chat-btn" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
          <i data-feather="plus-circle" class="inline-block w-5 h-5 mr-2"></i>
          Nueva Conversación
        </button>
      </div>
    </div>

    <!-- Vista de conversación (oculta por defecto) -->
    <div id="conversation-view" class="flex-1 flex flex-col hidden">
      <!-- Cabecera de conversación -->
      <div class="bg-white dark:bg-neutral-800 p-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <button id="back-to-conversations" class="lg:hidden p-1 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
            <i data-feather="arrow-left" class="w-5 h-5"></i>
          </button>
          <div id="chat-user-avatar" class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
            <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
          </div>
          <div>
            <p id="chat-user-name" class="font-medium text-neutral-800 dark:text-neutral-200">Nombre de usuario</p>
            <p id="chat-user-status" class="text-sm text-green-500">En línea</p>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <button class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700" title="Iniciar videollamada">
            <i data-feather="video" class="w-5 h-5 text-neutral-600 dark:text-neutral-400"></i>
          </button>
          <button class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700" title="Iniciar llamada">
            <i data-feather="phone" class="w-5 h-5 text-neutral-600 dark:text-neutral-400"></i>
          </button>
          <button class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700" title="Ver información">
            <i data-feather="info" class="w-5 h-5 text-neutral-600 dark:text-neutral-400"></i>
          </button>
        </div>
      </div>

      <!-- Mensajes -->
      <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
        <!-- Los mensajes se cargarán dinámicamente -->
      </div>

      <!-- Input de mensaje -->
      <div class="bg-white dark:bg-neutral-800 p-4 border-t border-neutral-200 dark:border-neutral-700">
        <form id="message-form" class="flex items-center gap-2">
          <button type="button" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700" title="Adjuntar archivo">
            <i data-feather="paperclip" class="w-5 h-5 text-neutral-600 dark:text-neutral-400"></i>
          </button>
          <input type="text" id="message-input" placeholder="Escribe un mensaje..." 
                 class="flex-1 px-4 py-2 bg-neutral-100 dark:bg-neutral-700 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500">
          <button type="button" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700" title="Enviar emoji">
            <i data-feather="smile" class="w-5 h-5 text-neutral-600 dark:text-neutral-400"></i>
          </button>
          <button type="submit" class="p-2 bg-primary-600 hover:bg-primary-700 text-white rounded-full transition-colors">
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
  const chatsTab = document.getElementById('chats-tab');
  const contactsTab = document.getElementById('contacts-tab');
  const conversationsList = document.getElementById('conversations-list');
  const contactsList = document.getElementById('contacts-list');
  const chatSearch = document.getElementById('chat-search');
  const welcomeView = document.getElementById('welcome-view');
  const conversationView = document.getElementById('conversation-view');
  const backToConversations = document.getElementById('back-to-conversations');
  const newChatBtn = document.getElementById('new-chat-btn');
  const chatMessages = document.getElementById('chat-messages');
  const messageForm = document.getElementById('message-form');
  const messageInput = document.getElementById('message-input');
  const chatUserName = document.getElementById('chat-user-name');
  const chatUserAvatar = document.getElementById('chat-user-avatar');
  const chatUserStatus = document.getElementById('chat-user-status');

  // Estado del chat
  let currentChatUser = null;
  let currentTab = 'chats';

  // Event listeners
  chatsTab.addEventListener('click', () => switchTab('chats'));
  contactsTab.addEventListener('click', () => switchTab('contacts'));
  backToConversations.addEventListener('click', showWelcomeView);
  newChatBtn.addEventListener('click', showNewChatDialog);
  chatSearch.addEventListener('input', filterList);
  messageForm.addEventListener('submit', sendMessage);

  // Funciones
  function switchTab(tab) {
    currentTab = tab;

    // Actualizar pestañas
    if (tab === 'chats') {
      chatsTab.classList.add('text-primary-600', 'dark:text-primary-400', 'border-b-2', 'border-primary-600', 'dark:border-primary-400');
      chatsTab.classList.remove('text-neutral-500', 'dark:text-neutral-400');
      contactsTab.classList.remove('text-primary-600', 'dark:text-primary-400', 'border-b-2', 'border-primary-600', 'dark:border-primary-400');
      contactsTab.classList.add('text-neutral-500', 'dark:text-neutral-400');

      // Mostrar lista de conversaciones
      conversationsList.classList.remove('hidden');
      contactsList.classList.add('hidden');

      // Cargar conversaciones
      loadConversations();
    } else {
      contactsTab.classList.add('text-primary-600', 'dark:text-primary-400', 'border-b-2', 'border-primary-600', 'dark:border-primary-400');
      contactsTab.classList.remove('text-neutral-500', 'dark:text-neutral-400');
      chatsTab.classList.remove('text-primary-600', 'dark:text-primary-400', 'border-b-2', 'border-primary-600', 'dark:border-primary-400');
      chatsTab.classList.add('text-neutral-500', 'dark:text-neutral-400');

      // Mostrar lista de contactos
      contactsList.classList.remove('hidden');
      conversationsList.classList.add('hidden');

      // Cargar contactos
      loadContacts();
    }
  }

  function showWelcomeView() {
    welcomeView.classList.remove('hidden');
    conversationView.classList.add('hidden');
    currentChatUser = null;
  }

  function showConversation(userId, userName, userAvatar, isOnline) {
    currentChatUser = userId;

    // Actualizar información del usuario
    chatUserName.textContent = userName;
    chatUserStatus.textContent = isOnline ? 'En línea' : 'Desconectado';
    chatUserStatus.className = isOnline ? 'text-sm text-green-500' : 'text-sm text-neutral-500 dark:text-neutral-400';

    // Actualizar avatar
    if (userAvatar) {
      chatUserAvatar.innerHTML = `<img src="${userAvatar}" alt="${userName}" class="w-full h-full rounded-full object-cover">`;
    } else {
      chatUserAvatar.innerHTML = '<i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>';
    }

    // Mostrar conversación
    welcomeView.classList.add('hidden');
    conversationView.classList.remove('hidden');

    // Cargar mensajes
    loadMessages(userId);

    // Enfocar input de mensaje
    messageInput.focus();

    // Actualizar iconos
    if (window.feather) feather.replace();
  }

  function loadConversations() {
    // Simular carga de conversaciones
    const conversations = [
      { 
        id: 1, 
        name: 'Juan Pérez', 
        role: 'Estudiante', 
        avatar: null, 
        online: true, 
        lastMessage: 'Hola, ¿cómo estás?', 
        time: '10:30 AM',
        unread: 2 
      },
      { 
        id: 2, 
        name: 'María González', 
        role: 'Maestra', 
        avatar: null, 
        online: false, 
        lastMessage: 'Gracias por la información', 
        time: 'Ayer',
        unread: 0 
      },
      { 
        id: 3, 
        name: 'Carlos Rodríguez', 
        role: 'Estudiante', 
        avatar: null, 
        online: true, 
        lastMessage: '¿Podemos revisar la tarea?', 
        time: 'Lunes',
        unread: 1 
      },
      { 
        id: 4, 
        name: 'Ana López', 
        role: 'Maestra', 
        avatar: null, 
        online: true, 
        lastMessage: 'Nos vemos mañana', 
        time: 'Domingo',
        unread: 0 
      },
      { 
        id: 5, 
        name: 'Luis Martínez', 
        role: 'Administrador', 
        avatar: null, 
        online: false, 
        lastMessage: 'Por favor envía los documentos', 
        time: 'Semana pasada',
        unread: 0 
      }
    ];

    // Limpiar contenedor
    conversationsList.innerHTML = '';

    // Agregar conversaciones
    conversations.forEach(conversation => {
      const conversationElement = createConversationElement(conversation);
      conversationsList.appendChild(conversationElement);
    });

    // Actualizar iconos
    if (window.feather) feather.replace();
  }

  function createConversationElement(conversation) {
    const div = document.createElement('div');
    div.className = 'flex items-center gap-3 p-4 hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors conversation-item';
    div.dataset.userId = conversation.id;
    div.dataset.userName = conversation.name;
    div.dataset.userOnline = conversation.online;

    // Avatar
    const avatarDiv = document.createElement('div');
    avatarDiv.className = 'relative flex-shrink-0';

    const avatarInner = document.createElement('div');
    avatarInner.className = 'w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center';

    if (conversation.avatar) {
      const img = document.createElement('img');
      img.src = conversation.avatar;
      img.alt = conversation.name;
      img.className = 'w-full h-full rounded-full object-cover';
      avatarInner.appendChild(img);
    } else {
      const icon = document.createElement('i');
      icon.setAttribute('data-feather', 'user');
      icon.className = 'text-primary-700 dark:text-primary-300';
      avatarInner.appendChild(icon);
    }

    avatarDiv.appendChild(avatarInner);

    // Indicador de estado en línea
    const onlineIndicator = document.createElement('div');
    onlineIndicator.className = `absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white dark:border-neutral-800 ${
      conversation.online ? 'bg-green-500' : 'bg-neutral-400'
    }`;
    avatarDiv.appendChild(onlineIndicator);

    // Info
    const infoDiv = document.createElement('div');
    infoDiv.className = 'flex-1 min-w-0';

    const nameRow = document.createElement('div');
    nameRow.className = 'flex items-center justify-between mb-1';

    const nameP = document.createElement('p');
    nameP.className = 'font-medium text-neutral-800 dark:text-neutral-200 truncate';
    nameP.textContent = conversation.name;

    const timeP = document.createElement('p');
    timeP.className = 'text-xs text-neutral-500 dark:text-neutral-400';
    timeP.textContent = conversation.time;

    nameRow.appendChild(nameP);
    nameRow.appendChild(timeP);

    const roleP = document.createElement('p');
    roleP.className = 'text-xs text-neutral-500 dark:text-neutral-400 truncate';
    roleP.textContent = conversation.role;

    const messageRow = document.createElement('div');
    messageRow.className = 'flex items-center justify-between';

    const messageP = document.createElement('p');
    messageP.className = 'text-sm text-neutral-600 dark:text-neutral-400 truncate';
    messageP.textContent = conversation.lastMessage;

    messageRow.appendChild(messageP);

    // Indicador de mensajes no leídos
    if (conversation.unread > 0) {
      const unreadBadge = document.createElement('div');
      unreadBadge.className = 'bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
      unreadBadge.textContent = conversation.unread;
      messageRow.appendChild(unreadBadge);
    }

    infoDiv.appendChild(nameRow);
    infoDiv.appendChild(roleP);
    infoDiv.appendChild(messageRow);

    // Ensamblar
    div.appendChild(avatarDiv);
    div.appendChild(infoDiv);

    // Event listener
    div.addEventListener('click', () => {
      showConversation(conversation.id, conversation.name, conversation.avatar, conversation.online);
    });

    return div;
  }

  function loadContacts() {
    // Simular carga de contactos
    const contacts = [
      { id: 6, name: 'Roberto Sánchez', role: 'Estudiante', avatar: null, online: true },
      { id: 7, name: 'Carmen Torres', role: 'Maestra', avatar: null, online: false },
      { id: 8, name: 'Diego Herrera', role: 'Estudiante', avatar: null, online: true },
      { id: 9, name: 'Patricia Morales', role: 'Maestra', avatar: null, online: true },
      { id: 10, name: 'Javier Vargas', role: 'Capturista', avatar: null, online: false }
    ];

    // Limpiar contenedor
    contactsList.innerHTML = '';

    // Agregar contactos
    contacts.forEach(contact => {
      const contactElement = createContactElement(contact);
      contactsList.appendChild(contactElement);
    });

    // Actualizar iconos
    if (window.feather) feather.replace();
  }

  function createContactElement(contact) {
    const div = document.createElement('div');
    div.className = 'flex items-center gap-3 p-4 hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors contact-item';
    div.dataset.userId = contact.id;
    div.dataset.userName = contact.name;
    div.dataset.userOnline = contact.online;

    // Avatar
    const avatarDiv = document.createElement('div');
    avatarDiv.className = 'relative flex-shrink-0';

    const avatarInner = document.createElement('div');
    avatarInner.className = 'w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center';

    if (contact.avatar) {
      const img = document.createElement('img');
      img.src = contact.avatar;
      img.alt = contact.name;
      img.className = 'w-full h-full rounded-full object-cover';
      avatarInner.appendChild(img);
    } else {
      const icon = document.createElement('i');
      icon.setAttribute('data-feather', 'user');
      icon.className = 'text-primary-700 dark:text-primary-300';
      avatarInner.appendChild(icon);
    }

    avatarDiv.appendChild(avatarInner);

    // Indicador de estado en línea
    const onlineIndicator = document.createElement('div');
    onlineIndicator.className = `absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white dark:border-neutral-800 ${
      contact.online ? 'bg-green-500' : 'bg-neutral-400'
    }`;
    avatarDiv.appendChild(onlineIndicator);

    // Info
    const infoDiv = document.createElement('div');
    infoDiv.className = 'flex-1 min-w-0';

    const nameP = document.createElement('p');
    nameP.className = 'font-medium text-neutral-800 dark:text-neutral-200 truncate';
    nameP.textContent = contact.name;

    const roleP = document.createElement('p');
    roleP.className = 'text-sm text-neutral-500 dark:text-neutral-400 truncate';
    roleP.textContent = contact.role;

    infoDiv.appendChild(nameP);
    infoDiv.appendChild(roleP);

    // Botón de mensaje
    const messageBtn = document.createElement('button');
    messageBtn.className = 'p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700';
    messageBtn.innerHTML = '<i data-feather="message-circle" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>';

    // Ensamblar
    div.appendChild(avatarDiv);
    div.appendChild(infoDiv);
    div.appendChild(messageBtn);

    // Event listeners
    div.addEventListener('click', (e) => {
      if (!e.target.closest('button')) {
        showConversation(contact.id, contact.name, contact.avatar, contact.online);
      }
    });

    messageBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      showConversation(contact.id, contact.name, contact.avatar, contact.online);
    });

    return div;
  }

  function showNewChatDialog() {
    // Aquí podrías mostrar un diálogo para seleccionar un contacto
    // Por ahora, simplemente mostramos la lista de contactos
    switchTab('contacts');
  }

  function filterList() {
    const searchTerm = chatSearch.value.toLowerCase();

    if (currentTab === 'chats') {
      document.querySelectorAll('.conversation-item').forEach(item => {
        const userName = item.dataset.userName.toLowerCase();
        if (userName.includes(searchTerm)) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    } else {
      document.querySelectorAll('.contact-item').forEach(item => {
        const userName = item.dataset.userName.toLowerCase();
        if (userName.includes(searchTerm)) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    }
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
        ? 'bg-primary-600 text-white rounded-br-none'
        : 'bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 rounded-bl-none border border-neutral-200 dark:border-neutral-700'
    }`;

    const contentP = document.createElement('p');
    contentP.textContent = message.content;

    const timestampP = document.createElement('p');
    timestampP.className = `text-xs mt-1 ${
      message.sender === 'me' ? 'text-primary-200' : 'text-neutral-500 dark:text-neutral-400'
    }`;
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
      if (document.hidden) {
        showNotification(chatUserName.textContent, response.content);
      }
    }, 1000 + Math.random() * 2000);
  }

  function showNotification(title, message) {
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

  // Inicializar
  loadConversations();
});
</script>

<style>
/* Estilos adicionales para el chat */
#conversations-list, #contacts-list {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f1f5f9;
}

#conversations-list::-webkit-scrollbar, #contacts-list::-webkit-scrollbar {
  width: 6px;
}

#conversations-list::-webkit-scrollbar-track, #contacts-list::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

#conversations-list::-webkit-scrollbar-thumb, #contacts-list::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

.dark #conversations-list, .dark #contacts-list {
  scrollbar-color: #4b5563 #1f2937;
}

.dark #conversations-list::-webkit-scrollbar-track, .dark #contacts-list::-webkit-scrollbar-track {
  background: #1f2937;
}

.dark #conversations-list::-webkit-scrollbar-thumb, .dark #contacts-list::-webkit-scrollbar-thumb {
  background: #4b5563;
}

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
@media (max-width: 1024px) {
  .flex.h-full {
    height: calc(100vh - 64px);
  }
}
</style>
