<?php
class LoginModel {

    private PDO $con;

    public function __construct() {
        try {
            $this->con = new PDO("pgsql:host=localhost;port=5432;dbname=exame", "dona", "donaldo");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Falha na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Busca um usuário pelo email.
     * @param string $email
     * @return array|false
     */
    public function buscarEmail(string $email): array|false {
        try {
            $stmt = $this->con->prepare("SELECT id, nome, email, senha, role FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            return $usuario ?: false;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return false;
        }
    }
}
