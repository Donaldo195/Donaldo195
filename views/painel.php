<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ./login.php");
    exit();
}

$nome_usuario = $_SESSION['usuario_nome'];
$email_usuario = $_SESSION['usuario_email'] ?? 'Email não cadastrado';



// Conexão
$con = new PDO("pgsql:host=localhost;port=5432;dbname=exame", "dona", "donaldo");

$id = $_GET['id'] ?? 1;

// Busca apenas o curso
$sql = "SELECT curso FROM candidato WHERE id = :id";
$stmt = $con->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$dado = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Candidato</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border: #dee2e6;
            --sidebar-width: 250px;
            --header-height: 70px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 22px;
            margin-top: 10px;
        }

        .user-info {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background-color: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 32px;
            margin: 0 auto 15px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-details small {
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--success);
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: var(--success);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: var(--transition);
            border-left: 4px solid transparent;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--warning);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
        }

        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .toggle-sidebar {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--primary);
        }

        .content {
            padding: 25px;
        }

        .content-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .content-section.active {
            display: block;
        }

        /* Card Styles */
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Styles */
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .radio-group {
            display: flex;
            gap: 20px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .btn-submit:hover {
            background-color: var(--secondary);
        }

        /* Status Card */
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            background-color: #fff3cd;
            color: #856404;
            margin-top: 10px;
        }

        /* Info Card */
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        /* Dashboard Grid */
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Validation Styles */
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        /* Notification */
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            background-color: var(--success);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 0;
            }
            
            .sidebar.active {
                transform: translateX(0);
                width: var(--sidebar-width);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .toggle-sidebar {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="user-avatar"><?= strtoupper($nome_usuario[0]) ?></div>

                <div><?= htmlspecialchars($nome_usuario) ?></div>
                <small><?= htmlspecialchars($email_usuario) ?></small>
        </div>
        
        <div class="user-info">
            <div class="user-details">
            </div>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-item active" data-target="dashboard">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            
            <div class="menu-item" data-target="inscricao">
                <i class="fas fa-file-alt"></i>
                <span>Nova Inscrição</span>
            </div>
            
            <div class="menu-item" data-target="status">
                <i class="fas fa-tasks"></i>
                <span>Status da Inscrição</span>
            </div>
            
            
        </div>
        
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sair</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h2>Painel do Candidato</h2>
            <div></div> <!-- Empty div for spacing -->
        </div>

        <!-- Content Sections -->
        <div class="content">
            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboard">
                <h2>Bem-vindo, <?= htmlspecialchars($nome_usuario) ?>!</h2>
                <p>Utilize o menu lateral para acessar as diferentes funcionalidades do sistema.</p>
                
                <div class="dashboard" style="margin-top: 30px;">
                    <div class="card">
                        <h3 class="card-title"><i class="fas fa-tasks"></i> Status da Inscrição</h3>
                        <p>Sua inscrição para o exame de admissão está sendo analisada pela comissão.</p>
                        <span class="status-badge">Em Análise</span>
                    </div>
                    <div class="card"><div class="card">
                            <h3 class="card-title"><i class="fas fa-book"></i> Curso Escolhido</h3>
                            <div class="info-item">
                                <span>Curso:</span>
                                <span><strong><?= htmlspecialchars($dado['curso']) ?></strong></span>
                            </div>
                        </div>
                        <div class="info-item">
                            <span>Data do Exame:</span>
                            <span>15 de fevereiro de 2026</span>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="card-title"><i class="fas fa-user-circle"></i> Informações Pessoais</h3>
                        <div class="info-item">
                            <span>Nome:</span>
                            <span><?= htmlspecialchars($nome_usuario) ?></span>
                        </div>
                        <div class="info-item">
                            <span>Email:</span>
                            <span><?= htmlspecialchars($email_usuario) ?></span>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="card-title"><i class="fas fa-bolt"></i> Ações Rápidas</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <button class="btn btn-primary"><i class="fas fa-download"></i> Baixar Comprovativo</button>
                            <button class="btn btn-primary"><i class="fas fa-print"></i> Imprimir Dados</button>
                            <button class="btn btn-success"><i class="fas fa-calendar-alt"></i> Adicionar ao Calendário</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inscrição Section -->
            <div class="content-section" id="inscricao">
                <h2>Nova Inscrição</h2>
                <p>Preencha o formulário abaixo para realizar sua inscrição.</p>
                
                <div class="card">
                    <form id="candidatoForm" action="../controller/InscricaoController.php" method="POST">
    <!-- Dados Pessoais -->
    <div class="form-section">
        <div class="section-title"><i class="fas fa-user"></i> Dados Pessoais</div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" placeholder="digita o nome" class="form-control" 
                       value="<?= htmlspecialchars($nome_usuario) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="apelido">Apelido *</label>
                <input type="text" id="apelido" name="apelido" placeholder="digita o apelido" class="form-control" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento *</label>
                <input type="date" id="data_nascimento" name="data_nascimento" placeholder="digita a data de nascimento" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Género *</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="genero_m" name="genero" value="Masculino" required>
                        <label for="genero_m">Masculino</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="genero_f" name="genero" value="Feminino">
                        <label for="genero_f">Feminino</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="nacionalidade">Nacionalidade *</label>
                <input type="text" id="nacionalidade" name="nacionalidade" placeholder="digita a nacionalidade" class="form-control" required>
            </div>
        </div>
    </div>
    
    <!-- Documentação e Contactos -->
    <div class="form-section">
        <div class="section-title"><i class="fas fa-id-card"></i> Documentação e Contactos</div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="BI">Bilhete de Identidade *</label>
                <input type="text" id="BI" name="BI" placeholder="digita o numero de BI" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="telefone">Telefone *</label>
                <input type="tel" id="telefone" name="telefone" placeholder="digita o numero de Telfone" class="form-control" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="morada">Morada *</label>
            <input type="text" id="morada" name="morada" placeholder="digita sua morada" class="form-control" required>
        </div>
    </div>
    
    <!-- Curso Pretendido -->
    <div class="form-section">
        <div class="form-group">
            <label for="curso">Curso *</label>
            <input type="text" id="curso" name="curso" placeholder="digita o curso" class="form-control" required>
        </div>
    </div>
    
    <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i> Submeter Candidatura
    </button>
</form>

                </div>
            </div>

            <!-- Status Section -->
            <div class="content-section" id="status">
                <h2>Status da Inscrição</h2>
                
                <div class="card">
                    <h3 class="card-title"><i class="fas fa-tasks"></i> Status da Inscrição</h3>
                    <p>Sua inscrição para o exame de admissão está sendo analisada pela comissão.</p>
                    <span class="status-badge">Em Análise</span>
                    
                    <div style="margin-top: 20px;">
                        <h4>Histórico de Status</h4>
                        <div class="info-item">
                            <span>Inscrição Recebida</span>
                            <span>10/01/2026 14:30</span>
                        </div>
                        <div class="info-item">
                            <span>Documentação em Análise</span>
                            <span>12/01/2026 09:15</span>
                        </div><br>
                         <h2>Informações do Curso</h2>
                     <div class="info-item">
                        <span>Curso:</span>
                        <span><strong>Biologia e Saúde</strong></span>
                    </div>
                    <div class="info-item">
                        <span>Data do Exame:</span>
                        <span>15 de fevereiro de 2026</span>
                    </div>
                    <div class="info-item">
                        <span>Horário:</span>
                        <span>08:00 - 12:00</span>
                    </div>
                    <div class="info-item">
                        <span>Local:</span>
                        <span>Campus Universitário</span>
                    </div>
                        
                    </div>
                    <div class="content-section" id="curso">
               
                
            </div>

            
            
          
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos do DOM
            const sidebar = document.getElementById('sidebar');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const menuItems = document.querySelectorAll('.menu-item');
            const contentSections = document.querySelectorAll('.content-section');
            const candidatoForm = document.getElementById('candidatoForm');
 
            
            // Toggle sidebar em dispositivos móveis
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            // Navegação pelo menu
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove a classe active de todos os itens do menu
                    menuItems.forEach(i => i.classList.remove('active'));
                    // Adiciona a classe active ao item clicado
                    this.classList.add('active');
                    
                    // Mostra a seção correspondente
                    const target = this.getAttribute('data-target');
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === target) {
                            section.classList.add('active');
                        }
                    });
                    
                    // Fecha o sidebar em dispositivos móveis
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('active');
                    }
                });
            });
            
           
            
            // Função para mostrar notificação
            function showNotification(message, type = 'success') {
                notification.textContent = message;
                notification.style.backgroundColor = type === 'success' ? '#4cc9f0' : '#f72585';
                notification.style.display = 'block';
                
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 3000);
            }
            
            // Função para resetar o formulário
            function resetForm() {
                setTimeout(() => {
                    candidatoForm.reset();
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submeter Candidatura';
                    
                    // Limpar erros de validação
                    document.querySelectorAll('.error').forEach(el => {
                        el.style.display = 'none';
                    });
                    document.querySelectorAll('.is-invalid').forEach(el => {
                        el.classList.remove('is-invalid');
                    });
                }, 1000);
            }
            
            // Validação em tempo real
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('is-invalid');
                        const errorElement = document.getElementById(this.id + '_error');
                        if (errorElement) {
                            errorElement.style.display = 'block';
                        }
                    } else {
                        this.classList.remove('is-invalid');
                        const errorElement = document.getElementById(this.id + '_error');
                        if (errorElement) {
                            errorElement.style.display = 'none';
                        }
                    }
                    
                    // Validação específica para telefone
                    if (this.id === 'telefone' && this.value && !isValidPhone(this.value)) {
                        this.classList.add('is-invalid');
                        const errorElement = document.getElementById('telefone_error');
                        errorElement.textContent = 'Formato de telefone inválido';
                        errorElement.style.display = 'block';
                    }
                });
            });
        });
    </script>
</body>
</html>