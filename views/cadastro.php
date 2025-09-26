
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/registo.css">
   

</head>
<body>

     <header>
        <div class="header-container">
            <a href="#" class="logo">
                <img src="../assets/img/logo.jpeg" alt="Universidade Pedagógica">
                <div class="logo-text">
                     <h2 class="titulo-universidade">Universidade Pedagógica</h2>
                     <span class="titulo-universidade">Excelência em Educação</span>
                </div>
            </a>
        </div>
    </header><br>
    <div class="container">
       
            <form action="../controller/RegisterController.php" method="POST">
                <input type="hidden" name="acao" value="registrar">
                
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <div class="input-with-icon">
                        <span class="form-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="nome" name="nome" class="form-control" 
                            placeholder="Nome" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-with-icon">
                        <span class="form-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" 
                            placeholder="Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <div class="input-with-icon">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="senha" name="senha" class="form-control" 
                            placeholder="Digite sua senha" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha</label>
                    <div class="input-with-icon">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirmar_senha" name="confirmar_senha" 
                            class="form-control" placeholder="Repita sua senha" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-solid">
                    <span>Criar Conta</span>
                </button><br>

                 <div class="login-link">
                        Já tem uma conta? <a href="./login.php">Faça login</a>
                 </div>
            </form>

            
       
    </div>

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
    </footer>
</body>
</html>