<?php

class StudentsController {
    public function index() {
        // Verificar autenticación
        Auth::checkAuthentication();
        
        // Verificar rol de administrador
        Gate::allowsOrFail('admin');
        
        // Obtener lista de estudiantes de la base de datos
        $students = User::where('role', 'student')->get();
        
        // Cargar la vista con los datos
        View::render('admin/students/index', [
            'students' => $students
        ]);
    }
    
    public function create() {
        Auth::checkAuthentication();
        Gate::allowsOrFail('admin');
        
        View::render('admin/students/create');
    }
    
    public function store() {
        Auth::checkAuthentication();
        Gate::allowsOrFail('admin');
        
        // Validación de datos
        $data = $_POST;
        // TODO: Implementar validación
        
        // Crear nuevo estudiante
        $student = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'student'
        ]);
        
        // Redireccionar a la lista de estudiantes
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }
    
    public function edit($id) {
        Auth::checkAuthentication();
        Gate::allowsOrFail('admin');
        
        $student = User::find($id);
        
        View::render('admin/students/edit', [
            'student' => $student
        ]);
    }
    
    public function update($id) {
        Auth::checkAuthentication();
        Gate::allowsOrFail('admin');
        
        $data = $_POST;
        // TODO: Implementar validación
        
        $student = User::find($id);
        $student->update([
            'name' => $data['name'],
            'email' => $data['email']
        ]);
        
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }
    
    public function delete($id) {
        Auth::checkAuthentication();
        Gate::allowsOrFail('admin');
        
        User::delete($id);
        
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }
}