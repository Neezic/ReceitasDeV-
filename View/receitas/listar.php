<h1>Lista de Receitas</h1>

<?php if (isset($_SESSION['sucesso'])): ?>
    <div class="alert success"><?= $_SESSION['sucesso'] ?></div>
    <?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="alert error"><?= $_SESSION['erro'] ?></div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['usuario'])): ?>
    <a href="/?pagina=receitas&acao=criar" class="btn">Nova Receita</a>
<?php endif; ?>

<div class="receitas">
    <?php foreach ($receitas as $receita): ?>
        <div class="receita">
            <h2><?= htmlspecialchars($receita['titulo']) ?></h2>
            <p>Por: <?= htmlspecialchars($receita['usuario_id']) ?></p>
            <p>Tempo: <?= $receita['tempo_preparo'] ?> minutos</p>
            <p>Dificuldade: <?= $receita['dificuldade'] ?></p>
            <a href="/?pagina=receitas&acao=ver&id=<?= $receita['id'] ?>">Ver detalhes</a>
            
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $receita['usuario_id']): ?>
                <a href="/?pagina=receitas&acao=editar&id=<?= $receita['id'] ?>">Editar</a>
                <a href="/?pagina=receitas&acao=deletar&id=<?= $receita['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>