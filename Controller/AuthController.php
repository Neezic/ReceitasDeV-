<?php
session_start();
require_once '../Config/banco.php';
require_once '../Model/Usuario.php';

if ($_POST && isset($_POST['acao']) && $_POST['acao'] == 'login') {
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

include 'view/login.php';
?>
