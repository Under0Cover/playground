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
    $params = [
        ':ID'                   =>  $_POST['ID'],
        ':TASK_NAME'            =>  $_POST['TASK_NAME'],
        ':TASK_DESCRIPTION'     =>  $_POST['TASK_DESCRIPTION'],
        ':STATUS'               =>  $_POST['STATUS']
    ];

    if($params[':STATUS'] === 'P'){
        $params['COMPLETED_AT'] = NULL;
    }else if($params[':STATUS'] === 'C'){
        $params['COMPLETED_AT'] = date('Y-m-d H:i:s');
    }
    
    if($_POST['ACTION'] === 'SAVE'){
        updateTask($params);
        header('Location: /admin');
        exit;
    }else if($_POST['ACTION'] === 'DELETE'){
        deleteTask($params);
        header('Location: /admin');
        exit;
    }
}

function updateTask($params){
    $sql = Queries::UPDATE_TASK;
    $stmt = DatabaseHelper::executeQuery($sql, $params);

    $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteTask($params){
    $sql = Queries::DELETE_TASK;
    $stmt = DatabaseHelper::executeQuery($sql, $params);

    $stmt->fetch(PDO::FETCH_ASSOC);
}

?>