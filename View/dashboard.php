<h2>Tarefas <?=$nomeUsuario?>:</h2>

<?php foreach ($tarefas as $key => $tarefa): ?>
    <li> 
        <?=$tarefa->texto?>;
        <a href='apagar/<?=$tarefa->id?>'>[apagar]</a>
        <a href='editar/<?=$tarefa->id?>'>[editar]</a>
    </li>
<?php  endforeach; ?>

<hr>
<form action="add" method="post">
    Nova Tarefa: <input type="text" name="nova-tarefa">
    <input type="submit" value="Salvar">
</form>