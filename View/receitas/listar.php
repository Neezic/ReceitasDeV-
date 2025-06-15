<h1>Lista de Receitas</h1>
<?php
    include_once "./Config/csrf.php";
?>

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
            <p>Dificuldade: <?= $receita['dificuldade'] ?></p>
            <a href="<?=BASE_URL?>?pagina=receitas&acao=ver&id=<?= $receita['id'] ?>">Ver detalhes</a>
            
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $receita['usuario_id']): ?>
                <a href="/?pagina=receitas&acao=editar&id=<?= $receita['id'] ?>">Editar</a>
                <form method="POST" action="/?pagina=receitas&acao=deletar" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?');">
                    <input type="hidden" name="id" value="<?= $receita['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(gerar_token_csrf()) ?>">
                    <button type="submit" class="btn-link">Excluir</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>