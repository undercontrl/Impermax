<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-tools me-2"></i>
                    Materiais
                </h1>
                <p class="page-subtitle">Gerencie todos os materiais utilizados nos serviços</p>
            </div>
            <a href="/backend/material/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Material
            </a>
        </div>
    </div>

    <!-- Filtros e Barra de Ações -->
    <form method="GET" action="/backend/material/listar" id="filterForm">
        <input type="hidden" name="ordem_campo" id="ordem_campo" value="<?= htmlspecialchars($_GET['ordem_campo'] ?? '') ?>">
        <input type="hidden" name="ordem_direcao" id="ordem_direcao" value="<?= htmlspecialchars($_GET['ordem_direcao'] ?? '') ?>">
        
        <div class="filters-section">
            <div class="filters-group">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" 
                           name="busca" 
                           placeholder="Buscar por nome, descrição..." 
                           class="search-input"
                           value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                           onkeyup="autoSubmitFilter()">
                </div>
                
                <select class="filter-select" name="servico" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Todos os Serviços</option>
                    <?php foreach ($servicosUnicos as $s): ?>
                        <option value="<?= $s['id_servico'] ?>" <?= (($_GET['servico'] ?? '') == $s['id_servico']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nome_servico']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if (!empty($_GET['busca']) || !empty($_GET['servico'])): ?>
                    <a href="/backend/material/listar" class="btn-filter-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Limpar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Cards de Estatísticas Rápidas -->
    <div class="quick-stats">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total de Materiais</span>
                <span class="stat-value"><?= $stats['total_materiais'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-stock">
            <div class="stat-icon">
                <i class="bi bi-boxes"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Itens em Estoque</span>
                <span class="stat-value"><?= $stats['total_estoque'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-low">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Estoque Baixo</span>
                <span class="stat-value"><?= $stats['estoque_baixo'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-services">
            <div class="stat-icon">
                <i class="bi bi-gear-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Serviços Vinculados</span>
                <span class="stat-value"><?= $stats['servicos_vinculados'] ?? 0 ?></span>
            </div>
        </div>
    </div>

    <!-- Barra de Ações em Massa -->
    <div id="bulkActionsBar" class="bulk-actions-bar" style="display: none;">
        <div class="bulk-actions-info">
            <span id="selectedCount">0</span> material(is) selecionado(s)
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

    <!-- Tabela de Materiais -->
    <div class="content-card">
        <div class="table-container">
            <?php if (!empty($materiais)): ?>
                <table class="data-table" id="materiaisTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="table-checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('id_material')">
                                    ID
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('nome_material')">
                                    Material
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('qtd_material')">
                                    Quantidade
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>Descrição</th>
                            <th>
                                <div class="th-content" onclick="sortTable('nome_servico')">
                                    Serviço
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materiais as $material): ?>
                            <tr class="table-row">
                                <td>
                                    <input type="checkbox" class="table-checkbox row-checkbox" 
                                           value="<?= $material['id_material'] ?>" 
                                           onchange="updateSelection()">
                                </td>
                                <td>
                                    <span class="table-id">#<?= htmlspecialchars($material['id_material']) ?></span>
                                </td>
                                <td>
                                    <div class="material-info">
                                        <div class="material-icon">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <span class="material-name"><?= htmlspecialchars($material['nome_material']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        $qtd = (int)$material['qtd_material'];
                                        $badgeClass = match(true) {
                                            $qtd === 0 => 'qty-empty',
                                            $qtd < 10 => 'qty-low',
                                            $qtd < 50 => 'qty-medium',
                                            default => 'qty-high'
                                        };
                                        $icon = match(true) {
                                            $qtd === 0 => 'x-circle-fill',
                                            $qtd < 10 => 'exclamation-triangle-fill',
                                            default => 'check-circle-fill'
                                        };
                                    ?>
                                    <span class="qty-badge <?= $badgeClass ?>">
                                        <i class="bi bi-<?= $icon ?>"></i>
                                        <?= $qtd ?> un.
                                    </span>
                                </td>
                                <td>
                                    <div class="description-text">
                                        <?= htmlspecialchars(mb_substr($material['descricao_material'], 0, 60)) ?>
                                        <?= mb_strlen($material['descricao_material']) > 60 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($material['nome_servico'])): ?>
                                        <span class="service-badge">
                                            <i class="bi bi-gear-fill"></i>
                                            <?= htmlspecialchars($material['nome_servico']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="action-buttons">
                                        <a href="/backend/material/editar/<?= $material['id_material'] ?>" 
                                           class="btn-action btn-action-edit" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button onclick="confirmarExclusao(<?= $material['id_material'] ?>)" 
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
                        Mostrando <strong><?= $paginacao['inicio'] ?? 1 ?></strong> a <strong><?= $paginacao['fim'] ?? count($materiais) ?></strong> de <strong><?= $paginacao['total'] ?? count($materiais) ?></strong> materiais
                    </div>
                    <?php if (isset($paginacao) && $paginacao['total_paginas'] > 1): ?>
                        <div class="pagination">
                            <?php
                            $params = [];
                            if (!empty($_GET['busca'])) $params[] = 'busca=' . urlencode($_GET['busca']);
                            if (!empty($_GET['servico'])) $params[] = 'servico=' . urlencode($_GET['servico']);
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
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="empty-title">Nenhum material encontrado</h3>
                    <p class="empty-description">
                        <?php if (!empty($_GET['busca']) || !empty($_GET['servico'])): ?>
                            Nenhum resultado corresponde aos filtros aplicados.
                        <?php else: ?>
                            Comece cadastrando o primeiro material
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($_GET['busca']) || !empty($_GET['servico'])): ?>
                        <a href="/backend/material/listar" class="btn-action-primary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                            Limpar Filtros
                        </a>
                    <?php else: ?>
                        <a href="/backend/material/criar" class="btn-action-primary">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeiro Material
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
        color: var(--cor-primaria);
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

    .stat-total .stat-icon {
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
    }

    .stat-stock .stat-icon {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
        color: white;
    }

    .stat-low .stat-icon {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        color: white;
    }

    .stat-services .stat-icon {
        background: linear-gradient(135deg, #60a5fa, var(--cor-info));
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

    /* Material Info */
    .material-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .material-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .material-name {
        font-weight: 600;
        color: #1e293b;
    }

    /* Quantidade Badge */
    .qty-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .qty-empty {
        background: #fee2e2;
        color: #991b1b;
    }

    .qty-low {
        background: #fef3c7;
        color: #92400e;
    }

    .qty-medium {
        background: #dbeafe;
        color: #1e40af;
    }

    .qty-high {
        background: #dcfce7;
        color: #166534;
    }

    .description-text {
        color: #64748b;
        font-size: 0.875rem;
        max-width: 350px;
    }

    /* Service Badge */
    .service-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        white-space: nowrap;
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
        transition: all 0.2s;
        text-decoration: none;
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

    .text-muted {
        color: #94a3b8;
    }

    .text-end {
        text-align: right;
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
        alert('Nenhum material selecionado!');
        return;
    }
    
    const count = selectedIds.size;
    const materialText = count === 1 ? 'material' : 'materiais';
    
    if (!confirm(`Tem certeza que deseja excluir ${count} ${materialText}?\n\nEsta ação não pode ser desfeita.`)) {
        return;
    }
    
    // Mostrar loading
    const bulkBar = document.getElementById('bulkActionsBar');
    const originalHTML = bulkBar.innerHTML;
    bulkBar.innerHTML = '<div style="text-align: center; width: 100%; padding: 1rem;">Excluindo materiais... Por favor, aguarde.</div>';
    
    const formData = new FormData();
    selectedIds.forEach(id => {
        formData.append('ids[]', id);
        console.log('Adicionando ID:', id); // Debug
    });
    
    console.log('IDs para excluir:', Array.from(selectedIds)); // Debug
    console.log('URL da requisição:', window.location.origin + '/backend/material/deletar-multiplos'); // Debug
    
    // Tentar com caminho absoluto primeiro
    const url = '/backend/material/deletar-multiplos';
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Status HTTP:', response.status); // Debug
        console.log('Headers:', response.headers); // Debug
        
        if (response.status === 404) {
            throw new Error('Rota não encontrada (404). Verifique se a rota POST /backend/material/deletar-multiplos existe.');
        }
        
        if (!response.ok) {
            throw new Error('Erro HTTP: ' + response.status);
        }
        
        // Tentar ler como JSON
        return response.json().catch(err => {
            console.error('Resposta não é JSON:', err);
            return response.text().then(text => {
                console.error('Resposta texto:', text);
                throw new Error('Resposta inválida do servidor');
            });
        });
    })
    .then(data => {
        console.log('Resposta do servidor:', data); // Debug
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            bulkBar.innerHTML = originalHTML;
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro completo:', error);
        bulkBar.innerHTML = originalHTML;
        alert('Erro ao excluir materiais: ' + error.message + '\n\nVerifique o console (F12) para mais detalhes.');
    });
}

// ==================== EXCLUSÃO INDIVIDUAL ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este material?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/material/excluir/${id}`;
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