<?php
    class Usuario{
        private $pdo;
        private $tabela = 'usuarios';

        public $id;
        public $nome;
        public $email;
        public $senha;

        public function __contruct(PDO $tabela){
            $this -> pdo = $tabela;
        }

        public function criar(string $nome, string $email, string $senha) : bool {
            $query = "INSERT INTO " . $this -> tabela . " (nome, email, senha) VALUES (:nome, :email, :senha)";
            
            $stmt = $this -> pdo -> prepare($query);
            $this -> nome = htmlspecialchars(strip_tags($nome));
            $this -> email = htmlspecialchars(strip_tags($email));
            $this -> senha = password_hash($senha, PASSWORD_DEFAULT);
            
            $stmt -> bindParam(':nome',$this->nome);
            $stmt -> bindParam(':senha',$this->nome);
            $stmt -> bindParam(':senha',$this->senha);  
            
            if ($stmt-> execute()){
                return true;
            }
            return false;
            
        }

        public function buscarPorId(int $id){
            $query ="SELECT id, nome, email FROM " . $this->tabela . " WHERE id = :id LIMIT 1";

            $stmt = $this -> pdo -> prepare($query);
            $stmt-> bindParam(':id', $id);
            $stmt -> execute();

            if ($stmt-> rowCount() > 0 ){
                $linha = $stmt-> fetch(PDO::FETCH_ASSOC);
                return $linha;
            }
            return false;
        }
        public function buscarPorEmail(int $email){
            $query ="SELECT id, nome, email FROM " . $this->tabela . " WHERE email = :email LIMIT 1";

            $stmt = $this -> pdo -> prepare($query);
            $stmt-> bindParam(':email', $email);
            $stmt -> execute();

            if ($stmt-> rowCount() > 0 ){
                $linha = $stmt-> fetch(PDO::FETCH_ASSOC);
                return $linha;
            }
            return false;
        }
        public function emailExiste(string $email) : bool{
            $query = "SELECT id FROM " . $this->tabela . " WHERE email = :email LIMIT 1";
            $stmt = $this -> pdo -> prepare($query);
            $stmt-> bindParam(':email', $email);
            return $stmt-> rowCount() > 0;
        }
    }
?>