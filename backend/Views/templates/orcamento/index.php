<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-receipt-cutoff me-2"></i>
                    Orçamentos
                </h1>
                <p class="page-subtitle">Gerencie todos os orçamentos de projetos</p>
            </div>
            <a href="/backend/orcamento/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Orçamento
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <form method="GET" action="/backend/orcamento/listar" id="filterForm">
        <input type="hidden" name="ordem_campo" id="ordem_campo" value="<?= htmlspecialchars($_GET['ordem_campo'] ?? '') ?>">
        <input type="hidden" name="ordem_direcao" id="ordem_direcao" value="<?= htmlspecialchars($_GET['ordem_direcao'] ?? '') ?>">
        
        <div class="filters-section">
            <div class="filters-group">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" 
                           name="busca" 
                           placeholder="Buscar por cliente, descrição..." 
                           class="search-input"
                           value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                           onkeyup="autoSubmitFilter()">
                </div>
                
                <select class="filter-select" name="status" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Todos os Status</option>
                    <option value="aprovado" <?= (($_GET['status'] ?? '') === 'aprovado') ? 'selected' : '' ?>>Aprovado</option>
                    <option value="aguardando" <?= (($_GET['status'] ?? '') === 'aguardando') ? 'selected' : '' ?>>Aguardando</option>
                    <option value="recusado" <?= (($_GET['status'] ?? '') === 'recusado') ? 'selected' : '' ?>>Recusado</option>
                    <option value="em_analise" <?= (($_GET['status'] ?? '') === 'em_analise') ? 'selected' : '' ?>>Em Análise</option>
                </select>

                <select class="filter-select" name="periodo" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Período</option>
                    <option value="hoje" <?= (($_GET['periodo'] ?? '') === 'hoje') ? 'selected' : '' ?>>Hoje</option>
                    <option value="semana" <?= (($_GET['periodo'] ?? '') === 'semana') ? 'selected' : '' ?>>Esta Semana</option>
                    <option value="mes" <?= (($_GET['periodo'] ?? '') === 'mes') ? 'selected' : '' ?>>Este Mês</option>
                </select>

                <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                    <a href="/backend/orcamento/listar" class="btn-filter-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Limpar
                    </a>
                <?php endif; ?>
            </div>

            <!--<div class="view-options">
                <button type="button" class="view-toggle active" title="Visualização em Grade">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
                <button type="button" class="view-toggle" title="Visualização em Lista">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>-->
        </div>
    </form>

    <!-- Stats Cards -->
    <div class="quick-stats">
        <div class="stat-card stat-aprovado">
            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Aprovados</span>
                <span class="stat-value"><?= $stats['aprovado'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-aguardando">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Aguardando</span>
                <span class="stat-value"><?= $stats['aguardando'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-analise">
            <div class="stat-icon">
                <i class="bi bi-search"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Em Análise</span>
                <span class="stat-value"><?= $stats['em_analise'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Valor Total</span>
                <span class="stat-value">R$ <?= number_format($stats['valor_total'] ?? 0, 2, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Tabela -->
    <div class="content-card">
        <!-- Barra de ações em massa -->
        <div class="bulk-actions" id="bulkActions" style="display: none;">
            <div class="bulk-actions-content">
                <span class="bulk-selected-count">
                    <strong id="selectedCount">0</strong> itens selecionados
                </span>
                <div class="bulk-actions-buttons">
                    <button type="button" class="btn-bulk-action" onclick="alterarStatusEmMassa('aprovado')">
                        <i class="bi bi-check-circle"></i> Aprovar Selecionados
                    </button>
                    <button type="button" class="btn-bulk-action" onclick="alterarStatusEmMassa('recusado')">
                        <i class="bi bi-x-circle"></i> Recusar Selecionados
                    </button>
                    <button type="button" class="btn-bulk-action btn-bulk-danger" onclick="excluirEmMassa()">
                        <i class="bi bi-trash"></i> Excluir Selecionados
                    </button>
                </div>
            </div>
        </div>

        <div class="table-container">
            <?php if (!empty($orcamentos)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" class="table-checkbox" id="selectAll" onchange="toggleSelectAll()">
                            </th>
                            <th style="width: 80px;">
                                <div class="th-content" onclick="ordenarPor('id_orcamento')">
                                    ID
                                    <?php 
                                    $campo = $_GET['ordem_campo'] ?? '';
                                    $direcao = $_GET['ordem_direcao'] ?? '';
                                    if ($campo === 'id_orcamento'): ?>
                                        <i class="bi bi-chevron-<?= $direcao === 'ASC' ? 'up' : 'down' ?> sort-icon active"></i>
                                    <?php else: ?>
                                        <i class="bi bi-chevron-expand sort-icon"></i>
                                    <?php endif; ?>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="ordenarPor('cliente_nome')">
                                    Cliente
                                    <?php if ($campo === 'cliente_nome'): ?>
                                        <i class="bi bi-chevron-<?= $direcao === 'ASC' ? 'up' : 'down' ?> sort-icon active"></i>
                                    <?php else: ?>
                                        <i class="bi bi-chevron-expand sort-icon"></i>
                                    <?php endif; ?>
                                </div>
                            </th>
                            <th>Descrição</th>
                            <th>
                                <div class="th-content" onclick="ordenarPor('data_orcamento')">
                                    Data
                                    <?php if ($campo === 'data_orcamento'): ?>
                                        <i class="bi bi-chevron-<?= $direcao === 'ASC' ? 'up' : 'down' ?> sort-icon active"></i>
                                    <?php else: ?>
                                        <i class="bi bi-chevron-expand sort-icon"></i>
                                    <?php endif; ?>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="ordenarPor('valor_orcamento')">
                                    Valor
                                    <?php if ($campo === 'valor_orcamento'): ?>
                                        <i class="bi bi-chevron-<?= $direcao === 'ASC' ? 'up' : 'down' ?> sort-icon active"></i>
                                    <?php else: ?>
                                        <i class="bi bi-chevron-expand sort-icon"></i>
                                    <?php endif; ?>
                                </div>
                            </th>
                            <th>Itens</th>
                            <th>
                                <div class="th-content" onclick="ordenarPor('status_orcamento')">
                                    Status
                                    <?php if ($campo === 'status_orcamento'): ?>
                                        <i class="bi bi-chevron-<?= $direcao === 'ASC' ? 'up' : 'down' ?> sort-icon active"></i>
                                    <?php else: ?>
                                        <i class="bi bi-chevron-expand sort-icon"></i>
                                    <?php endif; ?>
                                </div>
                            </th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orcamentos as $orcamento): ?>
                            <tr class="table-row">
                                <td>
                                    <input type="checkbox" 
                                           class="table-checkbox row-checkbox" 
                                           value="<?= $orcamento['id_orcamento'] ?>"
                                           onchange="updateSelectedCount()">
                                </td>
                                <td>
                                    <span class="table-id">#<?= htmlspecialchars($orcamento['id_orcamento']) ?></span>
                                </td>
                                <td>
                                    <div class="client-info">
                                        <div class="client-avatar">
                                            <?= strtoupper(substr($orcamento['cliente_nome'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div class="client-details">
                                            <span class="client-name"><?= htmlspecialchars($orcamento['cliente_nome'] ?? 'Cliente') ?></span>
                                            <span class="client-email"><?= htmlspecialchars($orcamento['cliente_email'] ?? 'Sem email') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="description-text">
                                        <?= htmlspecialchars(substr($orcamento['descricao_orcamento'], 0, 50)) ?>
                                        <?= strlen($orcamento['descricao_orcamento']) > 50 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <i class="bi bi-calendar3 me-2 text-muted"></i>
                                        <span><?= htmlspecialchars(date('d/m/Y', strtotime($orcamento['data_orcamento']))) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="table-amount">R$ <?= number_format($orcamento['valor_orcamento'], 2, ',', '.') ?></span>
                                </td>
                                <td>
                                    <span class="items-badge"><?= htmlspecialchars($orcamento['total_item_orcamento']) ?> itens</span>
                                </td>
                                <td>
                                    <?php
                                        $status = $orcamento['status_orcamento'];
                                        $statusConfig = match ($status) {
                                            'aprovado' => ['class' => 'status-aprovado', 'icon' => 'check-circle-fill', 'text' => 'Aprovado'],
                                            'aguardando' => ['class' => 'status-aguardando', 'icon' => 'clock-fill', 'text' => 'Aguardando'],
                                            'recusado' => ['class' => 'status-recusado', 'icon' => 'x-circle-fill', 'text' => 'Recusado'],
                                            'em_analise' => ['class' => 'status-analise', 'icon' => 'search', 'text' => 'Em Análise'],
                                            default => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status)]
                                        };
                                    ?>
                                    <span class="status-badge <?= $statusConfig['class'] ?>">
                                        <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
                                        <?= $statusConfig['text'] ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="action-buttons">
                                        <a href="/backend/orcamento/visualizar/<?= $orcamento['id_orcamento'] ?>" 
                                           class="btn-action btn-action-view" 
                                           title="Ver detalhes">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/backend/orcamento/editar/<?= $orcamento['id_orcamento'] ?>" 
                                           class="btn-action btn-action-edit" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button onclick="confirmarExclusao(<?= $orcamento['id_orcamento'] ?>)" 
                                                class="btn-action btn-action-delete" 
                                                title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Paginação -->
                <?php if (isset($paginacao) && $paginacao['total_paginas'] > 1): ?>
                    <div class="table-footer">
                        <div class="table-info">
                            Mostrando <strong><?= $paginacao['inicio'] ?>-<?= $paginacao['fim'] ?></strong> de <strong><?= $paginacao['total'] ?></strong> orçamentos
                        </div>
                        <div class="pagination">
                            <?php 
                            $params = [];
                            if (!empty($_GET['busca'])) $params[] = 'busca=' . urlencode($_GET['busca']);
                            if (!empty($_GET['status'])) $params[] = 'status=' . urlencode($_GET['status']);
                            if (!empty($_GET['periodo'])) $params[] = 'periodo=' . urlencode($_GET['periodo']);
                            if (!empty($_GET['ordem_campo'])) $params[] = 'ordem_campo=' . urlencode($_GET['ordem_campo']);
                            if (!empty($_GET['ordem_direcao'])) $params[] = 'ordem_direcao=' . urlencode($_GET['ordem_direcao']);
                            $queryString = !empty($params) ? '&' . implode('&', $params) : '';
                            ?>

                            <?php if ($paginacao['pagina_atual'] > 1): ?>
                                <a href="?pagina=<?= $paginacao['pagina_atual'] - 1 ?><?= $queryString ?>" class="pagination-btn">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            <?php else: ?>
                                <button class="pagination-btn" disabled>
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                            <?php endif; ?>

                            <?php 
                            $inicio = max(1, $paginacao['pagina_atual'] - 2);
                            $fim = min($paginacao['total_paginas'], $paginacao['pagina_atual'] + 2);
                            
                            if ($inicio > 1): ?>
                                <a href="?pagina=1<?= $queryString ?>" class="pagination-btn">1</a>
                                <?php if ($inicio > 2): ?>
                                    <span class="pagination-dots">...</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                                <?php if ($i == $paginacao['pagina_atual']): ?>
                                    <button class="pagination-btn active"><?= $i ?></button>
                                <?php else: ?>
                                    <a href="?pagina=<?= $i ?><?= $queryString ?>" class="pagination-btn"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($fim < $paginacao['total_paginas']): ?>
                                <?php if ($fim < $paginacao['total_paginas'] - 1): ?>
                                    <span class="pagination-dots">...</span>
                                <?php endif; ?>
                                <a href="?pagina=<?= $paginacao['total_paginas'] ?><?= $queryString ?>" class="pagination-btn"><?= $paginacao['total_paginas'] ?></a>
                            <?php endif; ?>

                            <?php if ($paginacao['pagina_atual'] < $paginacao['total_paginas']): ?>
                                <a href="?pagina=<?= $paginacao['pagina_atual'] + 1 ?><?= $queryString ?>" class="pagination-btn">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            <?php else: ?>
                                <button class="pagination-btn" disabled>
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <h3 class="empty-title">Nenhum orçamento encontrado</h3>
                    <p class="empty-description">Comece criando seu primeiro orçamento</p>
                    <a href="/backend/orcamento/criar" class="btn-action-primary">
                        <i class="bi bi-plus-lg me-2"></i>
                        Criar Primeiro Orçamento
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-clara: #ffffff;
        --cor-cinza: #a7a7a7;
        --cor-fundo: #f4f6f9;
        --cor-success: #22c55e;
        --cor-warning: #f59e0b;
        --cor-danger: #ef4444;
        --cor-info: #3b82f6;
        --border-radius: 12px;
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header */
    .page-header {
        margin-bottom: var(--spacing-xl);
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    .page-title-group {
        flex: 1;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 var(--spacing-xs) 0;
        display: flex;
        align-items: center;
        letter-spacing: -0.025em;
    }

    .page-title i {
        color: var(--cor-acento);
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: var(--cor-cinza);
        margin: 0;
    }

    .btn-action-primary {
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    /* Filtros */
    .filters-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .filters-group {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
        flex: 1;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 280px;
        max-width: 400px;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--cor-cinza);
        font-size: 1rem;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: var(--transition);
        background: white;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .filter-select {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        background: white;
        cursor: pointer;
        transition: var(--transition);
        min-width: 150px;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .btn-filter-reset {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        color: #64748b;
        font-size: 0.9375rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-filter-reset:hover {
        background: #f8fafc;
        border-color: var(--cor-cinza);
    }

    .view-options {
        display: flex;
        gap: 0.5rem;
        background: white;
        padding: 0.375rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .view-toggle {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 8px;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .view-toggle:hover {
        background: #f1f5f9;
        color: var(--cor-acento);
    }

    .view-toggle.active {
        background: var(--cor-acento);
        color: white;
    }

    /* Stats */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-xl);
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-lg);
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
        border: 1px solid #f1f5f9;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-aprovado .stat-icon {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
        color: white;
    }

    .stat-aguardando .stat-icon {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        color: white;
    }

    .stat-analise .stat-icon {
        background: linear-gradient(135deg, #60a5fa, var(--cor-info));
        color: white;
    }

    .stat-total .stat-icon {
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-top: 0.25rem;
    }

    /* Card */
    .content-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    /* Bulk Actions */
    .bulk-actions {
        background: #f0f9ff;
        border-bottom: 2px solid #bae6fd;
        padding: 1rem 1.5rem;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bulk-actions-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .bulk-selected-count {
        font-size: 0.9375rem;
        color: #0c4a6e;
        font-weight: 500;
    }

    .bulk-selected-count strong {
        color: var(--cor-acento);
        font-size: 1.125rem;
    }

    .bulk-actions-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-bulk-action {
        padding: 0.625rem 1rem;
        border: none;
        border-radius: 8px;
        background: white;
        color: #475569;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .btn-bulk-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-bulk-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-bulk-danger:hover {
        background: #fecaca;
    }

    /* Tabela */
    .table-container {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table thead {
        background: #f8fafc;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .th-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        user-select: none;
    }

    .sort-icon {
        font-size: 0.75rem;
        opacity: 0.4;
        transition: var(--transition);
    }

    .sort-icon.active {
        opacity: 1;
        color: var(--cor-acento);
    }

    .th-content:hover .sort-icon {
        opacity: 1;
        color: var(--cor-acento);
    }

    .data-table td {
        padding: 1rem 1.25rem;
        font-size: 0.9375rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-row {
        transition: var(--transition);
    }

    .table-row:hover {
        background: #fafbfc;
    }

    .table-checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 4px;
        cursor: pointer;
        transition: var(--transition);
    }

    .table-checkbox:checked {
        background: var(--cor-acento);
        border-color: var(--cor-acento);
    }

    .table-id {
        font-weight: 600;
        color: #64748b;
        font-size: 0.875rem;
    }

    /* Cliente Info */
    .client-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .client-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9375rem;
        flex-shrink: 0;
    }

    .client-details {
        display: flex;
        flex-direction: column;
    }

    .client-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9375rem;
    }

    .client-email {
        font-size: 0.8125rem;
        color: var(--cor-cinza);
    }

    .description-text {
        color: #64748b;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .date-info {
        display: flex;
        align-items: center;
        color: #64748b;
    }

    .table-amount {
        font-weight: 700;
        color: #1e293b;
        font-size: 1rem;
    }

    .items-badge {
        padding: 0.375rem 0.75rem;
        background: #f1f5f9;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #475569;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        letter-spacing: 0.025em;
        white-space: nowrap;
    }

    .status-aprovado {
        background: #dcfce7;
        color: #166534;
    }

    .status-aguardando {
        background: #fef3c7;
        color: #92400e;
    }

    .status-recusado {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-analise {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-default {
        background: #f1f5f9;
        color: #475569;
    }

    /* Botões de Ação */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 1rem;
        text-decoration: none;
    }

    .btn-action-view {
        color: var(--cor-info);
    }

    .btn-action-view:hover {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-action-edit {
        color: var(--cor-acento);
    }

    .btn-action-edit:hover {
        background: #e0f2fe;
        color: #0e6eb8;
    }

    .btn-action-delete {
        color: var(--cor-danger);
    }

    .btn-action-delete:hover {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Footer da Tabela */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    .table-info {
        font-size: 0.875rem;
        color: #64748b;
    }

    .table-info strong {
        color: #1e293b;
        font-weight: 600;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination-btn:hover:not(:disabled):not(.active) {
        border-color: var(--cor-acento);
        color: var(--cor-acento);
        background: #f0f9ff;
    }

    .pagination-btn.active {
        background: var(--cor-acento);
        color: white;
        border-color: var(--cor-acento);
        font-weight: 600;
    }

    .pagination-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .pagination-dots {
        padding: 0 0.5rem;
        color: #94a3b8;
        font-weight: 600;
    }

    /* Estado Vazio */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--cor-cinza);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }

    .empty-description {
        font-size: 0.9375rem;
        color: var(--cor-cinza);
        margin: 0 0 1.5rem 0;
    }

    /* Responsividade */
    @media (max-width: 1024px) {
        .quick-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .btn-action-primary {
            width: 100%;
            justify-content: center;
        }

        .filters-section {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }

        .filters-group {
            flex-direction: column;
            gap: 0.75rem;
        }

        .search-box {
            max-width: 100%;
        }

        .view-options {
            width: 100%;
            justify-content: center;
        }

        .quick-stats {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .table-footer {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.5rem;
        }

        .page-subtitle {
            font-size: 0.8125rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            font-size: 1.25rem;
        }

        .stat-value {
            font-size: 1.25rem;
        }
    }
</style>

<script>
// ==================== CONFIRMAÇÃO DE EXCLUSÃO ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este orçamento?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/orcamento/excluir/${id}`;
    }
}

// ==================== AUTO-SUBMIT FILTROS ====================
let timeoutId;
function autoSubmitFilter() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
}

// ==================== ORDENAÇÃO DE COLUNAS ====================
function ordenarPor(campo) {
    const form = document.getElementById('filterForm');
    const campoInput = document.getElementById('ordem_campo');
    const direcaoInput = document.getElementById('ordem_direcao');
    
    if (campoInput.value === campo) {
        direcaoInput.value = direcaoInput.value === 'ASC' ? 'DESC' : 'ASC';
    } else {
        campoInput.value = campo;
        direcaoInput.value = 'ASC';
    }
    
    form.submit();
}

// ==================== SELEÇÃO MÚLTIPLA ====================
const selectedIds = new Set();

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
        if (selectAll.checked) {
            selectedIds.add(checkbox.value);
        } else {
            selectedIds.delete(checkbox.value);
        }
    });
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const count = checkboxes.length;
    
    selectedIds.clear();
    checkboxes.forEach(cb => selectedIds.add(cb.value));
    
    const bulkActions = document.getElementById('bulkActions');
    const selectedCountEl = document.getElementById('selectedCount');
    
    if (count > 0) {
        bulkActions.style.display = 'block';
        selectedCountEl.textContent = count;
    } else {
        bulkActions.style.display = 'none';
    }
    
    const selectAll = document.getElementById('selectAll');
    const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
    selectAll.checked = count === totalCheckboxes && count > 0;
    selectAll.indeterminate = count > 0 && count < totalCheckboxes;
}

// ==================== AÇÕES EM MASSA ====================
function alterarStatusEmMassa(novoStatus) {
    if (selectedIds.size === 0) {
        alert('Nenhum item selecionado!');
        return;
    }
    
    const statusTexto = {
        'aprovado': 'Aprovado',
        'aguardando': 'Aguardando',
        'recusado': 'Recusado',
        'em_analise': 'Em Análise'
    };
    
    if (confirm(`Deseja alterar o status de ${selectedIds.size} orçamento(s) para "${statusTexto[novoStatus]}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/backend/orcamento/alterar-status-massa';
        
        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'ids';
        idsInput.value = Array.from(selectedIds).join(',');
        form.appendChild(idsInput);
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = novoStatus;
        form.appendChild(statusInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function excluirEmMassa() {
    if (selectedIds.size === 0) {
        alert('Nenhum item selecionado!');
        return;
    }
    
    if (confirm(`⚠️ ATENÇÃO!\n\nDeseja excluir ${selectedIds.size} orçamento(s)?\n\nEsta ação não pode ser desfeita!`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/backend/orcamento/excluir-massa';
        
        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'ids';
        idsInput.value = Array.from(selectedIds).join(',');
        form.appendChild(idsInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// ==================== INICIALIZAÇÃO ====================
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    updateSelectedCount();
});
</script>