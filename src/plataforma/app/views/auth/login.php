<?php
// src/plataforma/app/views/auth/login.php
if (session_status() === PHP_SESSION_NONE) session_start();
$error   = $_SESSION['flash_error']   ?? null;
$success = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_error'], $_SESSION['flash_success']);

// URL de tu landing/principal (ajústala si es distinto)
$HOME_URL = '/src'; // p.ej. '/' o '/index.php'
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Universidad Tecnológica</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --ut-green-800:#166534;
      --ut-green-700:#15803d;
      --ut-green-600:#16a34a;
    }
    body{
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, var(--ut-green-800) 0%, var(--ut-green-700) 100%);
      min-height: 100vh;
    }
    .login-card{
      backdrop-filter: blur(10px);
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.18);
    }
    .input-field{
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.20);
      transition: all .25s ease;
    }
    .input-field:focus{
      background: rgba(255,255,255,.18);
      border-color: rgba(255,255,255,.40);
      outline: none;
      box-shadow: 0 0 0 3px rgba(22,163,74,.25);
    }
    .btn-login{
      background: linear-gradient(135deg, var(--ut-green-600) 0%, var(--ut-green-700) 100%);
      transition: transform .2s ease, box-shadow .25s ease, opacity .25s ease;
    }
    .btn-login:hover{
      transform: translateY(-2px);
      box-shadow: 0 14px 28px -16px rgba(22,163,74,.6);
    }
    .btn-ghost{
      transition: background .2s ease, transform .2s ease;
    }
    .btn-ghost:hover{ background: rgba(255,255,255,.08); transform: translateY(-1px); }
  </style>
</head>
<body class="flex items-center justify-center p-4">

  <div class="login-card rounded-2xl shadow-2xl overflow-hidden w-full max-w-md">
    <!-- Header -->
    <div class="bg-white/10 p-8">
      <div class="text-center mb-8">
        <img src="http://static.photos/education/1200x630/42"
             alt="Logo Universidad"
             class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-white/30">
        <h1 class="text-2xl font-bold text-white mt-4">Universidad Tecnológica</h1>
        <p class="text-white/80 mt-2">Sistema de Acceso para Estudiantes</p>
      </div>

      <!-- Flash messages -->
      <?php if ($error): ?>
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 text-red-100 px-4 py-3 text-sm">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-500/10 text-emerald-100 px-4 py-3 text-sm">
          <?php echo htmlspecialchars($success); ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form class="space-y-6" method="post" action="/src/plataforma/login" autocomplete="on">
        <div>
          <label for="email" class="block text-sm font-medium text-white/80 mb-1">Correo</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-feather="mail" class="text-white/60"></i>
            </div>
            <input
              type="email"
              id="email"
              name="email"
              required
              inputmode="email"
              value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
              class="input-field w-full pl-10 pr-4 py-3 rounded-lg text-white placeholder-white/50"
              placeholder="admin@utec.edu">
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-white/80 mb-1">Contraseña</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-feather="lock" class="text-white/60"></i>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              class="input-field w-full pl-10 pr-10 py-3 rounded-lg text-white placeholder-white/50"
              placeholder="••••••••">
            <button type="button" aria-label="Mostrar/ocultar contraseña"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-white/70 hover:text-white/90"
                    onclick="const p=document.getElementById('password'); p.type = p.type==='password' ? 'text' : 'password';">
              <i data-feather="eye"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-sm text-white/80">
            <input id="remember" name="remember" type="checkbox"
                   class="h-4 w-4 text-emerald-400 focus:ring-emerald-300 border-white/40 rounded">
            Recordarme
          </label>
          <a href="#" class="text-sm font-medium text-white hover:text-emerald-200">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn-login w-full flex justify-center py-3 px-4 rounded-lg text-sm font-medium text-white">
          Iniciar Sesión
        </button>

        <!-- Botón: Volver al inicio -->
        <a href="<?php echo htmlspecialchars($HOME_URL); ?>"
           class="btn-ghost w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-lg text-sm font-medium text-white/90 ring-1 ring-white/20">
          <i data-feather="arrow-left"></i>
          Volver al inicio
        </a>
      </form>
    </div>

    <div class="bg-white/5 px-4 py-3 text-center">
      <span class="text-xs text-white/70">© <?php echo date('Y'); ?> Universidad Tecnológica</span>
    </div>
  </div>

  <script>feather.replace();</script>
</body>
</html>