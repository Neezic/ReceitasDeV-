<?php
define('BASE_URL', '/ReceitasDeV-/');

$host = 'localhost:3306'; // mudar a porta conforme for preciso 
$dbname = 'receitas';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';// suportar todas as letras e emojis

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,// para o código quando ha um ero
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// Retorna arrays associativo
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

?>