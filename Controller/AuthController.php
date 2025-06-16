<?php
session_start();
require_once 'Config/banco.php';
require_once 'Model/Usuario.php';
require_once 'Config/csrf.php';

class AuthController{
    private $usuarioModel;
    private $pdo;

    public function __construct() {
        global $pdo; 
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($this->pdo);
    }
    public function index() {
        $this->exibirLogin();
    }

    public function exibirLogin() {
        $csrf_token = gerar_token_csrf();
        
        require 'View/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?pagina=login');
            exit;
        }

        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
            $_SESSION['erro'] = "Erro de validação de segurança. Tente novamente.";
            $this->exibirLogin();
            exit;
        }

        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        $usuarioEncontrado = $this->usuarioModel->buscarPorEmail($email);
    
        if ($usuarioEncontrado && password_verify($senha, $usuarioEncontrado['senha'])) {
            unset($usuarioEncontrado['senha']);
            $_SESSION['usuario'] = $usuarioEncontrado;
            header('Location: ' . BASE_URL . '?pagina=home');
        } else {
            $_SESSION['erro'] = "E-mail ou senha inválidos!";
            $this->exibirLogin();
        }
        exit;
    }

    public function cadastro() {
        $csrf_token = gerar_token_csrf();

        require 'View/auth/cadastro.php';
    }

    public function salvarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '?pagina=login&acao=cadastro');
        exit;
        }

        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
        $_SESSION['mensagem_erro'] = "Erro de validação de segurança. Tente novamente.";
        header('Location: ' . BASE_URL . '?pagina=login&acao=cadastro');
        exit;
        }

    
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $cpf = trim($_POST['cpf'] ?? '');
        $data_nascimento = trim($_POST['data_nascimento'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $senha_confirmacao = $_POST['senha_confirmacao'] ?? ''; // Requer o campo do Passo 2

        $erros = [];
        if (empty($nome) || empty($email) || empty($senha) || empty($cpf) || empty($data_nascimento)) {
        $erros[] = "Todos os campos são obrigatórios.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O formato do e-mail é inválido.";
        }
        if ($this->usuarioModel->emailExiste($email)) {
        $erros[] = "Este e-mail já está cadastrado em nosso sistema.";
        }
        if (strlen($senha) < 6) {
        $erros[] = "A senha deve ter no mínimo 6 caracteres.";
        }
        if ($senha !== $senha_confirmacao) { 
        $erros[] = "As senhas não coincidem.";
        }

        if (!empty($erros)) {
        $_SESSION['mensagem_erro'] = implode('<br>', $erros);
        header('Location: ' . BASE_URL . '?pagina=login&acao=cadastro');
        exit;
        }

        $dados_usuario = [
        'nome' => $nome,
        'email' => $email,
        'cpf' => $cpf,
        'data_nascimento' => $data_nascimento,
        'senha' => $senha 
        ];
        $sucesso = $this->usuarioModel->criar($dados_usuario);

        if ($sucesso) {
        $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Por favor, faça o login.";
        header('Location: ' . BASE_URL . '?pagina=login');
        } else {
        $_SESSION['mensagem_erro'] = "Ocorreu um erro inesperado ao realizar o cadastro. Tente novamente.";
        header('Location: ' . BASE_URL . '?pagina=login&acao=cadastro');
        }
        exit;
    }


    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '?pagina=home');
        exit;
    }



    public function solicitarRecuperacao() {
        $csrf_token = gerar_token_csrf();
        require 'View/auth/solicitar_recuperacao.php';
    }
    
    public function verificarDados() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?pagina=login&acao=solicitarRecuperacao');
            exit;
        }
        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
            $_SESSION['erro'] = "Erro de validação de segurança.";
            header('Location: ' . BASE_URL . '?pagina=login&acao=solicitarRecuperacao');
            exit;
        }
    
        $cpf = $_POST['cpf'] ?? '';
        $data_nascimento = $_POST['data_nascimento'] ?? '';
    
        $usuario = $this->usuarioModel->buscarPorCpfEDob($cpf, $data_nascimento);
    
        if ($usuario) {
            $_SESSION['usuario_recuperacao_id'] = $usuario['id'];
            header('Location: ' . BASE_URL . '?pagina=login&acao=redefinirSenha');
        } else {
            
            $_SESSION['erro'] = "Dados não encontrados. Verifique seu CPF e data de nascimento.";
            header('Location: ' . BASE_URL . '?pagina=login&acao=solicitarRecuperacao');
        }
        exit;
    }
    
    public function redefinirSenha() {
        if (!isset($_SESSION['usuario_recuperacao_id'])) {
            header('Location: ' . BASE_URL . '?pagina=login');
            exit;
        }
        $csrf_token = gerar_token_csrf();
        require 'View/auth/redefinir_senha.php';
    }
    public function atualizarSenha() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['usuario_recuperacao_id'])) {
            header('Location: ' . BASE_URL . '?pagina=login');
            exit;
        }
        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
            $_SESSION['erro'] = "Erro de validação de segurança.";
            header('Location: ' . BASE_URL . '?pagina=login&acao=redefinirSenha');
            exit;
        }
    
        $senha = $_POST['senha'] ?? '';
        $senha_confirmacao = $_POST['senha_confirmacao'] ?? '';
    
        if (strlen($senha) < 6) {
            $_SESSION['erro'] = "A nova senha deve ter no mínimo 6 caracteres.";
            header('Location: ' . BASE_URL . '?pagina=login&acao=redefinirSenha');
            exit;
        }
        if ($senha !== $senha_confirmacao) {
            $_SESSION['erro'] = "As senhas não coincidem.";
            header('Location: ' . BASE_URL . '?pagina=login&acao=redefinirSenha');
            exit;
        }
    
        $id_usuario = $_SESSION['usuario_recuperacao_id'];
        $sucesso = $this->usuarioModel->atualizarSenha($id_usuario, $senha);
    
        unset($_SESSION['usuario_recuperacao_id']);
    
        if ($sucesso) {
            $_SESSION['sucesso'] = "Senha redefinida com sucesso! Você já pode fazer o login.";
            header('Location: ' . BASE_URL . '?pagina=login');
        } else {
            $_SESSION['erro'] = "Ocorreu um erro ao atualizar sua senha. Tente novamente.";
            header('Location: ' . BASE_URL . '?pagina=login&acao=redefinirSenha');
        }
        exit;
    }
}
?>
