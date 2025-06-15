<?php

if (!isset($_GET['acao'])) {
    $sql = "SELECT * FROM receitas ORDER BY criado_em DESC LIMIT 3";
    $receitas = $pdo->query($sql)->fetchAll();
    
    include './View/home.php';
    exit;
}

// Página "sobre"
if ($_GET['acao'] == 'sobre') {
    include './View/sobre.php';
    exit;
}
?>





