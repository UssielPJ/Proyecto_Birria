<?php
namespace App\Controllers;
class ScholarshipsController {
  function index(){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    ob_start(); include __DIR__.'/../views/scholarships/index.php'; return ob_get_clean();
  }

  function create(){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    ob_start(); include __DIR__.'/../views/admin/scholarships/create.php'; return ob_get_clean();
  }

  function store(){
    // Implement store logic
    header('Location: /src/plataforma/app/admin/scholarships');
  }

  function edit($id){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    // Get scholarship data
    $scholarship = ['id' => $id, 'name' => 'Beca de Excelencia', 'type' => 'academica', 'percentage' => 50, 'deadline' => '2025-12-31', 'description' => 'Descripción', 'requirements' => ['Req1', 'Req2'], 'documents' => ['Doc1', 'Doc2']];
    ob_start(); include __DIR__.'/../views/admin/scholarships/edit.php'; return ob_get_clean();
  }

  function update($id){
    // Implement update logic
    header('Location: /src/plataforma/app/admin/scholarships');
  }

  function delete($id){
    // Implement delete logic
    header('Location: /src/plataforma/app/admin/scholarships');
  }

  function apply($id){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    // Get scholarship data
    $scholarship = ['id' => $id, 'name' => 'Beca de Excelencia', 'type' => 'academica', 'percentage' => 50, 'deadline' => '2025-12-31', 'description' => 'Descripción', 'requirements' => ['Req1', 'Req2'], 'documents' => ['Doc1', 'Doc2']];
    $user = $_SESSION['user'];
    ob_start(); include __DIR__.'/../views/student/scholarships/apply.php'; return ob_get_clean();
  }

  function submitApplication($id){
    // Implement submit application logic
    header('Location: /src/plataforma/app/scholarships');
  }
}
