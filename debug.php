<?php
// Ativa todos os erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicia a sessão
session_start();

// Conexão com o banco
require_once 'config/banco.php';

echo '<!DOCTYPE html>
<html>
<head>
    <title>Debug do Sistema</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        h1 { color: #333; }
        h2 { color: #555; margin-top: 0; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Debug do Sistema</h1>';

// Seção 1: Informações do Servidor
echo '<div class="section">
    <h2>Informações do Servidor</h2>
    <table>
        <tr><th>Variável</th><th>Valor</th></tr>';

$serverVars = [
    'PHP Version' => PHP_VERSION,
    'Server Software' => $_SERVER['SERVER_SOFTWARE'],
    'Request Method' => $_SERVER['REQUEST_METHOD'],
    'Request URI' => $_SERVER['REQUEST_URI'],
    'Script Name' => $_SERVER['SCRIPT_NAME']
];

foreach ($serverVars as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>";
}

echo '</table></div>';

// Seção 2: Parâmetros da Requisição
echo '<div class="section">
    <h2>Parâmetros Recebidos</h2>
    <h3>GET</h3>
    <pre>' . print_r($_GET, true) . '</pre>
    <h3>POST</h3>
    <pre>' . print_r($_POST, true) . '</pre>
    <h3>FILES</h3>
    <pre>' . print_r($_FILES, true) . '</pre>
</div>';

// Seção 3: Sessão Atual
echo '<div class="section">
    <h2>Dados da Sessão</h2>
    <pre>' . print_r($_SESSION, true) . '</pre>
</div>';

// Seção 4: Configuração do Banco (ocultando senha)
if (file_exists('config/banco.php')) {
    $bancoConfig = file_get_contents('config/banco.php');
    $bancoConfig = preg_replace('/\'password\' => \'.*?\'/', "'password' => '*****'", $bancoConfig);
    
    echo '<div class="section">
        <h2>Configuração do Banco</h2>
        <pre>' . htmlspecialchars($bancoConfig) . '</pre>
    </div>';
}

// Seção 5: Teste de Conexão com o Banco
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $stmt = $pdo->query("SELECT DATABASE() as db, USER() as user");
    $dbInfo = $stmt->fetch();
    
    echo '<div class="section">
        <h2>Conexão com o Banco</h2>
        <p>Status: <strong style="color: green;">Conectado com sucesso</strong></p>
        <table>
            <tr><th>Banco de Dados</th><td>' . $dbInfo['db'] . '</td></tr>
            <tr><th>Usuário</th><td>' . $dbInfo['user'] . '</td></tr>
        </table>';
    
    // Tabelas existentes
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo '<h3>Tabelas no Banco</h3>
        <ul>';
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo '</ul></div>';
} catch (PDOException $e) {
    echo '<div class="section">
        <h2>Conexão com o Banco</h2>
        <p>Status: <strong style="color: red;">Falha na conexão</strong></p>
        <pre>Erro: ' . $e->getMessage() . '</pre>
    </div>';
}

echo '</body></html>';
?>