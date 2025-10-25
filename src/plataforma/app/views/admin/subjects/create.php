<?php
// helpers
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
?>
<div class="container px-6 py-8">
  <div class="max-w-xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nueva Materia</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Registra una materia y su clave abreviada.</p>
      </div>

      <!-- Ajusta la acción si tu ruta difiere -->
      <form action="/src/plataforma/app/admin/subjects/store" method="POST" class="space-y-6">
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <div>
            <label class="block text-sm font-medium mb-1">Nombre de la materia</label>
            <input
              type="text"
              id="nombre"
              name="nombre"
              required
              placeholder="Ej. Programación Orientada a Objetos"
              class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800"
            >
            <p class="mt-1 text-xs text-neutral-500">Usaremos este texto para sugerir la clave automáticamente.</p>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Clave (abreviación)</label>
            <input
              type="text"
              id="clave"
              name="clave"
              placeholder="Ej. POO"
              class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 uppercase"
            >
            <p class="mt-1 text-xs text-neutral-500">Se autogenera (puedes editarla). Solo letras y números, máx. 12.</p>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Estado</label>
            <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
              <option value="activa" selected>Activa</option>
              <option value="inactiva">Inactiva</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-3">
          <a href="/src/plataforma/app/admin/subjects" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar Materia
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Quita acentos/diacríticos
function quitarAcentos(str){
  return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

// Sugerir clave ignorando stopwords en español
function sugerirClaveDesdeNombre(nombre) {
  const stop = new Set([
    'a','al','del','de','la','las','lo','los','y','e','u','o',
    'en','para','por','con','sobre','sin','un','una','unos','unas',
    'el'
  ]);
  const limpio = quitarAcentos(nombre).replace(/[^A-Za-z0-9\s]/g, ' ');
  const palabras = limpio.trim().split(/\s+/).filter(Boolean);

  // tomar iniciales, omitiendo stopwords (salvo que sea una sola palabra)
  const sig = [];
  for (const p of palabras) {
    const lw = p.toLowerCase();
    if (palabras.length > 1 && stop.has(lw)) continue;
    sig.push(p[0].toUpperCase());
  }

  let abbr = sig.join('');
  // respaldo si quedaron solo stopwords
  if (!abbr) {
    abbr = quitarAcentos(limpio).replace(/\s+/g, '').toUpperCase().slice(0, 6);
  }
  return abbr.slice(0, 12);
}

(function(){
  const $nombre = document.getElementById('nombre');
  const $clave  = document.getElementById('clave');

  // Autogenerar mientras se escribe, pero no pisar si el usuario ya modificó
  if ($nombre && $clave) {
    // Marcador para saber si el usuario editó manualmente
    $clave.dataset.auto = $clave.value ? '0' : '1';

    $nombre.addEventListener('input', () => {
      if ($clave.dataset.auto === '1') {
        $clave.value = sugerirClaveDesdeNombre($nombre.value);
      }
    });

    $clave.addEventListener('input', () => {
      // Si escribe algo, desactiva autollenado; si borra todo, lo reactiva
      $clave.dataset.auto = $clave.value ? '0' : '1';
    });

    // Normalizar al salir del campo
    $clave.addEventListener('blur', () => {
      let v = quitarAcentos($clave.value).toUpperCase();
      v = v.replace(/[^A-Z0-9]/g, '').slice(0, 12);
      $clave.value = v;
    });

    // Sugerencia inicial si nombre ya tiene valor y clave está vacía
    if ($nombre.value && !$clave.value) {
      $clave.value = sugerirClaveDesdeNombre($nombre.value);
    }
  }
})();
</script>
