<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $pdo;
    private $stmt;

    public function __construct() {
        $config = require __DIR__ . '/../../../../config/config.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['name'],
            $config['db']['charset']
        );

        try {
            $this->pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Changed to FETCH_OBJ for consistency with Notification.php
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => true,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            $msg = ($config['app']['debug'] ?? false) ? $e->getMessage() : 'DB error';
            echo json_encode(['ok' => false, 'error' => 'DB_CONNECTION_FAILED', 'message' => $msg], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function query($sql, $params = []) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this->stmt;
    }

    public function fetchAll(?int $fetchMode = null, ...$args) {
        if ($fetchMode !== null) {
            return $this->stmt->fetchAll($fetchMode, ...$args);
        }
        return $this->stmt->fetchAll();
    }

    public function fetch() {
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function fetchColumn() {
        return $this->stmt->fetchColumn();
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    // 👇 Pega esto dentro de la clase Database
public function beginTransaction(): bool {
    return $this->pdo->beginTransaction();
}

public function commit(): bool {
    return $this->pdo->commit();
}

public function rollBack(): bool {
    // Ojo: en PDO es rollBack (B mayúscula)
    return $this->pdo->rollBack();
}

/** Alias útil si quieres el PDO crudo en otros lados */
public function pdo(): PDO {
    return $this->pdo;
}

}