<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registre-se</title>
    <link href="/mobile/assets/css/style.css" rel="stylesheet">

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/mobile/assets/css/style.css">
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 registration-container">
                    <h3 class="text-center mb-4">Cadastro de Novo Usuário</h3>
                    <form method="POST" action="backend/processRegister.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Digite seu nome completo">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="Digite seu telefone" maxlength="15">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu e-mail">
                        </div>

                        <div class="mb-3" id="password-group">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Escolha uma senha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="A senha deve conter pelo menos 8 caracteres, incluindo números, letras maiúsculas e caracteres especiais">
                            <small class="form-text text-muted password-hint">A senha deve ter pelo menos 8 caracteres, incluindo números, letras maiúsculas e caracteres especiais.</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="permission" name="permission" value="S">
                            <label class="form-check-label" for="permission">Conceder permissões</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>

                    <!-- Back Login -->
                    <div class="text-center mt-3">
                        <p class="form-text">Já tem uma conta? <a href="/">Faça login</a></p>
                    </div>
                </div>
            </div>
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
