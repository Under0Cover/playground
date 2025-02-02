<?php
session_start();

// Check if access was not made directly via the URL
require_once 'AccessControl/AccessControl.php';
require_once 'Queries/Queries.php';
require_once 'Database/DatabaseHelper.php';

use Queries\Queries;
use Database\DatabaseHelper;

AccessControl\AccessControl::checkDirectAccess();

if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['task_name'], $_POST['task_description'])) {

    if (isset($_POST['task_name'], $_POST['task_description'])) {
        
        $params['USER_ID'] = $_SESSION['USER_ID'];
        $params['TASK_NAME'] = $_POST['task_name'];
        $params['TASK_DESCRIPTION'] = $_POST['task_description'];
        $params['ACTIVE'] = 'S';
        
        $id = InsertTask($params);
    
        header("Location: /todo");
        exit;
    } else {
        AccessControl\AccessControl::checkDirectAccess('Formulário não preenchido corretamente', null, true);
        return;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID'])) {
    // 'C' for 'Complete'
    $sql = Queries::UPDATE_TASK_STATUS;
    $field = ':ID';
    $params = [':ID' => intval($_POST['ID'])];

    $updated = DatabaseHelper::executeQuery($sql, $params, $field);
    
    if ($updated) {
        $completionDate = date('Y-m-d H:i:s');
        echo json_encode([
            'success' => true, 
            'message' => 'Tarefa concluída com sucesso!',
            'completionDate' => $completionDate
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Erro ao concluir a tarefa.'
        ]);
    }
    exit;
}

function InsertTask($params){
    $sql = Queries::INSERT_TASK;
    DatabaseHelper::executeQuery($sql, $params);

    $lastInsertId = DatabaseHelper::getConnection()->lastInsertId();
    return $lastInsertId;
}

?>