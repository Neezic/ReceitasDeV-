<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'Config/csrf.php';
require_once 'Config/banco.php';
require_once 'Model/Receita.php';
require_once 'Model/Categoria.php';

class ReceitasController {
    private $pdo;
    private $receitaModel;
    private $categoriaModel;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->receitaModel = new Receita($pdo);
        $this->categoriaModel = new Categoria($pdo);
    }
    
    public function index() {
        $termo_busca = $_GET['busca'] ?? null;
        $receitas = [];

        // Se houver um termo de busca, chama o método de busca no model
        if ($termo_busca) {
        // Remove espaços em branco extras do termo
        $termo_busca = trim($termo_busca);
        // Chama o novo método que vamos criar no model
        $receitas = $this->receitaModel->buscarPorTermo($termo_busca);
        } else {
        // Se não houver busca, lista todas as receitas como antes
        $receitas = $this->receitaModel->listarTodas();
        }
    
        require './View/receitas/listar.php';
    }
    

    public function ver($id) {
        if ($id === null){
            $receita = $this->receitaModel->buscarPorId((int)$id);
        }

        if (!$receita) {
            header("Location: ". BASE_URL. "?pagina=receitas");
            exit;
        }
        
        include './View/receitas/ver.php';
    }

    public function salvar() {

        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
        $_SESSION['erro'] = "Erro de validação (CSRF). Tente novamente.";
        header("Location: " . BASE_URL . "?pagina=receitas&acao=criar");
        exit;
        }

        if (!isset($_SESSION['usuario'])) {
        header("Location: " . BASE_URL . "?pagina=login");
        exit;
        }
    
        if (empty($_POST['titulo']) || empty($_POST['ingredientes']) || empty($_POST['modo_preparo'])) {
        $_SESSION['erro'] = "Preencha todos os campos obrigatórios!";
        header("Location: " . BASE_URL . "?pagina=receitas&acao=criar");
        exit;
        }
    
        $categoria_id = $_POST['categoria_id'] ?? null;// pega os dados da categoria do formulário
        $nova_categoria = trim($_POST['nova_categoria'] ?? '');

        if (!empty($nova_categoria)) {
        $categoria_id = $this->categoriaModel->criar($nova_categoria);
        
        if (!$categoria_id) {
            $_SESSION['erro'] = "Ocorreu um erro ao tentar criar a nova categoria.";
            header("Location: " . BASE_URL . "?pagina=receitas&acao=criar");
            exit;
        }
        } elseif (empty($categoria_id)) {
        $_SESSION['erro'] = "É obrigatório selecionar uma categoria";
        header("Location: " . BASE_URL . "?pagina=receitas&acao=criar");
        exit;
        }
    
        $dadosReceita = [
        'titulo' => $_POST['titulo'],
        'ingredientes' => $_POST['ingredientes'],
        'modo_preparo' => $_POST['modo_preparo'],
        'dificuldade' => $_POST['dificuldade'] ?? 'médio',
        'usuario_id' => $_SESSION['usuario']['id'],
        'categoria_id' => $categoria_id 
        ];
    
        $novoId = $this->receitaModel->criar($dadosReceita);

        if ($novoId) {
        $_SESSION['sucesso'] = "Receita criada com sucesso!";
        header("Location: " . BASE_URL . "?pagina=receitas");
        } else {
        $_SESSION['erro'] = "Erro ao criar receita!";
        header("Location: " . BASE_URL . "?pagina=receitas&acao=criar");
        }
        exit;
    }

    public function atualizar($id) {

        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
            $_SESSION['erro'] = "Erro de validação (CSRF). Tente novamente.";
            header("Location: ". BASE_URL ."?pagina=receitas&acao=editar&id=$id");
            exit;
        }   
        if ($id === null) { header("Location: /?pagina=receitas"); exit; }
        $idReceita = (int)$id;


        if (!isset($_SESSION['usuario'])) { 
            header("Location: ". BASE_URL ."?pagina=login");
            exit;
         }
        $idUsuarioLogado = $_SESSION['usuario']['id'];

        if (empty($_POST['titulo']) || empty($_POST['ingredientes']) || empty($_POST['modo_preparo'])) {
            $_SESSION['erro'] = "Preencha todos os campos obrigatórios!";
            header("Location: ". BASE_URL ."?pagina=receitas&acao=editar&id=$idReceita");
            exit;
        }

        $donoReceita = $this->receitaModel->buscarDonoReceita($idReceita);
        if (!$donoReceita || $donoReceita != $idUsuarioLogado) {
            $_SESSION['erro'] = "Você não tem permissão para editar esta receita.";
            header("Location: ". BASE_URL ."?pagina=receitas");
            exit;
        }
        
        $dadosAtualizar = [
            'titulo' => $_POST['titulo'],
            'ingredientes' => $_POST['ingredientes'],
            'modo_preparo' => $_POST['modo_preparo'],
            'tempo_preparo' => $_POST['tempo_preparo'] ?? 0,
            'dificuldade' => $_POST['dificuldade'] ?? 'médio'
            
        ];
        
        if ($this->receitaModel->atualizar($idReceita, $dadosAtualizar, $idUsuarioLogado)) {
            $_SESSION['sucesso'] = "Receita atualizada com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar receita ou nenhuma alteração detectada.";
        }
        
        header("Location: ". BASE_URL ."?pagina=receitas&acao=ver&id=$idReceita");
        exit;
    }

    public function deletar(){

        if (!validar_token_csrf($_POST['csrf_token'] ?? null)) {
            $_SESSION['erro'] = "Erro de validação (CSRF).";
            header("Location: ". BASE_URL ."?pagina=receitas");
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
        header("Location: ". BASE_URL ."?pagina=receitas");
        exit;
        }
        if (!isset($_SESSION['usuario'])) { 
            header("Location: ". BASE_URL ."?pagina=login");
            exit;
        }
        $idUsuarioLogado = $_SESSION['usuario']['id'];

        $donoReceita = $this->receitaModel->buscarDonoReceita($id);
        if (!$donoReceita || $donoReceita != $idUsuarioLogado) {
            $_SESSION['erro'] = "Você não tem permissão para remover esta receita.";
            header("Location: ". BASE_URL ."?pagina=receitas");
            exit;
        }

        if ($this->receitaModel->deletar($id, $idUsuarioLogado)) {
            $_SESSION['sucesso'] = "Receita removida com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao remover receita.";
        }
        
        header("Location: ". BASE_URL ."?pagina=receitas");
        exit;
    }


    public function criar() { 
        if (!isset($_SESSION['usuario'])) {
            header("Location: <?=BASE_URL?>?pagina=login");
            exit;
        }
        $categorias = $this->categoriaModel->listarTodas();
        $csrf_token = gerar_token_csrf();
        $receita = null; 
        include './View/receitas/formulario.php';
    }


    public function editar($id) { 
        if ($id === null) { header("Location: ". BASE_URL. "?pagina=receitas"); exit; }
        $idReceita = (int)$id;

        if (!isset($_SESSION['usuario'])) {
            header("Location: ". BASE_URL .">?pagina=login");
            exit;
        }
        $idUsuarioLogado = $_SESSION['usuario']['id'];

        $receita = $this->receitaModel->buscarPorId($idReceita);
        
        if (!$receita || $receita['usuario_id'] != $idUsuarioLogado) {
            $_SESSION['erro'] = "Receita não encontrada ou você não tem permissão para editá-la.";
            header("Location: ".BASE_URL."?pagina=receitas");
            exit;
        }
        $categorias = $this->categoriaModel->listarTodas();
        $csrf_token = gerar_token_csrf();
        include './View/receitas/formulario.php';  
        
    }
    
}

?>