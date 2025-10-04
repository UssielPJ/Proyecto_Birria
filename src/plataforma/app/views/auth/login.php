<?php
// src/plataforma/app/views/auth/login.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Obtener mensajes flash
$error = $_SESSION['flash_error'] ?? null;
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
  <meta name="theme-color" content="#28a55f">
  <meta name="description" content="Accede a la Plataforma Estudiantil de UTSC. Inicia sesión con tu correo institucional para continuar tu aprendizaje en 2025.">
  <meta name="keywords" content="login UTSC, plataforma estudiantil, acceso universidad tecnológica">
  <meta property="og:title" content="Login - Plataforma Estudiantil UTSC">
  <meta property="og:description" content="Inicia sesión en tu cuenta de estudiante UTSC.">
  <meta property="og:image" content="/static/images/logo.png">
  <meta property="og:url" content="https://utsc.edu/src/plataforma/login">
  <title>Login - Plataforma Estudiantil UTSC</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
  <!-- Prevenir flash de tema incorrecto -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  <script src="/src/js/theme.js" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --ut-green-800: #1e5e3eff;
      --ut-green-700: #2e7d47ff;
      --ut-green-600: #389e5fff;
      --ut-green-500: #43a047ff;
      --ut-green-400: #66bb6aff;
      --ut-green-100: #c8e6c9ff;
    }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, var(--ut-green-800) 0%, var(--ut-green-700) 50%, var(--ut-green-600) 100%);
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
      animation: gradientAnimation 15s ease infinite;
      background-size: 400% 400%;
    }
    @keyframes gradientAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('/src/plataforma/app/img/PlantelUT.jpg') center/cover fixed;
      opacity: 0.15;
      z-index: -1;
      filter: none;
      animation: slowZoom 30s ease-in-out infinite alternate;
    }
    @keyframes slowZoom {
      from { transform: scale(1); }
      to { transform: scale(1.1); }
    }
    body::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                          radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
      pointer-events: none;
      animation: shimmer 5s ease-in-out infinite alternate;
    }
    @keyframes shimmer {
      0% { opacity: 0.5; }
      100% { opacity: 1; }
    }
    .login-card {
      backdrop-filter: blur(25px) saturate(200%);
      background: rgba(255,255,255,0.25);
      border: 1px solid rgba(255,255,255,0.4);
      box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35),
                  0 0 40px rgba(34,197,94,0.3);
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 30px 60px -15px rgba(0,0,0,0.3),
                  0 0 40px rgba(34,197,94,0.3);
    }
    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      animation: borderGlow 2s ease-in-out infinite;
    }
    @keyframes borderGlow {
      0%, 100% { opacity: 0.3; }
      50% { opacity: 1; }
    }
    .input-field {
      background: rgba(255,255,255,0.25);
      border: 2px solid rgba(255,255,255,0.4);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      padding: 1rem 1rem 1rem 3rem;
      border-radius: 0.75rem;
      color: white;
      font-size: 0.95rem;
      font-weight: 500;
      backdrop-filter: blur(10px);
      letter-spacing: 0.5px;
    }
    .input-field::placeholder {
      color: rgba(255,255,255,0.6);
      transition: all 0.3s ease;
    }
    .input-field:focus {
      background: rgba(255,255,255,0.35);
      border-color: var(--ut-green-400);
      outline: none;
      box-shadow: 0 0 0 4px rgba(102,187,106,0.4),
                  0 0 25px rgba(102,187,106,0.5);
      transform: scale(1.02);
      letter-spacing: 1px;
    }
    .input-field:focus::placeholder {
      opacity: 0.7;
      transform: translateX(10px);
    }
    .input-group {
      position: relative;
      overflow: hidden;
    }
    .input-group::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-400));
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }
    .input-group:focus-within::after {
      transform: scaleX(1);
    }
    .btn-login {
      background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-500));
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      border-radius: 0.75rem;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      border: none;
      z-index: 1;
    }
    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.6s;
    }
    .btn-login:hover {
      background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-400));
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(102,187,106,0.4);
      cursor: pointer;
    }
    .btn-login:hover::before {
      left: 100%;
    }
    .btn-login:active {
      transform: translateY(0);
      box-shadow: 0 5px 15px rgba(102,187,106,0.3);
      cursor: pointer;
    }
    .btn-ghost {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 2px solid rgba(255,255,255,0.3);
      background: rgba(255,255,255,0.05);
      border-radius: 0.75rem;
      font-weight: 500;
    }
    .btn-ghost:hover {
      background: rgba(255,255,255,0.15);
      border-color: rgba(255,255,255,0.5);
      transform: translateY(-1px);
    }
    .flash-message {
      animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .logo-spin {
      transition: transform 0.6s ease;
    }
    .logo-spin:hover {
      transform: rotate(360deg);
    }
    /* Dark mode */
    body.dark {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    }
    body.dark .login-card {
      background: rgba(30,41,59,0.4);
      border-color: rgba(255,255,255,0.1);
      box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
    }
    body.dark .input-field {
      background: rgba(30,41,59,0.6);
      border-color: rgba(255,255,255,0.1);
      color: #f8fafc;
    }
    body.dark .input-field::placeholder {
      color: rgba(248,250,252,0.6);
    }
    body.dark .input-field:focus {
      background: rgba(30,41,59,0.8);
      border-color: var(--ut-green-500);
      box-shadow: 0 0 0 4px rgba(34,197,94,0.2);
    }
    body.dark .btn-ghost {
      border-color: rgba(255,255,255,0.2);
      background: rgba(30,41,59,0.3);
    }
    body.dark .btn-ghost:hover {
      background: rgba(30,41,59,0.5);
      border-color: rgba(255,255,255,0.4);
    }
    body.dark .flash-message.error {
      background: rgba(239,68,68,0.2);
      border-color: rgba(239,68,68,0.3);
    }
    body.dark .flash-message.success {
      background: rgba(34,197,94,0.2);
      border-color: rgba(34,197,94,0.3);
    }
    /* Responsive */
    @media (max-width: 640px) {
      .login-card { margin: 1rem; }
      .input-field { padding-left: 2.5rem; }
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 relative">
  <!-- Floating particles -->
  <div class="fixed inset-0 pointer-events-none overflow-hidden">
    <div class="absolute top-20 left-10 w-2 h-2 bg-white/20 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
    <div class="absolute top-40 right-20 w-1 h-1 bg-white/10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-32 left-1/2 w-3 h-3 bg-white/15 rounded-full animate-bounce slow" style="animation-delay: 2s;"></div>
  </div>

  <div class="login-card rounded-3xl w-full max-w-md relative animate-fade-in-up" data-aos="fade-up">
    <!-- Header -->
    <div class="bg-white/5 backdrop-blur-sm p-8 relative">
      <div class="text-center mb-8">
        <div class="logo-spin inline-block mb-6">
          <img src="/src/plataforma/app/img/UT.jpg" 
               alt="UTSC Logo" 
               class="w-28 h-28 mx-auto rounded-full object-cover border-4 border-white/20 shadow-xl ring-2 ring-white/10"
               onerror="this.src='/src/plataforma/app/img/CorrecaminosUT.jpg'">
        </div>
        <h1 class="text-3xl font-bold text-white mt-2 tracking-tight bg-gradient-to-r from-white to-emerald-100 bg-clip-text text-transparent">Plataforma Estudiantil</h1>
        <p class="text-white/80 mt-3 text-lg leading-relaxed">Inicia sesión para continuar tu aprendizaje</p>
      </div>


<!-- Flash messages -->
  <?php if ($error): ?>
    <div class="flash-message error mb-6 rounded-xl border border-red-500/30 bg-red-500/10 text-red-100 px-4 py-3 text-sm backdrop-blur-sm" role="alert" aria-live="polite">
      <div class="flex items-center">
        <i data-feather="alert-triangle" class="w-4 h-4 mr-2"></i>
        <?php echo htmlspecialchars($error); ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="flash-message success mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-100 px-4 py-3 text-sm backdrop-blur-sm" role="alert" aria-live="polite">
      <div class="flex items-center">
        <i data-feather="check-circle" class="w-4 h-4 mr-2"></i>
        <?php echo htmlspecialchars($success); ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Form -->
  <form class="space-y-6" method="post" action="/src/plataforma/login" autocomplete="on" id="loginForm">
    <div class="space-y-6">
      <div class="relative">
        <label for="email" class="block text-sm font-medium text-white/90 mb-2 sr-only">Correo Institucional</label>
        <div class="relative group">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i data-feather="mail" class="w-5 h-5 text-white/60 group-focus-within:text-white/80 transition-colors duration-200"></i>
          </div>
          <input
            type="email"
            id="email"
            name="email"
            required
            inputmode="email"
            autocomplete="email"
            placeholder="tu.correo@utsc.edu"
            class="input-field w-full pr-12"
            value="<?php echo htmlspecialchars($_POST['email'] ?? $_COOKIE['user_email'] ?? ''); ?>"
            aria-describedby="email-error">
          <div id="email-error" class="hidden absolute -bottom-6 left-0 text-red-200 text-xs mt-1">Correo inválido</div>
        </div>
      </div>

      <div class="relative">
        <label for="password" class="block text-sm font-medium text-white/90 mb-2 sr-only">Contraseña</label>
        <div class="relative group">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i data-feather="lock" class="w-5 h-5 text-white/60 group-focus-within:text-white/80 transition-colors duration-200"></i>
          </div>
          <input
            type="password"
            id="password"
            name="password"
            required
            autocomplete="current-password"
            class="input-field w-full pr-12"
            placeholder="Tu contraseña"
            value="<?php echo htmlspecialchars($_COOKIE['user_password'] ?? ''); ?>"
            aria-describedby="password-error">
          <button type="button"
                  id="togglePassword"
                  aria-label="Mostrar/ocultar contraseña"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center text-white/60 hover:text-white transition-colors duration-200"
                  tabindex="-1">
            <i data-feather="eye" class="w-5 h-5" id="eyeIcon"></i>
          </button>
          <div id="password-error" class="hidden absolute -bottom-6 left-0 text-red-200 text-xs mt-1">Contraseña requerida</div>
        </div>
      </div>

      <div class="flex items-center justify-between pt-2">
        <label class="flex items-center gap-2 cursor-pointer group">
          <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-white/30 bg-white/10 text-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-colors duration-200" <?php echo isset($_COOKIE['user_email']) ? 'checked' : ''; ?>>
          <span class="text-sm text-white/80 group-hover:text-white transition-colors">Recordarme</span>
        </label>
        <a href="#" class="text-sm font-medium text-white/80 hover:text-white transition-all duration-200 hover:underline focus:outline-none focus:ring-2 focus:ring-white/30">¿Olvidaste tu contraseña?</a>
      </div>

      <button type="submit" 
              class="btn-login w-full flex justify-center items-center gap-2 py-4 px-6 rounded-xl text-base font-medium text-white mt-4 relative overflow-hidden"
              id="submitBtn"
              aria-label="Iniciar sesión"
              onclick="console.log('Botón de inicio de sesión clickeado')">
        <span class="relative z-10 flex items-center gap-2">
          <i data-feather="log-in" class="w-5 h-5"></i>
          Iniciar Sesión
        </span>
        <div class="loading-spinner hidden absolute inset-0 flex items-center justify-center">
          <div class="w-6 h-6 border-2 border-white/20 border-t-white rounded-full animate-spin"></div>
        </div>
      </button>

      <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-white/10"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-4 text-white/60 bg-white/5 rounded-full backdrop-blur-sm">o</span>
        </div>
      </div>

      <!-- Botón: Volver al inicio -->
      <a href="<?php echo htmlspecialchars($HOME_URL); ?>"
         class="btn-ghost w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl text-sm font-medium text-white/80 hover:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/30"
         aria-label="Volver a la página principal">
        <i data-feather="arrow-left" class="w-4 h-4"></i>
        Volver al inicio
      </a>
    </div>
  </form>
</div>

<!-- Footer -->
<div class="bg-white/5 px-6 py-4 text-center border-t border-white/10 backdrop-blur-sm">
  <p class="text-sm text-white/60">
    © <?php echo date('Y'); ?> Universidad Tecnológica | 
    <a href="#" class="hover:text-white/80 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/30">Ayuda</a> | 
    <a href="#" class="hover:text-white/80 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/30">Privacidad</a>
  </p>
</div>
  </div>

  <script>
    // AOS Init
    AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 50 });

    // Feather Icons
    feather.replace();

    // Password Toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (togglePassword && passwordField && eyeIcon) {
      togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        eyeIcon.setAttribute('data-feather', type === 'password' ? 'eye' : 'eye-off');
        feather.replace({icons: {eyeIcon: {}}});
      });
    }

    // Form Validation
    const form = document.getElementById('loginForm');
    const emailField = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
      console.log('Formulario enviado');
      console.log('Email:', emailField.value);
      console.log('Password length:', passwordField.value.length);
      
      let isValid = true;

      // Email validation
      const email = emailField.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        console.log('Email inválido');
        emailError.classList.remove('hidden');
        isValid = false;
      } else {
        console.log('Email válido');
        emailError.classList.add('hidden');
      }

      // Password validation
      const password = passwordField.value;
      if (password.length < 6) {
        console.log('Contraseña demasiado corta');
        passwordError.classList.remove('hidden');
        isValid = false;
      } else {
        console.log('Contraseña válida');
        passwordError.classList.add('hidden');
      }

      if (!isValid) {
        console.log('Formulario inválido');
        e.preventDefault();
        return false;
      }

      // Loading state
      submitBtn.disabled = true;
      const spinner = submitBtn.querySelector('.loading-spinner');
      const text = submitBtn.querySelector('span');
      spinner.classList.remove('hidden');
      text.style.opacity = '0.5';
      
      console.log('Formulario válido, enviando...');
      console.log('Action:', form.action);
      console.log('Method:', form.method);
    });

    // Real-time validation
    emailField.addEventListener('blur', function() {
      const email = this.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (email && !emailRegex.test(email)) {
        emailError.classList.remove('hidden');
      } else {
        emailError.classList.add('hidden');
      }
    });

    passwordField.addEventListener('blur', function() {
      if (this.value.length < 6) {
        passwordError.classList.remove('hidden');
      } else {
        passwordError.classList.add('hidden');
      }
    });

    // Theme integration
    document.addEventListener('themechange', () => {
      feather.replace();
    });
  </script>

</body>
</html>