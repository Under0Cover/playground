<?php
session_start();
// Check if access was not made directly via the URL
require_once 'AccessControl/AccessControl.php';
require_once 'Queries/Queries.php';
require_once 'Database/DatabaseHelper.php';

use Queries\Queries;
use Database\DatabaseHelper;

AccessControl\AccessControl::checkDirectAccess();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params[':NAME'] = trim($_POST['name']);
    $params[':PHONE'] = trim($_POST['phone']);
    $params[':EMAIL'] = trim($_POST['email']);
    $params[':PASSWORD'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $params[':PERMISSION'] = $_POST['permission'] ? $_POST['permission'] : 'N';

    if (empty($params[':NAME']) || empty($params[':PHONE']) || empty($params[':EMAIL']) || empty($params[':PASSWORD'])) {
        AccessControl\AccessControl::checkDirectAccess('Formulário não preenchido corretamente', null, true);
        return;
    }

    $check = CheckEmail($params[':EMAIL']);

    if($check){
        $_SESSION['LOGIN'] = true;
        $_SESSION['PERMISSION'] = $params['PERMISSION'];
        InsertUser($params);
        header("Location: /todo");
        exit;
    } else{
        header("Location: /");
        exit;
    }
}

function CheckEmail($email){
    $sql = Queries::CHECK_EMAIL;
    $field = ':EMAIL';
    $stmt = DatabaseHelper::executeQuery($sql, $email, $field);

    return !($stmt->fetchColumn() > 0);
}

function InsertUser($params) {
    $sql = Queries::INSERT_USER;
    $newUser = DatabaseHelper::executeQuery($sql, $params);
    $_SESSION['USER_ID'] = DatabaseHelper::getConnection()->lastInsertId();
}

?>