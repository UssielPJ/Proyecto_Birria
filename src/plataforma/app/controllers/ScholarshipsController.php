<?php
namespace App\Controllers;

use App\Core\View;
// use App\Models\Scholarship; // <-- cuando tengas el modelo, descomenta

class ScholarshipsController
{
    /* ----------------- Guards compatibles ----------------- */
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
    public function index() {
        $this->requireLogin();
        $roles = $_SESSION['user']['roles'] ?? [];

        // $scholarshipModel = new Scholarship();

        if (in_array('admin', $roles, true)) {
            // $scholarships = $scholarshipModel->getAll(); // TODO
            $scholarships = []; // placeholder
            View::render('admin/scholarships/index', 'admin', [
                'scholarships' => $scholarships
            ]);
            return;
        }

        if (in_array('student', $roles, true)) {
            // $scholarships = $scholarshipModel->getOpenForStudent($_SESSION['user']['id']); // TODO
            $scholarships = []; // placeholder
            View::render('scholarships/index', 'student', [
                'scholarships' => $scholarships
            ]);
            return;
        }

        if (in_array('teacher', $roles, true)) {
            // Si los maestros solo pueden ver listado informativo:
            // $scholarships = $scholarshipModel->getAllOpen(); // TODO
            $scholarships = [];
            View::render('scholarships/index', 'teacher', [
                'scholarships' => $scholarships
            ]);
            return;
        }

        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Admin: Crear ===================== */
    public function create() {
        $this->requireRole(['admin']);
        View::render('admin/scholarships/create', 'admin');
    }

    public function store() {
        $this->requireRole(['admin']);
        $data = $_POST;

        // TODO: validar $data y guardar
        // (cuando tengas Scholarship model)
        // $scholarshipModel = new Scholarship();
        // $scholarshipModel->create($data);

        header('Location: /src/plataforma/app/admin/scholarships'); exit;
    }

    /* ===================== Admin: Editar ===================== */
    public function edit($id) {
        $this->requireRole(['admin']);

        // $scholarshipModel = new Scholarship();
        // $scholarship = $scholarshipModel->findById($id);
        // if (!$scholarship) { header('Location: /src/plataforma/app/admin/scholarships'); exit; }

        // Placeholder para que no truene la vista
        $scholarship = [
            'id' => (int)$id,
            'name' => 'Beca de Excelencia',
            'type' => 'academica',
            'percentage' => 50,
            'deadline' => '2025-12-31',
            'description' => 'Descripción',
            'requirements' => ['Req1','Req2'],
            'documents' => ['Doc1','Doc2'],
        ];

        View::render('admin/scholarships/edit', 'admin', [
            'scholarship' => (object)$scholarship
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin']);
        $data = $_POST;

        // TODO: validar y actualizar
        // $scholarshipModel = new Scholarship();
        // $scholarshipModel->update($id, $data);

        header('Location: /src/plataforma/app/admin/scholarships'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin']);

        // $scholarshipModel = new Scholarship();
        // $scholarshipModel->delete($id);

        header('Location: /src/plataforma/app/admin/scholarships'); exit;
    }

    /* ===================== Student: Aplicar ===================== */
    public function apply($id) {
        $this->requireRole(['student']);

        // $scholarshipModel = new Scholarship();
        // $scholarship = $scholarshipModel->findById($id);
        // if (!$scholarship) { header('Location: /src/plataforma/app/scholarships'); exit; }

        $scholarship = [
            'id' => (int)$id,
            'name' => 'Beca de Excelencia',
            'type' => 'academica',
            'percentage' => 50,
            'deadline' => '2025-12-31',
            'description' => 'Descripción',
            'requirements' => ['Req1','Req2'],
            'documents' => ['Doc1','Doc2'],
        ];

        View::render('student/scholarships/apply', 'student', [
            'scholarship' => (object)$scholarship,
            'user'        => $_SESSION['user']
        ]);
    }

    public function submitApplication($id) {
        $this->requireRole(['student']);
        $data = $_POST;

        // TODO: guardar solicitud en DB ligada a $_SESSION['user']['id']
        // $scholarshipModel = new Scholarship();
        // $scholarshipModel->submitApplication($id, $_SESSION['user']['id'], $data);

        header('Location: /src/plataforma/app/scholarships'); exit;
    }
}
