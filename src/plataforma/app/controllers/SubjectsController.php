<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Course;

class SubjectsController
{
    /* ----------------- Guards ----------------- */
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login'); exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login'); exit;
    }

    /* ----------------- Helpers SIN intl ----------------- */
    private function stripDiacritics(string $s): string {
        // 1) intentar transliterar con iconv si está disponible
        if (function_exists('iconv')) {
            $t = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
            if ($t !== false) {
                return $t;
            }
        }
        // 2) fallback manual para acentos comunes en ES
        $map = [
            'á'=>'a','à'=>'a','ä'=>'a','â'=>'a','ã'=>'a','å'=>'a','Á'=>'A','À'=>'A','Ä'=>'A','Â'=>'A','Ã'=>'A','Å'=>'A',
            'é'=>'e','è'=>'e','ë'=>'e','ê'=>'e','É'=>'E','È'=>'E','Ë'=>'E','Ê'=>'E',
            'í'=>'i','ì'=>'i','ï'=>'i','î'=>'i','Í'=>'I','Ì'=>'I','Ï'=>'I','Î'=>'I',
            'ó'=>'o','ò'=>'o','ö'=>'o','ô'=>'o','õ'=>'o','Ó'=>'O','Ò'=>'O','Ö'=>'O','Ô'=>'O','Õ'=>'O',
            'ú'=>'u','ù'=>'u','ü'=>'u','û'=>'u','Ú'=>'U','Ù'=>'U','Ü'=>'U','Û'=>'U',
            'ñ'=>'n','Ñ'=>'N','ç'=>'c','Ç'=>'C'
        ];
        return strtr($s, $map);
    }

    private function generateClaveFromNombre(string $nombre): string {
        // limpiar primero (acentos y espacios)
        $clean  = trim(preg_replace('/\s+/', ' ', $this->stripDiacritics($nombre)));
        if ($clean === '') return '';

        $words  = array_filter(explode(' ', $clean));
        $stops  = ['de','del','la','las','el','los','y','e','a','en','para','por','con','un','una','uno'];

        // iniciales ignorando stopwords si hay más de una palabra
        $initials = '';
        $count = count($words);
        foreach ($words as $w) {
            if ($count > 1 && in_array(strtolower($w), $stops, true)) continue;
            $initials .= substr($w, 0, 1);
        }

        if ($initials === '') {
            // respaldo: primeras letras del nombre ya sin acentos/espacios
            $initials = preg_replace('/[^a-z0-9]/i', '', $clean);
        }

        $clave = strtoupper($initials);
        $clave = preg_replace('/[^A-Z0-9]/', '', $clave);
        return substr($clave, 0, 10);
    }

    private function normalizeOrGenerateClave(?string $clave, string $nombre): string {
        $clave = trim((string)$clave);
        if ($clave !== '') {
            $clave = $this->stripDiacritics($clave);
            $clave = strtoupper($clave);
            $clave = preg_replace('/[^A-Z0-9]/', '', $clave);
            return substr($clave, 0, 10);
        }
        return $this->generateClaveFromNombre($nombre);
    }

    /* ===================== Index ===================== */
    public function index() {
        $this->requireLogin();
        $roles = $_SESSION['user']['roles'] ?? [];

        $courseModel = new Course();

        if (in_array('teacher', $roles, true)) {
            $subjects = $courseModel->getByTeacher($_SESSION['user']['id']);
            View::render('teacher/subjects/index', 'teacher', ['subjects' => $subjects]);
            return;
        }

        if (in_array('admin', $roles, true)) {
            $subjects = $courseModel->getAll();
            View::render('admin/subjects/index', 'admin', ['subjects' => $subjects]);
            return;
        }

        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Crear ===================== */
    public function create() {
        $this->requireRole(['admin']);
        View::render('admin/subjects/create', 'admin');
    }

    public function store() {
        $this->requireRole(['admin']);

        $nombre = trim($_POST['nombre'] ?? '');
        $status = $_POST['status'] ?? 'activa';
        $clave  = $this->normalizeOrGenerateClave($_POST['clave'] ?? '', $nombre);

        if ($nombre === '' || $clave === '') {
            header('Location: /src/plataforma/app/admin/subjects/create?error=' . urlencode('Nombre y clave son obligatorios.'));
            exit;
        }

        $courseModel = new Course();
        $ok = $courseModel->create([
            'nombre' => $nombre,
            'clave'  => $clave,
            'status' => $status,
        ]);

        header('Location: /src/plataforma/app/admin/subjects' . ($ok ? '' : '?error=' . urlencode('No se pudo crear'))); 
        exit;
    }

    /* ===================== Editar ===================== */
    public function edit($id) {
        $this->requireRole(['admin']);

        $courseModel = new Course();
        $subject = $courseModel->findById((int)$id);

        if (!$subject || !is_object($subject)) {
            header('Location: /src/plataforma/app/admin/subjects'); exit;
        }

        View::render('admin/subjects/edit', 'admin', ['subject' => $subject]);
    }

    public function update($id) {
        $this->requireRole(['admin']);

        $nombre = trim($_POST['nombre'] ?? '');
        $status = $_POST['status'] ?? 'activa';
        $clave  = $this->normalizeOrGenerateClave($_POST['clave'] ?? '', $nombre);

        if ($nombre === '' || $clave === '') {
            header('Location: /src/plataforma/app/admin/subjects/'.$id.'/edit?error=' . urlencode('Nombre y clave son obligatorios.'));
            exit;
        }

        $courseModel = new Course();
        $ok = $courseModel->update((int)$id, [
            'nombre' => $nombre,
            'clave'  => $clave,
            'status' => $status,
        ]);

        header('Location: /src/plataforma/app/admin/subjects' . ($ok ? '' : '?error=' . urlencode('No se pudo actualizar')));
        exit;
    }

    /* ===================== Eliminar ===================== */
    public function delete($id) {
        $this->requireRole(['admin']);

        $courseModel = new Course();
        $courseModel->delete((int)$id);

        header('Location: /src/plataforma/app/admin/subjects'); exit;
    }


    /* ===================== Asignar Materia a Grupo ===================== */
    
}
