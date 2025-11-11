// server.js
// npm i socket.io mysql2 jsonwebtoken dotenv

require('dotenv').config();
const jwt = require('jsonwebtoken');
const { createServer } = require('http');
const { Server } = require('socket.io');
const mysql = require('mysql2/promise');

/* ----------------------------- HTTP básico ----------------------------- */
const httpServer = createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
  res.end('✅ Realtime UTSC activo en puerto ' + (process.env.RT_PORT || 3001));
});

/* -------------------------------- CORS -------------------------------- */
const rawOrigins = (process.env.CORS_ORIGIN || '')
  .split(',')
  .map(s => s.trim())
  .filter(Boolean);

// Acepta localhost con o sin puerto
const localhostWhitelist = new Set([
  'http://localhost', 'http://127.0.0.1', 'http://birria.local',
  'https://localhost', 'https://127.0.0.1', 'https://birria.local'
]);

const allowedOrigins = new Set(rawOrigins);
localhostWhitelist.forEach(o => allowedOrigins.add(o));

const io = new Server(httpServer, {
  cors: {
    origin: (origin, cb) => {
      if (!origin) return cb(null, true); // llamadas locales/sin origin
      try {
        const u = new URL(origin);
        const base = `${u.protocol}//${u.hostname}`;
        if (allowedOrigins.has(origin) || allowedOrigins.has(base)) {
          return cb(null, true);
        }
      } catch (_) {}
      return cb(new Error('CORS not allowed: ' + origin), false);
    },
    credentials: true,
  },
});

/* ----------------------------- Pool de MySQL ---------------------------- */
const pool = mysql.createPool({
  host: process.env.DB_HOST,
  port: Number(process.env.DB_PORT || 3306),
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME,
  charset: 'utf8mb4',
  waitForConnections: true,
  connectionLimit: 10,
});

/* ----------------------- Helpers de JWT ----------------------- */
function getJwtSecret() {
  const s = process.env.JWT_KEY || process.env.JWT_SECRET;
  if (!s) throw new Error('JWT secret missing (define JWT_KEY o JWT_SECRET)');
  return s;
}

/* ----------------------- Middleware de autenticación -------------------- */
io.use((socket, next) => {
  try {
    const token =
      socket.handshake.auth?.token ||
      socket.handshake.query?.token ||
      null;

    if (!token) throw new Error('No token in handshake');

    const payload = jwt.verify(token, getJwtSecret(), { algorithms: ['HS256'] });
    const id = Number(payload.id);
    if (!id) throw new Error('Token sin id numérico');

    socket.user = { id, name: payload.name || 'User', role: payload.role || 'user' };
    return next();
  } catch (e) {
    console.error('🔐 Auth error:', e.message);
    return next(new Error('Auth failed: ' + e.message));
  }
});

/* --------------------------------- Sockets ------------------------------ */
io.on('connection', (socket) => {
  const uid = socket.user?.id;
  console.log(`🟢 Conectado uid=${uid} (${socket.user?.name || 'Anon'})`);

  // Sala personal del usuario (para notificaciones de bandeja)
  if (uid) socket.join(`user:${uid}`);

  // Compatibilidad: algunos clientes emiten esto al conectar
  socket.on('join_user', ({ user_id }) => {
    if (Number(user_id)) {
      socket.join(`user:${Number(user_id)}`);
      console.log(`👤 uid=${uid} join user:${Number(user_id)}`);
    }
  });

  // Unirse a una conversación (cuando la abren)
  socket.on('join', ({ conversation_id }) => {
    if (!conversation_id) return;
    socket.join(`conv:${conversation_id}`);
    console.log(`👥 uid=${uid} join conv:${conversation_id}`);
    socket.emit('joined', { room: `conv:${conversation_id}` });
  });

  // Enviar mensaje
  socket.on('send_message', async ({ conversation_id, body }) => {
    if (!conversation_id || !body) return;
    try {
      // Guardar mensaje
      const [res] = await pool.execute(
        'INSERT INTO messages (conversation_id, sender_id, body) VALUES (?, ?, ?)',
        [conversation_id, uid, body]
      );

      // Actualizar timestamps de la conversación
      await pool.execute(
        'UPDATE conversations SET last_message_at = NOW(), updated_at = NOW() WHERE id = ?',
        [conversation_id]
      );

      // Mensaje completo (para el chat abierto)
      const payload = {
        conversation_id: Number(conversation_id),
        id: res.insertId,
        sender_id: uid,
        body,
        created_at: new Date().toISOString(),
      };

      // 1) Emitir SOLO al room de la conversación (chat abierto)
      io.to(`conv:${conversation_id}`).emit('message', payload);

      // 2) Emitir un resumen a cada usuario para refrescar la BANDEJA/LISTA (no pintar burbuja)
      const [rows] = await pool.execute(
        'SELECT user_id FROM conversation_users WHERE conversation_id = ?',
        [conversation_id]
      );
      const inbox = {
        conversation_id: Number(conversation_id),
        last_body: body,
        at: payload.created_at,
        sender_id: uid
      };
      rows.forEach(r => io.to(`user:${r.user_id}`).emit('inbox', inbox));

      console.log(`💬 mensaje #${payload.id} conv:${conversation_id} de uid=${uid}`);
    } catch (err) {
      console.error('❌ Error send_message:', err.message);
      socket.emit('error_message', { error: 'send_message failed', detail: err.message });
    }
  });

  socket.on('disconnect', () => {
    console.log(`🔴 Desconectado uid=${uid}`);
  });
});

/* ------------------------------ Arranque ------------------------------- */
const PORT = process.env.RT_PORT || 3001;
httpServer.listen(PORT, () => {
  console.log(`✅ Servidor realtime escuchando en :${PORT}`);
  if (allowedOrigins.size) {
    console.log('CORS permitido para:', Array.from(allowedOrigins).join(', '));
  } else {
    console.log('CORS permitido para * (CORS_ORIGIN vacío)');
  }
});
