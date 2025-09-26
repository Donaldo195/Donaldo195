<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/InscricaoModel.php';

class InscricaoController {

    public function inscricao() {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $nome            = trim($_POST['nome'] ?? '');
            $apelido         = trim($_POST['apelido'] ?? '');
            $genero          = trim($_POST['genero'] ?? '');
            $nacionalidade   = trim($_POST['nacionalidade'] ?? '');
            $data_nascimento = trim($_POST['data_nascimento'] ?? '');
            $BI              = trim($_POST['BI'] ?? '');
            $telefone        = trim($_POST['telefone'] ?? '');
            $morada          = trim($_POST['morada'] ?? '');
            $curso           = trim($_POST['curso'] ?? '');

            // Validação de campos obrigatórios
            if (empty($nome) || empty($apelido) || empty($genero) || empty($nacionalidade) || empty($data_nascimento) || empty($BI) || empty($telefone) || empty($morada) || empty($curso)) {
                echo 'Preencha todos os campos obrigatórios!';
                return;
            }

            // Validações adicionais
            if (!preg_match("/^[a-zA-ZÀ-ú\s]+$/", $nome)) {
                echo "O nome só pode conter letras e espaços.";
                return;
            }

            if (!preg_match("/^[0-9]{9}$/", $telefone)) {
                echo "Telefone deve ter 9 dígitos.";
                return;
            }

            if (!DateTime::createFromFormat('Y-m-d', $data_nascimento)) {
                echo "Data de nascimento inválida. Use o formato YYYY-MM-DD.";
                return;
            }

            $user = new InscricaoModel();
            $user->setNome($nome);
            $user->setApelido($apelido);
            $user->setGenero($genero);
            $user->setNacionalidade($nacionalidade);
            $user->setNascimento($data_nascimento);
            $user->setBI($BI);
            $user->setTelefone($telefone);
            $user->setMorada($morada);
            $user->setCurso($curso);

            if ($user->salvar()) {
                echo "Inscrição realizada com sucesso!";
            } else {
                echo "Erro ao realizar a inscrição.";
            }
        }
    }
}

// Executar o controller
$controller = new InscricaoController();
$controller->inscricao();
