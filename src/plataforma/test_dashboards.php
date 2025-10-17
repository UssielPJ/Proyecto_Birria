<?php
// Test script for dashboards
require_once '../../src/db.php';
require_once 'app/config/app.php';
require_once 'app/core/Database.php';
require_once 'app/core/Auth.php';
require_once 'app/core/Gate.php';
require_once 'app/core/View.php';
require_once 'app/core/helpers.php';
require_once 'app/models/User.php';
require_once 'app/models/Course.php';
require_once 'app/models/Grade.php';
require_once 'app/models/Payment.php';
require_once 'app/controllers/AdminDashboardController.php';
require_once 'app/controllers/StudentDashboardController.php';

echo "Testing Admin Dashboard data...\n";

// Test User model methods
$userModel = new \App\Models\User();

try {
    $total_students = $userModel->countByRole('alumno');
    echo "Total students: $total_students\n";
} catch (Exception $e) {
    echo "Error counting students: " . $e->getMessage() . "\n";
}

try {
    $total_teachers = $userModel->countByRole('maestro');
    echo "Total teachers: $total_teachers\n";
} catch (Exception $e) {
    echo "Error counting teachers: " . $e->getMessage() . "\n";
}

try {
    $recent_users = $userModel->getRecentUsers(5);
    echo "Recent users count: " . count($recent_users) . "\n";
} catch (Exception $e) {
    echo "Error getting recent users: " . $e->getMessage() . "\n";
}

// Test Course model
$courseModel = new \App\Models\Course();

try {
    $total_courses = $courseModel->count();
    echo "Total courses: $total_courses\n";
} catch (Exception $e) {
    echo "Error counting courses: " . $e->getMessage() . "\n";
}

try {
    $active_courses = $courseModel->countActive();
    echo "Active courses: $active_courses\n";
} catch (Exception $e) {
    echo "Error counting active courses: " . $e->getMessage() . "\n";
}

// Test Payment model
$paymentModel = new \App\Models\Payment();

try {
    $pending_payments = \App\Models\Payment::countPending();
    echo "Pending payments: $pending_payments\n";
} catch (Exception $e) {
    echo "Error counting pending payments: " . $e->getMessage() . "\n";
}

echo "\nTesting Student Dashboard data...\n";

// Simulate student user
$_SESSION['user'] = [
    'id' => 4,
    'name' => 'Estudiante',
    'email' => 'estudiante@UTSC.edu',
    'role' => 'student'
];

try {
    $currentCourses = $courseModel->getCurrentByStudent(4);
    echo "Current courses for student: " . count($currentCourses) . "\n";
} catch (Exception $e) {
    echo "Error getting current courses: " . $e->getMessage() . "\n";
}

// Test Grade model
$gradeModel = new \App\Models\Grade();

try {
    $recentGrades = $gradeModel->getRecentByStudent(4);
    echo "Recent grades for student: " . count($recentGrades) . "\n";
} catch (Exception $e) {
    echo "Error getting recent grades: " . $e->getMessage() . "\n";
}

try {
    $averageGradeData = $gradeModel->getAverageByStudent(4);
    echo "Average grade for student: " . $averageGradeData['average'] . "\n";
} catch (Exception $e) {
    echo "Error getting average grade: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";