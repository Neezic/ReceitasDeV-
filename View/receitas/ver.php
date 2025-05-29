<h1><?= htmlspecialchars($receita['titulo']) ?></h1>

<div class="receita-detalhes">
    <p><strong>Ingredientes:</strong></p>
    <p><?= nl2br(htmlspecialchars($receita['ingredientes'])) ?></p>
    
    <p><strong>Modo de Preparo:</strong></p>
    <p><?= nl2br(htmlspecialchars($receita['modo_preparo'])) ?></p>
    
    <p>Tempo: <?= $receita['tempo_preparo'] ?> minutos</p>
    <p>Dificuldade: <?= $receita['dificuldade'] ?></p>
    <p>Criado em: <?= date('d/m/Y H:i', strtotime($receita['criado_em'])) ?></p>
</div>

<a href="/?pagina=receitas">Voltar para lista</a>