<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
function gerar_token_csrf(): string {
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function validar_token_csrf(?string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }

    $token_sessao = $_SESSION['csrf_token'];

    
    unset($_SESSION['csrf_token']); 

    
    return hash_equals($token_sessao, $token);
}




?>