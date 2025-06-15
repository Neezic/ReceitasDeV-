 

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Site de Receitas</h1>
        <nav>
            <ul>
                <li><a href="home.php">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <div class="form-content">
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