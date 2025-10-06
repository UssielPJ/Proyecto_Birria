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
  <title>Acceso Académico — UTSC</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root{
      --ut-green-900:#0c4f2e; --ut-green-800:#12663a; --ut-green-700:#177a46;
      --ut-green-600:#1e8c51; --ut-green-500:#28a55f; --ut-green-100:#e6f6ed;
      --ut-green-50:#f0faf4;
      --accent-gold: #d4af37; --light-gold: #f4e4a6;
    }
    
    body {
      background: linear-gradient(135deg, #0c4f2e 0%, #12663a 50%, #177a46 100%);
      font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .login-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
      position: relative;
      overflow: hidden;
    }
    
    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--ut-green-600), var(--accent-gold), var(--ut-green-600));
    }
    
    .login-container::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: conic-gradient(
        from 0deg,
        transparent,
        rgba(40, 165, 95, 0.1),
        rgba(212, 175, 55, 0.05),
        transparent
      );
      animation: rotate 10s linear infinite;
      z-index: 0;
    }
    
    @keyframes rotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .form-content {
      position: relative;
      z-index: 1;
    }
    
    .elegant-input {
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid #e2e8f0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-size: 15px;
    }
    
    .elegant-input:focus {
      border-color: var(--ut-green-500);
      box-shadow: 
        0 0 0 3px rgba(40, 165, 95, 0.15),
        0 4px 6px -1px rgba(0, 0, 0, 0.05);
      background: rgba(255, 255, 255, 0.95);
      transform: translateY(-1px);
    }
    
    .prestige-btn {
      background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-700));
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    
    .prestige-btn::before {
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
    }
    
    .prestige-btn:hover::before {
      left: 100%;
    }
    
    .prestige-btn:hover {
      transform: translateY(-2px);
      box-shadow: 
        0 12px 25px -8px rgba(12, 79, 46, 0.4),
        0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .university-logo {
      transition: all 0.3s ease;
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }
    
    .university-logo:hover {
      transform: scale(1.05);
      filter: drop-shadow(0 6px 8px rgba(0, 0, 0, 0.15));
    }
    
    .feature-icon {
      background: linear-gradient(135deg, var(--ut-green-100), var(--ut-green-50));
      border: 1px solid rgba(40, 165, 95, 0.2);
      transition: all 0.3s ease;
    }
    
    .feature-icon:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(40, 165, 95, 0.15);
    }
    
    .floating-shapes {
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-10px) rotate(2deg); }
    }
    
    .security-badge {
      background: linear-gradient(135deg, var(--ut-green-50), white);
      border: 1px solid rgba(40, 165, 95, 0.2);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .pulse-dot {
      width: 8px;
      height: 8px;
      background: var(--ut-green-500);
      border-radius: 50%;
      animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
      0%, 100% { 
        opacity: 1;
        box-shadow: 0 0 0 0 rgba(40, 165, 95, 0.7);
      }
      50% { 
        opacity: 0.8;
        box-shadow: 0 0 0 6px rgba(40, 165, 55, 0);
      }
    }
    
    .divider {
      background: linear-gradient(90deg, transparent, var(--ut-green-300), transparent);
      height: 1px;
    }
    
    .accent-text {
      background: linear-gradient(135deg, var(--ut-green-600), var(--accent-gold));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
  </style>
</head>
<body class="p-4">
  <!-- Elementos decorativos de fondo -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-20 left-10 w-20 h-20 bg-green-400/10 rounded-full floating-shapes"></div>
    <div class="absolute bottom-20 right-20 w-16 h-16 bg-green-300/10 rounded-full floating-shapes" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-green-500/10 rounded-full floating-shapes" style="animation-delay: 4s;"></div>
  </div>

  <div class="login-container rounded-3xl w-full max-w-md mx-auto">
    <div class="form-content p-8">
      <!-- Header con logo discreto -->
      <div class="flex items-center gap-3 mb-8">
        <div class="university-logo w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-500 rounded-xl flex items-center justify-center">
          <i data-feather="book-open" class="w-6 h-6 text-white"></i>
        </div>
        <div>
          <h1 class="text-xl font-bold text-gray-900">UTSC</h1>
          <p class="text-gray-600 text-sm">Portal Académico</p>
        </div>
      </div>

      <!-- Encabezado del formulario -->
      <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Bienvenido</h2>
        <p class="text-gray-600">Ingrese sus credenciales de acceso</p>
      </div>

      <form id="loginForm" action="/auth/login" method="post" novalidate class="space-y-6">
        <!-- Campo Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-3">Correo Institucional</label>
          <div class="relative">
            <input id="email" name="email" type="email" required
                   class="elegant-input w-full rounded-xl px-4 py-4 pr-12 focus:outline-none"
                   placeholder="usuario@utsc.edu.mx"/>
            <div class="absolute right-4 top-1/2 -translate-y-1/2">
              <i data-feather="mail" class="w-5 h-5 text-gray-400"></i>
            </div>
          </div>
          <p id="emailError" class="mt-2 text-red-600 text-sm hidden flex items-center gap-2">
            <i data-feather="alert-circle" class="w-4 h-4"></i>
            Ingrese un correo válido
          </p>
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
            placeholder="Contraseña: 12345"
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
              aria-label="Iniciar sesión">
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

    function validateForm() {
      const email = emailField.value.trim();
      const password = passwordField.value;
      let isValid = true;

      // Email validation
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        emailError.classList.remove('hidden');
        emailError.textContent = 'Por favor ingresa un correo válido';
        isValid = false;
      } else {
        emailError.classList.add('hidden');
      }

      // Password validation
      if (password.length < 5) {
        passwordError.classList.remove('hidden');
        passwordError.textContent = 'La contraseña debe tener al menos 5 caracteres';
        isValid = false;
      } else {
        passwordError.classList.add('hidden');
      }

      if (isValid) {
        // Loading state
        submitBtn.disabled = true;
        const spinner = submitBtn.querySelector('.loading-spinner');
        const text = submitBtn.querySelector('span');
        spinner.classList.remove('hidden');
        text.style.opacity = '0.5';
      }

      return isValid;
    }

    // Real-time validation
    form.addEventListener('submit', function(e) {
      if (!validateForm()) {
        e.preventDefault();
      }
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
      if (this.value.length < 5) {
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

    feather.replace();
    
    // Toggle password visibility
    const toggle = document.getElementById('togglePwd');
    const pwd = document.getElementById('password');
    
    toggle.addEventListener('click', ()=>{
      const isText = pwd.type === 'text';
      pwd.type = isText ? 'password' : 'text';
      toggle.innerHTML = isText ? feather.icons['eye'].toSvg() : feather.icons['eye-off'].toSvg();
    });

    // Form validation
    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const passError = document.getElementById('passError');
    
    form.addEventListener('submit', (e)=>{
      emailError.classList.add('hidden'); 
      passError.classList.add('hidden');
      let ok = true;
      
      if(!email.value || !/^\S+@\S+\.\S+$/.test(email.value)){ 
        emailError.classList.remove('hidden'); 
        ok = false; 
      }
      
      if(!pwd.value || pwd.value.length < 6){ 
        passError.classList.remove('hidden'); 
        ok = false; 
      }
      
      if(!ok) {
        e.preventDefault();
        feather.replace();
      }
    });
    
    // Real-time validation
    email.addEventListener('blur', () => {
      if(email.value && !/^\S+@\S+\.\S+$/.test(email.value)) {
        emailError.classList.remove('hidden');
        email.parentElement.classList.add('ring-2', 'ring-red-200');
        feather.replace();
      } else {
        emailError.classList.add('hidden');
        email.parentElement.classList.remove('ring-2', 'ring-red-200');
      }
    });
    
    pwd.addEventListener('blur', () => {
      if(pwd.value && pwd.value.length < 6) {
        passError.classList.remove('hidden');
        pwd.parentElement.classList.add('ring-2', 'ring-red-200');
        feather.replace();
      } else {
        passError.classList.add('hidden');
        pwd.parentElement.classList.remove('ring-2', 'ring-red-200');
      }
    });

    // Efectos de focus mejorados
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('focus', () => {
        input.parentElement.classList.add('ring-2', 'ring-green-100');
      });
      
      input.addEventListener('blur', () => {
        input.parentElement.classList.remove('ring-2', 'ring-green-100');
      });
    });
  </script>
</body>
</html>