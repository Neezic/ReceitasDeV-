<?php
session_start();
require_once '../Config/banco.php';
require_once '../Model/Usuario.php';
require_once '../Config/csrf.php';


if ($_POST && isset($_POST['acao']) && $_POST['acao'] == 'login') {
    if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
        $erro = "Erro de validação. Por favor, tente novamente.";
        $csrf_token = gerar_token_csrf(); 
        include 'view/login.php';
        exit;
    }
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuarioModel = new Usuario($pdo);
    $usuarioEncontrado = $usuarioModel -> buscarPorEmail($email);

    if ($usuarioEcontrado && password_verify($senha,$usuarioEncontrado['senha'])){
        unset($usuarioEncontrado['senha']);
        $_SESSION['usuario'] = $usuarioEcontrado;
        header('Location: ?pagina=home');
        exit;
    } else {
        $erro ="Email ou senha invalidos!";
        include '../View/login.php';
        exit;
    }
    
   
}
$csrf_token = gerar_token_csrf();
include '../View/login.php';
?>
