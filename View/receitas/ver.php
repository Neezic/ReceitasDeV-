<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($receita['titulo']) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <style>
        /* Estilos específicos para a página de visualização da receita */
        .receita-detalhe { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 1px 6px rgb(0 0 0 / 0.12); }
        .receita-detalhe h1 { color: #d35400; margin-bottom: 20px; }
        .receita-detalhe h3 { color: #f37021; margin-top: 25px; margin-bottom: 10px; border-bottom: 2px solid #fff3e0; padding-bottom: 5px; }
        .receita-info { display: flex; gap: 20px; margin-bottom: 20px; padding: 15px; background: #fff8f0; border-radius: 8px; }
        .receita-ingredientes ul { list-style: none; padding-left: 0; }
        .receita-ingredientes li { margin-bottom: 5px; }
    </style>
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
        <article class="receita-detalhe">
            <h1><?= htmlspecialchars($receita['titulo']) ?></h1>

            <div class="receita-info">
                <span><strong>Dificuldade:</strong> <?= htmlspecialchars($receita['dificuldade']) ?></span>
                <span><strong>Tempo de Preparo:</strong> <?= htmlspecialchars($receita['tempo_preparo']) ?> minutos</span>
            </div>

            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $receita['usuario_id']): ?>
                <div class="receita-acoes" style="margin-bottom: 20px;">
                    <a href="<?= BASE_URL ?>?pagina=receitas&acao=editar&id=<?= $receita['id'] ?>" class="btn-editar">Editar Receita</a>
                    <form method="POST" action="<?= BASE_URL ?>?pagina=receitas&acao=deletar" style="display: inline;" onsubmit="return confirm('Tem certeza?');">
                        <input type="hidden" name="id" value="<?= $receita['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= gerar_token_csrf() ?>">
                        <button type="submit" class="btn-excluir">Excluir Receita</button>
                    </form>
                </div>
            <?php endif; ?>

            <section class="receita-ingredientes">
                <h3>Ingredientes</h3>
                <ul>
                    <?php 
                    // Transforma a string de ingredientes em uma lista
                    $ingredientes = explode("\n", $receita['ingredientes']);
                    foreach ($ingredientes as $ingrediente) {
                        echo "<li>" . htmlspecialchars(trim($ingrediente)) . "</li>";
                    }
                    ?>
                </ul>
            </section>

            <section class="receita-preparo">
                <h3>Modo de Preparo</h3>
                <p><?= nl2br(htmlspecialchars($receita['modo_preparo'])) ?></p>
            </section>

        </article>
    </main>

    <footer>
        <p>2025. Site de Receitas. Todos os direitos reservados para os quatro que fizeram. O site. Esse site. Esse site que você tá lendo agora.</p>
    </footer>
</body>
</html>