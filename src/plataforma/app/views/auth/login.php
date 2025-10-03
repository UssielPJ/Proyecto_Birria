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

        <!-- Campo Contraseña -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-3">Contraseña</label>
          <div class="relative">
            <input id="password" name="password" type="password" required minlength="6"
                   class="elegant-input w-full rounded-xl px-4 py-4 pr-12 focus:outline-none"
                   placeholder="••••••••"/>
            <button type="button" id="togglePwd" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-gray-500 hover:text-gray-700 transition-colors">
              <i data-feather="eye"></i>
            </button>
          </div>
          <p id="passError" class="mt-2 text-red-600 text-sm hidden flex items-center gap-2">
            <i data-feather="alert-circle" class="w-4 h-4"></i>
            Mínimo 6 caracteres
          </p>
        </div>

        <!-- Opciones adicionales -->
        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-3 text-sm text-gray-600 select-none cursor-pointer group">
            <div class="relative">
              <input type="checkbox" name="remember" class="sr-only peer">
              <div class="w-5 h-5 border-2 border-gray-300 rounded-lg peer-checked:bg-green-500 peer-checked:border-green-500 transition-colors group-hover:border-green-400"></div>
              <i data-feather="check" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
            </div>
            <span class="group-hover:text-gray-700 transition-colors">Recordar acceso</span>
          </label>
          <a href="#" class="text-sm font-medium text-green-600 hover:text-green-700 transition-colors">
            ¿Olvidó contraseña?
          </a>
        </div>

        <!-- Botón de Acceso -->
<button type="submit" class="prestige-btn w-full rounded-xl px-4 py-4 font-semibold mt-2 flex items-center justify-center gap-3">
  <i data-feather="log-in" class="w-5 h-5"></i>
  Acceder al Sistema
</button>

<!-- Botón para regresar al inicio - Estilo ghost -->
<a href="<?php echo htmlspecialchars($HOME_URL); ?>" 
   class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold text-green-600 hover:text-green-700 transition-all duration-200 border-2 border-green-200 hover:border-green-300 hover:bg-green-50 mt-4">
  <i data-feather="home" class="w-4 h-4"></i>
  Regresar al Inicio
  <a href="./index.php"></a>
</a>

        <!-- Badge de seguridad -->
        <div class="security-badge rounded-xl p-4 text-center">
          <div class="flex items-center justify-center gap-2 mb-2">
            <div class="pulse-dot"></div>
            <span class="text-sm font-medium text-green-700">Conexión Segura</span>
          </div>
          <p class="text-xs text-gray-600">Sus datos están protegidos con encriptación SSL</p>
        </div>
      </form>

      <!-- Footer minimalista -->
      <div class="mt-6 pt-4 border-t border-gray-100">
        <div class="text-center">
          <p class="text-xs text-gray-500">
            UTSC © 2024 • 
            <a href="#" class="text-green-600 hover:text-green-700 transition-colors">Soporte Técnico</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script>
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
