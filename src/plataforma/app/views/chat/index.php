<?php
// ================== Sesión y rol ==================
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
  header('Location: /src/plataforma/login');
  exit;
}
$currentUser = $_SESSION['user'];
$userRole = $currentUser['roles'][0] ?? 'student';

// ================== Elegir layout ==================
switch ($userRole) {
  case 'admin':      $layoutFile = __DIR__ . '/../layouts/admin.php'; break;
  case 'teacher':    $layoutFile = __DIR__ . '/../layouts/teacher.php'; break;
  case 'capturista': $layoutFile = __DIR__ . '/../layouts/capturista.php'; break;
  default:           $layoutFile = __DIR__ . '/../layouts/student.php'; break;
}

$pageTitle = 'Chat UTSC';
ob_start();
?>

<div id="chat-root" class="flex h-[calc(100vh-4rem)] w-full min-w-0 relative">
  <!-- Panel izquierdo -->
  <div class="w-80 bg-white dark:bg-neutral-800 border-r border-neutral-200 dark:border-neutral-700 flex flex-col min-h-0">
    <div class="p-4 border-b border-neutral-200 dark:border-neutral-700">
      <div class="flex items-center gap-3">
        <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 w-auto rounded">
        <div>
          <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-200">Chat UTSC</h2>
          <p class="text-sm text-neutral-500 dark:text-neutral-400">Conecta con tu comunidad</p>
        </div>
      </div>
      <div class="relative mt-4">
        <input id="chat-search" type="text" placeholder="Buscar conversaciones o contactos..."
          class="w-full px-4 py-2 pl-10 bg-neutral-100 dark:bg-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
        <i data-feather="search" class="absolute left-3 top-2.5 w-5 h-5 text-neutral-400"></i>
      </div>
    </div>

    <!-- Tabs -->
    <div class="flex border-b border-neutral-200 dark:border-neutral-700">
      <button id="chats-tab" class="flex-1 py-3 text-center font-medium text-primary-600 border-b-2 border-primary-600">Chats</button>
      <button id="contacts-tab" class="flex-1 py-3 text-center font-medium text-neutral-500 hover:text-neutral-700">Contactos</button>
    </div>

    <div id="conversations-list" class="flex-1 overflow-y-auto"></div>
    <div id="contacts-list" class="flex-1 overflow-y-auto hidden"></div>
  </div>

  <!-- Panel derecho -->
  <div id="chat-panel" class="flex-1 flex flex-col bg-neutral-50 dark:bg-neutral-900 min-h-0">
    <div id="welcome-view" class="flex-1 flex items-center justify-center min-h-0">
      <div class="text-center max-w-md p-6">
        <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC" class="h-20 w-auto mx-auto mb-4 rounded-lg">
        <h3 class="text-2xl font-bold text-neutral-800 dark:text-neutral-200 mb-2">Bienvenido al Chat UTSC</h3>
        <p class="text-neutral-600 dark:text-neutral-400 mb-6">Selecciona una conversación para empezar a chatear con tu comunidad.</p>
        <button id="new-chat-btn" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
          <i data-feather="plus-circle" class="inline-block w-5 h-5 mr-2"></i> Nueva Conversación
        </button>
      </div>
    </div>

    <div id="conversation-view" class="flex-1 flex flex-col hidden min-h-0">
      <div class="bg-white dark:bg-neutral-800 p-4 border-b border-neutral-200 flex items-center gap-3">
        <button id="back-to-conversations" class="lg:hidden p-1 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="arrow-left" class="w-5 h-5"></i>
        </button>
        <div id="chat-user-avatar" class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center overflow-hidden">
          <i data-feather="user" class="text-primary-700"></i>
        </div>
        <div>
          <p id="chat-user-name" class="font-medium text-neutral-800 dark:text-neutral-200">Usuario</p>
          <p id="chat-user-status" class="text-sm text-green-500">En línea</p>
        </div>
      </div>

      <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4"></div>

      <div class="bg-white dark:bg-neutral-800 p-4 border-t border-neutral-200">
        <form id="message-form" class="flex items-center gap-2">
          <input id="message-input" type="text" placeholder="Escribe un mensaje..."
            class="flex-1 px-4 py-2 bg-neutral-100 dark:bg-neutral-700 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500">
          <button type="submit" class="p-2 bg-primary-600 hover:bg-primary-700 text-white rounded-full transition-colors">
            <i data-feather="send" class="w-5 h-5"></i>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Nueva Conversación -->
  <div id="new-chat-modal" class="hidden absolute inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-2xl w-full max-w-md p-6 relative">
      <button id="close-modal" class="absolute top-3 right-3 text-neutral-500 hover:text-red-500">
        <i data-feather="x" class="w-5 h-5"></i>
      </button>
      <h2 class="text-xl font-bold mb-4 text-neutral-800 dark:text-neutral-100">Nueva conversación</h2>
      <input id="user-search" type="text" placeholder="Buscar usuario..." 
             class="w-full px-4 py-2 mb-3 bg-neutral-100 dark:bg-neutral-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
      <div id="user-list" class="max-h-64 overflow-y-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
        <div class="p-3 text-neutral-500 text-sm">Cargando...</div>
      </div>
    </div>
  </div>
</div>

<script>window.CURRENT_USER_ID = <?php echo (int)($_SESSION['user']['id'] ?? 0); ?>;</script>

<!-- Socket.IO -->
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.feather) feather.replace();

  // ====================== CONFIG ======================
  const ME_ID = <?= (int)($currentUser['id'] ?? 0) ?>;

  // refs
  const welcomeView = document.getElementById('welcome-view');
  const conversationView = document.getElementById('conversation-view');
  const chatMessages = document.getElementById('chat-messages');
  const messageForm = document.getElementById('message-form');
  const messageInput = document.getElementById('message-input');
  const chatUserName = document.getElementById('chat-user-name');
  const chatUserAvatar = document.getElementById('chat-user-avatar');
  const chatUserStatus = document.getElementById('chat-user-status');

  const newChatBtn = document.getElementById('new-chat-btn');
  const modal = document.getElementById('new-chat-modal');
  const closeModal = document.getElementById('close-modal');
  const userSearch = document.getElementById('user-search');
  const userList = document.getElementById('user-list');

  const conversationsList = document.getElementById('conversations-list');
  const contactsList = document.getElementById('contacts-list');

  let currentConversationId = null;
  let socket = null;
  let rtReady = false;
  let searchTimer = null;
  let aborter = null;

  // === anti-duplicados de mensajes ===
  const seenMsgIds = new Set();

  // ====================== SOCKET.IO CONNECT ======================
  async function initRealtime() {
    try {
      const res = await fetch('/src/plataforma/app/chat/token', { credentials: 'include' });
      if (!res.ok) throw new Error('No token: ' + res.status);
      const data = await res.json(); // {token, rt_url}
      const rtUrl = data.rt_url || 'http://localhost:3001';
      socket = io(rtUrl, { auth: { token: data.token }, transports: ['websocket','polling'] });

      socket.on('connect', () => {
        rtReady = true;
        console.log('Realtime conectado, id socket=', socket.id);
        if (ME_ID) socket.emit('join_user', { user_id: ME_ID });
      });

      socket.on('disconnect', () => {
        rtReady = false;
        console.log('Realtime desconectado');
      });

      socket.on('connect_error', (err) => {
        console.warn('socket connect_error', err && err.message);
      });

      // RT: mensaje para conversación abierta
      socket.on('message', (payload) => {
        try {
          if (!payload || !payload.conversation_id) return;
          handleIncomingMessage(payload);
        } catch (e) {
          console.error('message handler error', e);
        }
      });

      // RT: resumen para actualizar la lista/side bar (NO pinta burbujas)
      socket.on('inbox', (brief) => {
        try {
          if (!brief || !brief.conversation_id) return;
          updateOrInsertConversation(Number(brief.conversation_id), {
            body: brief.last_body,
            created_at: brief.at,
            sender_id: brief.sender_id
          });
        } catch (e) {
          console.error('inbox handler error', e);
        }
      });

    } catch (err) {
      console.warn('Realtime init failed:', err);
    }
  }
  initRealtime();

  // ====================== HANDLE INCOMING MESSAGE ======================
  function handleIncomingMessage(payload) {
    // filtro idempotente
    if (payload.id && seenMsgIds.has(payload.id)) return;
    if (payload.id) seenMsgIds.add(payload.id);

    const convId = Number(payload.conversation_id);
    const isMine = Number(payload.sender_id) === Number(ME_ID);

    // 1) Si la conversación está abierta -> añadir/reemplazar mensaje en el chat
    if (currentConversationId && Number(currentConversationId) === convId) {
      // Si soy yo, intenta reemplazar el optimista tmp-*
      if (isMine) {
        const tmp = chatMessages.querySelector('[data-msg-id^="tmp-"]');
        if (tmp) {
          const real = createMessageElement({
            id: payload.id,
            sender: 'me',
            content: payload.body,
            timestamp: formatTime(payload.created_at || null)
          });
          chatMessages.replaceChild(real, tmp);
        } else {
          const msg = {
            id: payload.id,
            sender: 'me',
            content: payload.body,
            timestamp: formatTime(payload.created_at || null)
          };
          chatMessages.appendChild(createMessageElement(msg));
        }
      } else {
        const msg = {
          id: payload.id,
          sender: 'other',
          content: payload.body,
          timestamp: formatTime(payload.created_at || null)
        };
        chatMessages.appendChild(createMessageElement(msg));
      }
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // 2) Actualizar/crear entrada en lista de conversaciones
    updateOrInsertConversation(convId, payload);

    // 3) Notificación si no está abierta
    if (!currentConversationId || Number(currentConversationId) !== convId) {
      if ('Notification' in window && Notification.permission === 'granted') {
        const title = payload.sender_name || 'Nuevo mensaje';
        const body = (payload.body || '').slice(0, 120);
        new Notification(title, { body, icon: '/src/plataforma/app/img/UT.jpg' });
      }
    }
  }

  function formatTime(iso) {
    try {
      if (iso) {
        const d = new Date(iso);
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      }
    } catch(e) {}
    return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  // ====================== ACTUALIZAR / INSERTAR CONVERSACIÓN EN LISTA ======================
  function updateOrInsertConversation(convId, payload) {
    // payload puede venir de 'message' o de 'inbox'
    const lastMsg = (payload.body ?? payload.last_body ?? '');
    const lastTimeIso = (payload.created_at ?? payload.at ?? null);
    const lastTime = formatTime(lastTimeIso);
    const incomingSenderId = Number(payload.sender_id ?? -1);

    let el = conversationsList.querySelector(`[data-conv-id="${convId}"]`);

    if (el) {
      // actualizar texto y hora
      const msgP = el.querySelector('.last-message-text');
      if (msgP) msgP.textContent = lastMsg;
      const timeP = el.querySelector('.time-text');
      if (timeP) timeP.textContent = lastTime;

      // mover al tope
      conversationsList.prepend(el);

      // badge unread (solo si NO soy yo)
      if (incomingSenderId > 0 && incomingSenderId !== Number(ME_ID)) {
        let badge = el.querySelector('.unread-badge');
        if (!badge) {
          badge = document.createElement('div');
          badge.className = 'bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center unread-badge';
          badge.textContent = '1';
          el.querySelector('.last-message-text').parentElement.appendChild(badge);
        } else {
          const current = Number(badge.textContent || 0);
          badge.textContent = String(current + 1);
          badge.style.display = '';
        }
      }
      return;
    }

    // si no existe -> recargar conversaciones (sencillo y consistente con tu backend)
    fetch('/src/plataforma/app/chat/conversations', { credentials: 'include' })
      .then(r => r.ok ? r.json() : Promise.reject(r))
      .then(list => {
        conversationsList.innerHTML = '';
        (Array.isArray(list) ? list : []).forEach(c => conversationsList.appendChild(createConversationElementFromData(c)));
        if (window.feather) feather.replace();
      })
      .catch(err => {
        console.error('No se pudo refrescar conversaciones:', err);
      });
  }

  function createConversationElementFromData(c) {
    const div = document.createElement('div');
    div.className = 'flex items-center gap-3 p-4 hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors conversation-item';
    div.setAttribute('data-conv-id', c.id);
    div.setAttribute('data-user-id', c.partner_id || c.id);

    const avatarDiv = document.createElement('div');
    avatarDiv.className = 'relative flex-shrink-0';
    const avatarInner = document.createElement('div');
    avatarInner.className = 'w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden';
    avatarInner.innerHTML = c.avatar ? `<img src="${c.avatar}" class="w-full h-full object-cover rounded-full">` : '<i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>';
    avatarDiv.appendChild(avatarInner);
    const onlineIndicator = document.createElement('div');
    onlineIndicator.className = `absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white dark:border-neutral-800 ${c.online ? 'bg-green-500' : 'bg-neutral-400'}`;
    avatarDiv.appendChild(onlineIndicator);

    const infoDiv = document.createElement('div');
    infoDiv.className = 'flex-1 min-w-0';
    const nameRow = document.createElement('div');
    nameRow.className = 'flex items-center justify-between mb-1';
    const nameP = document.createElement('p');
    nameP.className = 'font-medium text-neutral-800 dark:text-neutral-200 truncate';
    nameP.textContent = c.name;
    const timeP = document.createElement('p');
    timeP.className = 'text-xs text-neutral-500 dark:text-neutral-400 time-text';
    timeP.textContent = c.time || '';
    nameRow.appendChild(nameP);
    nameRow.appendChild(timeP);

    const roleP = document.createElement('p');
    roleP.className = 'text-xs text-neutral-500 dark:text-neutral-400 truncate';
    roleP.textContent = c.role || '';

    const messageRow = document.createElement('div');
    messageRow.className = 'flex items-center justify-between';
    const messageP = document.createElement('p');
    messageP.className = 'text-sm text-neutral-600 dark:text-neutral-400 truncate last-message-text';
    messageP.textContent = c.lastMessage || '';

    const unreadBadge = document.createElement('div');
    unreadBadge.className = 'bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center unread-badge';
    unreadBadge.textContent = c.unread || '';
    if (!c.unread) unreadBadge.style.display = 'none';

    messageRow.appendChild(messageP);
    messageRow.appendChild(unreadBadge);

    infoDiv.appendChild(nameRow);
    infoDiv.appendChild(roleP);
    infoDiv.appendChild(messageRow);

    div.appendChild(avatarDiv);
    div.appendChild(infoDiv);

    div.addEventListener('click', () => {
      showConversation(c.id, c.name, c.avatar || null, c.online);
      if (socket && rtReady) socket.emit('join', { conversation_id: c.id });
    });

    return div;
  }

  // ====================== CARGA INICIAL DE CONVERSACIONES ======================
  function loadConversations() {
    fetch('/src/plataforma/app/chat/conversations', { credentials: 'include' })
      .then(r => r.ok ? r.json() : Promise.reject(r))
      .then(list => {
        conversationsList.innerHTML = '';
        (Array.isArray(list) ? list : []).forEach(c => conversationsList.appendChild(createConversationElementFromData(c)));
        if (window.feather) feather.replace();
      })
      .catch(err => {
        conversationsList.innerHTML = '<div class="p-4 text-sm text-neutral-500">No se pudieron cargar las conversaciones.</div>';
        console.error('loadConversations error', err);
      });
  }
  loadConversations();

  // ====================== MENSAJES (HTTP fallback) ======================
  function loadMessagesFor(conversationId) {
    chatMessages.innerHTML = '<div class="p-4 text-sm text-neutral-500">Cargando mensajes...</div>';
    fetch(`/src/plataforma/app/chat/messages/${conversationId}`, { credentials: 'include' })
      .then(r => r.ok ? r.json() : Promise.reject(r))
      .then(messages => {
        chatMessages.innerHTML = '';
        (Array.isArray(messages) ? messages : []).forEach(m => chatMessages.appendChild(createMessageElement(m)));
        chatMessages.scrollTop = chatMessages.scrollHeight;
      })
      .catch(err => {
        console.error('messages error:', err);
        chatMessages.innerHTML = '<div class="p-4 text-sm text-red-600">No se pudieron cargar los mensajes.</div>';
      });
  }

  // reuse function name expected by global callers
  function loadMessages(conversationId) { return loadMessagesFor(conversationId); }

  function createMessageElement(message) {
    const div = document.createElement('div');
    if (message.id) div.dataset.msgId = message.id; // para reemplazar optimista
    div.className = `flex ${message.sender === 'me' ? 'justify-end' : 'justify-start'}`;
    const bubble = document.createElement('div');
    bubble.className = `max-w-[70%] px-4 py-2 rounded-2xl ${message.sender === 'me' ? 'bg-primary-600 text-white rounded-br-none' : 'bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 rounded-bl-none border border-neutral-200 dark:border-neutral-700'}`;
    const p = document.createElement('p'); p.textContent = message.content || '';
    const t = document.createElement('p');
    t.className = `text-xs mt-1 ${message.sender === 'me' ? 'text-primary-200' : 'text-neutral-500 dark:text-neutral-400'}`;
    t.textContent = message.timestamp || '';
    bubble.appendChild(p); bubble.appendChild(t); div.appendChild(bubble);
    return div;
  }

  // ====================== ENVÍO MENSAJE ======================
  messageForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const content = (messageInput.value || '').trim();
    if (!content || !currentConversationId) return;

    // pintar optimista (reemplazable)
    const tempId = 'tmp-' + Date.now();
    const optimistic = { id: tempId, sender: 'me', content, timestamp: new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'}) };
    const el = createMessageElement(optimistic);
    chatMessages.appendChild(el);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    messageInput.value = '';

    if (socket && rtReady) {
      socket.emit('send_message', { conversation_id: currentConversationId, body: content });
    } else {
      fetch('/src/plataforma/app/chat/send', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ conversation_id: currentConversationId, body: content })
      }).catch(()=>{});
    }
  });

  // ====================== MODAL USUARIOS ======================
  function openNewChatModal() {
    modal.classList.remove('hidden');
    userSearch.value = '';
    userList.innerHTML = '<div class="p-3 text-neutral-500 text-sm">Cargando usuarios...</div>';
    fetchUsers('');
    userSearch.focus();
  }
  function closeNewChatModal() {
    modal.classList.add('hidden');
    userSearch.value = '';
    userList.innerHTML = '';
    if (aborter) aborter.abort();
  }

  async function fetchUsers(query) {
    if (aborter) aborter.abort();
    aborter = new AbortController();
    const url = new URL('/src/plataforma/app/chat/contacts', window.location.origin);
    if (query) url.searchParams.set('q', query);
    try {
      const res = await fetch(url, { credentials: 'include', signal: aborter.signal });
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const users = await res.json();
      renderUserList(users || []);
    } catch (err) {
      if (err.name !== 'AbortError') {
        console.error('contacts error:', err);
        userList.innerHTML = '<div class="p-3 text-red-600 text-sm">Error al cargar usuarios.</div>';
      }
    }
  }

  function renderUserList(users) {
    userList.innerHTML = '';
    if (!Array.isArray(users) || users.length === 0) {
      userList.innerHTML = '<div class="p-3 text-neutral-500 text-sm">No se encontraron usuarios.</div>';
      return;
    }
    users.forEach(u => {
      const item = document.createElement('div');
      item.className = 'flex items-center justify-between p-3 hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors';
      item.innerHTML = `
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center overflow-hidden">
            <i data-feather="user" class="text-primary-700"></i>
          </div>
          <div>
            <p class="font-medium text-neutral-800 dark:text-neutral-100">${u.name}</p>
            <p class="text-sm text-neutral-500">${u.role || ''}</p>
          </div>
        </div>
        <button class="px-3 py-1 text-sm bg-primary-600 hover:bg-primary-700 text-white rounded">Chatear</button>
      `;
      const startChat = async () => {
        try {
          const r = await fetch('/src/plataforma/app/chat/start', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ user_id: u.id })
          });
          if (!r.ok) throw new Error('HTTP ' + r.status);
          const data = await r.json();
          closeNewChatModal();
          const partner = data.partner || { name: u.name, avatar: null };
          showConversation(data.conversation_id, partner.name, partner.avatar || null, true);
          if (socket && rtReady) socket.emit('join', { conversation_id: data.conversation_id });
        } catch (err) {
          console.error('start error', err);
          alert('No se pudo iniciar la conversación.');
        }
      };
      item.querySelector('button').addEventListener('click', e => { e.stopPropagation(); startChat(); });
      item.addEventListener('click', () => startChat());
      userList.appendChild(item);
    });
    if (window.feather) feather.replace();
  }

  userSearch.addEventListener('input', () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
      const q = userSearch.value.trim();
      userList.innerHTML = '<div class="p-3 text-neutral-500 text-sm">Buscando...</div>';
      fetchUsers(q);
    }, 250);
  });

  newChatBtn.addEventListener('click', openNewChatModal);
  closeModal.addEventListener('click', closeNewChatModal);
  modal.addEventListener('click', (e) => { if (e.target === modal) closeNewChatModal(); });

  if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
  }

  // ====================== FUNCIONES PÚBLICAS ======================
  function showConversation(conversationId, displayName, avatarUrl, isOnline) {
    currentConversationId = conversationId;
    chatUserName.textContent = displayName || 'Conversación';
    chatUserStatus.textContent = isOnline ? 'En línea' : '—';
    chatUserStatus.className = isOnline ? 'text-sm text-green-500' : 'text-sm text-neutral-500 dark:text-neutral-400';
    chatUserAvatar.innerHTML = avatarUrl ? `<img src="${avatarUrl}" class="w-full h-full object-cover rounded-full">` : '<i data-feather="user" class="text-primary-700"></i>';
    welcomeView.classList.add('hidden');
    conversationView.classList.remove('hidden');
    if (window.feather) feather.replace();
    // join room
    if (socket && rtReady) socket.emit('join', { conversation_id: conversationId });
    // load messages
    loadMessagesFor(conversationId);
  }

  // Exponer showConversation globalmente (evita error "showConversation is not defined")
  window.showConversation = showConversation;

});
</script>

<style>
#conversations-list, #contacts-list, #chat-messages, #user-list {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f1f5f9;
}
#user-list::-webkit-scrollbar, #chat-messages::-webkit-scrollbar { width: 6px; }
#user-list::-webkit-scrollbar-thumb, #chat-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.dark #user-list::-webkit-scrollbar-thumb { background: #4b5563; }
</style>

<?php
$content = ob_get_clean();
include $layoutFile;
