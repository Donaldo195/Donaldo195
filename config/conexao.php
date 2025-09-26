<?php
class Conexao {
    private $host = "localhost";
    private $port = "5432";
    private $user = "dona";
    private $password = "donaldo";
    private $database = "exame";
    public $con;
    
    public function __construct() {
        try {
            $this->con = new PDO(
                "pgsql:host=$this->host;port=$this->port;dbname=$this->database;options='--client_encoding=UTF8'", 
                $this->user, 
                $this->password
            );
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            die("Falha na conexão: " . $e->getMessage());
        }
    }
}
?>
