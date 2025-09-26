<?php
require_once __DIR__ . '/../models/LoginModel.php';
session_start();

class LoginController {

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            // Recebe dados do formulário
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            if (empty($email) || empty($senha)) {
                $_SESSION['erro_login'] = "Preencha todos os campos!";
                header("Location: ../views/login.php");
                exit();
            }

            $model = new LoginModel();
            $usuario = $model->buscarEmail($email);

            if (!$usuario) {
                $_SESSION['erro_login'] = "Usuário não encontrado!";
                header("Location: ../views/login.php");
                exit();
            }

            // Verifica a senha usando crypt (compatível com PostgreSQL bcrypt)
            if (crypt($senha, $usuario['senha']) !== $usuario['senha']) {
                $_SESSION['erro_login'] = "Credenciais incorretas!";
                header("Location: ../views/login.php");
                exit();
            }

            // Armazena informações do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_role'] = $usuario['role'];

            // Redireciona de acordo com a role
            if ($usuario['role'] === 'admin') {
                header("Location: ../views/painelAdmin.php");
            } else {
                header("Location: ../views/painel.php");
            }
            exit();
        }
    }
}

// Executa o login
$controller = new LoginController();
$controller->login();
