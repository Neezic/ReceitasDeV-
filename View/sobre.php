<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre o site</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
     <header>
        <h1>Site de Receitas</h1>
        <nav>
            <ul>
                <li><a href="<?=BASE_URL?>?pagina=home">Início</a></li>
        
                <li><a href="<?=BASE_URL?>?pagina=sobre">Sobre</a></li>
        
                <?php if (isset($_SESSION['usuario'])): ?>
                
                    <li><a href="<?= BASE_URL ?>?pagina=receitas&acao=criar">Criar Receita</a></li>
                
                    <li><a href="<?= BASE_URL ?>?pagina=login&acao=logout">Sair (<?= htmlspecialchars($_SESSION['usuario']['nome']) ?>)</a></li>

                <?php else: ?>

                    <li><a href="<?= BASE_URL ?>?pagina=login&acao=cadastro">Cadastro</a></li>
                    <li><a href="<?= BASE_URL ?>?pagina=login">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section>

            <h2>Sobre o site</h2>
            <p> Nós somos quatros pessoas fazendo um site de receitas. Com receitas. Onde fazem-se receitas.<br>
                E leem receitas as pessoas que vem pro site. E talvez até cozinhem junto as receitas que estão aqui receitadas.
            </p>
        </section>  
    </main>

    <footer>
        <p>2025. Site de Receitas. Todos os direitos reservados para os quatro que fizeram. O site. Esse site. Esse site que você tá lendo agora.</p>
    </footer>

</body>
</html>