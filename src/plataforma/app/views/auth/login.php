<?php
// src/plataforma/app/views/auth/login.php
if (session_status() === PHP_SESSION_NONE) session_start();
$error   = $_SESSION['flash_error']   ?? null;
$success = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_error'], $_SESSION['flash_success']);

$HOME_URL = '/src'; // Asegúrate de que esta URL sea correcta para tu entorno.
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
  <!-- Usar una fuente de Google Fonts para mejor estética, como Inter que ya tenías en tu CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Variables CSS - Mantengo tus variables para consistencia */
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
      /* quitamos overflow: hidden para permitir el scroll si es necesario */
      /* El scroll será gestionado por el contenedor principal */
    }

    /* Contenedor principal para manejar el scroll y centrado */
    .main-content-wrapper {
        flex-grow: 1; /* Permite que el contenedor ocupe el espacio disponible */
        display: flex;
        align-items: center; /* Centra verticalmente cuando hay espacio */
        justify-content: center; /* Centra horizontalmente */
        padding: 1rem; /* Padding base para evitar que la tarjeta toque los bordes */
        /* Aseguramos el scroll aquí, si el contenido excede la altura del viewport */
        overflow-y: auto;
        -webkit-overflow-scrolling: touch; /* Suaviza el scroll en iOS */
    }
    
    /* Animación de entrada para el premium-card */
    .premium-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow:
        0 25px 50px -12px rgba(0, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
      border-radius: 0.75rem; /* Aseguramos redondeado global */
      /* Añadimos un max-height para controlar el tamaño en pantallas muy pequeñas, con overflow interno si se necesita */
      max-height: calc(100vh - 2rem); /* 2rem es el padding total de main-content-wrapper */
      overflow-y: auto; /* Scroll interno si la tarjeta es muy alta */
      -webkit-overflow-scrolling: touch;
      /* Animación de entrada */
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInSlideUp 0.8s ease-out forwards;
      animation-delay: 0.3s; /* Un pequeño retardo después del fondo */
    }

    .premium-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--ut-green-600), var(--ut-green-400), var(--ut-green-600));
      border-radius: 0.75rem 0.75rem 0 0; /* Coincide con el borde redondeado de la tarjeta */
      /* Efecto de carga o progresión */
      transform: scaleX(0);
      transform-origin: left;
      animation: gradientBarLoad 1.2s ease-out forwards;
      animation-delay: 0.8s;
    }

    /* Animación para inputs y iconos al enfocar */
    .form-input {
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid #e2e8f0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      /* Para que la caja se ajuste visualmente bien */
      padding-top: 13px; /* Más espacio para centrar el texto con los iconos */
      padding-bottom: 13px;
    }

    .form-input:focus {
      border-color: var(--ut-green-500);
      box-shadow:
        0 0 0 3px rgba(40, 165, 95, 0.15),
        0 4px 6px -1px rgba(0, 0, 0, 0.05);
      background: rgba(255, 255, 255, 0.98); /* Ligeramente más opaco al enfocar */
      transform: translateY(-1px);
    }

    /* Efecto para el icono cuando el input está enfocado */
    .form-input-wrapper:focus-within .input-icon {
      color: var(--ut-green-600);
      transform: scale(1.1); /* Ligeramente más grande */
    }

    .premium-btn {
      background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-700));
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      border: none; /* Asegura que no tenga borde predeterminado */
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
      z-index: 1; /* Para que esté por encima del color de fondo del botón */
    }

    .premium-btn:hover::before {
      left: 100%;
    }

    .premium-btn:hover:not(:disabled) { /* No aplicar si está deshabilitado */
      transform: translateY(-2px);
      box-shadow:
        0 12px 25px -8px rgba(12, 79, 46, 0.4),
        0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .premium-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800)); /* Oscurece un poco al deshabilitar */
        transform: none; /* Elimina cualquier transformación si se desactiva mientras está en hover */
        box-shadow: none;
    }

    .ghost-btn {
      background-color: rgba(0, 0, 0, 0.8);
      border: 2px solid rgba(0, 0, 0, 0.9);
      color: white;
      font-weight: 600;
      transition: all 0.3s ease;
      /* Animación en el hover */
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
        border-radius: 0.5rem; /* Asegura que el background sea redondeado */
        z-index: -1;
        opacity: 0;
        transform: scale(0.9);
        transition: all 0.3s ease;
    }

    .ghost-btn:hover {
      /* background-color: rgba(255, 255, 255, 0.1); Esto ahora lo hace el pseudo-elemento */
      transform: translateY(-2px) scale(1.01); /* ligera escala junto al translate */
      border-color: rgba(255, 255, 255, 0.5); /* Borde un poco más visible al hover */
    }
    .ghost-btn:hover::before {
        opacity: 1;
        transform: scale(1);
    }


    /* Estilos y animaciones para mensajes flash */
    .flash-message {
      padding: 1rem 1.25rem;
      border-radius: 0.75rem;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
      font-weight: 500;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border: 1px solid;
      display: flex; /* Asegura que el icono y texto estén en línea */
      align-items: center;
      position: relative; /* Para el botón de cerrar */

      /* Animación de entrada */
      opacity: 0;
      transform: scale(0.95);
      animation: flashAppear 0.5s ease-out forwards;
    }

    /* Botón de cerrar para mensajes flash */
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
      color: inherit; /* Hereda el color del texto del flash message */
      transition: all 0.2s ease;
    }
    .flash-message .close-button:hover {
      background-color: rgba(0,0,0,0.05); /* Ligero hover effect */
    }


    .flash-error {
      background-color: #FEF2F2; /* Rojo muy claro */
      border-color: #FCA5A5; /* Borde rojo */
      color: #DC2626;       /* Texto rojo oscuro */
    }
    .flash-success {
      background-color: #F0FDF4; /* Verde muy claro */
      border-color: #BBF7D0; /* Borde verde */
      color: #15803D;       /* Texto verde oscuro */
    }

    /* Animación de fondo */
    .floating-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden; /* Mantener hidden para las animaciones del fondo */
    }

    .floating-circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      animation: float 20s infinite ease-in-out;
      will-change: transform, opacity; /* Optimización de rendimiento */
    }

    .circle-1 {
      width: 300px;
      height: 300px;
      top: 10%;
      left: 10%;
      animation-delay: 0s;
      animation-duration: 25s; /* Variar la duración */
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
    .circle-4 { /* Añadir otro círculo para más dinamismo */
        width: 250px;
        height: 250px;
        top: 30%;
        right: 40%;
        animation-delay: 8s;
        animation-duration: 20s;
        background: rgba(255, 255, 255, 0.03); /* Ligeramente más transparente */
    }


    /* KEYFRAMES */
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

    @keyframes rotateEye {
      0% { transform: rotateY(0deg); }
      50% { transform: rotateY(90deg); }
      100% { transform: rotateY(180deg); }
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
        0%, 100% { color: #f87171; /* red-400 */ }
        50% { color: #ef4444; /* red-500 */ transform: scale(1.1); }
    }
    .animate-pulse-color {
        animation: pulse-color 2s infinite ease-in-out;
    }

    /* Estilo para el input de tipo checkbox personalizado */
    .animated-checkbox-wrapper {
        display: inline-flex;
        align-items: center;
        position: relative;
        cursor: pointer;
    }
    .animated-checkbox-wrapper input[type="checkbox"] {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    .animated-checkbox-checkmark {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #a1a1aa; /* text-gray-400 */
        border-radius: 0.25rem; /* rounded-sm */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9fafb; /* Fondo blanco */
        transition: all 0.2s ease;
        flex-shrink: 0; /* Evita que el checkmark se encoja */
    }
    .animated-checkbox-checkmark i {
        color: white;
        font-size: 0.9rem; /* Tamaño del icono */
        opacity: 0;
        transform: scale(0);
        transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Bounce effect */
    }
    .animated-checkbox-wrapper input[type="checkbox"]:checked + .animated-checkbox-checkmark {
        background-color: var(--ut-green-600);
        border-color: var(--ut-green-600);
    }
    .animated-checkbox-wrapper input[type="checkbox"]:checked + .animated-checkbox-checkmark i {
        opacity: 1;
        transform: scale(1);
    }
    .animated-checkbox-wrapper:hover .animated-checkbox-checkmark {
        border-color: var(--ut-green-500); /* Highlight en hover */
        box-shadow: 0 0 0 2px rgba(40, 165, 95, 0.2);
    }
    .animated-checkbox-wrapper input[type="checkbox"]:focus + .animated-checkbox-checkmark {
        box-shadow: 0 0 0 3px rgba(40, 165, 95, 0.3);
    }

    /* Estilos para el nuevo checkbox de Recordarme */
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


    /* Media queries para responsividad */
    /* Para pantallas más pequeñas que 768px (ej. móviles) */
    @media (max-width: 767px) {
        .main-content-wrapper {
            padding: 0; /* Elimina padding lateral para que la tarjeta ocupe más ancho */
            align-items: flex-start; /* Alinea la tarjeta arriba para más espacio vertical, luego permite el scroll */
            padding-top: 1rem;
            padding-bottom: 1rem; /* Mantiene padding vertical */
        }

        .premium-card {
            margin: 0.5rem; /* Margen ligero para no pegar completamente a los bordes */
            max-width: 95%; /* La tarjeta ocupa casi todo el ancho */
            border-radius: 0.75rem;
            /* Eliminamos max-height o ajustamos para que la tarjeta misma scrolle si su contenido es grande */
            width: calc(100% - 1rem); /* 100% menos los márgenes horizontales */
            /* En pantallas móviles, queremos que el overflow-y: auto de la tarjeta sea más evidente
               Si el main-content-wrapper ya tiene overflow-y: auto, esta línea se puede omitir o ajustar */
            max-height: calc(100vh - 2rem); /* Altura máxima de la tarjeta para dejar espacio a padding wrapper */
            box-shadow:
                0 10px 20px -5px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6); /* Sombra más suave para móviles */
            /* En un dispositivo móvil es posible que quieras un padding un poco menor dentro de la tarjeta */
            padding: 1.5rem; /* Un poco menos de padding en móviles si p es 2rem antes */
        }
    }
    
    /* Media queries para alturas de viewport muy pequeñas (dispositivos landscape) */
    @media (max-height: 600px) and (min-width: 768px) { /* tablets o desktops con viewport bajo */
        .main-content-wrapper {
            align-items: flex-start; /* Empezar de arriba, dando más espacio al contenido para scroll */
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .premium-card {
            max-height: calc(100vh - 2rem); /* Asegura que no se salga de la pantalla */
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
    <div class="floating-circle circle-4"></div> <!-- Nuevo círculo -->
  </div>

  <!-- Contenedor principal que manejará el scroll vertical -->
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

      <!-- Mensajes Flash de error o éxito -->
      <div id="flash-messages-container">
          <?php if ($error): ?>
            <div class="flash-message flash-error flex items-center mb-4 transition-all duration-300 ease-in-out transform" role="alert">
              <i data-feather="alert-circle" class="w-5 h-5 mr-3 flex-shrink-0"></i>
              <span><?php echo htmlspecialchars($error); ?></span>
              <button type="button" class="close-button" aria-label="Cerrar mensaje">
                <i data-feather="x" class="w-4 h-4"></i>
              </button>
            </div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="flash-message flash-success flex items-center mb-4 transition-all duration-300 ease-in-out transform" role="alert">
              <i data-feather="check-circle" class="w-5 h-5 mr-3 flex-shrink-0"></i>
              <span><?php echo htmlspecialchars($success); ?></span>
              <button type="button" class="close-button" aria-label="Cerrar mensaje">
                <i data-feather="x" class="w-4 h-4"></i>
              </button>
            </div>
          <?php endif; ?>
      </div>


      <!-- Formulario de Inicio de Sesión -->
      <form class="space-y-6" id="loginForm" method="post" action="/src/plataforma/login" autocomplete="on">
        <div>
          <label for="identificador" class="block text-sm font-medium text-gray-700 mb-2 text-left">
            Matrícula o No. de empleado
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
              value="<?php echo htmlspecialchars($_POST['identificador'] ?? ''); ?>"
              class="form-input w-full pl-10 pr-3 rounded-lg text-gray-900 placeholder-gray-500 text-base"
              placeholder="Ej.: A23-00123 o EMP-0456">
          </div>
          <p class="mt-2 text-xs text-gray-500 text-left opacity-80 animate-pulse-fadein" style="animation-delay: 1.5s;">
            Alumnos: usa tu <strong class="text-ut-green-700">matrícula</strong>. Personal: tu <strong class="text-ut-green-700">número de empleado</strong>.
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
                     class="sr-only" <?php echo (isset($_COOKIE['remember_user']) && $_COOKIE['remember_user'] === 'true') ? 'checked' : ''; ?>>
              <div class="remember-checkbox block w-5 h-5 rounded border-2 border-gray-400 bg-white transition-all duration-200 flex items-center justify-center">
                <svg class="checkmark hidden w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <span>Recordarme</span>
          </label>
        </div>

        <!-- Botones de acción -->
        <button type="submit" id="submitButton" class="premium-btn w-full flex justify-center items-center gap-2 py-3 px-4 rounded-lg text-white">
          <i data-feather="log-in" class="h-5 w-5"></i>
          Iniciar Sesión
        </button>

        <a href="<?php echo htmlspecialchars($HOME_URL); ?>"
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
        <span class="text-xs text-gray-400">© <?php echo date('Y'); ?> UTSC - Todos los derechos reservados</span>
      </div>
    </div>
  </div>

  <script>
    feather.replace(); // Inicializar Feather Icons al inicio

    document.addEventListener('DOMContentLoaded', () => {
      // 1. Mostrar/ocultar contraseña
      const passwordInput = document.getElementById('password');
      const togglePasswordBtn = document.getElementById('togglePasswordVisibility');
      if (passwordInput && togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', () => {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          const iconElement = togglePasswordBtn.querySelector('i');
          
          // Anima el giro y cambia el ícono
          iconElement.style.transform = 'rotateY(90deg)';
          setTimeout(() => {
            iconElement.setAttribute('data-feather', type === 'password' ? 'eye' : 'eye-off');
            feather.replace({width: '20px', height: '20px'}); // Refresca un icono específico
            iconElement.style.transform = 'rotateY(0deg)'; // Restablece el giro
          }, 150); // Tiempo a mitad de la transición
        });
      }

      // 2. Manejo de formulario para evitar doble submit
      const loginForm = document.getElementById('loginForm');
      const submitButton = document.getElementById('submitButton');

      if (loginForm && submitButton) {
        loginForm.addEventListener('submit', () => {
          submitButton.disabled = true;
          submitButton.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg> Iniciando Sesión...`;
        });
      }

      // 3. Cerrar mensajes flash
      const flashMessages = document.querySelectorAll('.flash-message');
      flashMessages.forEach(msg => {
        const closeButton = msg.querySelector('.close-button');
        if (closeButton) {
          closeButton.addEventListener('click', () => {
            // Aplicar la animación de salida
            msg.style.animation = 'flashDisappear 0.4s ease-out forwards';
            setTimeout(() => {
              msg.remove();
            }, 400); // Quitar del DOM después de la animación
          });
        }
      });
      
      // 4. Funcionalidad para el checkbox "Recordarme"
      const rememberCheckbox = document.getElementById('remember');
      const identificadorInput = document.getElementById('identificador');
      
      // Función para obtener una cookie específica
      function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
      }
      
      // Función para establecer una cookie
      function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = `expires=${date.toUTCString()}`;
        document.cookie = `${name}=${value};${expires};path=/`;
      }
      
      // Comprobar si hay una cookie de recordarme al cargar la página
      const rememberUser = getCookie('remember_user');
      if (rememberUser === 'true') {
        rememberCheckbox.checked = true;
        // Si existe una cookie con el identificador, rellenar el campo
        const savedUsername = getCookie('saved_username');
        if (savedUsername && identificadorInput) {
          identificadorInput.value = savedUsername;
        }
      }
      
      // Guardar o eliminar el identificador cuando cambia el estado del checkbox
      rememberCheckbox.addEventListener('change', function() {
        if (this.checked) {
          setCookie('remember_user', 'true', 30); // 30 días
          if (identificadorInput.value) {
            setCookie('saved_username', identificadorInput.value, 30);
          }
        } else {
          // Eliminar las cookies
          document.cookie = 'remember_user=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
          document.cookie = 'saved_username=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;';
        }
      });
      
      // 5. Autofocus en el primer input después de que la tarjeta ha animado
      // No necesitamos observar 'premium-card' directamente, la acción es para la tarjeta entera.
      // Basta con que el DOM esté cargado.

      // Retardo para asegurar que las animaciones iniciales CSS terminen o casi terminen
      const animationDelayForFocus = 800 + 300; // sumatoria de los delays de las animaciones iniciales
      setTimeout(() => {
        if (identificadorInput) {
            identificadorInput.focus();
        }
      }, animationDelayForFocus);
    });
  </script>
</body>
</html>