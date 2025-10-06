<?php
namespace App\Controllers;
class SurveysController {
  function index(){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    ob_start(); include __DIR__.'/../views/surveys/index.php'; return ob_get_clean();
  }

  function create(){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    ob_start(); include __DIR__.'/../views/admin/surveys/create.php'; return ob_get_clean();
  }

  function store(){
    // Implement store logic
    header('Location: /src/plataforma/app/admin/surveys');
  }

  function edit($id){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    // Get survey data
    $survey = ['id' => $id, 'title' => 'Encuesta de Satisfacción', 'type' => 'satisfaccion', 'description' => 'Descripción', 'start_date' => '2025-01-01', 'end_date' => '2025-12-31', 'is_anonymous' => 1, 'is_required' => 0, 'questions' => [['text' => 'Pregunta 1', 'type' => 'text', 'required' => 1]]];
    ob_start(); include __DIR__.'/../views/admin/surveys/edit.php'; return ob_get_clean();
  }

  function update($id){
    // Implement update logic
    header('Location: /src/plataforma/app/admin/surveys');
  }

  function delete($id){
    // Implement delete logic
    header('Location: /src/plataforma/app/admin/surveys');
  }

  function take($id){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    // Get survey data
    $survey = ['id' => $id, 'title' => 'Encuesta de Satisfacción', 'type' => 'satisfaccion', 'description' => 'Descripción', 'start_date' => '2025-01-01', 'end_date' => '2025-12-31', 'is_anonymous' => 1, 'is_required' => 0, 'questions' => [['text' => 'Pregunta 1', 'type' => 'text', 'required' => 1]]];
    ob_start(); include __DIR__.'/../views/student/surveys/take.php'; return ob_get_clean();
  }

  function submit($id){
    // Implement submit logic
    header('Location: /src/plataforma/app/surveys');
  }
}
