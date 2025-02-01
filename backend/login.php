<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplicação</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/mobile/assets/css/style.css">
</head>
<body>
    <!-- Content -->
    <div class="login-container">
        <h3 class="text-center mb-4">Login</h3>
        <form action="/backend/processLogin.php" method="POST">
            <div class="mb-3">
                <label for="user" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="user" name="user" required placeholder="Digite seu usuário">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Digite sua senha">
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
            <p class="form-text">Não tem uma conta? <a href="/registration">Cadastre-se</a></p>
        </form>
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
