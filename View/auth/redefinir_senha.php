<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/style.css">
</head>
<body>
    <div class="form-content">
        <h2>Crie sua Nova Senha</h2>

        <?php if (isset($_SESSION['erro'])): ?>
            <div class='alerta erro'><?php echo $_SESSION['erro']; ?></div>
            <?php unset($_SESSION['erro']); endif; ?>

        <form action="<?php echo BASE_URL ?>?pagina=login&acao=atualizarSenha" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token ?? '') ?>">
            
            <div class="form-group">
                <label for="senha">Nova Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="senha_confirmacao">Confirme a Nova Senha:</label>
                <input type="password" id="senha_confirmacao" name="senha_confirmacao" required>
            </div>
            
            <button type="submit">Salvar Nova Senha</button>
        </form>
    </div>
</body>
</html>