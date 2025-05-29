<?php
// Inicia a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui a conexão com o banco
require_once '../Config/banco.php';

class ReceitaController {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * Lista todas as receitas
     */
    public function index() {
        $stmt = $this->pdo->query("SELECT * FROM receitas ORDER BY criado_em DESC");
        $receitas = $stmt->fetchAll();
        
        include '../View/receitas/listar.php';
    }
    
    /**
     * Mostra uma receita específica
     */
    public function ver($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM receitas WHERE id = ?");
        $stmt->execute([$id]);
        $receita = $stmt->fetch();
        
        if (!$receita) {
            header("Location: /?pagina=receitas");
            exit;
        }
        
        include '../View/receitas/ver.php';
    }
    
    /**
     * Exibe o formulário de criação
     */
    public function criar() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?pagina=login");
            exit;
        }
        
        include '../View/receitas/formulario.php';
    }
    
    /**
     * Processa o formulário de criação
     */
    public function salvar() {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?pagina=login");
            exit;
        }
        
        // Validação básica
        if (empty($_POST['titulo']) || empty($_POST['ingredientes']) || empty($_POST['modo_preparo'])) {
            $_SESSION['erro'] = "Preencha todos os campos obrigatórios!";
            header("Location: /?pagina=receitas&acao=criar");
            exit;
        }
        
        // Prepara os dados
        $dados = [
            'titulo' => $_POST['titulo'],
            'ingredientes' => $_POST['ingredientes'],
            'modo_preparo' => $_POST['modo_preparo'],
            'tempo_preparo' => $_POST['tempo_preparo'] ?? 0,
            'dificuldade' => $_POST['dificuldade'] ?? 'médio',
            'usuario_id' => $_SESSION['usuario']['id']
        ];
        
        // Insere no banco
        $stmt = $this->pdo->prepare("INSERT INTO receitas (titulo, ingredientes, modo_preparo, tempo_preparo, dificuldade, usuario_id) 
                                    VALUES (:titulo, :ingredientes, :modo_preparo, :tempo_preparo, :dificuldade, :usuario_id)");
        
        if ($stmt->execute($dados)) {
            $_SESSION['sucesso'] = "Receita criada com sucesso!";
            header("Location: /?pagina=receitas");
        } else {
            $_SESSION['erro'] = "Erro ao criar receita!";
            header("Location: /?pagina=receitas&acao=criar");
        }
        exit;
    }
    
    /**
     * Exibe o formulário de edição
     */
    public function editar($id) {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?pagina=login");
            exit;
        }
        
        $stmt = $this->pdo->prepare("SELECT * FROM receitas WHERE id = ?");
        $stmt->execute([$id]);
        $receita = $stmt->fetch();
        
        // Verifica se a receita existe e pertence ao usuário
        if (!$receita || $receita['usuario_id'] != $_SESSION['usuario']['id']) {
            header("Location: /?pagina=receitas");
            exit;
        }
        
        include '../View/receitas/formulario.php';
    }
    
    /**
     * Processa o formulário de edição
     */
    public function atualizar($id) {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?pagina=login");
            exit;
        }
        
        // Validação básica
        if (empty($_POST['titulo']) || empty($_POST['ingredientes']) || empty($_POST['modo_preparo'])) {
            $_SESSION['erro'] = "Preencha todos os campos obrigatórios!";
            header("Location: /?pagina=receitas&acao=editar&id=$id");
            exit;
        }
        
        // Verifica se a receita pertence ao usuário
        $stmt = $this->pdo->prepare("SELECT usuario_id FROM receitas WHERE id = ?");
        $stmt->execute([$id]);
        $receita = $stmt->fetch();
        
        if (!$receita || $receita['usuario_id'] != $_SESSION['usuario']['id']) {
            header("Location: /?pagina=receitas");
            exit;
        }
        
        // Prepara os dados
        $dados = [
            'id' => $id,
            'titulo' => $_POST['titulo'],
            'ingredientes' => $_POST['ingredientes'],
            'modo_preparo' => $_POST['modo_preparo'],
            'tempo_preparo' => $_POST['tempo_preparo'] ?? 0,
            'dificuldade' => $_POST['dificuldade'] ?? 'médio'
        ];
        
        // Atualiza no banco
        $stmt = $this->pdo->prepare("UPDATE receitas SET 
                                    titulo = :titulo, 
                                    ingredientes = :ingredientes, 
                                    modo_preparo = :modo_preparo, 
                                    tempo_preparo = :tempo_preparo, 
                                    dificuldade = :dificuldade, 
                                    atualizado_em = NOW() 
                                    WHERE id = :id");
        
        if ($stmt->execute($dados)) {
            $_SESSION['sucesso'] = "Receita atualizada com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar receita!";
        }
        
        header("Location: /?pagina=receitas&acao=ver&id=$id");
        exit;
    }
    
    /**
     * Remove uma receita
     */
    public function deletar($id) {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /?pagina=login");
            exit;
        }
        
        // Verifica se a receita pertence ao usuário
        $stmt = $this->pdo->prepare("SELECT usuario_id FROM receitas WHERE id = ?");
        $stmt->execute([$id]);
        $receita = $stmt->fetch();
        
        if (!$receita || $receita['usuario_id'] != $_SESSION['usuario']['id']) {
            header("Location: /?pagina=receitas");
            exit;
        }
        
        // Remove do banco
        $stmt = $this->pdo->prepare("DELETE FROM receitas WHERE id = ?");
        
        if ($stmt->execute([$id])) {
            $_SESSION['sucesso'] = "Receita removida com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao remover receita!";
        }
        
        header("Location: /?pagina=receitas");
        exit;
    }
}

// Cria a instância do controller
$controller = new ReceitaController();

// Roteamento simples
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    $id = $_GET['id'] ?? null;
    
    switch ($acao) {
        case 'ver':
            $controller->ver($id);
            break;
        case 'criar':
            $controller->criar();
            break;
        case 'salvar':
            $controller->salvar();
            break;
        case 'editar':
            $controller->editar($id);
            break;
        case 'atualizar':
            $controller->atualizar($id);
            break;
        case 'deletar':
            $controller->deletar($id);
            break;
        default:
            $controller->index();
    }
} else {
    $controller->index();
}