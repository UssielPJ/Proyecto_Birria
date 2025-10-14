<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Announcement;

class AnnouncementsController
{
    /* ------------ Guards compatibles con la nueva sesión ------------ */
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

    /* ===================== Listado ===================== */
    public function index()
    {
        $this->requireRole(['admin','teacher']);

        $roles = $_SESSION['user']['roles'] ?? [];

        if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
            // Solo maestro (sin admin): mostrar anuncios dirigidos a docentes
            $announcements = Announcement::getByRole('teacher'); // o 'teachers' según tu implementación
            View::render('teacher/announcements/index', 'teacher', [
                'announcements' => $announcements
            ]);
            return;
        }

        // Admin (o admin+teacher): ver todos
        $announcements = Announcement::all();
        View::render('admin/announcements/index', 'admin', [
            'announcements' => $announcements
        ]);
    }

    /* ===================== Crear ===================== */
    public function create()
{
    $this->requireRole(['admin','teacher']);
    $roles = $_SESSION['user']['roles'] ?? [];
    $user  = $_SESSION['user'];

    if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
        // Cargar materias del profe para el <select> (opcional)
        $course = new \App\Models\Course();
        $materias = $course->getByTeacher((int)$user['id']); // ya lo tienes en Course.php
        View::render('teacher/announcements/create', 'teacher', ['materias' => $materias]);
        return;
    }

    // Admin
    View::render('admin/announcements/create', 'admin');
}

    /* ===================== Editar ===================== */
    public function edit($id)
{
    $this->requireRole(['admin','teacher']);
    $roles = $_SESSION['user']['roles'] ?? [];
    $user  = $_SESSION['user'];

    $announcement = Announcement::find($id);
    if (!$announcement) {
        $_SESSION['error'] = 'Anuncio no encontrado';
        $back = (in_array('teacher', $roles,true) && !in_array('admin',$roles,true))
            ? '/src/plataforma/app/teacher/announcements'
            : '/src/plataforma/app/admin/announcements';
        header('Location: ' . $back); exit;
    }

    // Teacher puro solo edita lo suyo
    if (in_array('teacher', $roles,true) && !in_array('admin',$roles,true)) {
        if ((int)($announcement->teacher_id ?? 0) !== (int)$user['id']) {
            $_SESSION['error'] = 'No tienes permiso para editar este anuncio.';
            header('Location: /src/plataforma/app/teacher/announcements'); exit;
        }
        View::render('teacher/announcements/edit', 'teacher', ['announcement' => $announcement]);
        return;
    }

    // Admin
    View::render('admin/announcements/edit', 'admin', ['announcement' => $announcement]);
}


    public function update($id)
{
    $this->requireRole(['admin','teacher']);
    $roles = $_SESSION['user']['roles'] ?? [];
    $user  = $_SESSION['user'];

    $announcement = Announcement::find($id);
    if (!$announcement) {
        $_SESSION['error'] = 'Anuncio no encontrado';
        $back = (in_array('teacher',$roles,true) && !in_array('admin',$roles,true))
            ? '/src/plataforma/app/teacher/announcements'
            : '/src/plataforma/app/admin/announcements';
        header('Location: ' . $back); exit;
    }

    if (in_array('teacher',$roles,true) && !in_array('admin',$roles,true)) {
        if ((int)($announcement->teacher_id ?? 0) !== (int)$user['id']) {
            $_SESSION['error'] = 'No tienes permiso para actualizar este anuncio.';
            header('Location: /src/plataforma/app/teacher/announcements'); exit;
        }
    }

    $title   = trim($_POST['title']   ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title === '' || $content === '') {
        $_SESSION['error'] = 'Título y contenido son obligatorios.';
        $editPath = (in_array('teacher',$roles,true) && !in_array('admin',$roles,true))
            ? '/src/plataforma/app/teacher/announcements/edit/'.$id
            : '/src/plataforma/app/admin/announcements/edit/'.$id;
        header('Location: ' . $editPath); exit;
    }

    $data = [
        'title'       => $title,
        'content'     => $content,
        'target_role' => $_POST['target_role'] ?? ($announcement->target_role ?? 'all'),
        'materia_id'  => !empty($_POST['materia_id']) ? (int)$_POST['materia_id'] : ($announcement->materia_id ?? null),
    ];

    $announcement->update($data);

    $back = (in_array('teacher',$roles,true) && !in_array('admin',$roles,true))
        ? '/src/plataforma/app/teacher/announcements'
        : '/src/plataforma/app/admin/announcements';
    header('Location: ' . $back); exit;
}
    /* ===================== Eliminar ===================== */
    public function delete($id)
{
    $this->requireRole(['admin','teacher']);
    $roles = $_SESSION['user']['roles'] ?? [];
    $user  = $_SESSION['user'];

    $announcement = Announcement::find($id);
    if (!$announcement) {
        $_SESSION['error'] = 'Anuncio no encontrado';
        $back = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
            ? '/src/plataforma/app/teacher/announcements'
            : '/src/plataforma/app/admin/announcements';
        header('Location: ' . $back);
        exit;
    }

    if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
        if ((int)($announcement->teacher_id ?? 0) !== (int)$user['id']) {
            $_SESSION['error'] = 'No tienes permiso para eliminar este anuncio.';
            header('Location: /src/plataforma/app/teacher/announcements');
            exit;
        }
    }

    $announcement->delete();

    $back = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
        ? '/src/plataforma/app/teacher/announcements'
        : '/src/plataforma/app/admin/announcements';

    header('Location: ' . $back);
    exit;
}
    /* ===================== Almacenar ===================== */

    public function store()
{
    $this->requireRole(['admin','teacher']);
    if (session_status() === PHP_SESSION_NONE) session_start();
    $user  = $_SESSION['user'];
    $roles = $_SESSION['user']['roles'] ?? [];

    $title   = trim($_POST['title']   ?? '');
    $content = trim($_POST['content'] ?? '');
    if ($title === '' || $content === '') {
        if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
            $_SESSION['error'] = 'Título y contenido son obligatorios.';
            header('Location: /src/plataforma/app/teacher/announcements/create'); exit;
        }
        $_SESSION['error'] = 'Título y contenido son obligatorios.';
        header('Location: /src/plataforma/app/admin/announcements/create'); exit;
    }

    // Target/alcance
    $target_role = $_POST['target_role'] ?? 'all';
    // Si es teacher puro, opcionalmente forzamos a estudiantes:
    if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
        $target_role = $_POST['target_role'] ?? 'student';
    }

    // (Opcional) materia_id si tu formulario de teacher lo manda
    $materia_id = !empty($_POST['materia_id']) ? (int)$_POST['materia_id'] : null;

    $data = [
        'title'       => $title,
        'content'     => $content,
        'target_role' => $target_role,
        'user_id'     => (int)$user['id'],
        'teacher_id'  => (int)$user['id'],   // si tu tabla lo tiene
        'materia_id'  => $materia_id,        // si tu tabla lo tiene
    ];

    Announcement::create($data);

    $redirect = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
        ? '/src/plataforma/app/teacher/announcements'
        : '/src/plataforma/app/admin/announcements';

    header('Location: ' . $redirect); exit;
}

}
