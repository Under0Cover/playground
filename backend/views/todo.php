<?php
session_start();

// Check if access was not made directly via the URL
require_once __DIR__ . '/../AccessControl/AccessControl.php';
require_once __DIR__ . '/../Queries/Queries.php';
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Database/DatabaseHelper.php';

use Queries\Queries;
use Database\DatabaseHelper;

AccessControl\AccessControl::checkDirectAccess();
var_dump($_SESSION);die;

if (!isset($_SESSION['USER_ID'])) {
    header("Location: /");
    exit;
} else if($_SESSION['PERMISSION'] === 'S') {
    header("Location: /admin");
    exit;
}else if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params[':USER_ID'] = $_SESSION['USER_ID'];

    $tasks = GetTasks($params);
}

function GetTasks($params){
    $sql = Queries::GET_TASKS;
    $field = ':USER_ID';
    $stmt = DatabaseHelper::executeQuery($sql, $params, $field);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/mobile/assets/css/style.css">
</head>
<body>
    <a href="/backend/logout.php" class="btn btn-danger position-fixed top-0 end-0 m-3">SAIR</a>
    <div class="container">
        <div class="todo-container">
            <div class="todo-form">
                <h3>Adicionar Tarefa</h3>
                <form action="/backend/processTask.php" method="POST">
                    <div class="form-group">
                        <label for="task_name">Nome da Tarefa</label>
                        <input type="text" id="task_name" name="task_name" class="form-control" required placeholder="Nome da tarefa" required>
                    </div>
                    <div class="form-group">
                        <label for="task_description">Descrição da Tarefa</label>
                        <textarea id="task_description" name="task_description" class="form-control" required placeholder="Descrição da tarefa"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Adicionar Tarefa</button>
                </form>
            </div>
        </div>

        <div class="todo-container todo-list">
            <h3>Tarefas</h3>
            <ul id="todoList" class="list-group">
                <?php foreach ($tasks as $task): ?>
                    <li class="todo-item">
                        <span><?php echo htmlspecialchars($task['TASK_NAME']); ?></span>

                        <?php if ($task['STATUS'] === 'P'): ?>
                            <button class="btn btn-sm btn-success" onclick="markAsCompleted(<?php echo $task['ID']; ?>)">Concluir</button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>Concluído</button>
                            <small class="text-muted">Finalizado em: <?php echo htmlspecialchars($task['COMPLETED_AT']); ?></small>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/mobile/assets/js/script.js"></script>
</body>
</html>
