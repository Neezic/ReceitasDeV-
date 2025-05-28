<?php

require_once __DIR__ . "/../Model/Usuario.php";

class HomeController {
    
    static function login() {

        session_start();

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $usuario_formulario = $_POST['usuario'] ?? null;
            $senha_formulario = $_POST['senha'] ?? null;

            if (is_null($usuario_formulario) || is_null($senha_formulario)) {
                echo "Fazer Login...";
            } else {

                $resp = Usuario::fazerLogin($usuario_formulario, $senha_formulario);

                if ($resp) {
                    echo "Sucesso!";
                    header("Location: dashboard");
                } else {
                    echo "Erro X.x";
                }
            }
        }

        include __DIR__ . "/../View/login.php";
    }


    static function index() {
        HomeController::login();
    }


}
