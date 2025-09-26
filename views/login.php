<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universidade Pedagógica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <style>
        /* Estilos básicos para caso o arquivo CSS ainda não seja encontrado */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .header-container {
            background: linear-gradient(135deg, #fff 0%, #fff 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }
        
        .logo img {
            height: 100px;
            margin-right: 20px;
            border-radius: 1px;
        }
        
        .logo-text h1 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: black;
        }
        
        .logo-text span {
            font-size: 0.9rem;
            opacity: 0.9;
            color: black;
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 160px);
            padding: 2rem;
        }
        
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .login-header p {
            color: #666;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #444;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .input-with-icon input:focus {
            outline: none;
            border-color: #1a5fb4;
            box-shadow: 0 0 0 3px rgba(26, 95, 180, 0.2);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            margin-right: 5px;
        }
        
        .forgot-password {
            color: #1a5fb4;
            text-decoration: none;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1a5fb4 0%, #1c71d8 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 95, 180, 0.3);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .register-link a {
            color: #1a5fb4;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        footer {
            background: white;
            padding: 1.5rem 2rem;
            border-top: 1px solid #eee;
            margin-top: auto;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .footer-links {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .footer-links a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .footer-links a:hover {
            color: #1a5fb4;
        }
        
        .copyright {
            color: #888;
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 1.5rem;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 0.5rem;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="#" class="logo">
                <img src="../assets/img/logo.jpeg" alt="Universidade Pedagógica">
                <div class="logo-text">
                    <h1>Universidade Pedagógica</h1>
                    <span>Exames de admissao</span>
                </div>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="login-container">
        <div class="login-card">
            <div class="login-header">
                <p>Entre com suas credenciais para acessar o sistema</p>
            </div>
            
           <form id="loginForm" action="../controller/LoginController.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-with-icon">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Palavra-passe</label>
                <div class="input-with-icon">
                    
                    <input type="password" id="password" name="senha" placeholder="Sua palavra-passe" required>
                </div>
            </div>
            
            <div class="remember-forgot">
                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Lembrar-me</label>
                </div>
                <a href="#" class="forgot-password">Esqueceu a palavra-passe?</a>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Entrar no Sistema
            </button>
        </form> 

            
            <div class="register-link">
                Precisa de ajuda? <a href="cadastro.php">Contacte o suporte técnico</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-links">
                <a href="#">Termos de Uso</a>
                <a href="#">Política de Privacidade</a>
                <a href="#">Acessibilidade</a>
            </div>
            <div class="copyright">
                &copy; 2023 Universidade Pedagógica. Todos os direitos reservados.
            </div>
        </div>
    </footer>

</body>
</html>