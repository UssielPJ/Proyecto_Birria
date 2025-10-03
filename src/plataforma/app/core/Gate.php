<?php
/** Comprobaciones de rol basadas en la sesión */
class Gate
{
  /** Devuelve el slug de rol actual: 'alumno', 'maestro' o 'admin' */
  public static function role(): string {
    return $_SESSION['user']['role'] ?? '';
  }

  /** ¿Coincide exactamente con un rol? o alguno si pasas array */
  public static function is($roles): bool {
    $current = self::role();
    if (is_array($roles)) {
      return in_array($current, $roles, true);
    }
    return $current === $roles;
  }

  /** ¿Pertenece a cualquiera de estos roles? */
  public static function any(array $roles): bool {
    return self::is($roles);
  }

  /** Si no tiene el/los roles, redirige fuera (al login por simplicidad) */
  public static function allow($roles): void {
    $mapped_roles = array_map(function($role) {
      return match($role) {
        'alumno' => 'student',
        'maestro' => 'teacher',
        default => $role
      };
    }, (array)$roles);
    if (!self::any($mapped_roles)) {
      header('Location: /src/plataforma/'); exit;
    }
  }
}
