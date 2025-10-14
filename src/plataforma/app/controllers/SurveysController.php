<?php
namespace App\Controllers;

use App\Core\View;
// use App\Models\Survey; // cuando tengas el modelo, descomenta

class SurveysController
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

        // $surveyModel = new Survey();

        if (in_array('admin', $roles, true)) {
            // $surveys = $surveyModel->getAll();
            $surveys = []; // placeholder
            View::render('admin/surveys/index', 'admin', [
                'surveys' => $surveys
            ]);
            return;
        }

        if (in_array('teacher', $roles, true)) {
            // $surveys = $surveyModel->getByTeacher($_SESSION['user']['id']);
            $surveys = [];
            View::render('teacher/surveys/index', 'teacher', [
                'surveys' => $surveys
            ]);
            return;
        }

        if (in_array('student', $roles, true)) {
            // $surveys = $surveyModel->getOpenForStudent($_SESSION['user']['id']);
            $surveys = [];
            View::render('surveys/index', 'student', [
                'surveys' => $surveys
            ]);
            return;
        }

        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Admin/Teacher: Crear ===================== */
    public function create() {
        $this->requireRole(['admin','teacher']);
        View::render('admin/surveys/create', 'admin');
    }

    public function store() {
        $this->requireRole(['admin','teacher']);
        $data = $_POST;

        // TODO: validar y guardar con Survey model
        // $surveyModel = new Survey();
        // $surveyModel->create($data + ['created_by' => $_SESSION['user']['id']]);

        header('Location: /src/plataforma/app/admin/surveys'); exit;
    }

    /* ===================== Admin/Teacher: Editar ===================== */
    public function edit($id) {
        $this->requireRole(['admin','teacher']);

        // $surveyModel = new Survey();
        // $survey = $surveyModel->findByIdForOwner($id, $_SESSION['user']['id']); // si limitas por dueño
        // if (!$survey) { header('Location: /src/plataforma/app/admin/surveys'); exit; }

        $survey = (object)[
            'id' => (int)$id,
            'title' => 'Encuesta de Satisfacción',
            'type' => 'satisfaccion',
            'description' => 'Descripción',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'is_anonymous' => 1,
            'is_required'  => 0,
            'questions' => [
                ['text' => 'Pregunta 1', 'type' => 'text', 'required' => 1]
            ]
        ];

        View::render('admin/surveys/edit', 'admin', [
            'survey' => $survey
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin','teacher']);
        $data = $_POST;

        // TODO: validar y actualizar
        // $surveyModel = new Survey();
        // $surveyModel->update($id, $data);

        header('Location: /src/plataforma/app/admin/surveys'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin','teacher']);

        // $surveyModel = new Survey();
        // $surveyModel->delete($id);

        header('Location: /src/plataforma/app/admin/surveys'); exit;
    }

    /* ===================== Student: Contestar ===================== */
    public function take($id) {
        $this->requireRole(['student']);

        // $surveyModel = new Survey();
        // $survey = $surveyModel->findOpenForStudent($id, $_SESSION['user']['id']);
        // if (!$survey) { header('Location: /src/plataforma/app/surveys'); exit; }

        $survey = (object)[
            'id' => (int)$id,
            'title' => 'Encuesta de Satisfacción',
            'type' => 'satisfaccion',
            'description' => 'Descripción',
            'start_date' => '2025-01-01',
            'end_date'   => '2025-12-31',
            'is_anonymous' => 1,
            'is_required'  => 0,
            'questions' => [
                ['text' => 'Pregunta 1', 'type' => 'text', 'required' => 1]
            ]
        ];

        View::render('student/surveys/take', 'student', [
            'survey' => $survey,
            'user'   => $_SESSION['user']
        ]);
    }

    public function submit($id) {
        $this->requireRole(['student']);
        $answers = $_POST;

        // TODO: guardar respuestas ligadas a $_SESSION['user']['id']
        // $surveyModel = new Survey();
        // $surveyModel->submitAnswers($id, $_SESSION['user']['id'], $answers);

        header('Location: /src/plataforma/app/surveys'); exit;
    }
}
