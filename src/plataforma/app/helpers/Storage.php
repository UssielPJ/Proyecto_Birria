<?php
namespace App\Helpers;

class Storage {
  public static function ensureDirs(array $cfg): void {
    $base = rtrim($cfg['base_disk'],'/');
    foreach ($cfg['paths'] as $p) {
      $dir = $base.'/'.$p;
      if (!is_dir($dir)) @mkdir($dir, 0775, true);
      if (!file_exists($dir.'/.htaccess')) {
        @file_put_contents($dir.'/.htaccess', "Options -Indexes\n<Files ~ \"\.(php|phar|phtml)$\">\nDeny from all\n</Files>\n");
      }
      if (!file_exists($dir.'/index.html')) @file_put_contents($dir.'/index.html', '');
    }
    if (!file_exists($base.'/.htaccess')) {
      @file_put_contents($base.'/.htaccess', "Options -Indexes\n<Files ~ \"\.(php|phar|phtml)$\">\nDeny from all\n</Files>\n");
    }
    if (!file_exists($base.'/index.html')) @file_put_contents($base.'/index.html', '');
  }

  public static function saveUpload(array $cfg, string $bucketKey, array $file): ?string {
    if (empty($file['tmp_name'])) return null;
    $base = rtrim($cfg['base_disk'],'/');
    $sub  = $cfg['paths'][$bucketKey] ?? null;
    if (!$sub) return null;
    $safe = time().'_'.preg_replace('/[^a-zA-Z0-9_.-]/','_', $file['name'] ?? 'file');
    $dest = $base.'/'.$sub.'/'.$safe;
    if (move_uploaded_file($file['tmp_name'], $dest)) {
      return rtrim($cfg['base_url'],'/').'/'.$sub.'/'.$safe;
    }
    return null;
  }
}
