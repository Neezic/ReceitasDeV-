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

    public function emailExiste(string $email): bool {
        // Query para contar quantos usuários têm o e-mail fornecido
        $query = "SELECT id FROM usuarios  WHERE email = :email LIMIT 1";

        // Prepara a query
        $stmt = $this->pdo->prepare($query);

        // Limpa e vincula o parâmetro de e-mail
        $emailLimpo = htmlspecialchars(strip_tags($email));
        $stmt->bindParam(':email', $emailLimpo);

        // Executa
        $stmt->execute();

        // Se a contagem de linhas for maior que 0, o e-mail existe
        if ($stmt->rowCount() > 0) {
        return true;
        }

        return false;
    }

    public function buscarPorEmail(string $email) {
        $query ="SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

}


?>