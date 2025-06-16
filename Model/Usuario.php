<?php
class Usuario {
    private $pdo;
    private $tabela = 'usuarios';

    public function __construct(PDO $conexaoPDO) {
        $this->pdo = $conexaoPDO;
    }
    public function criar(array $dados): bool {
        $query = "INSERT INTO ".$this->tabela." 
                (nome, email, cpf, data_nascimento, senha) 
                VALUES 
                (:nome, :email, :cpf, :data_nascimento, :senha)";

        $stmt = $this->pdo->prepare($query);

    
        $nome = htmlspecialchars(strip_tags($dados['nome']));
        $email = htmlspecialchars(strip_tags($dados['email']));
        $cpf = htmlspecialchars(strip_tags($dados['cpf'])); 
        $data_nascimento = htmlspecialchars(strip_tags($dados['data_nascimento']));
        $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

    
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha_hash);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function emailExiste(string $email): bool {
        $query = "SELECT id FROM usuarios  WHERE email = :email LIMIT 1";

        $stmt = $this->pdo->prepare($query);

        $emailLimpo = htmlspecialchars(strip_tags($email));
        $stmt->bindParam(':email', $emailLimpo);

        $stmt->execute();

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



    public function buscarPorCpfEDob(string $cpf, string $data_nascimento) {
        $query = "SELECT id, nome, email FROM " . $this->tabela . " WHERE cpf = :cpf AND data_nascimento = :data_nascimento LIMIT 1";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    
    public function atualizarSenha(int $id, string $novaSenha): bool {
        $query = "UPDATE " . $this->tabela . " SET senha = :senha WHERE id = :id";
        
        $stmt = $this->pdo->prepare($query);
        
        $senha_hash = password_hash($novaSenha, PASSWORD_DEFAULT);
        
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

}


?>