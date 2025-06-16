<?php

class Categoria {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listarTodas(): array {
        $stmt = $this->pdo->query("SELECT id, nome FROM categorias ORDER BY nome ASC");
        return $stmt->fetchAll();
    }
    
    public function criar(string $nome) {
        $sql = "INSERT INTO categorias (nome) VALUES (:nome)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        
        if ($stmt->execute()) {
            return $this->pdo->lastInsertId();
        }
        return false;
    }
}
?>