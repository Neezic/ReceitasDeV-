<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/style.css">
</head>
<body>
    <div class="form-content">
        <h2>Recuperar Acesso</h2>
        <p>Por favor, informe seu CPF e data de nascimento para continuar.</p>

        <?php if (isset($_SESSION['erro'])): ?>
            <div class='alerta erro'><?php echo $_SESSION['erro']; ?></div>
            <?php unset($_SESSION['erro']); endif; ?>

        <form action="<?php echo BASE_URL ?>?pagina=login&acao=verificarDados" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token ?? '') ?>">
            
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
            
            <button type="submit">Verificar Dados</button>
        </form>
    </div>
</body>
</html>