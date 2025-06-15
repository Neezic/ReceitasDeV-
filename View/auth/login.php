<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuario</title>
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
                <h1>Login</h1>
                <form action="<?= BASE_URL ?>?pagina=login&acao=login" method="POST">
                    <div class="form-group">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        Email: <input type="email" id="email" name="email"><br>
                        Senha: <input type="password" id="senha" name="senha"><br>
                    <button type="submit">Entrar</button>
                    </div>
                </form>
            </div>
        <a href="<?= BASE_URL ?>?pagina=login&acao=cadastro">Não tem uma conta? Cadastre-se</a>
        </section>
    </main>
    

    
</body>
</html>
