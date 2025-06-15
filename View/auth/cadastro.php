<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <header>
        <h1>Site de Receitas</h1>
        <nav>
            <ul>
                <li><a href="<?=BASE_URL?>?pagina=home">Início</a></li>
        
                <li><a href="<?=BASE_URL?>?pagina=sobre">Sobre</a></li>
        
                <li><a href="<?=BASE_URL?>?pagina=login&acao=cadastro">Cadastro</a></li>
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

                <form action="<?= BASE_URL ?>?pagina=login&acao=salvarUsuario" method="POST">
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
                <div class="form-group">
                    <label for="senha_confirmacao">Confirme sua Senha:</label>
                    <input type="password" id="senha_confirmacao" name="senha_confirmacao" required>
                </div>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <button type="submit">Cadastrar</button>
            </form>
            </div>
            <a href="<?= BASE_URL ?>?pagina=login">Já tem uma conta? Faça login</a>
        </section>
    </main>
    
    

</body>
</html>