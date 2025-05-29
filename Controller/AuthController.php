<?php
//Sistema de Login

if ($_POST && $_POST['acao'] == 'login') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario;
        header('Location: ?pagina=home');
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
}

include 'view/login.php';
?>
