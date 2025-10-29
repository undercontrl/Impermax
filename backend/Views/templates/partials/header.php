<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Caminhos onde o menu não deve aparecer
$rotasPublicas = ['/backend/login', '/backend/register', '/backend/authenticar'];

// Detecta a rota atual (sem parâmetros)
$currentPath = strtok($_SERVER['REQUEST_URI'], '?');

// Se for login/register, não renderiza o resto do layout
if (in_array($currentPath, $rotasPublicas)) {
    return;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Impermax</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="/public/css/status-badges.css">

    <style>
        :root {
            --cor-primaria: #5f7396;
            --cor-acento: #1487df;
            --cor-clara: #ffffff;
            --cor-cinza: #a7a7a7;
            --cor-fundo: #f4f6f9;
            --sidebar-width: 280px;
            --topbar-height: 70px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--cor-fundo);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #1e293b;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ==================== SIDEBAR ==================== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #4a5f7f 0%, var(--cor-primaria) 100%);
            color: var(--cor-clara);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }

        .sidebar-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
            padding: 1.5rem 1.25rem;
            height: var(--topbar-height);
            position: relative;
            overflow: hidden;
        }

        .sidebar-logo::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .sidebar-logo a {
            position: relative;
            z-index: 1;
        }

        .sidebar-logo img {
            width: 160px;
            max-height: 45px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            transition: var(--transition);
        }

        .sidebar-logo img:hover {
            transform: scale(1.05);
        }

        /* Menu de Navegação */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .nav-section-title {
            padding: 1.25rem 1.5rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 0.875rem 1.5rem;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            margin: 0.25rem 0.75rem;
            border-radius: 10px;
        }

        .sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: white;
            border-radius: 0 3px 3px 0;
            transition: var(--transition);
        }

        .sidebar a i {
            margin-right: 0.875rem;
            font-size: 1.15rem;
            width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar a:hover::before {
            height: 20px;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar a.active::before {
            height: 24px;
        }

        /* Logout na Sidebar */
        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer a {
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-footer a:hover {
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.15);
        }

        /* ==================== TOPBAR ==================== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            box-shadow: var(--shadow-sm);
            z-index: 999;
            border-bottom: 1px solid #f1f5f9;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .topbar-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            letter-spacing: -0.025em;
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #64748b;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .breadcrumb-custom li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-custom a {
            color: var(--cor-acento);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-custom a:hover {
            color: var(--cor-primaria);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }

        .topbar-icon-btn:hover {
            background: #f1f5f9;
            color: var(--cor-acento);
        }

        .topbar-icon-btn .badge-notification {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* ==================== USER MENU DROPDOWN ==================== */
        .user-menu-wrapper {
            position: relative;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            background: transparent;
            border: none;
            color: inherit;
        }

        .user-menu:hover {
            background: #f8fafc;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9375rem;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--cor-cinza);
        }

        /* Dropdown Menu */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid #f1f5f9;
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow: hidden;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            color: #1e293b;
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item i {
            font-size: 1.125rem;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: var(--cor-acento);
        }

        .dropdown-item.danger {
            color: #ef4444;
        }

        .dropdown-item.danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .dropdown-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 0.5rem 0;
        }

        /* ==================== CONTEÚDO PRINCIPAL ==================== */
        .content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            flex-grow: 1;
            padding: 2rem 2.5rem;
            background-color: var(--cor-fundo);
            min-height: calc(100vh - var(--topbar-height));
        }

        /* ==================== ALERTAS FLASH ==================== */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert::before {
            font-family: 'bootstrap-icons';
            font-size: 1.25rem;
        }

        .alert-success::before {
            content: '\f26b';
        }

        .alert-danger::before {
            content: '\f623';
        }

        /* ==================== RESPONSIVIDADE ==================== */
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 260px;
            }

            .content {
                padding: 1.5rem 1.25rem;
            }

            .topbar {
                padding: 0 1.25rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .topbar-title {
                font-size: 1.125rem;
            }

            .breadcrumb-custom {
                display: none;
            }

            .user-info-text {
                display: none;
            }

            .mobile-menu-btn {
                display: flex;
            }
        }

        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 1.5rem;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* ==================== ANIMAÇÕES ==================== */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>

<body>

    <!-- Menu lateral -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="/backend/admin/dashboard">
                <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax Logo">
            </a>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section-title">Principal</div>
            <a href="/backend/admin/dashboard" class="<?= str_contains($_SERVER['REQUEST_URI'], 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-section-title">Gestão</div>
            <a href="/backend/agendamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'agendamento') ? 'active' : '' ?>">
                <i class="bi bi-calendar-check"></i> Agendamentos
            </a>
            <a href="/backend/orcamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'orcamento') ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> Orçamentos
            </a>
            <a href="/backend/projeto/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'projetos') ? 'active' : '' ?>">
                <i class="bi bi-card-image"></i> Projetos
            </a>
            <a href="/backend/pagamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'pagamento') ? 'active' : '' ?>">
                <i class="bi bi-cash-coin"></i> Pagamentos
            </a>

            <div class="nav-section-title">Comunicação</div>
            <a href="/backend/contato/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'contato') ? 'active' : '' ?>">
                <i class="bi bi-envelope"></i> Contatos
            </a>
            <a href="/backend/avaliacao/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'avaliacao') ? 'active' : '' ?>">
                <i class="bi bi-star"></i> Avaliações
            </a>

            <div class="nav-section-title">Cadastros</div>
            <a href="/backend/usuario/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'usuario') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Usuários
            </a>
            <a href="/backend/servico/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'servico') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Serviços
            </a>
            <a href="/backend/material/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'material') ? 'active' : '' ?>">
                <i class="bi bi-tools"></i> Material
            </a>
            <a href="/backend/endereco/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'endereco') ? 'active' : '' ?>">
                <i class="bi bi-geo-alt"></i> Endereços
            </a>

            <div class="nav-section-title">Itens</div>
            <a href="/backend/item_agendamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'item_agendamento') ? 'active' : '' ?>">
                <i class="bi bi-list-check"></i> Itens Agendamento
            </a>
            <a href="/backend/item_orcamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'item_orcamento') ? 'active' : '' ?>">
                <i class="bi bi-receipt"></i> Itens Orçamento
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="/backend/logout">
                <i class="bi bi-box-arrow-left"></i> Sair
            </a>
        </div>
    </nav>

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="mobile-menu-btn" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <h1 class="topbar-title">Painel de Controle</h1>
                <ul class="breadcrumb-custom">
                    <li><a href="/backend/admin/dashboard"><i class="bi bi-house-door"></i> Home</a></li>
                    <li><i class="bi bi-chevron-right"></i></li>
                    <li>Dashboard</li>
                </ul>
            </div>
        </div>
        <div class="topbar-right">
            <!-- -- Ícone de Notificações 
            <a href="#" class="topbar-icon-btn" title="Notificações">
                <i class="bi bi-bell"></i>
                <span class="badge-notification"></span>
            </a>
            <a href="#" class="topbar-icon-btn" title="Configurações">
                <i class="bi bi-gear"></i>
            </a> 
            
            -->     
            <!-- User Menu com Dropdown -->
            <div class="user-menu-wrapper">
                <button class="user-menu" id="userMenuBtn">
                    <div class="user-avatar">
                        <?php if (!empty($_SESSION['foto_usuario'])): ?>
                            <img src="/public/uploads/avatars/<?= htmlspecialchars($_SESSION['foto_usuario']) ?>" 
                                 alt="Avatar">
                        <?php else: ?>
                            <?= strtoupper(substr($_SESSION['nome_usuario'] ?? 'A', 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                    <div class="user-info-text">
                        <span class="user-name"><?= htmlspecialchars($_SESSION['nome_usuario'] ?? 'Usuário') ?></span>
                        <span class="user-role"><?= ucfirst($_SESSION['tipo_usuario'] ?? 'Usuário') ?></span>
                    </div>
                    <i class="bi bi-chevron-down" style="color: #94a3b8; font-size: 0.75rem;"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown">
                    <a href="/backend/perfil" class="dropdown-item">
                        <i class="bi bi-person-circle"></i>
                        <span>Meu Perfil</span>
                    </a>
                    <a href="/backend/perfil" class="dropdown-item">
                        <i class="bi bi-shield-lock"></i>
                        <span>Alterar Senha</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/backend/logout" class="dropdown-item danger">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Sair</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <main class="content">
        <!-- Mensagens flash -->
        <?php
        use App\Impermax\Core\Flash;
        $mensagem = Flash::get();
        if (isset($mensagem)) {
            foreach ($mensagem as $key => $value) {
                if ($key == "type") {
                    $tipo = $value == "success" ? "alert-success" : "alert-danger";
                    echo "<div class='alert $tipo' role='alert'>";
                } else {
                    echo htmlspecialchars($value);
                    echo "</div>";
                }
            }
        }
        ?>
        
        <script>
        // Toggle User Dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdown = document.getElementById('userDropdown');
            
            if (userMenuBtn && userDropdown) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('active');
                });
                
                // Fechar ao clicar fora
                document.addEventListener('click', function() {
                    userDropdown.classList.remove('active');
                });
                
                // Prevenir fechar ao clicar no dropdown
                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });

        // Toggle Mobile Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        </script>