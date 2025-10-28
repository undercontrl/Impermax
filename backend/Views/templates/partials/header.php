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

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="/public/css/status-badges.css">

    <style>
        :root {
            --cor-primaria: #5f7396;
            --cor-acento: #1487df;
            --cor-clara: #ffffff;
            --cor-cinza: #a7a7a7;
            --cor-fundo: #f4f6f9;
        }

        body {
            background-color: var(--cor-fundo);
            font-family: 'Inter', sans-serif;
            color: #333;
            display: flex;
            margin: 0;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--cor-primaria);
            color: var(--cor-clara);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--cor-acento);
            padding: 1.2rem 1rem;
            height: 80px;
        }

        .sidebar-logo img {
            width: 150px;
            max-height: 50px;
            object-fit: contain;
            filter: brightness(0) invert(1); /* deixa a logo branca se for escura */
            transition: 0.3s ease;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: var(--cor-clara);
            text-decoration: none;
            padding: 12px 20px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--cor-acento);
            color: #fff;
        }

        /* Conteúdo principal */
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 30px 40px;
            background-color: var(--cor-fundo);
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #e3e3e3;
            padding-bottom: 10px;
        }

        .topbar h1 {
            font-size: 1.6rem;
            color: var(--cor-primaria);
            font-weight: 600;
        }

        .user-info {
            color: var(--cor-cinza);
            font-size: 0.9rem;
        }

        .user-info i {
            color: var(--cor-acento);
            margin-right: 6px;
        }

        /* Alertas flash */
        .alert {
            margin-bottom: 20px;
        }
        /*Botão Logout */
        .botao-sair {
            margin-top: auto;
            background-color: var(--cor-primaria);
            color: #fff ;
        }
    </style>
</head>

<body>

    <!-- Menu lateral -->
    <nav class="sidebar">
        <div class="sidebar-logo">
            <a href="/backend/admin/dashboard">
                <img src="/assets/icons/impermax-LOGO.svg" alt="Impermax Logo">
            </a>
        </div>
        <a href="/backend/agendamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'agendamento') ? 'active' : '' ?>"><i class="bi bi-calendar-check"></i> Agendamentos</a>
        <a href="/backend/avaliacao/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'avaliacao') ? 'active' : '' ?>"><i class="bi bi-star"></i> Avaliações</a>
        <a href="/backend/contato/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'contato') ? 'active' : '' ?>"><i class="bi bi-envelope"></i> Contatos</a>
        <a href="/backend/endereco/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'endereco') ? 'active' : '' ?>"><i class="bi bi-geo-alt"></i> Endereços</a>
        <a href="/backend/item_agendamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'item_agendamento') ? 'active' : '' ?>"><i class="bi bi-list-check"></i> Itens Agendamento</a>
        <a href="/backend/item_orcamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'item_orcamento') ? 'active' : '' ?>"><i class="bi bi-receipt"></i> Itens Orçamento</a>
        <a href="/backend/usuario/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'usuario') ? 'active' : '' ?>"><i class="bi bi-people"></i> Usuários</a>
        <a href="/backend/material/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'material') ? 'active' : '' ?>"><i class="bi bi-tools"></i>Material</a>
        <a href="/backend/orcamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'orcamento') ? 'active' : '' ?>"><i class="bi bi-newspaper"></i>Orçamentos</a>
        <a href="/backend/pagamento/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'pagamento') ? 'active' : '' ?>"><i class="bi bi-cash-coin"></i>Pagamentos</a>
        <a href="/backend/projeto/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'projetos') ? 'active' : '' ?>"><i class="bi bi-card-image"></i>Projetos</a>
        <a href="/backend/servico/listar" class="<?= str_contains($_SERVER['REQUEST_URI'], 'servico') ? 'active' : '' ?>"><i class="bi bi-box-seam"></i>Serviços</a>
        <a href="/backend/logout" class ="botao-sair"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </nav>

    <!-- Conteúdo -->
    <main class="content">
        <div class="topbar">
            <h1>Painel de Controle</h1>
            <div class="user-info">
                <i class="bi bi-person-circle"></i> Administrador
            </div>
        </div>

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
                    echo $value;
                    echo "</div>";
                }
            }
        }
        ?>
