<div class="dashboard-wrapper">
    <!-- Header do Dashboard -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Bem-vindo, <?= htmlspecialchars($nomeUsuario); ?>!</h1>
            <p class="dashboard-subtitle">Aqui está o que está acontecendo com seu negócio hoje</p>
        </div>
        <div class="dashboard-header-actions">
            <select class="form-select dashboard-select">
                <option>Último Mês</option>
                <option>Últimos 3 Meses</option>
                <option>Último Ano</option>
            </select>
            <!-- <button class="btn btn-primary dashboard-btn-primary">
                <i class="bi bi-download me-2"></i>Exportar
            </button> -->
        </div>
    </div>

    <!-- Cards de Métricas - AGORA COM LINKS -->
    <div class="metrics-grid">
        <!-- Card Usuários -->
        <a href="/backend/usuario/listar" class="metric-card-link">
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-label">Total de Usuários</span>
                    <div class="metric-icon metric-icon-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="metric-content">
                    <h2 class="metric-value"><?= count($usuarios) ?></h2>
                    <div class="metric-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>14.9%</span>
                        <span class="metric-comparison">(+<?= rand(5, 15) ?>)</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card Agendamentos -->
        <a href="/backend/agendamento/listar" class="metric-card-link">
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-label">Agendamentos</span>
                    <div class="metric-icon metric-icon-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
                <div class="metric-content">
                    <h2 class="metric-value"><?= htmlspecialchars($totalAgendamentos ?? 0) ?></h2>
                    <div class="metric-trend trend-down">
                        <i class="bi bi-arrow-down"></i>
                        <span>8.6%</span>
                        <span class="metric-comparison">(-<?= rand(1, 5) ?>)</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card Orçamentos -->
        <a href="/backend/orcamento/listar" class="metric-card-link">
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-label">Orçamentos Ativos</span>
                    <div class="metric-icon metric-icon-info">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                <div class="metric-content">
                    <h2 class="metric-value"><?= htmlspecialchars($totalOrcamentos ?? 0) ?></h2>
                    <div class="metric-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>25.4%</span>
                        <span class="metric-comparison">(+<?= rand(10, 20) ?>)</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card Contatos -->
        <a href="/backend/contato/listar" class="metric-card-link">
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-label">Novos Contatos</span>
                    <div class="metric-icon metric-icon-warning">
                        <i class="bi bi-chat-left-dots"></i>
                    </div>
                </div>
                <div class="metric-content">
                    <h2 class="metric-value"><?= htmlspecialchars($totalContatos ?? 0) ?></h2>
                    <div class="metric-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>12.4%</span>
                        <span class="metric-comparison">(+<?= rand(3, 8) ?>)</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- Card Taxa de Conversão -->
        <a href="#" class="metric-card-link">
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-label">Taxa de Conversão</span>
                    <div class="metric-icon metric-icon-accent">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>
                <div class="metric-content">
                    <h2 class="metric-value">32.65%</h2>
                    <div class="metric-trend trend-down">
                        <i class="bi bi-arrow-down"></i>
                        <span>12.42%</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Tabela de Usuários Modernizada -->
    <div class="dashboard-section">
        <div class="section-header">
            <div>
                <h3 class="section-title">Usuários Registrados</h3>
                <p class="section-subtitle">Gerencie todos os usuários do sistema</p>
            </div>
            <a href="/backend/usuario/listar" class="btn btn-outline-primary">
                <i class="bi bi-eye me-2"></i>Ver Todos
            </a>
        </div>

        <?php if (!empty($usuarios)): ?>
            <div class="modern-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $usuario): ?>
                            <tr>
                                <td class="text-muted">#<?= htmlspecialchars($usuario['id_usuario']) ?></td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">
                                            <?= strtoupper(substr($usuario['nome_usuario'], 0, 1)) ?>
                                        </div>
                                        <span class="user-name"><?= htmlspecialchars($usuario['nome_usuario']) ?></span>
                                    </div>
                                </td>
                                <td class="text-muted"><?= htmlspecialchars($usuario['email_usuario']) ?></td>
                                <td>
                                    <span class="badge-modern badge-secondary">
                                        <?= htmlspecialchars(ucfirst($usuario['tipo_usuario'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                        $status = strtolower($usuario['status_usuario']);
                                        $badgeClass = match($status) {
                                            'ativo' => 'badge-success',
                                            'pendente' => 'badge-warning',
                                            'inativo' => 'badge-secondary',
                                            default => 'badge-dark'
                                        };
                                        $statusIcon = match($status) {
                                            'ativo' => 'check-circle-fill',
                                            'pendente' => 'clock-fill',
                                            'inativo' => 'x-circle-fill',
                                            default => 'circle-fill'
                                        };
                                    ?>
                                    <span class="badge-modern <?= $badgeClass ?>">
                                        <i class="bi bi-<?= $statusIcon ?> me-1"></i>
                                        <?= htmlspecialchars(ucfirst($status)) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="/backend/usuario/editar/<?= $usuario['id_usuario'] ?>" class="btn-icon" title="Ver detalhes">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Nenhum usuário encontrado</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Reset e variáveis */
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-clara: #ffffff;
        --cor-cinza: #a7a7a7;
        --cor-fundo: #f4f6f9;
        --cor-success: #22c55e;
        --cor-warning: #f59e0b;
        --cor-info: #3b82f6;
        --cor-danger: #ef4444;
        --border-radius: 12px;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header do Dashboard */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-xl);
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .dashboard-subtitle {
        font-size: 0.95rem;
        color: var(--cor-cinza);
        margin: 0.25rem 0 0 0;
    }

    .dashboard-header-actions {
        display: flex;
        gap: var(--spacing-md);
        align-items: center;
    }

    .dashboard-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        min-width: 150px;
        cursor: pointer;
        transition: var(--transition);
    }

    .dashboard-select:focus {
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .dashboard-btn-primary {
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(20, 135, 223, 0.3);
        transition: var(--transition);
    }

    .dashboard-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.4);
    }

    /* Grid de Métricas */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-xl);
    }

    /* Link wrapper para os cards */
    .metric-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .metric-card {
        background: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--cor-primaria), var(--cor-acento));
        opacity: 0;
        transition: var(--transition);
    }

    .metric-card-link:hover .metric-card {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: #e2e8f0;
    }

    .metric-card-link:hover .metric-card::before {
        opacity: 1;
    }

    .metric-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-md);
    }

    .metric-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .metric-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .metric-icon-primary {
        background: linear-gradient(135deg, #6b7fa8, var(--cor-primaria));
        color: white;
    }

    .metric-icon-success {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
        color: white;
    }

    .metric-icon-info {
        background: linear-gradient(135deg, #60a5fa, var(--cor-info));
        color: white;
    }

    .metric-icon-warning {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        color: white;
    }

    .metric-icon-accent {
        background: linear-gradient(135deg, #1e9eff, var(--cor-acento));
        color: white;
    }

    .metric-content {
        margin-top: var(--spacing-md);
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .metric-trend {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .trend-up {
        color: var(--cor-success);
    }

    .trend-down {
        color: var(--cor-danger);
    }

    .metric-comparison {
        color: #64748b;
        font-weight: 400;
    }

    /* Seção da Tabela */
    .dashboard-section {
        background: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-xl);
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: var(--cor-cinza);
        margin: 0.25rem 0 0 0;
    }

    .btn-outline-primary {
        border: 1.5px solid var(--cor-acento);
        color: var(--cor-acento);
        background: transparent;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-outline-primary:hover {
        background: var(--cor-acento);
        color: white;
        transform: translateY(-2px);
    }

    /* Tabela Moderna */
    .modern-table {
        overflow-x: auto;
        border-radius: 8px;
    }

    .modern-table table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead {
        background: #f8fafc;
    }

    .modern-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-table td {
        padding: 1rem;
        font-size: 0.9375rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tbody tr {
        transition: var(--transition);
    }

    .modern-table tbody tr:hover {
        background: #fafbfc;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Célula de Usuário */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .user-name {
        font-weight: 500;
        color: #1e293b;
    }

    /* Badges Modernos */
    .badge-modern {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        letter-spacing: 0.025em;
    }

    .badge-success {
        background: #dcfce7;
        color: #166534;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-secondary {
        background: #e2e8f0;
        color: #475569;
    }

    .badge-dark {
        background: #e2e8f0;
        color: #334155;
    }

    /* Botão de Ícone */
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        background: transparent;
        color: var(--cor-cinza);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-icon:hover {
        background: #f1f5f9;
        color: var(--cor-acento);
    }

    /* Estado Vazio */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--cor-cinza);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 0.9375rem;
        margin: 0;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-header-actions {
            width: 100%;
            flex-direction: column;
        }

        .dashboard-select,
        .dashboard-btn-primary {
            width: 100%;
        }

        .metrics-grid {
            grid-template-columns: 1fr;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-outline-primary {
            width: 100%;
            justify-content: center;
        }

        .modern-table {
            font-size: 0.875rem;
        }

        .modern-table th,
        .modern-table td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>