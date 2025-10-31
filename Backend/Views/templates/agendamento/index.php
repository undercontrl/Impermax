<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-calendar-check-fill me-2"></i>
                    Agendamentos
                </h1>
                <p class="page-subtitle">Gerencie todos os agendamentos de serviços</p>
            </div>
            <a href="/backend/agendamento/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Agendamento
            </a>
        </div>
    </div>

    <!-- Filtros e Barra de Ações -->
    <form method="GET" action="/backend/agendamento/listar" id="filterForm">
        <!-- Campos hidden para manter ordenação -->
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
                    <option value="pendente" <?= (($_GET['status'] ?? '') === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                    <option value="agendada" <?= (($_GET['status'] ?? '') === 'agendada') ? 'selected' : '' ?>>Agendada</option>
                    <option value="realizada" <?= (($_GET['status'] ?? '') === 'realizada') ? 'selected' : '' ?>>Realizada</option>
                    <option value="cancelada" <?= (($_GET['status'] ?? '') === 'cancelada') ? 'selected' : '' ?>>Cancelada</option>
                </select>

                <select class="filter-select" name="periodo" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Período</option>
                    <option value="hoje" <?= (($_GET['periodo'] ?? '') === 'hoje') ? 'selected' : '' ?>>Hoje</option>
                    <option value="semana" <?= (($_GET['periodo'] ?? '') === 'semana') ? 'selected' : '' ?>>Esta Semana</option>
                    <option value="mes" <?= (($_GET['periodo'] ?? '') === 'mes') ? 'selected' : '' ?>>Este Mês</option>
                </select>

                <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                    <a href="/backend/agendamento/listar" class="btn-filter-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Limpar
                    </a>
                <?php endif; ?>
            </div>

            <div class="view-options">
                <button type="button" class="view-toggle <?= ($_GET['view'] ?? 'list') === 'list' ? 'active' : '' ?>" 
                        onclick="changeView('list')" title="Visualização em Lista">
                    <i class="bi bi-list-ul"></i>
                </button>
                <button type="button" class="view-toggle <?= ($_GET['view'] ?? 'list') === 'grid' ? 'active' : '' ?>" 
                        onclick="changeView('grid')" title="Visualização em Grade">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Cards de Estatísticas Rápidas -->
    <div class="quick-stats">
        <div class="stat-card stat-pendente">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pendentes</span>
                <span class="stat-value"><?= $stats['pendente'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-agendada">
            <div class="stat-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Agendadas</span>
                <span class="stat-value"><?= $stats['agendada'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-realizada">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Realizadas</span>
                <span class="stat-value"><?= $stats['realizada'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Receita Total</span>
                <span class="stat-value">R$ <?= number_format($stats['receita_total'] ?? 0, 2, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Barra de Ações em Massa (aparece quando há seleção) -->
    <div id="bulkActionsBar" class="bulk-actions-bar" style="display: none;">
        <div class="bulk-actions-info">
            <span id="selectedCount">0</span> item(ns) selecionado(s)
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

    <!-- Tabela/Grade de Agendamentos -->
    <div class="content-card">
        <!-- VISUALIZAÇÃO EM TABELA -->
        <div class="table-container" id="tableView" style="<?= ($_GET['view'] ?? 'list') === 'list' ? 'display: block;' : 'display: none;' ?>">
            <?php if (!empty($agendamentos)): ?>
                <table class="data-table" id="agendamentosTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="table-checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('id_agendamento')">
                                    ID
                                    <i class="bi bi-chevron-expand sort-icon <?= ($_GET['ordem_campo'] ?? '') === 'id_agendamento' ? 'active' : '' ?>"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('nome_cliente')">
                                    Cliente
                                    <i class="bi bi-chevron-expand sort-icon <?= ($_GET['ordem_campo'] ?? '') === 'nome_cliente' ? 'active' : '' ?>"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('data_solicitada')">
                                    Data Solicitada
                                    <i class="bi bi-chevron-expand sort-icon <?= ($_GET['ordem_campo'] ?? '') === 'data_solicitada' ? 'active' : '' ?>"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('total_agendamento')">
                                    Valor Total
                                    <i class="bi bi-chevron-expand sort-icon <?= ($_GET['ordem_campo'] ?? '') === 'total_agendamento' ? 'active' : '' ?>"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('status_agendamento')">
                                    Status
                                    <i class="bi bi-chevron-expand sort-icon <?= ($_GET['ordem_campo'] ?? '') === 'status_agendamento' ? 'active' : '' ?>"></i>
                                </div>
                            </th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agendamentos as $agendamento): ?>
                            <tr class="table-row">
                                <td>
                                    <input type="checkbox" class="table-checkbox row-checkbox" 
                                           value="<?= $agendamento['id_agendamento'] ?>" 
                                           onchange="updateSelection()">
                                </td>
                                <td>
                                    <span class="table-id">#<?= htmlspecialchars($agendamento['id_agendamento']) ?></span>
                                </td>
                                <td>
                                    <div class="client-info">
                                        <div class="client-avatar">
                                            <?= strtoupper(substr($agendamento['nome_cliente'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div class="client-details">
                                            <span class="client-name"><?= htmlspecialchars($agendamento['nome_cliente'] ?? 'Cliente') ?></span>
                                            <span class="client-email"><?= htmlspecialchars($agendamento['email_cliente'] ?? 'email@exemplo.com') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <i class="bi bi-calendar3 me-2 text-muted"></i>
                                        <span><?= htmlspecialchars(date('d/m/Y', strtotime($agendamento['data_solicitada']))) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?= htmlspecialchars($agendamento['descricao_servico'] ?? '—') ?>
                                </td>
                                <td>
                                    R$ <?= number_format($agendamento['total_agendamento'] ?? 0, 2, ',', '.') ?>
                                </td>

                                <!-- <td>
                                    <span class="table-amount">R$ </span>
                                </td> -->
                                <td>
                                    <?php
                                        $status = strtolower(trim($agendamento['status_agendamento']));
                                        $statusConfig = match ($status) {
                                            'realizada' => ['class' => 'status-realizada', 'icon' => 'check-circle-fill', 'text' => 'Realizada'],
                                            'agendada'  => ['class' => 'status-agendada', 'icon' => 'calendar-check-fill', 'text' => 'Agendada'],
                                            'pendente'  => ['class' => 'status-pendente', 'icon' => 'clock-fill', 'text' => 'Pendente'],
                                            'cancelada' => ['class' => 'status-cancelada', 'icon' => 'x-circle-fill', 'text' => 'Cancelada'],
                                            default     => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status)]
                                        };
                                    ?>
                                    <span class="status-badge <?= $statusConfig['class'] ?>">
                                        <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
                                        <?= $statusConfig['text'] ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="action-buttons">
                                        <a href="/backend/agendamento/ver/<?= $agendamento['id_agendamento'] ?>" 
                                           class="btn-action btn-action-view" 
                                           title="Ver detalhes">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/backend/agendamento/editar/<?= $agendamento['id_agendamento'] ?>" 
                                           class="btn-action btn-action-edit" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button onclick="confirmarExclusao(<?= $agendamento['id_agendamento'] ?>)" 
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
                        Mostrando <strong><?= $paginacao['inicio'] ?? 1 ?></strong> a <strong><?= $paginacao['fim'] ?? count($agendamentos) ?></strong> de <strong><?= $paginacao['total'] ?? count($agendamentos) ?></strong> agendamentos
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
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3 class="empty-title">Nenhum agendamento encontrado</h3>
                    <p class="empty-description">
                        <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                            Nenhum resultado corresponde aos filtros aplicados. Tente ajustar sua busca.
                        <?php else: ?>
                            Comece criando seu primeiro agendamento de serviço
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                        <a href="/backend/agendamento/listar" class="btn-action-primary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                            Limpar Filtros
                        </a>
                    <?php else: ?>
                        <a href="/backend/agendamento/criar" class="btn-action-primary">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeiro Agendamento
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- VISUALIZAÇÃO EM GRADE -->
        <div class="grid-container" id="gridView" style="<?= ($_GET['view'] ?? 'list') === 'grid' ? 'display: block;' : 'display: none;' ?>">
            <?php if (!empty($agendamentos)): ?>
                <div class="agendamentos-grid">
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <div class="agendamento-card">
                            <!-- Checkbox no canto -->
                            <div class="card-checkbox-wrapper">
                                <input type="checkbox" 
                                       class="table-checkbox row-checkbox" 
                                       value="<?= $agendamento['id_agendamento'] ?>" 
                                       onchange="updateSelection()">
                            </div>

                            <!-- Header do Card -->
                            <div class="card-header">
                                <div class="card-id">
                                    <i class="bi bi-calendar-event"></i>
                                    #<?= htmlspecialchars($agendamento['id_agendamento']) ?>
                                </div>
                                <?php
                                    $status = strtolower(trim($agendamento['status_agendamento']));
                                    $statusConfig = match ($status) {
                                        'realizada' => ['class' => 'status-realizada', 'icon' => 'check-circle-fill', 'text' => 'Realizada'],
                                        'agendada'  => ['class' => 'status-agendada', 'icon' => 'calendar-check-fill', 'text' => 'Agendada'],
                                        'pendente'  => ['class' => 'status-pendente', 'icon' => 'clock-fill', 'text' => 'Pendente'],
                                        'cancelada' => ['class' => 'status-cancelada', 'icon' => 'x-circle-fill', 'text' => 'Cancelada'],
                                        default     => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status)]
                                    };
                                ?>
                                <span class="status-badge <?= $statusConfig['class'] ?>">
                                    <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
                                    <?= $statusConfig['text'] ?>
                                </span>
                            </div>

                            <!-- Cliente Info -->
                            <div class="card-client">
                                <div class="client-avatar-large">
                                    <?= strtoupper(substr($agendamento['nome_cliente'] ?? 'C', 0, 1)) ?>
                                </div>
                                <div class="client-details-card">
                                    <h3 class="client-name-card"><?= htmlspecialchars($agendamento['nome_cliente'] ?? 'Cliente') ?></h3>
                                    <p class="client-email-card"><?= htmlspecialchars($agendamento['email_cliente'] ?? 'email@exemplo.com') ?></p>
                                </div>
                            </div>

                            <!-- Informações -->
                            <div class="card-info">
                                <div class="info-item">
                                    <i class="bi bi-calendar3"></i>
                                    <div>
                                        <span class="info-label">Data Solicitada</span>
                                        <span class="info-value"><?= htmlspecialchars(date('d/m/Y', strtotime($agendamento['data_solicitada']))) ?></span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-cash-coin"></i>
                                    <div>
                                        <span class="info-label">Valor Total</span>
                                        <span class="info-value">R$ <?= number_format($agendamento['total_agendamento'], 2, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="card-actions">
                                <a href="/backend/agendamento/ver/<?= $agendamento['id_agendamento'] ?>" 
                                   class="btn-card-action btn-card-view">
                                    <i class="bi bi-eye"></i>
                                    Ver
                                </a>
                                <a href="/backend/agendamento/editar/<?= $agendamento['id_agendamento'] ?>" 
                                   class="btn-card-action btn-card-edit">
                                    <i class="bi bi-pencil"></i>
                                    Editar
                                </a>
                                <button onclick="confirmarExclusao(<?= $agendamento['id_agendamento'] ?>)" 
                                        class="btn-card-action btn-card-delete">
                                    <i class="bi bi-trash"></i>
                                    Excluir
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Paginação (mesma da tabela) -->
                <div class="table-footer">
                    <div class="table-info">
                        Mostrando <strong><?= $paginacao['inicio'] ?? 1 ?></strong> a <strong><?= $paginacao['fim'] ?? count($agendamentos) ?></strong> de <strong><?= $paginacao['total'] ?? count($agendamentos) ?></strong> agendamentos
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
                            if (!empty($_GET['view'])) $params[] = 'view=' . urlencode($_GET['view']);
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
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3 class="empty-title">Nenhum agendamento encontrado</h3>
                    <p class="empty-description">
                        <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                            Nenhum resultado corresponde aos filtros aplicados. Tente ajustar sua busca.
                        <?php else: ?>
                            Comece criando seu primeiro agendamento de serviço
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['periodo'])): ?>
                        <a href="/backend/agendamento/listar" class="btn-action-primary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                            Limpar Filtros
                        </a>
                    <?php else: ?>
                        <a href="/backend/agendamento/criar" class="btn-action-primary">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeiro Agendamento
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

    /* ==================== HEADER DA PÁGINA ==================== */
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

    /* ==================== FILTROS ==================== */
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

    /* ==================== ESTATÍSTICAS RÁPIDAS ==================== */
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

    .stat-pendente .stat-icon {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        color: white;
    }

    .stat-agendada .stat-icon {
        background: linear-gradient(135deg, #60a5fa, var(--cor-info));
        color: white;
    }

    .stat-realizada .stat-icon {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
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

    /* ==================== AÇÕES EM MASSA ==================== */
    .bulk-actions-bar {
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: var(--spacing-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow-md);
        animation: slideDown 0.3s ease;
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

    .bulk-actions-info {
        font-weight: 600;
        font-size: 0.9375rem;
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
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-bulk-delete {
        background: var(--cor-danger);
        color: white;
    }

    .btn-bulk-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .btn-bulk-cancel {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .btn-bulk-cancel:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* ==================== CARD DE CONTEÚDO ==================== */
    .content-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    /* ==================== TABELA ==================== */
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
        accent-color: var(--cor-acento);
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
        margin-top: 15px;
    }

    .status-realizada {
        background: #dcfce7;
        color: #166534;
    }

    .status-agendada {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-pendente {
        background: #fef3c7;
        color: #92400e;
    }

    .status-cancelada {
        background: #fee2e2;
        color: #991b1b;
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

    /* ==================== FOOTER DA TABELA ==================== */
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
        color: #94a3b8;
        padding: 0 0.5rem;
    }

    /* ==================== VISUALIZAÇÃO EM GRADE ==================== */
    .grid-container {
        padding: 1.5rem;
    }

    .agendamentos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .agendamento-card {
        background: white;
        border-radius: var(--border-radius);
        border: 1px solid #f1f5f9;
        padding: 1.5rem;
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .agendamento-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: #e2e8f0;
    }

    .card-checkbox-wrapper {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .card-id {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #64748b;
        font-size: 0.875rem;
    }

    .card-id i {
        color: var(--cor-acento);
        font-size: 1rem;
    }

    .card-client {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .client-avatar-large {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .client-details-card {
        flex: 1;
        min-width: 0;
    }

    .client-name-card {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .client-email-card {
        font-size: 0.875rem;
        color: var(--cor-cinza);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .info-item i {
        font-size: 1.25rem;
        color: var(--cor-acento);
        margin-top: 0.125rem;
    }

    .info-item > div {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .card-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .btn-card-action {
        padding: 0.625rem 0.75rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        text-decoration: none;
    }

    .btn-card-view {
        color: var(--cor-info);
        border-color: #dbeafe;
    }

    .btn-card-view:hover {
        background: #dbeafe;
        border-color: var(--cor-info);
        transform: translateY(-1px);
    }

    .btn-card-edit {
        color: var(--cor-acento);
        border-color: #e0f2fe;
    }

    .btn-card-edit:hover {
        background: #e0f2fe;
        border-color: var(--cor-acento);
        transform: translateY(-1px);
    }

    .btn-card-delete {
        color: var(--cor-danger);
        border-color: #fee2e2;
    }

    .btn-card-delete:hover {
        background: #fee2e2;
        border-color: var(--cor-danger);
        transform: translateY(-1px);
    }

    /* ==================== ESTADO VAZIO ==================== */
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

    /* ==================== RESPONSIVIDADE ==================== */
    @media (max-width: 1024px) {
        .quick-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-action-primary {
            width: 100%;
            justify-content: center;
        }

        .filters-section {
            flex-direction: column;
            align-items: stretch;
        }

        .filters-group {
            flex-direction: column;
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
        }

        .table-footer {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .action-buttons {
            flex-wrap: wrap;
        }

        .bulk-actions-bar {
            flex-direction: column;
            gap: 1rem;
        }

        .bulk-actions-buttons {
            width: 100%;
            justify-content: stretch;
        }

        .btn-bulk-action {
            flex: 1;
        }

        /* Grid responsivo */
        .agendamentos-grid {
            grid-template-columns: 1fr;
        }

        .card-actions {
            grid-template-columns: 1fr;
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
        alert('Nenhum agendamento selecionado!');
        return;
    }
    
    if (!confirm(`Tem certeza que deseja excluir ${selectedIds.size} agendamento(s)?\n\nEsta ação não pode ser desfeita.`)) {
        return;
    }
    
    const formData = new FormData();
    selectedIds.forEach(id => formData.append('ids[]', id));
    
    fetch('/backend/agendamento/deletar-multiplos', {
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
        alert('Erro ao excluir agendamentos!');
    });
}

// ==================== EXCLUSÃO INDIVIDUAL ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este agendamento?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/agendamento/excluir/${id}`;
    }
}

// ==================== ORDENAÇÃO ====================
function sortTable(campo) {
    const ordemCampoInput = document.getElementById('ordem_campo');
    const ordemDirecaoInput = document.getElementById('ordem_direcao');
    
    // Se clicar no mesmo campo, inverte a direção
    if (ordemCampoInput.value === campo) {
        ordemDirecaoInput.value = ordemDirecaoInput.value === 'ASC' ? 'DESC' : 'ASC';
    } else {
        // Se for um novo campo, começa com DESC
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

// ==================== MUDANÇA DE VISUALIZAÇÃO ====================
function changeView(view) {
    const url = new URL(window.location);
    url.searchParams.set('view', view);
    window.location.href = url.toString();
}

// Alternar visualizações sem recarregar (alternativa)
function toggleView(view) {
    const tableView = document.getElementById('tableView');
    const gridView = document.getElementById('gridView');
    
    if (view === 'list') {
        tableView.style.display = 'block';
        gridView.style.display = 'none';
    } else {
        tableView.style.display = 'none';
        gridView.style.display = 'block';
    }
    
    // Atualizar estado ativo dos botões
    document.querySelectorAll('.view-toggle').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.view-toggle').classList.add('active');
}

// ==================== INICIALIZAÇÃO ====================
document.addEventListener('DOMContentLoaded', function() {
    // Atualizar estado dos ícones de ordenação
    const ordemCampo = new URLSearchParams(window.location.search).get('ordem_campo');
    const ordemDirecao = new URLSearchParams(window.location.search).get('ordem_direcao');
    
    if (ordemCampo) {
        const sortIcons = document.querySelectorAll('.sort-icon');
        sortIcons.forEach(icon => {
            const th = icon.closest('.th-content');
            if (th && th.textContent.toLowerCase().includes(ordemCampo.toLowerCase())) {
                icon.classList.add('active');
                if (ordemDirecao === 'ASC') {
                    icon.classList.remove('bi-chevron-expand');
                    icon.classList.add('bi-chevron-up');
                } else {
                    icon.classList.remove('bi-chevron-expand');
                    icon.classList.add('bi-chevron-down');
                }
            }
        });
    }
});
</script>