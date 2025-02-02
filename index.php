<?php

session_start();
session_set_cookie_params(1000);

// URL
$request = $_SERVER['REQUEST_URI'];

// Routing
switch ($request) {
    case '/registration':
        require __DIR__ . '/backend/registration.php';
        break;

    case '/':
        require __DIR__ . '/backend/login.php';
        break;

    case '/todo':
        require __DIR__ . '/backend/views/todo.php';
        break;

    case '/admin':
        require __DIR__ . '/backend/views/admin.php';
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada.";
        break;
}
