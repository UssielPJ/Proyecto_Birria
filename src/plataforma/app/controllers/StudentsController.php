<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\StudentProfile;


class StudentsController {

    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login');
            exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login');
        exit;
    }

    public function index() {
        $this->requireRole(['admin', 'teacher']);
        $user  = $_SESSION['user'];
        $roles = $_SESSION['user']['roles'];

        if (in_array('admin', $roles, true)) {
            // Filtros
            $buscar   = $_GET['q']        ?? '';
            $semestre = $_GET['semestre'] ?? '';
            $carrera  = $_GET['carrera']  ?? '';
            $estado   = $_GET['estado']   ?? '';
            $page     = max(1, (int)($_GET['page'] ?? 1));
            $limit    = 10;
            $offset   = ($page - 1) * $limit;

            $userModel = new User();
            $students  = $userModel->getStudentsWithFilters([
                'search'   => $buscar,
                'semestre' => $semestre,
                'carrera'  => $carrera,
                'estado'   => $estado,
                'limit'    => $limit,
                'offset'   => $offset
            ]);

            $total = $userModel->countStudentsWithFilters([
                'search'   => $buscar,
                'semestre' => $semestre,
                'carrera'  => $carrera,
                'estado'   => $estado
            ]);

            $totalPages = $total > 0 ? (int)ceil($total / $limit) : 1;
            $carreras   = $userModel->getDistinctCarreras();
            $semestres  = $userModel->getDistinctSemestres();

            View::render('admin/students/index', 'admin', [
                'students'   => $students,
                'buscar'     => $buscar,
                'semestre'   => $semestre,
                'carrera'    => $carrera,
                'estado'     => $estado,
                'page'       => $page,
                'totalPages' => $totalPages,
                'total'      => $total,
                'carreras'   => $carreras,
                'semestres'  => $semestres
            ]);

        } elseif (in_array('teacher', $roles, true)) {
            // Placeholder: depende de tu modelo de cursos/inscripciones
            $courseModel = new \App\Models\Course();
            $students = $courseModel->getStudentsByTeacher($user['id']);
            View::render('teacher/students/index', 'teacher', ['students' => $students]);
        }
    }

    public function create() {
        $this->requireRole(['admin', 'teacher']);
        // Si tienes catálogo de carreras, pásalo aquí:
        $userModel = new User();
        $carreras  = $userModel->getDistinctCarreras();
        View::render('admin/students/create', 'admin', ['carreras' => $carreras]);
    }

    public function store() {
        $this->requireRole(['admin', 'teacher']);

        $d = $_POST;
        error_log('StudentsController@store HIT: ' . json_encode($d)); // <-- se ve en error.log

        $errors = [];

        // USERS
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['password'])) $errors[] = 'La contraseña es requerida.';
        if (($d['password'] ?? '') !== ($d['password_confirmation'] ?? '')) $errors[] = 'Las contraseñas no coinciden.'; // <-- agrega esto
        if (empty($d['nombre']))   $errors[] = 'El nombre es requerido.';

        // STUDENTS_PROFILE
        if (empty($d['matricula']))   $errors[] = 'La matrícula es requerida.';
        if (empty($d['curp']))        $errors[] = 'La CURP es requerida.';
        if (empty($d['carrera_id']))  $errors[] = 'La carrera es requerida.';
        if (empty($d['semestre']))    $errors[] = 'El semestre es requerido.';

        if ($errors) {
            error_log('StudentsController@store VALIDATION: ' . implode(' | ', $errors));
            header('Location: /src/plataforma/app/admin/students/create?error='.urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel    = new User();
        $profileModel = new StudentProfile();

        $db = $userModel->getDb();
        if (method_exists($db, 'beginTransaction')) $db->beginTransaction();

        try {
            // INSERT users
            $userId = $userModel->create([
                'email'            => $d['email'],
                'password'         => $d['password'], // User::create ya hace hash
                'nombre'           => $d['nombre'],
                'apellido_paterno' => $d['apellido_paterno'] ?? null,
                'apellido_materno' => $d['apellido_materno'] ?? null,
                'telefono'         => $d['telefono'] ?? null,
                'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
                'status'           => $d['status'] ?? 'active',
            ]);
            error_log('StudentsController@store USERS.ID=' . $userId);

            // INSERT students_profile
            $profileModel->create([
                'user_id'                     => $userId,
                'matricula'                   => $d['matricula'],
                'curp'                        => $d['curp'],
                'carrera_id'                  => (int)$d['carrera_id'],
                'semestre'                    => (int)$d['semestre'],
                'grupo'                       => $d['grupo'] ?? null,
                'tipo_ingreso'                => $d['tipo_ingreso'] ?? 'nuevo',
                'beca_activa'                 => !empty($d['beca_activa']) ? 1 : 0,
                'promedio_general'            => $d['promedio_general'] ?? 0,
                'creditos_aprobados'          => $d['creditos_aprobados'] ?? 0,
                'direccion'                   => $d['direccion'] ?? null,
                'contacto_emergencia_nombre'  => $d['contacto_emergencia_nombre'] ?? null,
                'contacto_emergencia_telefono'=> $d['contacto_emergencia_telefono'] ?? null,
                'parentesco_emergencia'       => $d['parentesco_emergencia'] ?? null,
            ]);
            error_log('StudentsController@store PROFILE OK for user_id=' . $userId);

            if (method_exists($db, 'commit')) $db->commit();
            header('Location: /src/plataforma/app/admin/students');
            exit;

        } catch (\Throwable $e) {
            if (method_exists($db, 'rollBack')) $db->rollBack();
            error_log('StudentsController@store ERROR: ' . $e->getMessage());
            error_log($e->getTraceAsString());
            header('Location: /src/plataforma/app/admin/students/create?error='.urlencode('No se pudo crear'));
            exit;
        }
    }

    public function edit($id) {
        $this->requireRole(['admin', 'teacher']);

        $userModel    = new User();
        $profileModel = new StudentProfile();

        $student = $userModel->findById((int)$id);
        if (!$student) {
            header('Location: /src/plataforma/app/admin/students');
            exit;
        }

        $profile  = $profileModel->findByUserId((int)$id);
        $carreras = $userModel->getDistinctCarreras();

        View::render('admin/students/edit', 'admin', [
            'student'  => $student,
            'profile'  => $profile,
            'carreras' => $carreras
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin', 'teacher']);
        $id = (int)$id;
        $d  = $_POST;
        $errors = [];

        // USERS
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['nombre'])) $errors[] = 'El nombre es requerido.';

        if (!empty($d['password']) && ($d['password'] !== ($d['password_confirmation'] ?? ''))) {
            $errors[] = 'Las contraseñas no coinciden.';
        }

        // STUDENTS_PROFILE
        if (empty($d['matricula']))  $errors[] = 'La matrícula es requerida.';
        if (empty($d['curp']))       $errors[] = 'La CURP es requerida.';
        if (empty($d['carrera_id'])) $errors[] = 'La carrera es requerida.';
        if (empty($d['semestre']))   $errors[] = 'El semestre es requerido.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/students/edit/'.$id.'?error='.urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel    = new User();
        $profileModel = new StudentProfile();
        $db = $userModel->getDb();
        if (method_exists($db, 'beginTransaction')) $db->beginTransaction();

        try {
            // UPDATE users
            $userUpdate = [
                'email'            => $d['email'],
                'nombre'           => $d['nombre'],
                'apellido_paterno' => $d['apellido_paterno'] ?? null,
                'apellido_materno' => $d['apellido_materno'] ?? null,
                'telefono'         => $d['telefono'] ?? null,
                'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
                'status'           => $d['status'] ?? 'active',
            ];
            if (!empty($d['password'])) $userUpdate['password'] = $d['password'];
            $userModel->update($id, $userUpdate);

            // UPDATE students_profile
            $profileModel->updateByUserId($id, [
                'matricula'                   => $d['matricula'],
                'curp'                        => $d['curp'],
                'carrera_id'                  => (int)$d['carrera_id'],
                'semestre'                    => (int)$d['semestre'],
                'grupo'                       => $d['grupo'] ?? null,
                'tipo_ingreso'                => $d['tipo_ingreso'] ?? 'nuevo',
                'beca_activa'                 => !empty($d['beca_activa']) ? 1 : 0,
                'promedio_general'            => $d['promedio_general'] ?? 0,
                'creditos_aprobados'          => $d['creditos_aprobados'] ?? 0,
                'direccion'                   => $d['direccion'] ?? null,
                'contacto_emergencia_nombre'  => $d['contacto_emergencia_nombre'] ?? null,
                'contacto_emergencia_telefono'=> $d['contacto_emergencia_telefono'] ?? null,
                'parentesco_emergencia'       => $d['parentesco_emergencia'] ?? null,
            ]);

            if (method_exists($db, 'commit')) $db->commit();
            header('Location: /src/plataforma/app/admin/students');
            exit;

        } catch (\Throwable $e) {
            if (method_exists($db, 'rollBack')) $db->rollBack();
            header('Location: /src/plataforma/app/admin/students/edit/'.$id.'?error='.urlencode('No se pudo actualizar: '.$e->getMessage()));
            exit;
        }
    }

    public function delete($id) {
        $this->requireRole(['admin', 'teacher']);
        // Hard delete: si tienes FK ON DELETE CASCADE, basta con borrar users
        $userModel = new User();
        $userModel->delete((int)$id);
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }

    public function export() {
        $this->requireRole(['admin', 'teacher']);

        $format   = $_GET['format'] ?? 'csv';
        $buscar   = $_GET['q'] ?? '';
        $semestre = $_GET['semestre'] ?? '';
        $carrera  = $_GET['carrera'] ?? '';
        $estado   = $_GET['estado'] ?? '';

        $userModel = new User();
        $students = $userModel->getStudentsWithFilters([
            'search'   => $buscar,
            'semestre' => $semestre,
            'carrera'  => $carrera,
            'estado'   => $estado,
            'limit'    => 10000,
            'offset'   => 0
        ]);

        if ($format === 'csv') {
            $this->exportCSV($students);
        } else {
            header('Location: /src/plataforma/app/admin/students');
            exit;
        }
    }

    private function exportCSV($students) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=estudiantes_' . date('Y-m-d_H-i-s') . '.csv');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, [
            'ID','Nombre completo','Email','Matrícula','CURP','Carrera','Semestre',
            'Teléfono','Nacimiento','Grupo','Estado','Creado'
        ]);

        foreach ($students as $s) {
            $nombreCompleto = trim(($s->nombre ?? '').' '.($s->apellido_paterno ?? '').' '.($s->apellido_materno ?? ''));
            fputcsv($output, [
                $s->id,
                $nombreCompleto,
                $s->email,
                $s->matricula ?? '',
                $s->curp ?? '',
                $s->carrera ?? ($s->carrera_id ?? ''),
                $s->semestre ?? '',
                $s->telefono ?? '',
                $s->fecha_nacimiento ?? '',
                $s->grupo ?? '',
                $s->status ?? '',
                $s->created_at ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

    /* ======== Vistas de perfil para el rol student (simple) ======== */
    public function profile() {
        $this->requireRole(['student']);
        $user = $_SESSION['user'];
        View::render('student/profile/view', 'student', ['user' => $user]);
    }

    public function editProfile() {
        $this->requireRole(['student']);
        $user = $_SESSION['user'];
        View::render('student/profile/edit', 'student', ['user' => $user]);
    }

    public function updateProfile() {
        $this->requireRole(['student']);
        $data = $_POST;

        $userModel = new User();
        $userModel->update((int)$_SESSION['user']['id'], [
            'email'            => $data['email']            ?? null,
            'nombre'           => $data['nombre']           ?? null,
            'apellido_paterno' => $data['apellido_paterno'] ?? null,
            'apellido_materno' => $data['apellido_materno'] ?? null,
            'telefono'         => $data['telefono']         ?? null,
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
        ]);

        // Refresca sesión superficialmente (ideal: recargar desde DB)
        $_SESSION['user'] = array_merge($_SESSION['user'], $data);
        header('Location: /src/plataforma/app/student/profile');
        exit;
    }
}
