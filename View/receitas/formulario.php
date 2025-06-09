require __DIR__ 
<h1><?= isset($receita) ? 'Editar' : 'Criar' ?> Receita</h1>


<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">


<form method="POST" action="/?pagina=receitas&acao=<?= isset($receita) ? 'atualizar&id='.$receita['id'] : 'salvar' ?>">
    <div>
        <label>Título:</label>
        <input type="text" name="titulo" value="<?= isset($receita) ? htmlspecialchars($receita['titulo']) : '' ?>" required>
    </div>
    
    <div>
        <label>Ingredientes:</label>
        <textarea name="ingredientes" required><?= isset($receita) ? htmlspecialchars($receita['ingredientes']) : '' ?></textarea>
    </div>
    
    <div>
        <label>Modo de Preparo:</label>
        <textarea name="modo_preparo" required><?= isset($receita) ? htmlspecialchars($receita['modo_preparo']) : '' ?></textarea>
    </div>
    
    <div>
        <label>Tempo de Preparo (minutos):</label>
        <input type="number" name="tempo_preparo" value="<?= isset($receita) ? $receita['tempo_preparo'] : '30' ?>">
    </div>
    
    <div>
        <label>Dificuldade:</label>
        <select name="dificuldade">
            <option value="fácil" <?= isset($receita) && $receita['dificuldade'] == 'fácil' ? 'selected' : '' ?>>Fácil</option>
            <option value="médio" <?= isset($receita) && $receita['dificuldade'] == 'médio' ? 'selected' : '' ?>>Médio</option>
            <option value="difícil" <?= isset($receita) && $receita['dificuldade'] == 'difícil' ? 'selected' : '' ?>>Difícil</option>
        </select>
    </div>
    
    <button type="submit">Salvar</button>
</form>

<a href="/?pagina=receitas">Cancelar</a>