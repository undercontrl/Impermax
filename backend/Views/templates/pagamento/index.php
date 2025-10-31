<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-cash-coin me-2"></i>
                    Pagamentos
                </h1>
                <p class="page-subtitle">Gerencie todos os pagamentos do sistema</p>
            </div>
            <a href="/backend/pagamento/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Pagamento
            </a>
        </div>
    </div>

    <!-- Filtros e Barra de Ações -->
    <form method="GET" action="/backend/pagamento/listar" id="filterForm">
        <input type="hidden" name="ordem_campo" id="ordem_campo" value="<?= htmlspecialchars($_GET['ordem_campo'] ?? '') ?>">
        <input type="hidden" name="ordem_direcao" id="ordem_direcao" value="<?= htmlspecialchars($_GET['ordem_direcao'] ?? '') ?>">
        
        <div class="filters-section">
            <div class="filters-group">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" 
                           name="busca" 
                           placeholder="Buscar por cliente, ID..." 
                           class="search-input"
                           value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                           onkeyup="autoSubmitFilter()">
                </div>
                
                <select class="filter-select" name="status" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Todos os Status</option>
                    <option value="pago" <?= (($_GET['status'] ?? '') === 'pago') ? 'selected' : '' ?>>Pago</option>
                    <option value="aberto" <?= (($_GET['status'] ?? '') === 'aberto') ? 'selected' : '' ?>>Aberto</option>
                </select>

                <select class="filter-select" name="periodo" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Período</option>
                    <option value="hoje" <?= (($_GET['periodo'] ?? '') === 'hoje') ? 'selected' : '' ?>>Hoje</option>
                    <option value="semana" <?= (($_GET['periodo'] ?? '') === 'semana') ? 'selected' : '' ?>>Esta Semana</option>
                    <option value="mes" <?= (($_GET['periodo'] ?? '') === 'mes') ? 'selected' : '' ?>>Este Mês</option>
                </select>

                <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                    <a href="/backend/pagamento/listar" class="btn-filter-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Limpar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Cards de Estatísticas Rápidas -->
    <div class="quick-stats">
        <div class="stat-card stat-pago">
            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pagos</span>
                <span class="stat-value"><?= $stats['pago'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-aberto">
            <div class="stat-icon">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Em Aberto</span>
                <span class="stat-value"><?= $stats['aberto'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-devedor">
            <div class="stat-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total a Receber</span>
                <span class="stat-value">R$ <?= number_format($stats['total_devedor'] ?? 0, 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="stat-card stat-recebido">
            <div class="stat-icon">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Recebido</span>
                <span class="stat-value">R$ <?= number_format($stats['total_recebido'] ?? 0, 2, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Barra de Ações em Massa -->
    <div id="bulkActionsBar" class="bulk-actions-bar" style="display: none;">
        <div class="bulk-actions-info">
            <span id="selectedCount">0</span> pagamento(s) selecionado(s)
        </div>
        <div class="bulk-actions-buttons">
            <button onclick="bulkDelete()" class="btn-bulk-action btn-bulk-delete">
                <i class="bi bi-trash"></i>
                Excluir Selecionados
            </button>
            <button onclick="clearSelection()" class="btn-bulk-action btn-bulk-cancel">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </button>
        </div>
    </div>

    <!-- Tabela de Pagamentos -->
    <div class="content-card">
        <div class="table-container">
            <?php if (!empty($pagamentos)): ?>
                <table class="data-table" id="pagamentosTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="table-checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('id_pagamento')">
                                    ID
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('cliente_nome')">
                                    Cliente
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('data_pagamento')">
                                    Data
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('total_devedor')">
                                    Total Devedor
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('total_pago')">
                                    Total Pago
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>Formas de Pagamento</th>
                            <th>
                                <div class="th-content" onclick="sortTable('status_pagamento')">
                                    Status
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagamentos as $pagamento): ?>
                            <tr class="table-row">
                                <td>
                                    <input type="checkbox" class="table-checkbox row-checkbox" 
                                           value="<?= $pagamento['id_pagamento'] ?>" 
                                           onchange="updateSelection()">
                                </td>
                                <td>
                                    <span class="table-id">#<?= htmlspecialchars($pagamento['id_pagamento']) ?></span>
                                </td>
                                <td>
                                    <div class="client-info">
                                        <div class="client-avatar">
                                            <?= strtoupper(substr($pagamento['cliente_nome'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div class="client-details">
                                            <span class="client-name"><?= htmlspecialchars($pagamento['cliente_nome'] ?? 'Cliente') ?></span>
                                            <span class="client-email"><?= htmlspecialchars($pagamento['cliente_email'] ?? '') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <i class="bi bi-calendar3 me-2 text-muted"></i>
                                        <span><?= date('d/m/Y', strtotime($pagamento['data_pagamento'])) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="table-amount devedor">R$ <?= number_format($pagamento['total_devedor'], 2, ',', '.') ?></span>
                                </td>
                                <td>
                                    <span class="table-amount pago">R$ <?= number_format($pagamento['total_pago'], 2, ',', '.') ?></span>
                                </td>
                                <td>
                                    <div class="payment-methods">
                                        <?php if ($pagamento['dinheiro'] > 0): ?>
                                            <span class="payment-badge dinheiro" title="Dinheiro">
                                                <i class="bi bi-cash"></i>
                                                R$ <?= number_format($pagamento['dinheiro'], 2, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($pagamento['debito'] > 0): ?>
                                            <span class="payment-badge debito" title="Débito">
                                                <i class="bi bi-credit-card"></i>
                                                R$ <?= number_format($pagamento['debito'], 2, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($pagamento['credito'] > 0): ?>
                                            <span class="payment-badge credito" title="Crédito">
                                                <i class="bi bi-credit-card-2-front"></i>
                                                R$ <?= number_format($pagamento['credito'], 2, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($pagamento['pix'] > 0): ?>
                                            <span class="payment-badge pix" title="PIX">
                                                <i class="bi bi-qr-code"></i>
                                                R$ <?= number_format($pagamento['pix'], 2, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        $status = strtolower(trim($pagamento['status_pagamento']));
                                        $statusConfig = match ($status) {
                                            'pago' => ['class' => 'status-pago', 'icon' => 'check-circle-fill', 'text' => 'Pago'],
                                            'aberto' => ['class' => 'status-aberto', 'icon' => 'exclamation-circle-fill', 'text' => 'Em Aberto'],
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
                                        <a href="/backend/pagamento/ver/<?= $pagamento['id_pagamento'] ?>" 
                                           class="btn-action btn-action-view" 
                                           title="Ver detalhes">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/backend/pagamento/editar/<?= $pagamento['id_pagamento'] ?>" 
                                           class="btn-action btn-action-edit" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button onclick="confirmarExclusao(<?= $pagamento['id_pagamento'] ?>)" 
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
                <div class="table-footer">
                    <div class="table-info">
                        Mostrando <strong><?= $paginacao['inicio'] ?? 1 ?></strong> a <strong><?= $paginacao['fim'] ?? count($pagamentos) ?></strong> de <strong><?= $paginacao['total'] ?? count($pagamentos) ?></strong> pagamentos
                    </div>
                    <?php if (isset($paginacao) && $paginacao['total_paginas'] > 1): ?>
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
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h3 class="empty-title">Nenhum pagamento encontrado</h3>
                    <p class="empty-description">
                        <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                            Nenhum resultado corresponde aos filtros aplicados.
                        <?php else: ?>
                            Comece registrando seu primeiro pagamento
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                        <a href="/backend/pagamento/listar" class="btn-action-primary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                            Limpar Filtros
                        </a>
                    <?php else: ?>
                        <a href="/backend/pagamento/criar" class="btn-action-primary">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeiro Pagamento
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-success: #22c55e;
        --cor-warning: #f59e0b;
        --cor-danger: #ef4444;
        --cor-info: #3b82f6;
    }

    .page-wrapper {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
    }

    .page-title i {
        color: var(--cor-acento);
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
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
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    /* Filtros */
    .filters-section {
        margin-bottom: 1.5rem;
    }

    .filters-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
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
        color: #94a3b8;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
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
        transition: all 0.2s;
        min-width: 150px;
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
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-filter-reset:hover {
        background: #f8fafc;
    }

    /* Estatísticas */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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

    .stat-pago .stat-icon {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
        color: white;
    }

    .stat-aberto .stat-icon {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        color: white;
    }

    .stat-devedor .stat-icon {
        background: linear-gradient(135deg, #f87171, var(--cor-danger));
        color: white;
    }

    .stat-recebido .stat-icon {
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

    /* Bulk Actions */
    .bulk-actions-bar {
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .bulk-actions-info {
        font-weight: 600;
    }

    .bulk-actions-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .btn-bulk-action {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-bulk-delete {
        background: var(--cor-danger);
        color: white;
    }

    .btn-bulk-cancel {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    /* Tabela */
    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

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
    }

    .sort-icon {
        font-size: 0.75rem;
        opacity: 0.4;
        transition: all 0.2s;
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

    .table-row:hover {
        background: #fafbfc;
    }

    .table-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--cor-acento);
    }

    .table-id {
        font-weight: 600;
        color: #64748b;
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
        flex-shrink: 0;
    }

    .client-details {
        display: flex;
        flex-direction: column;
    }

    .client-name {
        font-weight: 600;
        color: #1e293b;
    }

    .client-email {
        font-size: 0.8125rem;
        color: #64748b;
    }

    .date-info {
        display: flex;
        align-items: center;
        color: #64748b;
    }

    .table-amount {
        font-weight: 700;
        font-size: 1rem;
    }

    .table-amount.devedor {
        color: var(--cor-danger);
    }

    .table-amount.pago {
        color: var(--cor-success);
    }

    /* Payment Methods */
    .payment-methods {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .payment-badge.dinheiro {
        background: #dcfce7;
        color: #166534;
    }

    .payment-badge.debito {
        background: #dbeafe;
        color: #1e40af;
    }

    .payment-badge.credito {
        background: #fef3c7;
        color: #92400e;
    }

    .payment-badge.pix {
        background: #e0e7ff;
        color: #3730a3;
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
        white-space: nowrap;
    }

    .status-pago {
        background: #dcfce7;
        color: #166534;
    }

    .status-aberto {
        background: #fef3c7;
        color: #92400e;
    }

    .status-default {
        background: #f1f5f9;
        color: #475569;
    }

    /* Action Buttons */
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
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-action-view {
        color: var(--cor-info);
    }

    .btn-action-view:hover {
        background: #dbeafe;
    }

    .btn-action-edit {
        color: var(--cor-acento);
    }

    .btn-action-edit:hover {
        background: #e0f2fe;
    }

    .btn-action-delete {
        color: var(--cor-danger);
    }

    .btn-action-delete:hover {
        background: #fee2e2;
    }

    /* Paginação */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
        flex-wrap: wrap;
        gap: 1rem;
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
        align-items: center;
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
        transition: all 0.2s;
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
        color: #94a3b8;
        padding: 0 0.5rem;
    }

    /* Empty State */
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
        color: #94a3b8;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }

    .empty-description {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0 0 1.5rem 0;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-action-primary {
            width: 100%;
            justify-content: center;
        }

        .filters-group {
            flex-direction: column;
        }

        .search-box {
            max-width: 100%;
        }

        .quick-stats {
            grid-template-columns: 1fr;
        }

        .table-footer {
            flex-direction: column;
            align-items: center;
        }

        .bulk-actions-bar {
            flex-direction: column;
            gap: 1rem;
        }

        .action-buttons {
            flex-wrap: wrap;
        }
    }
</style>

<script>
// ==================== SELEÇÃO DE CHECKBOXES ====================
let selectedIds = new Set();

function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
        if (checkbox.checked) {
            selectedIds.add(cb.value);
        } else {
            selectedIds.delete(cb.value);
        }
    });
    updateSelection();
}

function updateSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    selectedIds.clear();
    checkboxes.forEach(cb => selectedIds.add(cb.value));
    
    const selectAllCheckbox = document.getElementById('selectAll');
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
    
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedIds.size > 0) {
        bulkBar.style.display = 'flex';
        selectedCount.textContent = selectedIds.size;
    } else {
        bulkBar.style.display = 'none';
    }
}

function clearSelection() {
    selectedIds.clear();
    document.querySelectorAll('.table-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('bulkActionsBar').style.display = 'none';
}

// ==================== EXCLUSÃO EM MASSA ====================
function bulkDelete() {
    if (selectedIds.size === 0) {
        alert('Nenhum pagamento selecionado!');
        return;
    }
    
    if (!confirm(`Tem certeza que deseja excluir ${selectedIds.size} pagamento(s)?`)) {
        return;
    }
    
    const formData = new FormData();
    selectedIds.forEach(id => formData.append('ids[]', id));
    
    fetch('/backend/pagamento/deletar-multiplos', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao excluir pagamentos!');
    });
}

// ==================== EXCLUSÃO INDIVIDUAL ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este pagamento?')) {
        window.location.href = `/backend/pagamento/excluir/${id}`;
    }
}

// ==================== ORDENAÇÃO ====================
function sortTable(campo) {
    const ordemCampoInput = document.getElementById('ordem_campo');
    const ordemDirecaoInput = document.getElementById('ordem_direcao');
    
    if (ordemCampoInput.value === campo) {
        ordemDirecaoInput.value = ordemDirecaoInput.value === 'ASC' ? 'DESC' : 'ASC';
    } else {
        ordemCampoInput.value = campo;
        ordemDirecaoInput.value = 'DESC';
    }
    
    document.getElementById('filterForm').submit();
}

// ==================== BUSCA COM DEBOUNCE ====================
let timeoutId;
function autoSubmitFilter() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
}
</script>