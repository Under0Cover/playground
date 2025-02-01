<?php

namespace Database;

use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                $host = 'localhost';
                $db   = 'candidatura';
                $user = 'root';
                $pass = 'root';
                
                // PDO Instance
                self::$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erro de conexão: " . $e->getMessage();
                exit;
            }
        }
        return self::$pdo;
    }


}
