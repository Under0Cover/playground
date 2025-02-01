<?php

namespace Database;

session_start();
// Check if access was not made directly via the URL
require_once __DIR__ . '/../AccessControl/AccessControl.php';
require_once __DIR__ . '/../Queries/Queries.php';
require_once __DIR__ . '/Database.php';

use PDO;
use Database\Database;

\AccessControl\AccessControl::checkDirectAccess();

class DatabaseHelper {
    public static function bindParams($stmt, $params, $field = null) {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        } else {
            $stmt->bindValue($field, $params, PDO::PARAM_STR);
        }
    }
    
    public static function executeQuery($sql, $params = [], $field = null) {
        $stmt = Database::getConnection()->prepare($sql);
        self::bindParams($stmt, $params, $field);
        $stmt->execute();

        return $stmt;
    }

    public static function getConnection() {
        return Database::getConnection();
    }
}
