<?php
// Supondo que você tenha um arquivo que define a BASE_URL e inicia a sessão
// Se não, podemos fazer manualmente por enquanto.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('BASE_URL', '/ReceitasDeV-/'); // Defina a URL base do seu projeto aqui!

// Simula a estrutura de sessão que o seu Controller espera
$_SESSION['usuario'] = [
    'id' => 1, // Use um ID de um usuário que exista no seu banco
    'nome' => 'Chef Conectado' // Opcional, para exibição
];

echo "<h1>Login Falso (Versão 2.0) Realizado!</h1>";
echo "<p>Você está logado como usuário de ID 1.</p>";

// Este é o link correto para ACESSAR o formulário de criação
echo '<p><a href="' . BASE_URL . 'index.php?pagina=receitas&acao=criar">Cadastrar Nova Receita</a></p>';
?>