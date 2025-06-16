<?php
session_start();

define('BASE_URL', '/ReceitasDeV-/');
require_once 'Config/banco.php';
require_once 'Config/csrf.php';





$pagina = $_GET['pagina'] ?? 'home';
$acao = $_GET['acao'] ?? 'index';
$id = $_GET['id'] ?? null;



if ($pagina === 'sobre') {
    $caminho_view = 'View/sobre.php';
    if (file_exists($caminho_view)) {
        require_once $caminho_view;
    } else {
        http_response_code(404);
        echo "<h1>Erro 404: A página 'Sobre' não foi encontrada.</h1>";
    }
    exit(); 
}

$controllers = [
    'home'     => 'HomeController',
    'receitas' => 'ReceitasController',
    'login'    => 'AuthController'
];


if (!array_key_exists($pagina, $controllers)) {
    http_response_code(404);
    echo "<h1>Erro 404: Página não encontrada.</h1>";
    exit();
}


$controllerFile = 'Controller/' . $controllers[$pagina] . '.php';
$controllerClass = $controllers[$pagina];


if (file_exists($controllerFile)) {
    require_once $controllerFile;

    
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        
        if (method_exists($controller, $acao)) {
            
            if ($id !== null) {
                $controller->$acao($id);
            } else {
                $controller->$acao();
            }
        } else {
            http_response_code(404);
            echo "<h1>Erro 404: Ação '" . htmlspecialchars($acao) . "' não foi encontrada neste controller.</h1>";
        }
    } else {
        http_response_code(500);
        echo "<h1>Erro 500: A classe '" . htmlspecialchars($controllerClass) . "' não foi encontrada no arquivo do controller.</h1>";
    }
} else {
    http_response_code(500);
    echo "<h1>Erro 500: O arquivo do controller '" . htmlspecialchars($controllerFile) . "' não foi encontrado.</h1>";
}