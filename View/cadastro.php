 

<?php
// É essencial iniciar a sessão em todas as páginas que você quer acessar a variável $_SESSION
session_start();
// aqui eu pedi pro chat fazer alterar conforme necessario para o front 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        /* Estilos básicos para o formulário e mensagens */
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; }
        .form-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        .alerta { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; text-align: center; }
        .alerta.erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alerta.sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        button { width: 100%; padding: 0.7rem; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Crie sua Conta</h2>

        <?php
        // Bloco de PHP para exibir a mensagem de erro, se ela existir na sessão.
        if (isset($_SESSION['mensagem_erro'])) {
            echo "<div class='alerta erro'>" . htmlspecialchars($_SESSION['mensagem_erro']) . "</div>";
            // É crucial limpar a mensagem da sessão depois de exibi-la, para que ela não apareça novamente.
            unset($_SESSION['mensagem_erro']);
        }
        ?>

        <form action="../Controller/processa_cadastro.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Cadastrar</button>
        </form>
    </div>

</body>
</html>