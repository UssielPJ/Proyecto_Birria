<?php
function requireRole(string $role){
  if (session_status()===PHP_SESSION_NONE) session_start();
  $ok = isset($_SESSION['user']['roles']) && in_array($role, $_SESSION['user']['roles'], true);
  if(!$ok){ header('Location:/src/plataforma/login'); exit; }
}
