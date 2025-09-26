<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/conexao.php';

class InscricaoModel {

    private $con;
    private $nome;
    private $apelido;
    private $genero;
    private $nacionalidade;
    private $data_nascimento;
    private $BI;
    private $telefone;
    private $morada;
    private $curso;

    public function __construct() {
        try {
            $this->con = new PDO("pgsql:host=localhost;port=5432;dbname=exame", "dona", "donaldo");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Falha na conexão: " . $e->getMessage());
        }
    }

    public function setNome($nome) { $this->nome = $nome; }
    public function setApelido($apelido) { $this->apelido = $apelido; }
    public function setGenero($genero) { $this->genero = $genero; }
    public function setNacionalidade($nacionalidade) { $this->nacionalidade = $nacionalidade; }
    public function setNascimento($data_nascimento) { $this->data_nascimento = $data_nascimento; }
    public function setBI($BI) { $this->BI = $BI; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
    public function setMorada($morada) { $this->morada = $morada; }
    public function setCurso($curso) { $this->curso = $curso; }

    public function salvar() {
        try {
            $sql = "INSERT INTO candidato (nome, apelido, genero, nacionalidade, data_nascimento, BI, telefone, morada, curso) 
                    VALUES (:nome, :apelido, :genero, :nacionalidade, :data_nascimento, :BI, :telefone, :morada, :curso)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':apelido', $this->apelido);
            $stmt->bindParam(':genero', $this->genero);
            $stmt->bindParam(':nacionalidade', $this->nacionalidade);
            $stmt->bindParam(':data_nascimento', $this->data_nascimento);
            $stmt->bindParam(':BI', $this->BI);
            $stmt->bindParam(':telefone', $this->telefone);
            $stmt->bindParam(':morada', $this->morada);
            $stmt->bindParam(':curso', $this->curso);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao salvar os dados: " . $e->getMessage();
            return false;
        }
    }
}
