<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>

<body>
    <header>
        <h1>Site de Receitas</h1>
        <nav>
            <ul>
                <li><a href="<?= BASE_URL ?>?pagina=home">Início</a></li>

                <li><a href="<?= BASE_URL ?>?pagina=sobre">Sobre</a></li>

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
        <section id="receitas-main">

            <?php
            $termo_busca = $_GET['busca'] ?? null;
            if ($termo_busca) {
                echo "<h2>Resultados da busca por: \"" . htmlspecialchars($termo_busca) . "\"</h2>";
            } else {
                echo "<h2>Todas as Receitas</h2>";
            }
            ?>

            <?php if (empty($receitas)): ?>
                <p>Nenhuma receita encontrada.</p>
            <?php else: ?>
                <?php foreach ($receitas as $receita): ?>
                    <div class="receita">
                        <h2>
                            <a href="<?= BASE_URL ?>?pagina=receitas&acao=ver&id=<?= $receita['id'] ?>">
                                <?= htmlspecialchars($receita['titulo']) ?>
                            </a>
                        </h2>
                        <p>
                            <strong>Dificuldade:</strong> <?= htmlspecialchars($receita['dificuldade']) ?>
                            <strong>Categoria:</strong> <?= htmlspecialchars($receita['categoria'] ?? 'Sem categoria') ?>
                        </p>
                        <div class="receita-resumo">
                            <?php
                            // Pega o modo de preparo completo
                            $modo_preparo_completo = $receita['modo_preparo'];

                            // Define um limite de caracteres para o resumo
                            $limite_caracteres = 1000;

                            // Cria o resumo
                            if (strlen($modo_preparo_completo) > $limite_caracteres) {
                                // Se o texto for longo, corta e adiciona "..."
                                $resumo = substr($modo_preparo_completo, 0, $limite_caracteres) . '...';
                            } else {
                                // Se for curto, exibe o texto completo
                                $resumo = $modo_preparo_completo;
                            }

                            echo '<p>' . nl2br(htmlspecialchars($resumo)) . '</p>';
                            ?>
                        </div>

                        <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $receita['usuario_id']): ?>
                            <div class="receita-acoes">
                                <a href="<?php echo BASE_URL ?>?pagina=receitas&acao=editar&id=<?= $receita['id'] ?>" class="btn-editar">Editar</a>
                                <form method="POST" action="<?php echo BASE_URL ?>?pagina=receitas&acao=deletar" style="display: inline;" onsubmit="return confirm('Tem certeza?');">
                                    <input type="hidden" name="id" value="<?= $receita['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= gerar_token_csrf() ?>">
                                    <button type="submit" class="btn-excluir">Excluir</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>2025. Site de Receitas. Todos os direitos reservados para os quatro que fizeram. O site. Esse site. Esse site que você tá lendo agora.</p>
    </footer>
</body>

</html>