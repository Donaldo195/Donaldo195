<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_role']) || $_SESSION['usuario_role'] !== 'admin') {
    
    header("Location: ../views/login.php");
    exit();
}

$conexao = new conexao();

try {
    $stmt = $conexao->con->prepare("SELECT * FROM candidato ORDER BY criado_em DESC");
    $stmt->execute();
    $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar candidatos: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --warning: #f72585;
            --info: #7209b7;
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

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
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

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .stat-icon.green {
            background: linear-gradient(135deg, var(--success), #2a9d8f);
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #f9a826, #f3722c);
        }

        .stat-icon.red {
            background: linear-gradient(135deg, var(--warning), #e63946);
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--gray);
            font-size: 14px;
        }

        /* Charts */
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        @media (max-width: 992px) {
            .charts-row {
                grid-template-columns: 1fr;
            }
        }

        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 300px;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--gray);
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pendente {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-aprovado {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejeitado {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Action Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            font-size: 14px;
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

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
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

        /* Filter Bar */
        .filter-bar {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            position: relative;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .filter-select {
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
            <h2>Painel Admin</h2>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-item active" data-target="dashboard">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </div>
            
            <div class="menu-item" data-target="candidatos">
                <i class="fas fa-users"></i>
                <span>Candidatos</span>
            </div>
            
            <div class="menu-item" data-target="cursos">
                <i class="fas fa-book"></i>
                <span>Cursos</span>
            </div>
            
            <div class="menu-item" data-target="inscricoes">
                <i class="fas fa-file-alt"></i>
                <span>Inscrições</span>
            </div>
            
            <div class="menu-item" data-target="usuarios">
                <i class="fas fa-user-cog"></i>
                <span>Usuários</span>
            </div>
            
            <div class="menu-item" data-target="configuracoes">
                <i class="fas fa-cog"></i>
                <span>Configurações</span>
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
            <h2>Painel de Administração</h2>
            <div class="user-info">
                <div class="user-avatar">A</div>
                <span>Administrador</span>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="content">
            <!-- Dashboard Section -->
            <div class="content-section active" id="dashboard">
                <h2>Dashboard</h2>
                <p>Visão geral do sistema de inscrições</p>
                
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">245</div>
                            <div class="stat-label">Total de Candidatos</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">152</div>
                            <div class="stat-label">Inscrições Aprovadas</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">63</div>
                            <div class="stat-label">Inscrições Pendentes</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon red">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-value">30</div>
                            <div class="stat-label">Inscrições Rejeitadas</div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="charts-row">
                    <div class="chart-container">
                        <h3 class="card-title"><i class="fas fa-chart-pie"></i> Status das Inscrições</h3>
                        <canvas id="statusChart"></canvas>
                    </div>
                    
                    <div class="chart-container">
                        <h3 class="card-title"><i class="fas fa-chart-bar"></i> Candidatos por Curso</h3>
                        <canvas id="courseChart"></canvas>
                    </div>
                </div>
                
                <!-- Recent Notifications -->
                <div class="card">
                    <h3 class="card-title"><i class="fas fa-bell"></i> Notificações Recentes</h3>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Candidato</th>
                                    <th>Curso</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>João Silva</td>
                                    <td>Engenharia Informática</td>
                                    <td>10/02/2023</td>
                                    <td><span class="status-badge status-pendente">Pendente</span></td>
                                </tr>
                                <tr>
                                    <td>Maria Santos</td>
                                    <td>Medicina</td>
                                    <td>09/02/2023</td>
                                    <td><span class="status-badge status-aprovado">Aprovado</span></td>
                                </tr>
                                <tr>
                                    <td>Carlos Oliveira</td>
                                    <td>Direito</td>
                                    <td>08/02/2023</td>
                                    <td><span class="status-badge status-rejeitado">Rejeitado</span></td>
                                </tr>
                                <tr>
                                    <td>Ana Costa</td>
                                    <td>Economia</td>
                                    <td>07/02/2023</td>
                                    <td><span class="status-badge status-pendente">Pendente</span></td>
                                </tr>
                                <tr>
                                    <td>Pedro Alves</td>
                                    <td>Biologia e Saúde</td>
                                    <td>06/02/2023</td>
                                    <td><span class="status-badge status-aprovado">Aprovado</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Candidatos Section -->
            <div class="content-section" id="candidatos">
                <h2>Gestão de Candidatos</h2>
                <p>Visualize e gerencie todos os candidatos</p>
                
                <!-- Filter Bar -->
                <div class="filter-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Pesquisar candidato...">
                    </div>
                    
                    <select class="filter-select">
                        <option value="">Todos os cursos</option>
                        <option value="Engenharia Informática">Engenharia Informática</option>
                        <option value="Medicina">Medicina</option>
                        <option value="Direito">Direito</option>
                        <option value="Economia">Economia</option>
                        <option value="Biologia e Saúde">Biologia e Saúde</option>
                    </select>
                    
                    <select class="filter-select">
                        <option value="">Todos os status</option>
                        <option value="pendente">Pendente</option>
                        <option value="aprovado">Aprovado</option>
                        <option value="rejeitado">Rejeitado</option>
                    </select>
                </div>
                
                <!-- Candidates Table -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Completo</th>
                                <th>Apelido</th>
                                <th>Curso</th>
                                <th>Status</th>
                                <th>Data de Inscrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($candidatos as $candidato): ?>
                            <tr>
                                <td><?= htmlspecialchars($candidato['nome_completo']) ?></td>
    <td><?= htmlspecialchars($candidato['apelido']) ?></td>
    <td><?= htmlspecialchars($candidato['curso']) ?></td>
    <td>
        <?php
            // Exemplo de status fictício
            $status = $candidato['status'] ?? 'pendente';
            $classe = match($status) {
                'aprovado' => 'status-aprovado',
                'rejeitado' => 'status-rejeitado',
                default => 'status-pendente'
            };
        ?>
        <span class="status-badge <?= $classe ?>"><?= ucfirst($status) ?></span>
    </td>
    <td><?= date('d/m/Y', strtotime($candidato['criado_em'])) ?></td>
    <td>
        <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
        <button class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></button>
    </td>
                            </tr>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Santos</td>
                                <td>Medicina</td>
                                <td><span class="status-badge status-aprovado">Aprovado</span></td>
                                <td>09/02/2023</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Carlos Oliveira</td>
                                <td>Oliveira</td>
                                <td>Direito</td>
                                <td><span class="status-badge status-rejeitado">Rejeitado</span></td>
                                <td>08/02/2023</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ana Costa</td>
                                <td>Costa</td>
                                <td>Economia</td>
                                <td><span class="status-badge status-pendente">Pendente</span></td>
                                <td>07/02/2023</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Pedro Alves</td>
                                <td>Alves</td>
                                <td>Biologia e Saúde</td>
                                <td><span class="status-badge status-aprovado">Aprovado</span></td>
                                <td>06/02/2023</td>
                                <td>
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add other sections similarly -->
            <!-- Cursos Section -->
            <div class="content-section" id="cursos">
                <h2>Gestão de Cursos</h2>
                <p>Gerencie os cursos disponíveis para inscrição</p>
                
                <div class="card">
                    <h3 class="card-title"><i class="fas fa-book"></i> Lista de Cursos</h3>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome do Curso</th>
                                    <th>Capacidade</th>
                                    <th>Inscritos</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Engenharia Informática</td>
                                    <td>100</td>
                                    <td>45</td>
                                    <td><span class="status-badge status-aprovado">Ativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-warning btn-sm"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medicina</td>
                                    <td>80</td>
                                    <td>78</td>
                                    <td><span class="status-badge status-aprovado">Ativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-warning btn-sm"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Direito</td>
                                    <td>120</td>
                                    <td>65</td>
                                    <td><span class="status-badge status-aprovado">Ativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-warning btn-sm"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Economia</td>
                                    <td>90</td>
                                    <td>42</td>
                                    <td><span class="status-badge status-aprovado">Ativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-warning btn-sm"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biologia e Saúde</td>
                                    <td>60</td>
                                    <td>15</td>
                                    <td><span class="status-badge status-pendente">Inativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Inscricoes Section -->
            <div class="content-section" id="inscricoes">
                <h2>Gestão de Inscrições</h2>
                <p>Aprove, rejeite ou analise inscrições</p>
                
                <div class="card">
                    <h3 class="card-title"><i class="fas fa-file-alt"></i> Todas as Inscrições</h3>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Candidato</th>
                                    <th>Curso</th>
                                    <th>Data de Inscrição</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>João Silva</td>
                                    <td>Engenharia Informática</td>
                                    <td>10/02/2023</td>
                                    <td><span class="status-badge status-pendente">Pendente</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm">Aprovar</button>
                                        <button class="btn btn-warning btn-sm">Rejeitar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Maria Santos</td>
                                    <td>Medicina</td>
                                    <td>09/02/2023</td>
                                    <td><span class="status-badge status-aprovado">Aprovado</span></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Rejeitar</button>
                                        <button class="btn btn-primary btn-sm">Detalhes</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Carlos Oliveira</td>
                                    <td>Direito</td>
                                    <td>08/02/2023</td>
                                    <td><span class="status-badge status-rejeitado">Rejeitado</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm">Aprovar</button>
                                        <button class="btn btn-primary btn-sm">Detalhes</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Usuarios Section -->
            <div class="content-section" id="usuarios">
                <h2>Gestão de Usuários</h2>
                <p>Gerencie os usuários do sistema</p>
                
                <div class="card">
                    <h3 class="card-title"><i class="fas fa-user-cog"></i> Lista de Usuários</h3>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Permissão</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Administrador</td>
                                    <td>admin@universidade.edu</td>
                                    <td>Administrador</td>
                                    <td><span class="status-badge status-aprovado">Ativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-key"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>João Silva</td>
                                    <td>joao@universidade.edu</td>
                                    <td>Moderador</td>
                                    <td><span class="status-badge status-aprovado">Ativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-key"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Maria Santos</td>
                                    <td>maria@universidade.edu</td>
                                    <td>Moderador</td>
                                    <td><span class="status-badge status-pendente">Inativo</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-primary btn-sm"><i class="fas fa-check"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Configuracoes Section -->
            <div class="content-section" id="configuracoes">
                <h2>Configurações do Sistema</h2>
                <p>Configure as preferências do sistema</p>
                
                <div class="card">
                    <h3 class="card-title"><i class="fas fa-cog"></i> Configurações Gerais</h3>
                    
                    <div class="form-group">
                        <label>Número máximo de candidatos por curso</label>
                        <input type="number" class="form-control" value="100">
                    </div>
                    
                    <div class="form-group">
                        <label>Data limite para inscrições</label>
                        <input type="date" class="form-control" value="2023-03-31">
                    </div>
                    
                    <div class="form-group">
                        <label>Mensagem de inscrição aprovada</label>
                        <textarea class="form-control" rows="3">Parabéns! Sua inscrição foi aprovada. Entre em contato para mais informações.</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Mensagem de inscrição rejeitada</label>
                        <textarea class="form-control" rows="3">Lamentamos informar que sua inscrição não foi aprovada.</textarea>
                    </div>
                    
                    <button class="btn btn-primary">Salvar Configurações</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const sidebar = document.getElementById('sidebar');
            const toggleSidebar = document.getElementById('toggleSidebar');
            
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            // Navigation
            const menuItems = document.querySelectorAll('.menu-item');
            const contentSections = document.querySelectorAll('.content-section');
            
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    
                    const target = this.getAttribute('data-target');
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === target) {
                            section.classList.add('active');
                        }
                    });
                    
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('active');
                    }
                });
            });
            
            // Charts
            const statusChart = new Chart(document.getElementById('statusChart'), {
                type: 'pie',
                data: {
                    labels: ['Aprovadas', 'Pendentes', 'Rejeitadas'],
                    datasets: [{
                        data: [152, 63, 30],
                        backgroundColor: [
                            '#4cc9f0',
                            '#f9a826',
                            '#f72585'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            
            const courseChart = new Chart(document.getElementById('courseChart'), {
                type: 'bar',
                data: {
                    labels: ['Eng. Informática', 'Medicina', 'Direito', 'Economia', 'Biologia e Saúde'],
                    datasets: [{
                        label: 'Número de Candidatos',
                        data: [45, 78, 65, 42, 15],
                        backgroundColor: '#4361ee'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>