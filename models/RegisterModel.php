<?php
class RegisterModel {

    private $con;
    private $nome;
    private $email;
    private $senha;

    public function __construct() {
        try {
            $this->con = new PDO("pgsql:host=localhost;port=5432;dbname=exame", "dona", "donaldo");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Falha na conexão: " . $e->getMessage());
        }
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function save() {
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':senha', $this->senha);

            if($stmt->execute()) {
                return true;
            } else {
                
                print_r($stmt->errorInfo());
                return false;
            }

        } catch (PDOException $e) {
            echo "Erro ao salvar os dados: " . $e->getMessage();
            return false;
        }
    }
}
