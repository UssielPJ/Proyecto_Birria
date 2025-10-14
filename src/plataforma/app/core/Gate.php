<?php

namespace App\Core;

/**
 * Comprobaciones de rol basadas en la sesión
 * Compatible con:
 *  - $_SESSION['user']['roles'] = ['admin','teacher',...]
 *  - $_SESSION['roles'] (legacy)
 *  - $_SESSION['user']['role'] o $_SESSION['role'] (string)
 */
class Gate
{
  /** Normaliza un slug de rol a los usados internamente */
  private static function normalizeRole(string $r): string {
    $r = strtolower(trim($r));
    return match ($r) {
      'alumno'     => 'student',
      'maestro'    => 'teacher',
      'profesor'   => 'teacher',
      'capturista' => 'capturista',
      'admin', 'administrator' => 'admin',
      default => $r
    };
  }

  /** Obtiene TODOS los roles de la sesión (array, normalizados) */
  public static function roles(): array {
    // Preferir arreglo en user.roles
    $roles = [];
    if (!empty($_SESSION['user']['roles']) && is_array($_SESSION['user']['roles'])) {
      $roles = $_SESSION['user']['roles'];
    }

    // Compat: arreglo plano en $_SESSION['roles']
    if (empty($roles) && !empty($_SESSION['roles']) && is_array($_SESSION['roles'])) {
      $roles = $_SESSION['roles'];
    }

    // Compat: string único en user.role o $_SESSION['role']
    if (empty($roles)) {
      $one = $_SESSION['user']['role'] ?? ($_SESSION['role'] ?? '');
      if ($one !== '') $roles = [$one];
    }

    // Normalizar + deduplicar
    $roles = array_map([self::class,'normalizeRole'], $roles);
    $roles = array_values(array_unique($roles));

    return $roles;
  }

  /** ¿Tiene exactamente alguno de los roles solicitados? */
  public static function any(array $roles): bool {
    $current = self::roles();                  // p.ej. ['admin','teacher']
    $wanted  = array_map([self::class,'normalizeRole'], $roles);
    return (bool) array_intersect($current, $wanted);
  }

  /** Atajo: is('admin') o is(['admin','capturista']) */
  public static function is($roles): bool {
    return self::any((array)$roles);
  }

  /** Si no tiene alguno de los roles, redirige (al login por simplicidad) */
  public static function allow($roles): void {
    if (!self::any((array)$roles)) {
      header('Location: /src/plataforma/login'); exit;
    }
  }
}
