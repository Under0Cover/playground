<?php
session_start();

// Check if access was not made directly via the URL
require_once __DIR__ . '/../AccessControl/AccessControl.php';
require_once __DIR__ . '/../Queries/Queries.php';
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Database/DatabaseHelper.php';

use Queries\Queries;
use Database\DatabaseHelper;

AccessControl\AccessControl::checkAdminAccess();

if ($_SESSION['PERMISSION'] == 'S') {
    $users = getUsers();
    getTasks($users);

}

function getUsers(){
    $sql = Queries::GET_USERS;
    $stmt = DatabaseHelper::executeQuery($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

function getTasks(&$users){
    foreach($users as &$user){
        $sql = Queries::GET_TASKS_FOR_ALL;
        $field = ':USER_ID';
        $stmt = DatabaseHelper::executeQuery($sql, $user['ID'], $field);
        $user['TASKS'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administração de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container mt-5">
    <h2>Usuários Cadastrados</h2>
    <ul class="list-group" id="userList">
        <?php if (isset($users) && is_array($users)): ?>
            <?php foreach ($users as $user): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($user['NAME']) ?></span>
                    <button class="btn btn-primary btn-sm view-tasks" data-user-id="<?= $user['ID'] ?>" data-user-name="<?= htmlspecialchars($user['NAME']) ?>" data-bs-toggle="modal" data-bs-target="#taskModal">Ver Tarefas</button>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">Nenhum usuário encontrado.</li>
        <?php endif; ?>
    </ul>
</div>

<!-- first modal - tasks for user -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Gerenciar Tarefas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="username"></h4>

                <!-- Add task -->
                <div class="mb-3">
                    <label for="newTaskTitle" class="form-label">Nome da Tarefa</label>
                    <input type="text" class="form-control" id="newTaskTitle" placeholder="Título da tarefa">
                </div>
                <div class="mb-3">
                    <label for="newTaskDescription" class="form-label">Descrição da Tarefa</label>
                    <textarea class="form-control" id="newTaskDescription" rows="3" placeholder="Descrição da tarefa"></textarea>
                </div>
                <button type="button" class="btn btn-success" id="addTaskButton">Adicionar Tarefa</button>

                <div class="mb-3"></div>
                <!-- Tasks list-->
                <ul class="list-group" id="taskList"></ul>
            </div>
        </div>
    </div>
</div>

<!-- second modal - edit/remove task -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Editar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="taskTitle">
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="taskDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">Status</label>
                        <select class="form-select" id="taskStatus">
                            <option value="P">Pendente</option>
                            <option value="C">Concluída</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="taskCreatedDate" class="form-label">Data de Criação</label>
                        <input type="text" class="form-control" id="taskCreatedDate" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="taskCompletionDate" class="form-label">Data de Conclusão</label>
                        <input type="text" class="form-control" id="taskCompletionDate" disabled>
                    </div>
                    <button type="button" class="btn btn-primary" id="saveTask">Salvar</button>
                    <button type="button" class="btn btn-danger" id="deleteTask">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estrutura oculta para armazenar tarefas de cada usuário -->
<?php foreach ($users as $user): ?>
    <div class="user-tasks d-none" data-user-id="<?= $user['ID'] ?>">
        <?php foreach ($user['TASKS'] as $task): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center" data-task-id="<?= $task['ID'] ?>" data-task-name="<?= htmlspecialchars($task['TASK_NAME']) ?>" data-task-description="<?= htmlspecialchars($task['TASK_DESCRIPTION']) ?>" data-task-status="<?= $task['STATUS'] ?>" data-task-created="<?= $task['CREATE_AT'] ?>" data-task-completion="<?= $task['COMPLETED_AT'] ?>">
                <span><?= htmlspecialchars($task['TASK_NAME']) ?></span>
                <button class="btn btn-warning btn-sm edit-task" data-bs-toggle="modal" data-bs-target="#editTaskModal">Editar</button>
            </li>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/mobile/assets/js/admin.js"></script>
</body>
</html>
