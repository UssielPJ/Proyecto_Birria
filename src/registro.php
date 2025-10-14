<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Solicitud de Admisión — UTSC</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root{
      --ut-green-900:#0c4f2e; --ut-green-800:#12663a; --ut-green-700:#177a46;
      --ut-green-600:#1e8c51; --ut-green-500:#28a55f; --ut-green-100:#e6f6ed;
      --ut-green-50:#f0faf4;
      --accent-gold: #d4af37;
    }
    
    body {
      background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
      font-family: 'Inter', system-ui, sans-serif;
    }
    
    .premium-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 
        0 25px 50px -12px rgba(0, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }
    
    .premium-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--ut-green-600), var(--accent-gold), var(--ut-green-600));
    }
    
    .form-input {
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid #e2e8f0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .form-input:focus {
      border-color: var(--ut-green-500);
      box-shadow: 
        0 0 0 3px rgba(40, 165, 95, 0.15),
        0 4px 6px -1px rgba(0, 0, 0, 0.05);
      background: rgba(255, 255, 255, 0.95);
      transform: translateY(-1px);
    }
    
    .premium-btn {
      background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-700));
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
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
    }
    
    .premium-btn:hover::before {
      left: 100%;
    }
    
    .premium-btn:hover {
      transform: translateY(-2px);
      box-shadow: 
        0 12px 25px -8px rgba(12, 79, 46, 0.4),
        0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .step-indicator {
      width: 40px;
      height: 40px;
      border: 2px solid var(--ut-green-300);
      background: white;
      transition: all 0.3s ease;
    }
    
    .step-indicator.active {
      background: var(--ut-green-500);
      border-color: var(--ut-green-500);
      color: white;
    }
    
    .step-indicator.completed {
      background: var(--ut-green-500);
      border-color: var(--ut-green-500);
      color: white;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
  <!-- Elementos decorativos de fondo -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-20 left-10 w-20 h-20 bg-green-400/10 rounded-full"></div>
    <div class="absolute bottom-20 right-20 w-16 h-16 bg-green-300/10 rounded-full"></div>
    <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-green-500/10 rounded-full"></div>
  </div>

  <div class="premium-card rounded-3xl w-full max-w-4xl mx-auto relative overflow-hidden">
    <div class="p-8">
      <!-- Header -->
      <div class="flex items-center gap-4 mb-8">
        <div class="w-14 h-14 bg-gradient-to-br from-green-600 to-emerald-500 rounded-xl flex items-center justify-center">
          <i data-feather="book-open" class="w-7 h-7 text-white"></i>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">UTSC</h1>
          <p class="text-gray-600">Solicitud de Admisión</p>
        </div>
      </div>

      <!-- Progreso -->
      <div class="flex items-center justify-between mb-10">
        <div class="flex items-center gap-4">
          <div class="step-indicator rounded-full flex items-center justify-center font-semibold completed">
            <i data-feather="check" class="w-5 h-5"></i>
          </div>
          <div class="step-indicator rounded-full flex items-center justify-center font-semibold active">2</div>
          <div class="step-indicator rounded-full flex items-center justify-center font-semibold">3</div>
        </div>
        <div class="text-sm text-gray-500 font-medium">Paso 2 de 3</div>
      </div>

      <form id="admissionForm" action="/admission/apply" method="post" novalidate class="space-y-8">
        <!-- Información Personal -->
        <div class="space-y-6">
          <div class="border-l-4 border-green-500 pl-4">
            <h3 class="text-xl font-bold text-gray-900">Información Personal</h3>
            <p class="text-gray-600 text-sm">Datos básicos del aspirante</p>
          </div>
          
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="nombre">
                <span class="flex items-center gap-2">
                  <i data-feather="user" class="w-4 h-4"></i>
                  Nombre(s)
                </span>
              </label>
              <input id="nombre" name="nombre" type="text" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                     placeholder="Ingresa tu nombre completo"/>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="apellidos">
                <span class="flex items-center gap-2">
                  <i data-feather="user" class="w-4 h-4"></i>
                  Apellidos
                </span>
              </label>
              <input id="apellidos" name="apellidos" type="text" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                     placeholder="Ingresa tus apellidos"/>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="fecha_nacimiento">
                <span class="flex items-center gap-2">
                  <i data-feather="calendar" class="w-4 h-4"></i>
                  Fecha de Nacimiento
                </span>
              </label>
              <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"/>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="telefono">
                <span class="flex items-center gap-2">
                  <i data-feather="phone" class="w-4 h-4"></i>
                  Teléfono
                </span>
              </label>
              <input id="telefono" name="telefono" type="tel" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                     placeholder="+52 123 456 7890"/>
            </div>
          </div>
        </div>

        <!-- Información Académica -->
        <div class="space-y-6">
          <div class="border-l-4 border-green-500 pl-4">
            <h3 class="text-xl font-bold text-gray-900">Información Académica</h3>
            <p class="text-gray-600 text-sm">Tu preparación educativa</p>
          </div>
          
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3" for="preparatoria">
              <span class="flex items-center gap-2">
                <i data-feather="book" class="w-4 h-4"></i>
                Preparatoria de Procedencia
              </span>
            </label>
            <input id="preparatoria" name="preparatoria" type="text" required 
                   class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                   placeholder="Nombre de tu preparatoria"/>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="promedio">
                <span class="flex items-center gap-2">
                  <i data-feather="bar-chart" class="w-4 h-4"></i>
                  Promedio General
                </span>
              </label>
              <input id="promedio" name="promedio" type="number" step="0.1" min="6" max="10" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                     placeholder="8.5"/>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="carrera_interes">
                <span class="flex items-center gap-2">
                  <i data-feather="target" class="w-4 h-4"></i>
                  Carrera de Interés
                </span>
              </label>
              <select id="carrera_interes" name="carrera_interes" required 
                      class="form-input w-full rounded-xl px-4 py-4 focus:outline-none">
                <option value="">Selecciona una carrera</option>
                <option value="ingenieria">Ingeniería en Sistemas</option>
                <option value="mecatronica">Ingeniería Mecatrónica</option>
                <option value="negocios">Administración de Empresas</option>
                <option value="industrial">Ingeniería Industrial</option>
                <option value="diseño">Diseño Gráfico</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información de Contacto -->
        <div class="space-y-6">
          <div class="border-l-4 border-green-500 pl-4">
            <h3 class="text-xl font-bold text-gray-900">Información de Contacto</h3>
            <p class="text-gray-600 text-sm">Cómo podemos contactarte</p>
          </div>
          
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3" for="email">
              <span class="flex items-center gap-2">
                <i data-feather="mail" class="w-4 h-4"></i>
                Correo Electrónico
              </span>
            </label>
            <input id="email" name="email" type="email" required 
                   class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                   placeholder="tu.correo@ejemplo.com"/>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="password">
                <span class="flex items-center gap-2">
                  <i data-feather="lock" class="w-4 h-4"></i>
                  Contraseña
                </span>
              </label>
              <input id="password" name="password" type="password" minlength="8" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                     placeholder="Mínimo 8 caracteres"/>
            </div>
            
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-3" for="confirm_password">
                <span class="flex items-center gap-2">
                  <i data-feather="lock" class="w-4 h-4"></i>
                  Confirmar Contraseña
                </span>
              </label>
              <input id="confirm_password" name="confirm_password" type="password" minlength="8" required 
                     class="form-input w-full rounded-xl px-4 py-4 focus:outline-none"
                     placeholder="Repite tu contraseña"/>
            </div>
          </div>
        </div>

        <!-- Términos y Condiciones -->
        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-xl border border-green-200">
          <input id="terminos" name="terminos" type="checkbox" required 
                 class="mt-1 w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"/>
          <label for="terminos" class="text-sm text-gray-700">
            Acepto los <a href="#" class="text-green-600 hover:text-green-700 font-semibold">términos y condiciones</a> 
            y autorizo el tratamiento de mis datos personales según la política de privacidad de la UTSC.
          </label>
        </div>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6">
          <button type="button" class="flex-1 inline-flex items-center justify-center gap-2 py-4 px-6 rounded-xl font-semibold text-gray-700 border-2 border-gray-300 hover:border-gray-400 transition-colors">
            <i data-feather="arrow-left" class="w-5 h-5"></i>
            Regresar
            <a href="./index.php"></a>
          </button>
          <button type="submit" class="premium-btn flex-1 inline-flex items-center justify-center gap-2 py-4 px-6 rounded-xl font-semibold">
            <i data-feather="send" class="w-5 h-5"></i>
            Enviar Solicitud
          </button>
        </div>
      </form>

      <div class="mt-8 pt-6 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600">
          ¿Ya tienes una cuenta? 
          <a href="login.html" class="text-green-600 hover:text-green-700 font-semibold">Iniciar sesión</a>
        </p>
      </div>
    </div>
  </div>

  <script>
    feather.replace();
    
    // Validación del formulario
    const form = document.getElementById('admissionForm');
    form.addEventListener('submit', function(e) {
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirm_password');
      const terminos = document.getElementById('terminos');
      
      let isValid = true;
      
      // Validar contraseñas
      if (password.value !== confirmPassword.value) {
        isValid = false;
        alert('Las contraseñas no coinciden');
      }
      
      // Validar términos
      if (!terminos.checked) {
        isValid = false;
        alert('Debes aceptar los términos y condiciones');
      }
      
      if (!isValid) {
        e.preventDefault();
      }
    });
    
    // Efectos de focus mejorados
    document.querySelectorAll('input, select').forEach(input => {
      input.addEventListener('focus', () => {
        input.parentElement.classList.add('ring-2', 'ring-green-100', 'rounded-xl');
      });
      
      input.addEventListener('blur', () => {
        input.parentElement.classList.remove('ring-2', 'ring-green-100', 'rounded-xl');
      });
    });
  </script>
</body>
</html>