<?php

namespace AccessControl;

session_start();

class AccessControl {
    public static function checkDirectAccess($message = 'Página não encontrada!', $optional = null, $error = false) {
        $content = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Acesso Negado</title>
                    <link href="../../mobile/assets/css/style.css" rel="stylesheet">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                </head>
                <body>
                    <div class="container d-flex justify-content-center align-items-center vh-100">
                        <div class="message-box p-4 text-center">
                            <p>'.$message.'</p>'.
                            ($optional != null ? '<p>'.$optional.'</p>' : '').'
                            <p>Você será redirecionado para a página de Login.</p>
                        </div>
                    </div>
                </body>
                </html>';

        if($error){
            echo $content;
        } else {
            $allowedPaths = [
                '/backend/processRegister.php',
                '/backend/registration.php',
                '/backend/processLogin.php'
            ];

            $loggedPaths = [
                '/backend/views/todo.php',
                '/backend/processTask.php',
                '/todo'
            ];

            $currentPath = $_SERVER['REQUEST_URI'];        

            if (in_array($currentPath, $allowedPaths)) {
                return;
            } else if (in_array($currentPath, $loggedPaths) && ($_SESSION['LOGIN'])) {
                return;
            } else {
                echo $content;
                header('Refresh: 3; url=/');
                exit();
            }
        }
    }
}


?>