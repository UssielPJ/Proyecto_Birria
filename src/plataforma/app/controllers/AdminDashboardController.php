<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Subject;

class AdminDashboardController {
  public function index(){
    \App\Core\Gate::allow(['admin']);

    // Cargar modelos necesarios
    $userModel = new User();
    $courseModel = new Course();
    $paymentModel = new Payment();

    // Obtener estadísticas
    try {
        $total_students = $userModel->countByRole('alumno');
    } catch (\Exception $e) {
        $total_students = 0;
    }
    try {
        $total_teachers = $userModel->countByRole('maestro');
    } catch (\Exception $e) {
        $total_teachers = 0;
    }
    try {
        $total_courses = $courseModel->count();
    } catch (\Exception $e) {
        $total_courses = 0;
    }
    try {
        $active_courses = $courseModel->countActive();
    } catch (\Exception $e) {
        $active_courses = 0;
    }
    try {
        $total_subjects = $courseModel->count();
    } catch (\Exception $e) {
        $total_subjects = 0;
    }
    try {
        $recent_subjects = $courseModel->getRecent(5);
    } catch (\Exception $e) {
        $recent_subjects = [];
    }
    try {
        $monthly_registrations = $userModel->getMonthlyRegistrations();
    } catch (\Exception $e) {
        $monthly_registrations = [];
    }
    try {
        $role_distribution = $userModel->getRoleDistribution();
    } catch (\Exception $e) {
        $role_distribution = [];
    }
    try {
        $recent_users = $userModel->getRecentUsers(5);
    } catch (\Exception $e) {
        $recent_users = [];
    }
    try {
        $pending_payments = $paymentModel::countPending();
    } catch (\Exception $e) {
        $pending_payments = 0;
    }
    try {
        $pending_solicitudes = $userModel->countPendingSolicitudes();
    } catch (\Exception $e) {
        $pending_solicitudes = 0;
    }
    try {
        $incomplete_documents = $userModel->countIncompleteDocuments();
    } catch (\Exception $e) {
        $incomplete_documents = 0;
    }

    $stats = [
      'total_students' => $total_students,
      'total_teachers' => $total_teachers,
      'total_courses' => $total_courses,
      'active_courses' => $active_courses,
      'total_subjects' => $total_subjects,
      'recent_subjects' => $recent_subjects,
      'monthly_registrations' => $monthly_registrations,
      'role_distribution' => $role_distribution,
      'recent_users' => $recent_users,
      'pending_payments' => $pending_payments,
      'pending_solicitudes' => $pending_solicitudes,
      'incomplete_documents' => $incomplete_documents
    ];

    \App\Core\View::render('admin/dashboard', 'admin', [
      'title' => 'UTEC · Administración',
      'user'  => $_SESSION['user'] ?? null,
      'name'  => $_SESSION['user']['name'] ?? '',
      'email' => $_SESSION['user']['email'] ?? '',
      'stats' => $stats
    ]);
  }
}
