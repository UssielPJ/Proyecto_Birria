<?php

namespace App\Models;

use PDO;
use Exception;

class Payment
{
    private $db;
    private $table = 'payments';
    public $id;

    public function __construct()
    {
        $this->db = new \App\Core\Database(); // Usar la clase Database del framework
    }

    public static function all()
    {
        try {
            $pdo = db();
            $stmt = $pdo->query("SELECT payments.*, users.name as student_name 
                                FROM payments 
                                LEFT JOIN users ON payments.student_id = users.id
                                ORDER BY payments.created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error en Payment::all(): " . $e->getMessage());
            return [];
        }
    }

    public static function find($id)
    {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT payments.*, users.name as student_name 
                                  FROM payments 
                                  LEFT JOIN users ON payments.student_id = users.id
                                  WHERE payments.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error en Payment::find(): " . $e->getMessage());
            return null;
        }
    }

    public static function create($data)
    {
        try {
            $pdo = db();
            $sql = "INSERT INTO payments (student_id, concept, amount, payment_date, payment_method, status, notes, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            
            $stmt = $pdo->prepare($sql);
            
            return $stmt->execute([
                $data['student_id'],
                $data['concept'],
                $data['amount'],
                $data['payment_date'],
                $data['payment_method'],
                $data['status'],
                $data['notes']
            ]);
        } catch (Exception $e) {
            error_log("Error en Payment::create(): " . $e->getMessage());
            return false;
        }
    }

    public function update($data)
    {
        try {
            $pdo = db();
            $sql = "UPDATE payments 
                    SET student_id = ?,
                        concept = ?,
                        amount = ?,
                        payment_date = ?,
                        payment_method = ?,
                        status = ?,
                        notes = ?,
                        updated_at = NOW()
                    WHERE id = ?";
            
            $stmt = $pdo->prepare($sql);
            
            return $stmt->execute([
                $data['student_id'],
                $data['concept'],
                $data['amount'],
                $data['payment_date'],
                $data['payment_method'],
                $data['status'],
                $data['notes'],
                $this->id
            ]);
        } catch (Exception $e) {
            error_log("Error en Payment::update(): " . $e->getMessage());
            return false;
        }
    }

    public function delete()
    {
        try {
            $pdo = db();
            $sql = "DELETE FROM payments WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$this->id]);
        } catch (Exception $e) {
            error_log("Error en Payment::delete(): " . $e->getMessage());
            return false;
        }
    }

    public static function getByStudent($studentId)
    {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT * FROM payments WHERE student_id = ? ORDER BY payment_date DESC");
            $stmt->execute([$studentId]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error en Payment::getByStudent(): " . $e->getMessage());
            return [];
        }
    }

    public static function getTotalByStatus($status)
    {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM payments WHERE status = ?");
            $stmt->execute([$status]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result->total : 0;
        } catch (Exception $e) {
            error_log("Error en Payment::getTotalByStatus(): " . $e->getMessage());
            return 0;
        }
    }

    public static function countPending()
    {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM payments WHERE estatus = 'en_revision'");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result->count : 0;
        } catch (Exception $e) {
            error_log("Error en Payment::countPending(): " . $e->getMessage());
            return 0;
        }
    }
}