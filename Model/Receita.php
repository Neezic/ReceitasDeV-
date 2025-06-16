<?php

class Receita {
    private $pdo;
    private $tabela = 'receitas';
    public $id;
    public $usuario_id;
    public $titulo;
    public $ingredientes;
    public $modo_preparo;
    public $dificuldade;
    public $criado_em;
    public $atualizado_em;

    public function __construct(PDO $db){
        $this -> pdo = $db;
    }


    public function listarTodas(int $limit = null, int $offset = 0 ): array {
        $query = "SELECT 
                r.*, 
                c.nome AS nome_categoria 
              FROM 
                " . $this->tabela . " r
              LEFT JOIN 
                categorias c ON r.categoria_id = c.id
              ORDER BY 
                r.criado_em DESC";

        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        $stmt = $this->pdo->prepare($query);

        if ($limit !== null){
            $stmt->bindValue(':limit',$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarCategorias(): array {
    $query = "SELECT * FROM categorias ORDER BY nome ASC";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function buscarPorId(int $id){
        $query = "SELECT * FROM " . $this->tabela . " WHERE id = :id LIMIT 1";
        $stmt = $this ->pdo->prepare($query);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }


    // Dentro da classe Receita em Model/Receita.php

    public function criar(array $dados) {
    // Inicia a transação
    $this->pdo->beginTransaction();

    try {
        // 1. Insere a receita na tabela 'receitas'
        $queryReceita = "INSERT INTO receitas (usuario_id, titulo, ingredientes, modo_preparo, dificuldade,categoria_id) 
                         VALUES (:usuario_id, :titulo, :ingredientes, :modo_preparo, :dificuldade: categoria_id)";

        $stmtReceita = $this->pdo->prepare($queryReceita);
        $stmtReceita->bindValue(':usuario_id', $dados['usuario_id'], PDO::PARAM_INT);
        $stmtReceita->bindValue(':titulo', htmlspecialchars(strip_tags($dados['titulo'])));
        $stmtReceita->bindValue(':ingredientes', htmlspecialchars(strip_tags($dados['ingredientes'])));
        $stmtReceita->bindValue(':modo_preparo', htmlspecialchars(strip_tags($dados['modo_preparo'])));
        $stmtReceita->bindValue(':dificuldade', htmlspecialchars(strip_tags($dados['dificuldade'])));
        $stmtReceita->bindValue(':categoria_id', htmlspecialchars(strip_tags($dados['categoria_id'])));
        $stmtReceita->execute();
        
        // Pega o ID da receita que acabamos de criar
        $receitaId = $this->pdo->lastInsertId();

        // 2. Insere a relação na tabela 'receita_categoria'
        $queryCategoria = "INSERT INTO receita_categoria (receita_id, categoria_id) VALUES (:receita_id, :categoria_id)";
        $stmtCategoria = $this->pdo->prepare($queryCategoria);
        $stmtCategoria->bindValue(':receita_id', $receitaId, PDO::PARAM_INT);
        $stmtCategoria->bindValue(':categoria_id', $dados['categoria_id'], PDO::PARAM_INT);
        $stmtCategoria->execute();

        // Se tudo deu certo, confirma as operações
        $this->pdo->commit();
        
        return $receitaId; // Retorna o ID da nova receita

    } catch (Exception $e) {
        // Se algo deu errado, desfaz tudo
        $this->pdo->rollBack();
        error_log("Erro ao criar receita: " . $e->getMessage()); // Opcional: logar o erro
        return false;
    }
}
    


    public function atualizar( int $id, array $dados, int $usuario_id): bool{

        $query = "UPDATE " . $this->tabela . " SET 
                    titulo = :titulo, 
                    ingredientes = :ingredientes, 
                    modo_preparo = :modo_preparo, 
                    dificuldade = :dificuldade,
                    atualizado_em = NOW() 
                  WHERE id = :id AND usuario_id = :usuario_id";
        
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':titulo', htmlspecialchars(strip_tags($dados['titulo'])));
        $stmt->bindValue(':ingredientes', htmlspecialchars(strip_tags($dados['ingredientes'])));
        $stmt->bindValue(':modo_preparo', htmlspecialchars(strip_tags($dados['modo_preparo'])));
        $stmt->bindValue(':dificuldade', htmlspecialchars(strip_tags($dados['dificuldade'])));
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }

        return false;

    }

    public function deletar (int $id, int $usuario_id): bool{
        $query = "DELETE FROM " . $this->tabela . " WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; 
        }
        return false;
    }

    public function buscarDonoReceita(int $id){
        $query = "SELECT usuario_id FROM " . $this->tabela . " WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['usuario_id'];
        }
        return false;
    }
    public function buscarPorTermo(string $termo): array {
        $query = "SELECT * FROM " . $this->tabela . " 
              WHERE titulo LIKE :termo OR ingredientes LIKE :termo
              ORDER BY criado_em DESC";

        $stmt = $this->pdo->prepare($query);

        $termo_like = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termo_like);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





}
?>

