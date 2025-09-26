<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/RegisterModel.php';

class RegisterController {

    public function registrar() {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');
            $confirmar_senha = trim($_POST['confirmar_senha'] ?? '');

            
            if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
                echo "Preencha todos os campos";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "E-mail inválido";
                return;
            }

            if ($senha !== $confirmar_senha) {
                echo "As senhas não coincidem!";
                return;
            }

            $user = new RegisterModel();
            $user->setNome($nome);
            $user->setEmail($email);
            $user->setSenha(password_hash($senha, PASSWORD_DEFAULT));

            
            
            if ($user->save()) {
                
                header("Location: ../views/login.php");
                exit(); 
            } else {
                echo "Erro ao registrar o usuário.";
            }

        }
    }
}


$controller = new RegisterController();
$controller->registrar();
