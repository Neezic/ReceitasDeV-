<?php
session_start();

require_once __DIR__ . 'Config/banco.php';
require_once __DIR__ . 'Model/Usuario.php';

class UserController {

    public function processarCadastro() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../View/cadastro.php');
            exit;
        }// verifica se o post deu certp 

        $nome = $_POST['nome'] ?? null;
        $email = $_POST['email'] ?? null;
        $cpf = $_POST['cpf'] ?? null;
        $data_nascimento = $_POST['data_nascimento'] ?? null;
        $senha = $_POST['senha'] ?? null;

        if (empty($nome) || empty($email) || empty($cpf) || empty($data_nascimento) || empty($senha)) {
            $_SESSION['mensagem_erro'] = "Todos os campos são obrigatórios!";
            header('Location: ../View/cadastro.php?status=erro_validacao');
            exit;
        }// verifica se tudo foi preenchido
        
        global $pdo; //puxa do banco
        
        $usuarioModel = new Usuario($pdo);

        $sucesso = $usuarioModel->cadastrar($nome, $email, $cpf, $data_nascimento, $senha);

        if ($sucesso) {
            // se o cadastro foi bem-sucedido, redireciona para o login com mensagem de sucesso
            $_SESSION['mensagem_sucesso'] = "Cadastro realizado com sucesso! Faça o login.";
            header('Location: ../View/login.php?status=sucesso');
            exit;
        } else {
            // se houve um erro direciona a mensagem de erro
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar. O e-mail ou CPF já pode estar em uso.";
            header('Location: ../View/cadastro.php?status=erro_banco');
            exit;
        }
    }
}