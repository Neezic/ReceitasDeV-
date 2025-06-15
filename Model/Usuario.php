<?php
class Usuario {
    private $pdo;

    public function __construct(PDO $conexaoPDO) {
        $this->pdo = $conexaoPDO;
    }

    public function cadastrar(string $nome, string $email, string $cpf, string $data_nascimento, string $senha) : bool {
        
        $query = "INSERT INTO usuarios (nome, email, cpf, data_nascimento, senha) VALUES (:nome, :email, :cpf, :data_nascimento, :senha)";
        
        try {
            $stmt = $this->pdo->prepare($query);
 
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':data_nascimento', $data_nascimento);
            $stmt->bindValue(':senha', $senhaHash);
            
            return $stmt->execute();

        } catch (PDOException $e) {
          
            return false;
        }
    }

    public function buscarPorEmail(string $email) {
        $query ="SELECT id, nome, email FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }
}
?>