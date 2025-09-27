<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iniciar sesión — UTEC</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root{
      --ut-green-900:#0c4f2e; --ut-green-800:#12663a; --ut-green-700:#177a46;
      --ut-green-600:#1e8c51; --ut-green-500:#28a55f; --ut-green-100:#e6f6ed;
    }
    .bg-ut-gradient{
      background: radial-gradient(1200px 600px at 10% -10%, rgba(40,165,95,.25), transparent 55%),
                  radial-gradient(1000px 500px at 110% 20%, rgba(18,102,58,.25), transparent 55%),
                  linear-gradient(180deg, #0d3d25 0%, #0c2f1e 100%);
    }
    .glass{ background: rgba(255,255,255,.08); backdrop-filter: blur(10px); border:1px solid rgba(255,255,255,.18); }
  </style>
</head>
<body class="min-h-screen bg-ut-gradient text-white">
  <div class="relative z-10 mx-auto max-w-6xl px-4 py-10 md:py-16">
    <header class="flex items-center gap-3 mb-10">
      <a href="index.html" class="inline-flex items-center gap-3">
        <img src="http://static.photos/education/200x200/1" alt="UTEC" class="w-12 h-12 rounded-sm ring-2 ring-white/20" />
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight">UTEC</h1>
          <p class="text-white/70 text-sm -mt-1">saber hacer para competir</p>
        </div>
      </a>
    </header>

    <div class="grid lg:grid-cols-2 gap-8 items-stretch">
      <section class="hidden lg:flex flex-col justify-center rounded-2xl glass p-10">
        <h2 class="text-4xl font-black leading-tight">Plataforma E-Learning
          <span class="block text-emerald-300">Acceso seguro</span>
        </h2>
        <ul class="mt-6 space-y-3 text-white/90">
          <li class="flex items-center gap-3"><i data-feather="check-circle" class="w-5 h-5 text-emerald-300"></i> Autenticación segura</li>
          <li class="flex items-center gap-3"><i data-feather="check-circle" class="w-5 h-5 text-emerald-300"></i> Roles por perfil</li>
          <li class="flex items-center gap-3"><i data-feather="check-circle" class="w-5 h-5 text-emerald-300"></i> 100% responsivo</li>
        </ul>
      </section>

      <section class="rounded-2xl bg-white text-gray-800 p-6 sm:p-8 lg:p-10 shadow-xl">
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-[var(--ut-green-800)]">Iniciar sesión</h2>
          <p class="text-sm text-gray-500">Usa tu correo institucional</p>
        </div>

        <form id="loginForm" action="/auth/login" method="post" novalidate class="space-y-5">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
            <div class="mt-1 relative">
              <input id="email" name="email" type="email" required
                     class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 focus:border-[var(--ut-green-600)] focus:ring-[var(--ut-green-600)]"
                     placeholder="nombre.apellido@utec.edu"/>
              <i data-feather="mail" class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
            </div>
            <p id="emailError" class="mt-1 text-sm text-red-600 hidden">Ingresa un correo válido.</p>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <div class="mt-1 relative">
              <input id="password" name="password" type="password" required minlength="6"
                     class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 focus:border-[var(--ut-green-600)] focus:ring-[var(--ut-green-600)]"
                     placeholder="••••••••"/>
              <button type="button" id="togglePwd" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-500 hover:text-gray-700" aria-label="Mostrar u ocultar contraseña">
                <i data-feather="eye"></i>
              </button>
            </div>
            <p id="passError" class="mt-1 text-sm text-red-600 hidden">La contraseña debe tener al menos 6 caracteres.</p>
          </div>

          <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-gray-600 select-none">
              <input type="checkbox" name="remember" class="rounded text-[var(--ut-green-600)] focus:ring-[var(--ut-green-600)]">
              Recuérdame
            </label>
            <a href="#" class="text-sm font-medium text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)]">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 font-semibold text-white bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] focus:ring-2 focus:ring-offset-2 focus:ring-[var(--ut-green-500)]">
            <i data-feather="log-in" class="w-5 h-5"></i> Entrar
          </button>

          <div class="relative my-2">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t border-gray-200"></span></div>
            <div class="relative flex justify-center"><span class="bg-white px-3 text-xs text-gray-400">o</span></div>
          </div>

          <a href="registro.html" class="w-full inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 font-semibold text-[var(--ut-green-800)] border border-[var(--ut-green-200)] hover:bg-[var(--ut-green-100)]">
            <i data-feather="user-plus" class="w-5 h-5"></i> Crear cuenta
          </a>

          <p class="text-xs text-gray-500 text-center mt-4">
            Al continuar aceptas el <a href="#" class="underline">Aviso de Privacidad</a> y los <a href="#" class="underline">Términos del Servicio</a>.
          </p>
        </form>
      </section>
    </div>
  </div>

  <script>
    feather.replace();
    const toggle = document.getElementById('togglePwd');
    const pwd = document.getElementById('password');
    toggle.addEventListener('click', ()=>{
      const isText = pwd.type === 'text';
      pwd.type = isText ? 'password' : 'text';
      toggle.innerHTML = isText ? feather.icons['eye'].toSvg() : feather.icons['eye-off'].toSvg();
    });

    const form = document.getElementById('loginForm');
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const passError = document.getElementById('passError');
    form.addEventListener('submit', (e)=>{
      emailError.classList.add('hidden'); passError.classList.add('hidden');
      let ok = true;
      if(!email.value || !/^\S+@\S+\.\S+$/.test(email.value)){ emailError.classList.remove('hidden'); ok = false; }
      if(!pwd.value || pwd.value.length < 6){ passError.classList.remove('hidden'); ok = false; }
      if(!ok) e.preventDefault();
    });
  </script>



</body>




</html>
