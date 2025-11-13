<?php
// src/plataforma/app/views/auth/login.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Respetar $error si viene desde el AuthController::renderLoginView()
$error   = $error   ?? ($_SESSION['flash_error']   ?? null);
$success = $success ?? ($_SESSION['flash_success'] ?? null);
unset($_SESSION['flash_error'], $_SESSION['flash_success']);

$HOME_URL = '/src'; // Ajusta si tu home real es otro.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - UTSC</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- Fuente Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --ut-green-900:#0c4f2e;
      --ut-green-800:#12663a;
      --ut-green-700:#177a46;
      --ut-green-600:#1e8c51;
      --ut-green-500:#28a55f;
      --ut-green-400:#4ade80;
      --ut-green-100:#e6f6ed;
      --ut-green-50:#f0faf4;
      --ut-accent-blue: #3b82f6;
      --ut-accent-indigo: #6366f1;
      --ut-accent-purple: #8b5cf6;
    }

    body {
      background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
      font-family: 'Inter', system-ui, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .main-content-wrapper {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }

    .premium-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow:
        0 25px 50px -12px rgba(0, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
      border-radius: 0.75rem;
      max-height: calc(100vh - 2rem);
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInSlideUp 0.8s ease-out forwards;
      animation-delay: 0.3s;
    }

    .premium-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--ut-green-600), var(--ut-green-400), var(--ut-green-600));
      border-radius: 0.75rem 0.75rem 0 0;
      transform: scaleX(0);
      transform-origin: left;
      animation: gradientBarLoad 1.2s ease-out forwards;
      animation-delay: 0.8s;
    }

    .form-input {
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid #e2e8f0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      padding-top: 13px;
      padding-bottom: 13px;
    }

    .form-input:focus {
      border-color: var(--ut-green-500);
      box-shadow:
        0 0 0 3px rgba(40, 165, 95, 0.15),
        0 4px 6px -1px rgba(0, 0, 0, 0.05);
      background: rgba(255, 255, 255, 0.98);
      transform: translateY(-1px);
    }

    .form-input-wrapper:focus-within .input-icon {
      color: var(--ut-green-600);
      transform: scale(1.1);
    }

    .premium-btn {
      background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-700));
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      border: none;
    }

    .premium-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent);
      transition: left 0.6s ease;
      z-index: 1;
    }

    .premium-btn:hover::before {
      left: 100%;
    }

    .premium-btn:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow:
        0 12px 25px -8px rgba(12, 79, 46, 0.4),
        0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .premium-btn:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
      transform: none;
      box-shadow: none;
    }

    .ghost-btn {
      background-color: rgba(0, 0, 0, 0.8);
      border: 2px solid rgba(0, 0, 0, 0.9);
      color: white;
      font-weight: 600;
      transition: all 0.3s ease;
      transform-origin: center;
      position: relative;
      z-index: 0;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    }

    .ghost-btn::before {
      content: '';
      position: absolute;
      inset: 0;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 0.5rem;
      z-index: -1;
      opacity: 0;
      transform: scale(0.9);
      transition: all 0.3s ease;
    }

    .ghost-btn:hover {
      transform: translateY(-2px) scale(1.01);
      border-color: rgba(255, 255, 255, 0.5);
    }
    .ghost-btn:hover::before {
      opacity: 1;
      transform: scale(1);
    }

    .flash-message {
      padding: 1rem 1.25rem;
      border-radius: 0.75rem;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
      font-weight: 500;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border: 1px solid;
      display: flex;
      align-items: center;
      position: relative;
      opacity: 0;
      transform: scale(0.95);
      animation: flashAppear 0.5s ease-out forwards;
    }

    .flash-message .close-button {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.25rem;
      border-radius: 50%;
      color: inherit;
      transition: all 0.2s ease;
    }
    .flash-message .close-button:hover {
      background-color: rgba(0,0,0,0.05);
    }

    .flash-error {
      background-color: #FEF2F2;
      border-color: #FCA5A5;
      color: #DC2626;
    }
    .flash-success {
      background-color: #F0FDF4;
      border-color: #BBF7D0;
      color: #15803D;
    }

    .floating-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .floating-circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      animation: float 20s infinite ease-in-out;
      will-change: transform, opacity;
    }

    .circle-1 {
      width: 300px;
      height: 300px;
      top: 10%;
      left: 10%;
      animation-delay: 0s;
      animation-duration: 25s;
    }

    .circle-2 {
      width: 200px;
      height: 200px;
      top: 60%;
      right: 10%;
      animation-delay: 5s;
      animation-duration: 22s;
    }

    .circle-3 {
      width: 150px;
      height: 150px;
      bottom: 10%;
      left: 30%;
      animation-delay: 10s;
      animation-duration: 28s;
    }

    .circle-4 {
      width: 250px;
      height: 250px;
      top: 30%;
      right: 40%;
      animation-delay: 8s;
      animation-duration: 20s;
      background: rgba(255, 255, 255, 0.03);
    }

    @keyframes fadeInSlideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes flashAppear {
      from { opacity: 0; transform: scale(0.95) translateY(10px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }

    @keyframes flashDisappear {
      from { opacity: 1; transform: scale(1) translateY(0); }
      to { opacity: 0; transform: scale(0.95) translateY(-10px); }
    }

    @keyframes gradientBarLoad {
      from { transform: scaleX(0); }
      to { transform: scaleX(1); }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      25% { transform: translateY(-15px) rotate(5deg) scale(1.02); }
      50% { transform: translateY(-30px) rotate(0deg) scale(0.98); }
      75% { transform: translateY(-15px) rotate(-5deg) scale(1.02); }
    }

    @keyframes pulse-fadein {
      0% { opacity: 0; transform: translateY(5px); }
      50% { opacity: 0.7; transform: translateY(0); }
      100% { opacity: 0.8; }
    }
    .animate-pulse-fadein {
      animation: pulse-fadein 1s ease-out forwards;
    }

    @keyframes pulse-color {
      0%, 100% { color: #f87171; }
      50% { color: #ef4444; transform: scale(1.1); }
    }
    .animate-pulse-color {
      animation: pulse-color 2s infinite ease-in-out;
    }

    .remember-checkbox {
      border-color: #a1a1aa;
    }
    #remember:checked + .remember-checkbox {
      background-color: var(--ut-green-600);
      border-color: var(--ut-green-600);
    }
    #remember:checked + .remember-checkbox .checkmark {
      display: block;
    }
    label:hover .remember-checkbox {
      border-color: var(--ut-green-500);
      box-shadow: 0 0 0 2px rgba(40, 165, 95, 0.2);
    }

    @media (max-width: 767px) {
      .main-content-wrapper {
        padding: 0;
        align-items: flex-start;
        padding-top: 1rem;
        padding-bottom: 1rem;
      }

      .premium-card {
        margin: 0.5rem;
        max-width: 95%;
        border-radius: 0.75rem;
        width: calc(100% - 1rem);
        max-height: calc(100vh - 2rem);
        box-shadow:
          0 10px 20px -5px rgba(0, 0, 0, 0.1),
          inset 0 1px 0 rgba(255, 255, 255, 0.6);
        padding: 1.5rem;
      }
    }

    @media (max-height: 600px) and (min-width: 768px) {
      .main-content-wrapper {
        align-items: flex-start;
        padding-top: 1rem;
        padding-bottom: 1rem;
      }
      .premium-card {
        max-height: calc(100vh - 2rem);
      }
    }
  </style>
</head>
<body>
  <!-- Fondo animado -->
  <div class="floating-bg">
    <div class="floating-circle circle-1"></div>
    <div class="floating-circle circle-2"></div>
    <div class="floating-circle circle-3"></div>
    <div class="floating-circle circle-4"></div>
  </div>

  <div class="main-content-wrapper">
    <div class="premium-card rounded-2xl p-8 max-w-md w-full relative">
      <!-- Logo y título -->
      <div class="text-center mb-8">
        <div class="relative w-24 h-24 mx-auto mb-6 transform hover:scale-105 transition-transform duration-300 ease-in-out">
          <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="w-full h-full rounded-xl object-cover shadow-lg">
          <span class="absolute -top-2 -right-2 bg-ut-green-500 text-white text-xs px-2 py-1 rounded-full animate-pulse shadow-md">
            beta
          </span>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">UTSC</h1>
        <p class="text-gray-600">Plataforma Estudiantil</p>
      </div>

      <!-- Mensajes Flash -->
      <div id="flash-messages-container">
        <?php if (!empty($error)): ?>
          <div class="flash-message flash-error flex items-center mb-4 transition-all duration-300 ease-in-out transform" role="alert">
            <i data-feather="alert-circle" class="w-5 h-5 mr-3 flex-shrink-0"></i>
            <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></span>
            <button type="button" class="close-button" aria-label="Cerrar mensaje">
              <i data-feather="x" class="w-4 h-4"></i>
            </button>
          </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="flash-message flash-success flex items-center mb-4 transition-all duration-300 ease-in-out transform" role="alert">
            <i data-feather="check-circle" class="w-5 h-5 mr-3 flex-shrink-0"></i>
            <span><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></span>
            <button type="button" class="close-button" aria-label="Cerrar mensaje">
              <i data-feather="x" class="w-4 h-4"></i>
            </button>
          </div>
        <?php endif; ?>
      </div>

      <!-- Formulario de Inicio de Sesión -->
      <!-- Ruta apuntando al AuthController@login -->
      <form class="space-y-6" id="loginForm" method="post" action="/src/plataforma/login" autocomplete="on">
        <div>
          <label for="identificador" class="block text-sm font-medium text-gray-700 mb-2 text-left">
            Email, matrícula o No. de empleado
          </label>
          <div class="relative form-input-wrapper">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 input-icon">
              <i data-feather="user" class="h-5 w-5 text-gray-400"></i>
            </div>
            <input
              type="text"
              id="identificador"
              name="identificador"
              required
              inputmode="text"
              autocomplete="username"
              value="<?= htmlspecialchars($_POST['identificador'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
              class="form-input w-full pl-10 pr-3 rounded-lg text-gray-900 placeholder-gray-500 text-base"
              placeholder="email@utsc.mx • A23-00123 • 0042">
          </div>
          <p class="mt-2 text-xs text-gray-500 text-left opacity-80 animate-pulse-fadein" style="animation-delay: 1.5s;">
            Alumnos: usa tu <strong class="text-ut-green-700">matrícula</strong>. Docentes y capturistas: tu <strong class="text-ut-green-700">número de empleado</strong>. También puedes usar tu <strong>email</strong>.
          </p>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2 text-left">Contraseña</label>
          <div class="relative form-input-wrapper">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-colors duration-300 input-icon">
              <i data-feather="lock" class="h-5 w-5 text-gray-400"></i>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              autocomplete="current-password"
              class="form-input w-full pl-10 pr-10 rounded-lg text-gray-900 placeholder-gray-500 text-base"
              placeholder="••••••••">
            <button type="button" aria-label="Mostrar/ocultar contraseña" id="togglePasswordVisibility"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200">
              <i data-feather="eye" class="h-5 w-5 transform transition-transform duration-300"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-start">
          <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none" for="remember">
            <div class="relative inline-block">
              <input id="remember" name="remember" type="checkbox"
                     class="sr-only" <?= (isset($_COOKIE['remember_user']) && $_COOKIE['remember_user'] === 'true') ? 'checked' : ''; ?>>
              <div class="remember-checkbox block w-5 h-5 rounded border-2 border-gray-400 bg-white transition-all duration-200 flex items-center justify-center">
                <svg class="checkmark hidden w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <span>Recordarme</span>
          </label>
        </div>

        <button type="submit" id="submitButton" class="premium-btn w-full flex justify-center items-center gap-2 py-3 px-4 rounded-lg text-white">
          <i data-feather="log-in" class="h-5 w-5"></i>
          Iniciar Sesión
        </button>

        <a href="<?= htmlspecialchars($HOME_URL ?? '/', ENT_QUOTES, 'UTF-8'); ?>"
           class="ghost-btn w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-lg">
          <i data-feather="arrow-left" class="h-5 w-5"></i>
          Volver al inicio
        </a>
      </form>

      <!-- Pie de página -->
      <div class="mt-8 text-center pt-6 border-t border-gray-200 opacity-90">
        <div class="flex items-center justify-center gap-2 text-gray-500 mb-2">
          <i data-feather="heart" class="h-4 w-4 text-red-400 animate-pulse-color"></i>
          <span class="text-sm">Hecho con dedicación por la educación</span>
        </div>
        <span class="text-xs text-gray-400">© <?= date('Y'); ?> UTSC - Todos los derechos reservados</span>
      </div>
    </div>
  </div>

  <script>
    feather.replace();

    document.addEventListener('DOMContentLoaded', () => {
      const passwordInput    = document.getElementById('password');
      const togglePassword   = document.getElementById('togglePasswordVisibility');
      const loginForm        = document.getElementById('loginForm');
      const submitButton     = document.getElementById('submitButton');
      const rememberCheckbox = document.getElementById('remember');
      const identificador    = document.getElementById('identificador');

      // Mostrar/ocultar contraseña
      if (passwordInput && togglePassword) {
        togglePassword.addEventListener('click', () => {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          const icon = togglePassword.querySelector('i');
          icon.style.transform = 'rotateY(90deg)';
          setTimeout(() => {
            icon.setAttribute('data-feather', type === 'password' ? 'eye' : 'eye-off');
            feather.replace({width:'20px', height:'20px'});
            icon.style.transform = 'rotateY(0deg)';
          }, 150);
        });
      }

      // Evitar doble submit
      if (loginForm && submitButton) {
        loginForm.addEventListener('submit', () => {
          submitButton.disabled = true;
          submitButton.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg> Iniciando Sesión...`;
        });
      }

      // Cookies helpers
      function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
      }
      function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days*24*60*60*1000));
        document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
      }

      // Recordarme
      const rememberUser = getCookie('remember_user');
      if (rememberUser === 'true' && identificador) {
        const saved = getCookie('saved_username');
        if (saved) identificador.value = saved;
      }

      if (rememberCheckbox && identificador) {
        rememberCheckbox.addEventListener('change', function() {
          if (this.checked) {
            setCookie('remember_user', 'true', 30);
            if (identificador.value) setCookie('saved_username', identificador.value, 30);
          } else {
            document.cookie = 'remember_user=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
            document.cookie = 'saved_username=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
          }
        });

        identificador.addEventListener('blur', () => {
          if (rememberCheckbox.checked && identificador.value) {
            setCookie('saved_username', identificador.value, 30);
          }
        });
      }

      // Cerrar mensajes flash con animación
      document.querySelectorAll('.flash-message').forEach(msg => {
        const closeButton = msg.querySelector('.close-button');
        if (closeButton) {
          closeButton.addEventListener('click', () => {
            msg.style.animation = 'flashDisappear 0.4s ease-out forwards';
            setTimeout(() => msg.remove(), 400);
          });
        }
      });

      // Autofocus
      setTimeout(() => { if (identificador) identificador.focus(); }, 1100);
    });
  </script>
</body>
</html>
