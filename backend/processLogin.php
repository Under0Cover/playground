<?php
session_start();
require_once 'Database/Database.php';
require_once 'Queries/Queries.php';
require_once 'Database/DatabaseHelper.php';

use Queries\Queries;
use Database\DatabaseHelper;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params[':EMAIL'] = trim($_POST['user']);
    $params[':PASSWORD'] = trim($_POST['password']);

    if (empty($params[':EMAIL']) || empty($params[':PASSWORD'])) {
        AccessControl\AccessControl::checkDirectAccess('Formulário não preenchido corretamente', null, true);
    }

    $user = CheckUser($params[':EMAIL']);


    if(!$user){
        AccessControl\AccessControl::checkDirectAccess('Usuário não encontrado', null, true);
    }else{
        if(password_verify($params[':PASSWORD'], $user['PASSWORD'])){
            $_SESSION['LOGIN'] = true;
            $_SESSION['PERMISSION'] = !empty($user['PERMISSION']) ? $user['PERMISSION'] : 'N';
            $_SESSION['USER_ID'] = $user['ID'];

            header("Location: /todo");
            exit;
        }else{
            AccessControl\AccessControl::checkDirectAccess('Senha incorreta', null, true);
        }
    }
}

function CheckUser($email){
    $sql = Queries::CHECK_USER;
    $field = ':EMAIL';
    $stmt = DatabaseHelper::executeQuery($sql, $email, $field);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}