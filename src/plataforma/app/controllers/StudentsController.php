<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\StudentProfile;

class StudentsController {

    /* ===== Helpers internos ===== */

    /**
     * Normaliza $db a PDO (acepta PDO o tu wrapper App\Core\Database)
     */
    private function toPdo($db): \PDO {
        if ($db instanceof \PDO) return $db;
        if (is_object($db) && method_exists($db, 'getPdo')) return $db->getPdo();
        // Último recurso: si alguien pasó null u otro tipo
        return (new \App\Core\Database())->getPdo();
    }

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

    /**
     * Busca un semestre por ID y devuelve [id, carrera_id, numero].
     * Lanza \RuntimeException si no existe.
     */
    private function getSemestreRow(\PDO $pdo, int $semestreId): array {
        $st = $pdo->prepare("SELECT id, carrera_id, numero FROM semestres WHERE id = ? LIMIT 1");
        $st->execute([$semestreId]);
        $row = $st->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new \RuntimeException('El semestre seleccionado no existe.');
        }
        return [
            'id'         => (int)$row['id'],
            'carrera_id' => $row['carrera_id'] !== null ? (int)$row['carrera_id'] : null,
            'numero'     => $row['numero'] !== null ? (int)$row['numero'] : null,
        ];
    }

    /* ===== Listado ===== */

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

            // Para filtros en listado dejamos ambos catálogos por compatibilidad
            $carreras  = $userModel->getCarrerasCatalog();
            $semestres = $userModel->getSemestresCatalog();

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
            $courseModel = new \App\Models\Course();
            $students = $courseModel->getStudentsByTeacher($user['id']);
            View::render('teacher/students/index', 'teacher', ['students' => $students]);
        }
    }

    /* ===== Formularios ===== */

    public function create() {
        $this->requireRole(['admin', 'teacher']);

        $userModel = new User();
        // Solo necesitamos semestres (cada semestre define la carrera y el número)
        $semestres = $userModel->getSemestresCatalog();

        View::render('admin/students/create', 'admin', [
            'semestres' => $semestres,
        ]);
    }

    /* ===== Crear ===== */

    public function store() {
        $this->requireRole(['admin', 'teacher']);
        $d = $_POST;

        // ===== Validación =====
        $errors = [];
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['password'])) $errors[] = 'La contraseña es requerida.';
        if (($d['password'] ?? '') !== ($d['password_confirmation'] ?? '')) $errors[] = 'Las contraseñas no coinciden.';
        if (empty($d['nombre']))     $errors[] = 'El nombre es requerido.';
        if (empty($d['matricula']))  $errors[] = 'La matrícula es requerida.';
        if (empty($d['curp']))       $errors[] = 'La CURP es requerida.';
        // 🚩 Nueva lógica: el semestre_id es obligatorio (ya NO pedimos carrera_id)
        if (empty($d['semestre_id'])) $errors[] = 'Debes seleccionar el semestre.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/students/create?error='.urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel = new User();
        $pdo = $this->toPdo($userModel->getDb());
        $pdo->beginTransaction();

        try {
            // Pre-chequeos duplicados (mejor UX)
            // email único en users
            $st = $pdo->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
            $st->execute([$d['email']]);
            if ($st->fetch()) throw new \RuntimeException('El email ya está en uso.');

            // matrícula / CURP únicos en student_profiles
            $st = $pdo->prepare("SELECT 1 FROM student_profiles WHERE matricula = ? OR curp = ? LIMIT 1");
            $st->execute([$d['matricula'], $d['curp']]);
            if ($st->fetch()) throw new \RuntimeException('La matrícula o la CURP ya existen.');

            // === Derivar carrera_id y numero (semestre tinyint) a partir del semestre_id ===
            $semestreRow = $this->getSemestreRow($pdo, (int)$d['semestre_id']);
            $carreraId   = $semestreRow['carrera_id'];
            $semNumero   = $semestreRow['numero'];

            // === INSERT users ===
            $userId = $userModel->create([
                'email'            => $d['email'],
                'password'         => $d['password'], // el modelo hace hash
                'nombre'           => $d['nombre'],
                'apellido_paterno' => $d['apellido_paterno'] ?? null,
                'apellido_materno' => $d['apellido_materno'] ?? null,
                'telefono'         => $d['telefono'] ?? null,
                'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
                'status'           => $d['status'] ?? 'active',
            ]);

            // === INSERT profile (usa derivaciones) ===
            $profileModel = new StudentProfile($pdo);
            $profileModel->create([
                'user_id'     => $userId,
                'matricula'   => $d['matricula'],
                'curp'        => $d['curp'],
                'carrera_id'  => $carreraId,                   // ← derivado
                'semestre_id' => (int)$d['semestre_id'],       // ← elegido
                'grupo_id'    => null,                         // ← no se selecciona aquí
                // legacy opcionales:
                'semestre'    => $semNumero,                   // ← derivado
                'grupo'       => $d['grupo'] ?? null,          // si llegara, se respeta; si no, null
                'tipo_ingreso'=> $d['tipo_ingreso'] ?? 'nuevo',
                'beca_activa' => !empty($d['beca_activa']) ? 1 : 0,
                'promedio_general'   => ($d['promedio_general'] ?? '') !== '' ? (float)$d['promedio_general'] : 0.00,
                'creditos_aprobados' => ($d['creditos_aprobados'] ?? '') !== '' ? (int)$d['creditos_aprobados'] : 0,
                'direccion'   => $d['direccion'] ?? null,
                'contacto_emergencia_nombre'   => $d['contacto_emergencia_nombre'] ?? null,
                'contacto_emergencia_telefono' => $d['contacto_emergencia_telefono'] ?? null,
                'parentesco_emergencia'        => $d['parentesco_emergencia'] ?? null,
            ]);

            $pdo->commit();
            header('Location: /src/plataforma/app/admin/students?created=1');
            exit;

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log('StudentsController@store ERROR: '.$e->getMessage());
            header('Location: /src/plataforma/app/admin/students/create?error='.urlencode('No se pudo crear: '.$e->getMessage()));
            exit;
        }
    }

    /* ===== Editar ===== */

    public function edit($id) {
        $this->requireRole(['admin', 'teacher']);

        $userModel    = new User();
        $profileModel = new StudentProfile();

        $student = $userModel->findById((int)$id);
        if (!$student) { header('Location: /src/plataforma/app/admin/students'); exit; }

        $profile   = $profileModel->findByUserId((int)$id);
        $semestres = $userModel->getSemestresCatalog();

        View::render('admin/students/edit', 'admin', [
            'student'  => $student,
            'profile'  => $profile,
            'semestres'=> $semestres,
        ]);
    }

    /* ===== Actualizar ===== */

    public function update($id) {
        $this->requireRole(['admin', 'teacher']);
        $id = (int)$id;
        $d  = $_POST;

        // ===== Validación =====
        $errors = [];
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['nombre']))     $errors[] = 'El nombre es requerido.';
        if (!empty($d['password']) && ($d['password'] !== ($d['password_confirmation'] ?? ''))) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
        if (empty($d['matricula']))  $errors[] = 'La matrícula es requerida.';
        if (empty($d['curp']))       $errors[] = 'La CURP es requerida.';
        // 🚩 Nueva lógica: exigir semestre_id y NO carrera_id
        if (empty($d['semestre_id'])) $errors[] = 'Debes seleccionar el semestre.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/students/edit/'.$id.'?error='.urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel = new User();
        $pdo = $this->toPdo($userModel->getDb());
        $pdo->beginTransaction();

        try {
            // Validar unicidad de email si cambió
            $st = $pdo->prepare("SELECT 1 FROM users WHERE email = ? AND id <> ? LIMIT 1");
            $st->execute([$d['email'], $id]);
            if ($st->fetch()) throw new \RuntimeException('El email ya está en uso por otro usuario.');

            // Validar unicidad de matrícula/curp si cambian
            $st = $pdo->prepare("SELECT 1 FROM student_profiles WHERE (matricula = ? OR curp = ?) AND user_id <> ? LIMIT 1");
            $st->execute([$d['matricula'], $d['curp'], $id]);
            if ($st->fetch()) throw new \RuntimeException('La matrícula o la CURP ya pertenecen a otro alumno.');

            // === Derivar carrera_id y numero (semestre tinyint) a partir del semestre_id ===
            $semestreRow = $this->getSemestreRow($pdo, (int)$d['semestre_id']);
            $carreraId   = $semestreRow['carrera_id'];
            $semNumero   = $semestreRow['numero'];

            // === UPDATE users ===
            $userUpdate = [
                'email'            => $d['email'],
                'nombre'           => $d['nombre'],
                'apellido_paterno' => $d['apellido_paterno'] ?? null,
                'apellido_materno' => $d['apellido_materno'] ?? null,
                'telefono'         => $d['telefono'] ?? null,
                'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
                'status'           => $d['status'] ?? 'active',
            ];
            if (!empty($d['password'])) {
                $userUpdate['password'] = $d['password']; // el modelo hashea
            }
            $userModel->update($id, $userUpdate);

            // === UPSERT profile (usa derivaciones) ===
            $profileModel = new StudentProfile($pdo);
            $exists = $pdo->prepare("SELECT 1 FROM student_profiles WHERE user_id = ? LIMIT 1");
            $exists->execute([$id]);

            $payload = [
                'matricula'   => $d['matricula'],
                'curp'        => $d['curp'],
                'carrera_id'  => $carreraId,             // ← derivado
                'semestre_id' => (int)$d['semestre_id'], // ← elegido
                'grupo_id'    => null,                   // ← no se selecciona aquí
                // legacy
                'semestre'    => $semNumero,             // ← derivado
                'grupo'       => $d['grupo'] ?? null,
                'tipo_ingreso'=> $d['tipo_ingreso'] ?? 'nuevo',
                'beca_activa' => !empty($d['beca_activa']) ? 1 : 0,
                'promedio_general'   => ($d['promedio_general'] ?? '') !== '' ? (float)$d['promedio_general'] : 0.00,
                'creditos_aprobados' => ($d['creditos_aprobados'] ?? '') !== '' ? (int)$d['creditos_aprobados'] : 0,
                'direccion'   => $d['direccion'] ?? null,
                'contacto_emergencia_nombre'   => $d['contacto_emergencia_nombre'] ?? null,
                'contacto_emergencia_telefono' => $d['contacto_emergencia_telefono'] ?? null,
                'parentesco_emergencia'        => $d['parentesco_emergencia'] ?? null,
            ];

            if ($exists->fetch()) {
                $profileModel->updateByUserId($id, $payload);
            } else {
                $payload['user_id'] = $id;
                $profileModel->create($payload);
            }

            $pdo->commit();
            header('Location: /src/plataforma/app/admin/students?updated=1');
            exit;

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log('StudentsController@update ERROR: '.$e->getMessage());
            header('Location: /src/plataforma/app/admin/students/edit/'.$id.'?error='.urlencode('No se pudo actualizar: '.$e->getMessage()));
            exit;
        }
    }

    /* ===== Eliminar ===== */

    public function delete($id) {
        $this->requireRole(['admin', 'teacher']);
        $userModel = new User();
        $userModel->delete((int)$id);
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }

    /* ===== Exportar ===== */

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

    /* ===== Perfil de alumno (rol student) ===== */

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
