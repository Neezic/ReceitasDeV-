<!DOCTYPE html>
<html>
<head>
    <title>Receitas</title>
</head>
<body>
    <h1>Últimas Receitas</h1>
    
    <?php foreach ($receitas as $receita): ?>
        <div class="receita">
            <h2><?= htmlspecialchars($receita['titulo']) ?></h2>
            <p><?= nl2br(htmlspecialchars($receita['descricao'])) ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>