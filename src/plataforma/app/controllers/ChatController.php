<?php
namespace App\Controllers;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Firebase\JWT\JWT;
use PDO;

class ChatController {

  /* ================== Helpers ================== */

  private function ensureSession() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user'])) {
      http_response_code(401);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['error' => 'Unauthorized']);
      exit;
    }
  }

  private function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    try {
      $cfgPath = __DIR__ . '/../../../../config/config.php';
      $cfg = require $cfgPath;

      if (!is_array($cfg) || !isset($cfg['db']) || !is_array($cfg['db'])) {
        throw new \RuntimeException("Invalid config from {$cfgPath}: did not return expected array.");
      }

      $db = $cfg['db'];
      foreach (['host','port','name','user','pass'] as $k) {
        if (!array_key_exists($k, $db)) {
          throw new \RuntimeException("Invalid config: missing db.$k");
        }
      }

      $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        (string)$db['host'],
        (string)$db['port'],
        (string)$db['name'],
        (string)($db['charset'] ?? 'utf8mb4')
      );

      $pdo = new PDO($dsn, (string)$db['user'], (string)$db['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
      return $pdo;

    } catch (\Throwable $e) {
      http_response_code(500);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['error' => 'db_connect_failed', 'message' => $e->getMessage()]);
      exit;
    }
  }

  private function json($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
  }

  private function fullName(array $u): string {
    $parts = array_filter([
      $u['nombre'] ?? '',
      $u['apellido_paterno'] ?? '',
      $u['apellido_materno'] ?? ''
    ]);
    return trim(implode(' ', $parts));
  }

  /**
   * Normaliza un ID que puede venir como int, string ("123" ó "123?x=1")
   * o incluso array (algunos routers pasan ['id'=>123] o [0=>123]).
   */
  private function normalizeId($raw): int {
    if (is_int($raw)) return $raw;

    if (is_string($raw)) {
      // Elimina query pegada si viene por error: "123?foo=bar"
      $raw = explode('?', $raw, 2)[0];
      // Validar que sean dígitos
      if (ctype_digit($raw)) return (int)$raw;
      return 0;
    }

    if (is_array($raw)) {
      // Busca claves comunes
      if (isset($raw['id']) && ctype_digit((string)$raw['id'])) return (int)$raw['id'];
      if (isset($raw[0]) && ctype_digit((string)$raw[0])) return (int)$raw[0];
      return 0;
    }

    return 0;
  }

  /* ================== VISTA ================== */

  public function index() {
    $this->ensureSession();
    include __DIR__ . '/../views/chat/index.php';
  }

  /* ================== TOKEN para realtime (Socket.IO) ================== */
  public function token() {
    $this->ensureSession();

    // Autoload seguro (si el front controller no lo cargó)
    $autoload = __DIR__ . '/../../../../vendor/autoload.php';
    if (is_file($autoload)) {
      require_once $autoload;
    }

    if (!class_exists(\Firebase\JWT\JWT::class)) {
      http_response_code(500);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([
        'error' => 'jwt_lib_missing',
        'message' => 'No se encontró firebase/php-jwt. Ejecuta: composer require firebase/php-jwt'
      ]);
      exit;
    }

    // Secreto consistente con Node: getenv + $_ENV/$_SERVER + fallback config.php
    $secret =
      getenv('JWT_KEY') ?: getenv('JWT_SECRET') ?:
      ($_ENV['JWT_KEY'] ?? $_ENV['JWT_SECRET'] ?? $_SERVER['JWT_KEY'] ?? $_SERVER['JWT_SECRET'] ?? null);

    if (!$secret) {
      $cfgPath = __DIR__ . '/../../../../config/config.php';
      if (is_file($cfgPath)) {
        $cfg = require $cfgPath;
        if (is_array($cfg) && !empty($cfg['jwt_secret'])) {
          $secret = (string)$cfg['jwt_secret'];
        }
      }
    }

    if (!$secret) {
      http_response_code(500);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([
        'error' => 'jwt_secret_missing',
        'message' => 'Define JWT_KEY o JWT_SECRET en PHP (mismo valor que en Node) o $cfg["jwt_secret"] en config.php'
      ]);
      exit;
    }

    $u = $_SESSION['user'];
    $payload = [
      'id'   => (int)($u['id'] ?? 0),
      'name' => $u['name'] ?? ($u['nombre'] ?? 'User'),
      'role' => $u['roles'][0] ?? ($u['role'] ?? 'student'),
      'iat'  => time(),
      'exp'  => time() + 60*60*12, // 12h
    ];

    if ($payload['id'] <= 0) {
      http_response_code(500);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([
        'error' => 'invalid_user_id',
        'message' => 'El id de usuario en la sesión no es válido.'
      ]);
      exit;
    }

    try {
      $jwt = \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    } catch (\Throwable $e) {
      http_response_code(500);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode([
        'error' => 'jwt_encode_failed',
        'message' => $e->getMessage()
      ]);
      exit;
    }

    // URL del realtime
    $rtUrl = getenv('RT_URL') ?: ($_ENV['RT_URL'] ?? $_SERVER['RT_URL'] ?? 'http://localhost:3001');

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['token' => $jwt, 'rt_url' => $rtUrl]);
    exit;
  }

  /* ================== GET /chat/contacts?q= ================== */
  public function contacts() {
    $this->ensureSession();
    header('Content-Type: application/json; charset=utf-8');

    try {
      $me = (int)$_SESSION['user']['id'];
      $q  = isset($_GET['q']) ? trim($_GET['q']) : '';

      $sql = "SELECT id, nombre, apellido_paterno, apellido_materno, email, status
              FROM users
              WHERE id <> :me AND status = 'active' ";
      $params = [':me' => $me];

      if ($q !== '') {
        $sql .= " AND (
          nombre LIKE :q OR apellido_paterno LIKE :q OR apellido_materno LIKE :q
          OR CONCAT(nombre,' ',apellido_paterno,' ',IFNULL(apellido_materno,'')) LIKE :q
          OR email LIKE :q
        )";
        $params[':q'] = '%' . $q . '%';
      }

      $sql .= " ORDER BY nombre ASC, apellido_paterno ASC LIMIT 100";

      $stmt = $this->db()->prepare($sql);
      $stmt->execute($params);
      $rows = $stmt->fetchAll();

      $out = [];
      foreach ($rows as $r) {
        $name = trim(
          ($r['nombre'] ?? '') . ' ' .
          ($r['apellido_paterno'] ?? '') . ' ' .
          ($r['apellido_materno'] ?? '')
        );
        $out[] = [
          'id'     => (int)$r['id'],
          'name'   => $name !== '' ? $name : 'Usuario',
          'avatar' => null,
          'role'   => null,
          'email'  => $r['email'] ?? null
        ];
      }

      echo json_encode($out);
      exit;

    } catch (\Throwable $e) {
      http_response_code(500);
      echo json_encode(['error' => 'contacts_failed', 'message' => $e->getMessage()]);
      exit;
    }
  }

  /* ================== POST /chat/start (user_id) ================== */
  public function start() {
    $this->ensureSession();
    $me = (int)$_SESSION['user']['id'];
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    if ($userId <= 0 || $userId === $me) $this->json(['error' => 'invalid user_id'], 422);

    try {
      $uStmt = $this->db()->prepare("SELECT id, nombre, apellido_paterno, apellido_materno FROM users WHERE id = ? AND status='active' LIMIT 1");
      $uStmt->execute([$userId]);
      $other = $uStmt->fetch();
      if (!$other) $this->json(['error' => 'user not found'], 404);

      $a = min($me, $userId);
      $b = max($me, $userId);
      $directKey = "{$a}:{$b}";

      $pdo = $this->db();
      $pdo->beginTransaction();

      $cStmt = $pdo->prepare("SELECT id FROM conversations WHERE direct_key = ? LIMIT 1");
      $cStmt->execute([$directKey]);
      $convId = $cStmt->fetchColumn();

      if (!$convId) {
        $pdo->prepare("INSERT INTO conversations (type, direct_key, created_at, updated_at) VALUES ('direct', ?, NOW(), NOW())")
            ->execute([$directKey]);
        $convId = (int)$pdo->lastInsertId();

        $ins = $pdo->prepare("INSERT INTO conversation_users (conversation_id, user_id) VALUES (?, ?)");
        $ins->execute([$convId, $me]);
        $ins->execute([$convId, $userId]);
      }

      $pdo->commit();

      $partnerName = $this->fullName($other);
      $this->json([
        'conversation_id' => (int)$convId,
        'partner' => [
          'id'     => (int)$other['id'],
          'name'   => $partnerName ?: 'Usuario',
          'avatar' => null
        ]
      ]);
    } catch (\Throwable $e) {
      if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
      $this->json(['error' => 'db error', 'detail' => $e->getMessage()], 500);
    }
  }

  /* ================== GET /chat/conversations ================== */
  public function conversations() {
    $this->ensureSession();
    $me = (int)$_SESSION['user']['id'];

    $sql = "
      SELECT c.id,
             u2.id AS partner_id,
             u2.nombre, u2.apellido_paterno, u2.apellido_materno,
             (SELECT m.body FROM messages m WHERE m.conversation_id = c.id ORDER BY m.created_at DESC, m.id DESC LIMIT 1) AS last_body,
             (SELECT m.created_at FROM messages m WHERE m.conversation_id = c.id ORDER BY m.created_at DESC, m.id DESC LIMIT 1) AS last_at
      FROM conversations c
      JOIN conversation_users cu_me     ON cu_me.conversation_id = c.id AND cu_me.user_id = :me
      JOIN conversation_users cu_other  ON cu_other.conversation_id = c.id AND cu_other.user_id <> :me
      JOIN users u2 ON u2.id = cu_other.user_id
      WHERE c.type = 'direct'
      ORDER BY COALESCE(c.last_message_at, c.updated_at) DESC, c.id DESC
      LIMIT 100
    ";

    try {
      $stmt = $this->db()->prepare($sql);
      $stmt->execute([':me' => $me]);
      $rows = $stmt->fetchAll();

      $out = [];
      foreach ($rows as $r) {
        $name = trim(($r['nombre'] ?? '') . ' ' . ($r['apellido_paterno'] ?? '') . ' ' . ($r['apellido_materno'] ?? ''));
        $out[] = [
          'id'          => (int)$r['id'],
          'name'        => $name ?: 'Usuario',
          'avatar'      => null,
          'online'      => false,
          'lastMessage' => $r['last_body'] ?? '',
          'time'        => $r['last_at'] ? date('H:i', strtotime($r['last_at'])) : '',
          'unread'      => 0
        ];
      }

      $this->json($out);
    } catch (\Throwable $e) {
      $this->json(['error' => 'conversations_failed', 'message' => $e->getMessage()], 500);
    }
  }

  /* ================== GET /chat/messages/{id} ================== */
  public function messages($id = null) {
    $this->ensureSession();
    $me  = (int)$_SESSION['user']['id'];
    $cid = $this->normalizeId($id);

    if ($cid <= 0) {
      $this->json(['error' => 'invalid_conversation_id', 'detail' => 'El parámetro {id} debe ser un entero positivo.'], 422);
    }

    try {
      // Pertenece a la conversación
      $own = $this->db()->prepare("SELECT 1 FROM conversation_users WHERE conversation_id = ? AND user_id = ? LIMIT 1");
      $own->execute([$cid, $me]);
      if (!$own->fetchColumn()) $this->json(['error' => 'forbidden'], 403);

      $stmt = $this->db()->prepare("
        SELECT id, sender_id, body, created_at
        FROM messages
        WHERE conversation_id = ?
        ORDER BY created_at ASC, id ASC
        LIMIT 500
      ");
      $stmt->execute([$cid]);
      $rows = $stmt->fetchAll();

      $out = [];
      foreach ($rows as $m) {
        $out[] = [
          'id'        => (int)$m['id'],
          'sender'    => ((int)$m['sender_id'] === $me) ? 'me' : 'other',
          'content'   => $m['body'],
          'timestamp' => date('H:i', strtotime($m['created_at']))
        ];
      }

      $this->json($out);
    } catch (\Throwable $e) {
      $this->json(['error' => 'messages_failed', 'message' => $e->getMessage()], 500);
    }
  }

  /* ================== POST /chat/send ================== */
  public function send() {
    $this->ensureSession();
    $me  = (int)$_SESSION['user']['id'];
    $cid = isset($_POST['conversation_id']) ? (int)$_POST['conversation_id'] : 0;
    $body= isset($_POST['body']) ? trim($_POST['body']) : '';

    if ($cid <= 0 || $body === '') $this->json(['error' => 'invalid payload'], 422);

    try {
      // Verifica pertenencia
      $own = $this->db()->prepare("SELECT 1 FROM conversation_users WHERE conversation_id = ? AND user_id = ? LIMIT 1");
      $own->execute([$cid, $me]);
      if (!$own->fetchColumn()) $this->json(['error' => 'forbidden'], 403);

      $pdo = $this->db();
      $pdo->beginTransaction();

      $ins = $pdo->prepare("INSERT INTO messages (conversation_id, sender_id, body) VALUES (?, ?, ?)");
      $ins->execute([$cid, $me, $body]);

      $pdo->prepare("UPDATE conversations SET last_message_at = NOW(), updated_at = NOW() WHERE id = ?")
          ->execute([$cid]);

      $pdo->commit();
      $this->json(['ok' => true]);
    } catch (\Throwable $e) {
      if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
      $this->json(['error' => 'send_failed', 'message' => $e->getMessage()], 500);
    }
  }

}
