<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Caminhos onde o menu não deve aparecer
$rotasPublicas = [
    '/backend/login', 
    '/backend/register', 
    '/backend/authenticar',
    '/backend/cliente/avaliacao',
    '/backend/esqueci-senha',
    '/backend/redefinir-senha'
];

use App\Impermax\Core\Permissions;

// Pega o tipo de usuário da sessão
$tipoUsuario = $_SESSION['usuario_tipo'] ?? 'funcionario';
$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';

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
    <link rel="stylesheet" href="/public/css/dashboard-responsive.css">

    <!-- Favicon -->
    <link rel="icon" type="images/png" href="assets/icons/water.png">

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
            background: linear-gradient(135deg, #1a202c 0%, #062f77c9 100%);
            color: var(--cor-clara);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 4px 0 40px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
        }

        .sidebar-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            padding: 1.5rem 1.25rem;
            height: var(--topbar-height);
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(20, 135, 223, 0.1), transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .sidebar-logo a {
            position: relative;
            z-index: 1;
        }

        .sidebar-logo img {
            width: 160px;
            max-height: 45px;
            object-fit: contain;
            filter: brightness(0) invert(1) drop-shadow(0 2px 8px rgba(255,255,255,0.3));
            transition: var(--transition);
        }

        .sidebar-logo img:hover {
            transform: scale(1.08);
            filter: brightness(0) invert(1) drop-shadow(0 4px 16px rgba(255,255,255,0.5));
        }

        /* Menu de Navegação Premium */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.03);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(20, 135, 223, 0.5), rgba(14, 165, 233, 0.5));
            border-radius: 10px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(20, 135, 223, 0.8), rgba(14, 165, 233, 0.8));
        }

        .nav-section-title {
            padding: 1.5rem 1.5rem 0.75rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-section-title::before {
            content: '';
            width: 3px;
            height: 12px;
            background: linear-gradient(180deg, #1487df, #0ea5e9);
            border-radius: 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            padding: 0.875rem 1.25rem;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            margin: 0.25rem 0.75rem;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Linha lateral sutil (aparece no hover e ativo) */
        .sidebar a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(180deg, #1487df, #0ea5e9);
            transform: scaleY(0);
            transition: var(--transition);
            border-radius: 0 4px 4px 0;
        }

        /* Brilho sutil no hover (muito discreto) */
        .sidebar a::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(20, 135, 223, 0.08), transparent);
            opacity: 0;
            transition: var(--transition);
            border-radius: 12px;
        }

        .sidebar a i {
            margin-right: 1rem;
            font-size: 1.25rem;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }

        /* Hover suave */
        .sidebar a:hover {
            color: #ffffff;
            transform: translateX(2px);
        }

        .sidebar a:hover::before {
            transform: scaleY(1);
        }

        .sidebar a:hover::after {
            opacity: 1;
        }

        .sidebar a:hover i {
            background: rgba(20, 135, 223, 0.15);
            transform: scale(1.05);
        }

        /* Item ativo - SUPER SUTIL */
        .sidebar a.active {
            background: transparent; /* SEM FUNDO PESADO */
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar a.active::before {
            transform: scaleY(1);
            box-shadow: 0 0 12px rgba(20, 135, 223, 0.5); /* Brilho na linha */
        }

        .sidebar a.active::after {
            opacity: 1;
            background: linear-gradient(90deg, rgba(20, 135, 223, 0.12), transparent); /* Brilho muito sutil */
        }

        /* Ícone ativo com gradiente suave */
        .sidebar a.active i {
            background: linear-gradient(135deg, rgba(20, 135, 223, 0.25), rgba(14, 165, 233, 0.15));
            color: #60a5fa; /* Azul claro no ícone */
            box-shadow: 0 0 16px rgba(20, 135, 223, 0.3); /* Brilho suave */
        }

        /* Ícones coloridos por categoria (mais sutis) */
        .sidebar a[href*="dashboard"] i {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(37, 99, 235, 0.06));
        }

        .sidebar a[href*="agendamento"] i {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.12), rgba(22, 163, 74, 0.06));
        }

        .sidebar a[href*="orcamento"] i {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(217, 119, 6, 0.06));
        }

        .sidebar a[href*="projeto"] i {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.12), rgba(147, 51, 234, 0.06));
        }

        .sidebar a[href*="pagamento"] i {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.12), rgba(13, 148, 136, 0.06));
        }

        .sidebar a[href*="contato"] i {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.12), rgba(220, 38, 38, 0.06));
        }

        .sidebar a[href*="avaliacao"] i {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.12), rgba(245, 158, 11, 0.06));
        }

        .sidebar a[href*="usuario"] i {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(79, 70, 229, 0.06));
        }

        /* Hover nos ícones coloridos */
        .sidebar a[href*="dashboard"]:hover i {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1));
        }

        .sidebar a[href*="agendamento"]:hover i {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(22, 163, 74, 0.1));
        }

        .sidebar a[href*="orcamento"]:hover i {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(217, 119, 6, 0.1));
        }

        .sidebar a[href*="projeto"]:hover i {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(147, 51, 234, 0.1));
        }

        .sidebar a[href*="pagamento"]:hover i {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2), rgba(13, 148, 136, 0.1));
        }

        .sidebar a[href*="contato"]:hover i {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.1));
        }

        .sidebar a[href*="avaliacao"]:hover i {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(245, 158, 11, 0.1));
        }

        .sidebar a[href*="usuario"]:hover i {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(79, 70, 229, 0.1));
        }

        /* Logout na Sidebar */
        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .sidebar-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10%;
            right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        .sidebar-footer a {
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar-footer a:hover {
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.15);
        }

        .sidebar-footer a:hover i {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(220, 38, 38, 0.2));
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

        /* ==================== SIDEBAR OVERLAY (MOBILE) ==================== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
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
            /* SIDEBAR */
            .sidebar {
                transform: translateX(-100%);
                z-index: 1001; /* Above overlay */
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 8px 0 40px rgba(0, 0, 0, 0.3);
            }

            /* TOPBAR */
            .topbar {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding: 1.25rem 1rem;
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

            /* RESPONSIVE TABLES */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 8px;
            }

            table {
                min-width: 600px;
            }

            /* RESPONSIVE FORMS */
            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-control,
            .form-select {
                width: 100% !important;
                min-height: 44px;
                font-size: 16px; /* Prevents zoom on iOS */
            }

            .btn {
                min-height: 48px;
                font-size: 1rem;
            }

            .btn-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-group .btn {
                width: 100%;
            }

            /* RESPONSIVE CARDS */
            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            /* RESPONSIVE MODALS */
            .modal-dialog {
                margin: 0;
                max-width: 100%;
                height: 100vh;
            }

            .modal-content {
                height: 100%;
                border-radius: 0;
            }

            .modal-header,
            .modal-footer {
                padding: 1rem 1.25rem;
            }

            .modal-body {
                padding: 1.25rem;
                overflow-y: auto;
            }

            /* RESPONSIVE STATS CARDS */
            .stats-card {
                margin-bottom: 1rem;
            }

            .stats-number {
                font-size: 2rem !important;
            }

            /* ACTION BUTTONS */
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            /* Extra small devices */
            .content {
                padding: 1rem 0.75rem;
            }

            .topbar {
                padding: 0 1rem;
            }

            .topbar-title {
                font-size: 1rem;
            }

            /* Single column layout */
            .row > [class*='col-'] {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 1rem;
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
            transition: var(--transition);
        }

        .mobile-menu-btn:hover {
            background: #f1f5f9;
            color: var(--cor-acento);
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
            <a href="/../../index.php">
                <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax Logo">
            </a>
        </div>

        <div class="sidebar-nav">
            <!-- PRINCIPAL -->
            <div class="nav-section-title">Principal</div>
            <a href="/backend/<?= ($tipoUsuario === 'admin') ? 'admin' : 'funcionario' ?>/dashboard" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <!-- GESTÃO -->
            <div class="nav-section-title">Gestão</div>
            
            <!-- Agendamentos - Todos podem acessar -->
            <?php if (Permissions::canAccess($tipoUsuario, 'agendamento')): ?>
            <a href="/backend/agendamento/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'agendamento') ? 'active' : '' ?>">
                <i class="bi bi-calendar-check"></i> Agendamentos
            </a>
            <?php endif; ?>
            
            <!-- Orçamentos - Todos podem ver -->
            <?php if (Permissions::canAccess($tipoUsuario, 'orcamento')): ?>
            <a href="/backend/orcamento/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'orcamento') ? 'active' : '' ?>">
                <i class="bi bi-newspaper"></i> Orçamentos
                <?php if (!Permissions::canCreate($tipoUsuario, 'orcamento')): ?>
                    <span class="badge-readonly"></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
            
            <!-- Projetos - Todos podem ver -->
            <?php if (Permissions::canAccess($tipoUsuario, 'projeto')): ?>
            <a href="/backend/projeto/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'projetos') ? 'active' : '' ?>">
                <i class="bi bi-card-image"></i> Projetos
                <?php if (!Permissions::canCreate($tipoUsuario, 'projeto')): ?>
                    <span class="badge-readonly"></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
            
            <!-- Pagamentos - APENAS ADMIN -->
            <?php if (Permissions::canAccess($tipoUsuario, 'pagamento')): ?>
            <a href="/backend/pagamento/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'pagamento') ? 'active' : '' ?>">
                <i class="bi bi-cash-coin"></i> Pagamentos
            </a>
            <?php endif; ?>

            <!-- COMUNICAÇÃO -->
            <div class="nav-section-title">Comunicação</div>
            
            <!-- Contatos - Todos podem acessar -->
            <?php if (Permissions::canAccess($tipoUsuario, 'contato')): ?>
            <a href="/backend/contato/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'contato') ? 'active' : '' ?>">
                <i class="bi bi-envelope"></i> Contatos
            </a>
            <?php endif; ?>
            
            <!-- Avaliações - Todos podem ver -->
            <?php if (Permissions::canAccess($tipoUsuario, 'avaliacao')): ?>
            <a href="/backend/avaliacao/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'avaliacao') ? 'active' : '' ?>">
                <i class="bi bi-star"></i> Avaliações
                <?php if (!Permissions::canDelete($tipoUsuario, 'avaliacao')): ?>
                    <span class="badge-readonly"></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>

            <!-- CADASTROS -->
            <div class="nav-section-title">Cadastros</div>
            
            <!-- Usuários - APENAS ADMIN -->
            <?php if (Permissions::canAccess($tipoUsuario, 'usuario')): ?>
            <a href="/backend/usuario/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'usuario') ? 'active' : '' ?>">
                <i class="bi bi-people"></i> Usuários
            </a>
            <?php endif; ?>
            
            <!-- Serviços - Todos podem ver -->
            <?php if (Permissions::canAccess($tipoUsuario, 'servico')): ?>
            <a href="/backend/servico/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'servico') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Serviços
                <?php if (!Permissions::canCreate($tipoUsuario, 'servico')): ?>
                    <span class="badge-readonly"></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
            
            <!-- Material - Todos podem ver -->
            <?php if (Permissions::canAccess($tipoUsuario, 'material')): ?>
            <a href="/backend/material/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'material') ? 'active' : '' ?>">
                <i class="bi bi-tools"></i> Materiais
                <?php if (!Permissions::canCreate($tipoUsuario, 'material')): ?>
                    <span class="badge-readonly"></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
            
            <!-- Endereços - Todos podem ver -->
            <?php if (Permissions::canAccess($tipoUsuario, 'endereco')): ?>
            <a href="/backend/endereco/listar" 
            class="<?= str_contains($_SERVER['REQUEST_URI'], 'endereco') ? 'active' : '' ?>">
                <i class="bi bi-geo-alt"></i> Endereços
                <?php if (!Permissions::canCreate($tipoUsuario, 'endereco')): ?>
                    <span class="badge-readonly"></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
        </div>
        <div class="sidebar-footer">
            <a href="/backend/logout">
                <i class="bi bi-box-arrow-left"></i> Sair
            </a>
        </div>
    </nav>

    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="mobile-menu-btn" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <h1 class="topbar-title">Painel de Controle</h1>
                <ul class="breadcrumb-custom">
                    <li>
                        <a href="<?= \App\Impermax\Core\Helpers\LinkHelper::getDashboardUrl() ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li><i class="bi bi-chevron-right"></i></li>
                    <li><?= \App\Impermax\Core\Helpers\LinkHelper::getDashboardLabel() ?></li>
                </ul>
            </div>
        </div>
        <div class="topbar-right">
            <!-- <a href="#" class="topbar-icon-btn" title="Notificações">
                <i class="bi bi-bell"></i>
                <span class="badge-notification"></span>
            </a>
            <a href="#" class="topbar-icon-btn" title="Configurações">
                <i class="bi bi-gear"></i>
            </a> -->
            
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
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // Close sidebar when clicking overlay
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    toggleSidebar();
                });
            }
        });
        </script>