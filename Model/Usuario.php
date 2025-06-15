<?php
class Usuario {
    private $pdo;

    public function __construct(PDO $conexaoPDO) {
        $this->pdo = $conexaoPDO;
    }
    public function criar(array $dados): bool {
        $query = "INSERT INTO usuarios 
                (nome, email, cpf, data_nascimento, senha) 
                VALUES 
                (:nome, :email, :cpf, :data_nascimento, :senha)";

        $stmt = $this->pdo->prepare($query);

    
        $nome = htmlspecialchars(strip_tags($dados['nome']));
        $email = htmlspecialchars(strip_tags($dados['email']));
        $cpf = htmlspecialchars(strip_tags($dados['cpf'])); // Apenas sanitização básica
        $data_nascimento = htmlspecialchars(strip_tags($dados['data_nascimento']));
        $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

    
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha_hash);

        // Executar a query
        if ($stmt->execute()) {
        return true;
        }

        return false;
    }


    

    public function emailExiste(string $email) {
        $query ="SELECT id, nome, email FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

}
?>