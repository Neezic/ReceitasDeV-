<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<header class="topo">
    <div class="topo-conteudo">
        <h1 class="logo">Receitas da Vó</h1>
        <div class="busca">
            <form action="<?php echo BASE_URL ?>" method="GET" class="form-busca">
                <input type="hidden" name="pagina" value="receitas">
                <input type="text" name="busca" placeholder="Procure uma receita..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
            </form>
            <button type="submit">Procurar</button>
        </div>
    
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo BASE_URL?>?pagina=home">Início</a></li>
        
            <li><a href="<?php echo BASE_URL?>?pagina=sobre">Sobre</a></li>
        
            <?php if (isset($_SESSION['usuario'])): ?>
                
                    <li><a href="<?php echo BASE_URL ?>?pagina=receitas&acao=criar">Criar Receita</a></li>
                
                    <li><a href="<?php echo BASE_URL ?>?pagina=login&acao=logout">Sair (<?= htmlspecialchars($_SESSION['usuario']['nome']) ?>)</a></li>

                <?php else: ?>

                    <li><a href="<?php echo BASE_URL ?>?pagina=login&acao=cadastro">Cadastro</a></li>
                    <li><a href="<?php echo BASE_URL ?>?pagina=login">Login</a></li>
            <?php endif; ?>

            <li><a href="#">Bolos e Tortas</a></li>
            <li><a href="#">Massas</a></li>
            <li><a href="#">Lanches</a></li>
            <li><a href="#">Doces</a></li>        
        </ul>
    </nav>
</header>

    <main>
        <section id="destaque">
            <h2>Bem-vindo!</h2>
            <p>Esta é a página inicial</p>
            
        </section>  

    <section id="receitas-main">
        <h2>Últimas receitas:</h2>
        <?php if (empty($receitas)): ?>
            <p>Ainda não há receitas cadastradas.</p>
        <?php else: ?>

        <?php foreach ($receitas as $receita): ?>
                <h2>
                <a href="<?php echo BASE_URL ?>?pagina=receitas&acao=ver&id=<?php echo $receita['id'] ?>">
                        <?= htmlspecialchars($receita['titulo']) ?>
                    </a>
                </h2>

                <p><?= isset($receita['descricao']) ? nl2br(htmlspecialchars($receita['descricao'])) : 'Clique no título para ver a receita completa.' ?></p>

                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $receita['usuario_id']): ?>
                    <div class="receita-acoes">
        
                    <form method="POST" action="<?php echo BASE_URL ?>?pagina=receitas&acao=deletar" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?');">
                        <input type="hidden" name="id" value="<?php echo $receita['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo gerar_token_csrf() ?>">
                        <button type="submit" class="btn-excluir">Excluir</button>
                    </form>
                </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
        
    </section>
    </main>

     <footer>
        <p>2025. Site de Receitas. Todos os direitos reservados para os quatro que fizeram. O site. Esse site. Esse site que você tá lendo agora.</p>
    </footer>


</body>
</html>