<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topo">
    <div class="topo-conteudo">
        <h1 class="logo">Receitas da Vó</h1>
        <div class="busca">
            <input type="text" placeholder="Procure uma receita, ingrediente...">
            <button>Procurar</button>
        </div>
    
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="<?=BASE_URL?>?pagina=home">Início</a></li>
        
            <li><a href="<?=BASE_URL?>?pagina=sobre">Sobre</a></li>
        
            <li><a href="<?=BASE_URL?>?pagina=login&acao=cadastro">Cadastro</a></li>
            <li><a href="#">Bolos e Tortas</a></li>
            <li><a href="#">Massas</a></li>
            <li><a href="#">Lanches</a></li>
            <li><a href="#">Doces</a></li>        </ul>
    </nav>
</header>

    <main>
        <section id="destaque">
            <h2>Bem-vindo!</h2>
            <p>Esta é a página inicial</p>
            
        </section>  

    <section id="receitas-main">
        <h2>Últimas receitas:</h2>

        <?php foreach ($receitas as $receita): ?>
            <div class="receita">
                <h2><?= htmlspecialchars($receita['titulo']) ?></h2>
                <p><?= nl2br(htmlspecialchars($receita['descricao'])) ?></p>
            </div>
        <?php endforeach; ?>
    </section>
    </main>

     <footer>
        <p>2025. Site de Receitas. Todos os direitos reservados para os quatro que fizeram. O site. Esse site. Esse site que você tá lendo agora.</p>
    </footer>


</body>
</html>