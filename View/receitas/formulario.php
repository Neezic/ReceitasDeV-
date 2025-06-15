
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
<?php

// Lógica para facilitar a leitura e preenchimento dos campos do formulário
$modo_edicao = isset($receita) && !empty($receita);

// Define o título da página e a URL de ação do formulário dinamicamente
$titulo_pagina = $modo_edicao ? 'Editar Receita' : 'Criar Nova Receita';
$url_acao = '<?=BASE_URL?>?pagina=receitas&acao=' . ($modo_edicao ? 'atualizar&id=' . htmlspecialchars($receita['id']) : 'criar');

// Preenche os valores dos campos, usando dados da receita ou valores padrão
$valor_titulo = $modo_edicao ? $receita['titulo'] : '';
$valor_ingredientes = $modo_edicao ? $receita['ingredientes'] : '';
$valor_modo_preparo = $modo_edicao ? $receita['modo_preparo'] : '';
$valor_dificuldade = $modo_edicao ? $receita['dificuldade'] : 'médio';

?>

<h1><?= $titulo_pagina ?></h1>

<form method="POST" action="<?= $url_acao ?>" class="formulario-receita">
    
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

    <div class="grupo-formulario">
        <label for="titulo">Título da Receita:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($valor_titulo) ?>" required>
    </div>
    
    <div class="grupo-formulario">
        <label for="ingredientes">Ingredientes:</label>
        <textarea id="ingredientes" name="ingredientes" rows="10" required><?= htmlspecialchars($valor_ingredientes) ?></textarea>
        <small>Dica: Coloque um ingrediente por linha para facilitar a leitura.</small>
    </div>
    
    <div class="grupo-formulario">
        <label for="modo_preparo">Modo de Preparo:</label>
        <textarea id="modo_preparo" name="modo_preparo" rows="10" required><?= htmlspecialchars($valor_modo_preparo) ?></textarea>
    </div>
    
    <div class="grupo-formulario">
        <label for="dificuldade">Dificuldade:</label>
        <select id="dificuldade" name="dificuldade">
            <option value="fácil" <?= $valor_dificuldade == 'fácil' ? 'selected' : '' ?>>Fácil</option>
            <option value="médio" <?= $valor_dificuldade == 'médio' ? 'selected' : '' ?>>Médio</option>
            <option value="difícil" <?= $valor_dificuldade == 'difícil' ? 'selected' : '' ?>>Difícil</option>
        </select>
    </div>
    
    <div class="acoes-formulario">
        <button type="submit" class="btn-principal">Salvar Receita</button>
        <a href="/?pagina=receitas" class="btn-secundario">Cancelar</a>
    </div>
</form>

<style>
    .formulario-receita {
        max-width: 700px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    .grupo-formulario {
        margin-bottom: 20px;
    }
    .grupo-formulario label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .grupo-formulario input[type="text"],
    .grupo-formulario input[type="number"],
    .grupo-formulario textarea,
    .grupo-formulario select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* Importante para o padding não alterar a largura total */
    }
    .grupo-formulario small {
        display: block;
        margin-top: 5px;
        color: #777;
    }
    .acoes-formulario {
        margin-top: 30px;
    }
    .acoes-formulario .btn-principal,
    .acoes-formulario .btn-secundario {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
    }
    .acoes-formulario .btn-principal {
        background-color: #28a745; /* Verde */
        color: white;
    }
    .acoes-formulario .btn-secundario {
        background-color: #6c757d; /* Cinza */
        color: white;
        margin-left: 10px;
    }
</style>