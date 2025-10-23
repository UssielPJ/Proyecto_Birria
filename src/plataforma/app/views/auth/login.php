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
  <title>Login - UTSC</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --ut-green-900: #0c4f2e;
      --ut-green-800: #12663a;
      --ut-green-700: #177a46;
      --ut-green-600: #1e8c51;
      --ut-green-500: #28a55f;
      --ut-green-400: #4cbb7c;
      --ut-green-300: #7dd0a0;
      --ut-green-200: #b8e4c9;
      --ut-green-100: #e6f6ed;
      --ut-green-50: #f0faf4;
      --ut-gold: #d4af37;
    }
    
    body{
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, var(--ut-green-800) 0%, var(--ut-green-700) 100%);
      min-height: 100vh;
      overflow-x: hidden;
    }
    
    .login-container {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .floating-shapes {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 1;
    }
    
    .shape {
      position: absolute;
      border-radius: 50%;
      opacity: 0.1;
      filter: blur(40px);
      animation: float 6s ease-in-out infinite;
    }
    
    .shape-1 {
      width: 300px;
      height: 300px;
      background: var(--ut-green-300);
      top: 10%;
      right: 10%;
      animation-delay: 0s;
    }
    
    .shape-2 {
      width: 200px;
      height: 200px;
      background: var(--ut-gold);
      bottom: 20%;
      left: 10%;
      animation-delay: 2s;
    }
    
    .shape-3 {
      width: 150px;
      height: 150px;
      background: var(--ut-green-100);
      top: 50%;
      left: 20%;
      animation-delay: 4s;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    .login-card{
      backdrop-filter: blur(20px);
      background: rgba(255,255,255,.12);
      border: 1px solid rgba(255,255,255,.25);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      position: relative;
      z-index: 2;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.35);
    }
    
    .input-field{
      background: rgba(255,255,255,.15);
      border: 1px solid rgba(255,255,255,.25);
      transition: all .3s ease;
      backdrop-filter: blur(10px);
    }
    
    .input-field:focus{
      background: rgba(255,255,255,.25);
      border-color: rgba(255,255,255,.5);
      outline: none;
      box-shadow: 0 0 0 3px rgba(40, 165, 95, 0.4);
      transform: translateY(-2px);
    }
    
    .input-field:hover {
      transform: translateY(-1px);
      border-color: rgba(255,255,255,.4);
    }
    
    .btn-login{
      background: linear-gradient(135deg, var(--ut-green-500) 0%, var(--ut-green-700) 100%);
      transition: all .3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.6s ease;
    }
    
    .btn-login:hover::before {
      left: 100%;
    }
    
    .btn-login:hover{
      transform: translateY(-3px);
      box-shadow: 0 15px 30px -10px rgba(40, 165, 95, 0.5);
    }
    
    .btn-ghost{
      transition: all .3s ease;
      backdrop-filter: blur(10px);
    }
    
    .btn-ghost:hover{ 
      background: rgba(255,255,255,.15); 
      transform: translateY(-2px);
      box-shadow: 0 10px 20px -5px rgba(255, 255, 255, 0.2);
    }
    
    .social-btn {
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,.2);
    }
    
    .social-btn:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 10px 20px -5px rgba(255, 255, 255, 0.3);
      background: rgba(255, 255, 255, 0.2);
    }
    
    .facebook-btn:hover {
      color: #1877f2;
      box-shadow: 0 10px 20px -5px rgba(24, 119, 242, 0.4);
    }
    
    .instagram-btn:hover {
      color: #e4405f;
      box-shadow: 0 10px 20px -5px rgba(228, 64, 95, 0.4);
    }
    
    .pulse-ring {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(40, 165, 95, 0.7); }
      70% { box-shadow: 0 0 0 10px rgba(40, 165, 95, 0); }
      100% { box-shadow: 0 0 0 0 rgba(40, 165, 95, 0); }
    }
    
    .logo-container {
      background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
      border: 2px solid rgba(255,255,255,0.3);
      backdrop-filter: blur(10px);
    }
    
    .floating-icon {
      animation: float-icon 3s ease-in-out infinite;
    }
    
    @keyframes float-icon {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    .gradient-text {
      background: linear-gradient(135deg, var(--ut-green-300), var(--ut-gold), var(--ut-green-100));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
  </style>
</head>
<body>
  <div class="login-container p-4">
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
    </div>

    <div class="login-card rounded-3xl overflow-hidden w-full max-w-md">
      <!-- Header con efecto mejorado -->
      <div class="bg-white/10 p-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-var(--ut-green-400) to-var(--ut-green-600)"></div>
        
        <div class="text-center mb-8 relative z-10">
          <!-- Logo UTSC con imagen personalizable -->
          <div class="relative inline-block">
            <div class="pulse-ring absolute inset-0 rounded-full"></div>
            <div class="logo-container w-24 h-24 mx-auto rounded-2xl flex items-center justify-center shadow-2xl floating-icon overflow-hidden">
              <!-- REEMPLAZA LA SIGUIENTE LÍNEA CON LA RUTA DE TU IMAGEN -->
              <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="w-20 h-20 rounded-lg object-contain">
            </div>
          </div>
          
          <h1 class="text-3xl font-bold gradient-text mt-6">UTSC</h1>
          <p class="text-white/90 mt-3 text-lg">Sistema de Acceso para Estudiantes</p>
        </div>

        <!-- Flash messages con mejor diseño -->
        <?php if ($error): ?>
          <div class="mb-6 rounded-xl border border-red-400/50 bg-red-500/20 backdrop-blur-sm text-red-100 px-4 py-3 text-sm transform transition-all duration-300 hover:scale-105">
            <div class="flex items-center gap-2">
              <i data-feather="alert-circle" class="w-4 h-4"></i>
              <?php echo htmlspecialchars($error); ?>
            </div>
          </div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="mb-6 rounded-xl border border-emerald-400/50 bg-emerald-500/20 backdrop-blur-sm text-emerald-100 px-4 py-3 text-sm transform transition-all duration-300 hover:scale-105">
            <div class="flex items-center gap-2">
              <i data-feather="check-circle" class="w-4 h-4"></i>
              <?php echo htmlspecialchars($success); ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Form -->
        <form class="space-y-6" method="post" action="/src/plataforma/login" autocomplete="on">
          <div class="space-y-4">
            <div>
              <label for="email" class="block text-sm font-medium text-white/90 mb-2">Correo Electrónico</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i data-feather="mail" class="text-white/70 floating-icon"></i>
                </div>
                <input
                  type="email"
                  id="email"
                  name="email"
                  required
                  inputmode="email"
                  value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                  class="input-field w-full pl-10 pr-4 py-4 rounded-xl text-white placeholder-white/60 text-lg"
                  placeholder="tucorreo@gmail.com">
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-white/90 mb-2">Contraseña</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i data-feather="lock" class="text-white/70 floating-icon"></i>
                </div>
                <input
                  type="password"
                  id="password"
                  name="password"
                  required
                  class="input-field w-full pl-10 pr-12 py-4 rounded-xl text-white placeholder-white/60 text-lg"
                  placeholder="••••••••">
                <button type="button" aria-label="Mostrar/ocultar contraseña"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-white/70 hover:text-white/90 transition-colors duration-200"
                        onclick="const p=document.getElementById('password'); p.type = p.type==='password' ? 'text' : 'password'; this.querySelector('i').setAttribute('data-feather', p.type==='password' ? 'eye' : 'eye-off'); feather.replace();">
                  <i data-feather="eye"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between">
            <label class="flex items-center gap-3 text-sm text-white/90 cursor-pointer">
              <input id="remember" name="remember" type="checkbox"
                     class="h-5 w-5 text-emerald-400 focus:ring-2 focus:ring-emerald-300 border-white/40 rounded-lg transition-all duration-200">
              Recordarme
            </label>
            <a href="#" class="text-sm font-medium text-white hover:text-emerald-200 transition-colors duration-200">
              ¿Olvidaste tu contraseña?
            </a>
          </div>

          <button type="submit" class="btn-login w-full flex justify-center items-center gap-2 py-4 px-4 rounded-xl text-lg font-semibold text-white">
            <i data-feather="log-in" class="w-5 h-5"></i>
            Iniciar Sesión
          </button>


          <!-- Botón: Volver al inicio -->
          <a href="<?php echo htmlspecialchars($HOME_URL); ?>"
             class="btn-ghost w-full inline-flex items-center justify-center gap-3 py-3 px-4 rounded-xl text-lg font-medium text-white/90 border border-white/20">
            <i data-feather="arrow-left" class="w-5 h-5"></i>
            Volver al inicio
          </a>
        </form>
      </div>

      <!-- Footer mejorado -->
      <div class="bg-white/5 px-6 py-4 text-center backdrop-blur-sm">
        <div class="flex items-center justify-center gap-2 text-white/70 mb-2">
          <i data-feather="heart" class="w-4 h-4 text-red-400"></i>
          <span class="text-sm">Hecho con pasión por la educación</span>
        </div>
        <span class="text-xs text-white/60">© <?php echo date('Y'); ?> UTSC - Todos los derechos reservados</span>
      </div>
    </div>
  </div>

  <script>
    feather.replace();
    
    // Efecto adicional para los inputs al cargar
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.input-field');
      inputs.forEach((input, index) => {
        setTimeout(() => {
          input.style.transform = 'translateY(0)';
          input.style.opacity = '1';
        }, index * 100);
      });
    });
  </script>
</body>
</html>