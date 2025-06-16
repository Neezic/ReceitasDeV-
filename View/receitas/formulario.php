<?php
$modo_edicao = isset($receita) && !empty($receita);
$titulo_pagina = $modo_edicao ? 'Editar Receita' : 'Criar Nova Receita';
$url_acao = BASE_URL . '?pagina=receitas&acao=' . ($modo_edicao ? 'atualizar&id=' . htmlspecialchars($receita['id']) : 'salvar');

$valor_titulo = $modo_edicao ? $receita['titulo'] : '';
$valor_ingredientes = $modo_edicao ? $receita['ingredientes'] : '';
$valor_modo_preparo = $modo_edicao ? $receita['modo_preparo'] : '';
$valor_dificuldade = $modo_edicao ? $receita['dificuldade'] : 'médio';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo_pagina ?></title>
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
        <div class="form-content">
            <h2><?= $titulo_pagina ?></h2>

            <?php if (isset($_SESSION['erro'])): ?>
                <div class='alerta erro'><?= $_SESSION['erro']; ?></div>
                <?php unset($_SESSION['erro']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= $url_acao ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                <div class="form-group">
                    <label for="titulo">Título da Receita:</label>
                    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($valor_titulo) ?>" required>
                </div>

                <div class="form-group">
                    <label for="ingredientes">Ingredientes:</label>
                    <textarea id="ingredientes" name="ingredientes" rows="8" required><?= htmlspecialchars($valor_ingredientes) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="modo_preparo">Modo de Preparo:</label>
                    <textarea id="modo_preparo" name="modo_preparo" rows="8" required><?= htmlspecialchars($valor_modo_preparo) ?></textarea>
                </div>

                <div class="grupo-formulario">
                    <label for="categoria_id">Categoria:</label>
                    <select id="categoria_id" name="categoria_id">
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= (isset($receita) && $receita['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categoria['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo-formulario">
                    <label for="nova_categoria">Ou crie uma nova categoria:</label>
                    <input type="text" id="nova_categoria" name="nova_categoria" placeholder="Ex: Sobremesas, Lanches, etc.">
                    <small>Deixe em branco se você selecionou uma categoria da lista acima.</small>
                </div>

                <div class="form-group">
                    <label for="dificuldade">Dificuldade:</label>
                    <select id="dificuldade" name="dificuldade">
                        <option value="fácil" <?= $valor_dificuldade == 'fácil' ? 'selected' : '' ?>>Fácil</option>
                        <option value="médio" <?= $valor_dificuldade == 'médio' ? 'selected' : '' ?>>Médio</option>
                        <option value="difícil" <?= $valor_dificuldade == 'difícil' ? 'selected' : '' ?>>Difícil</option>
                    </select>
                </div>

                <button type="submit">Salvar Receita</button>
            </form>
        </div>
    </main>

    <footer>
        <p>2025. Site de Receitas. Todos os direitos reservados para os quatro que fizeram. O site. Esse site. Esse site que você tá lendo agora.</p>
    </footer>
</body>

</html>