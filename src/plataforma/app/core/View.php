<?php

namespace App\Core;

/**
 * Renderizador minimalista de vistas con soporte opcional de layouts.
 * - Las vistas se buscan en:   app/views/<ruta>.php
 * - Los layouts se buscan en:  app/views/layouts/<layout>.php
 * - El layout (si existe) recibe $content con el HTML de la vista.
 */
class View
{
  public static function render(string $view, ?string $layout = null, array $data = []): void
  {
    $base      = __DIR__ . '/../views';
    $viewFile  = $base . '/' . ltrim($view, '/') . '.php';
    $layoutFile = $layout ? $base . '/layouts/' . ltrim($layout, '/') . '.php' : null;

    // variables disponibles en la vista/layout
    extract($data, EXTR_OVERWRITE);

    // Render de la vista a buffer
    ob_start();
    if (is_file($viewFile)) {
      include $viewFile;
    } else {
      echo "<!-- View no encontrada: {$viewFile} -->";
    }
    $content = ob_get_clean();

    // Si hay layout y existe, lo incluimos. Si no, imprimimos el contenido directo.
    if ($layout && is_file($layoutFile)) {
      include $layoutFile;
    } else {
      echo $content;
    }
  }
}
