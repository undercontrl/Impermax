<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-star-fill me-2"></i>
                    Avaliações
                </h1>
                <p class="page-subtitle">Gerencie todas as avaliações de clientes</p>
            </div>
            <a href="/backend/avaliacao/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Nova Avaliação
            </a>
        </div>
    </div>

    <!-- Filtros e Barra de Ações -->
    <form method="GET" action="/backend/avaliacao/listar" id="filterForm">
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
                    <option value="publicada" <?= (($_GET['status'] ?? '') === 'publicada') ? 'selected' : '' ?>>Publicada</option>
                    <option value="pendente" <?= (($_GET['status'] ?? '') === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                    <option value="oculta" <?= (($_GET['status'] ?? '') === 'oculta') ? 'selected' : '' ?>>Oculta</option>
                </select>

                <select class="filter-select" name="nota" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Todas as Notas</option>
                    <option value="5" <?= (($_GET['nota'] ?? '') === '5') ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (5 estrelas)</option>
                    <option value="4" <?= (($_GET['nota'] ?? '') === '4') ? 'selected' : '' ?>>⭐⭐⭐⭐ (4 estrelas)</option>
                    <option value="3" <?= (($_GET['nota'] ?? '') === '3') ? 'selected' : '' ?>>⭐⭐⭐ (3 estrelas)</option>
                    <option value="2" <?= (($_GET['nota'] ?? '') === '2') ? 'selected' : '' ?>>⭐⭐ (2 estrelas)</option>
                    <option value="1" <?= (($_GET['nota'] ?? '') === '1') ? 'selected' : '' ?>>⭐ (1 estrela)</option>
                </select>

                <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['nota'])): ?>
                    <a href="/backend/avaliacao/listar" class="btn-filter-reset">
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
                <i class="bi bi-chat-quote"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total de Avaliações</span>
                <span class="stat-value"><?= count($avaliacoes ?? []) ?></span>
            </div>
        </div>

        <div class="stat-card stat-publicada">
            <div class="stat-icon">
                <i class="bi bi-eye-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Publicadas</span>
                <span class="stat-value">
                    <?= count(array_filter($avaliacoes ?? [], fn($a) => strtolower($a['status_avaliacao']) === 'publicada')) ?>
                </span>
            </div>
        </div>

        <div class="stat-card stat-pendente">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pendentes</span>
                <span class="stat-value">
                    <?= count(array_filter($avaliacoes ?? [], fn($a) => strtolower($a['status_avaliacao']) === 'pendente')) ?>
                </span>
            </div>
        </div>

        <div class="stat-card stat-rating">
            <div class="stat-icon">
                <i class="bi bi-star-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Média de Notas</span>
                <span class="stat-value">
                    <?php 
                    $notas = array_column($avaliacoes ?? [], 'nota_avaliacao');
                    $media = !empty($notas) ? round(array_sum($notas) / count($notas), 1) : 0;
                    echo $media;
                    ?>
                    <i class="bi bi-star-fill" style="font-size: 1rem; color: #fbbf24; margin-left: 0.25rem;"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Barra de Ações em Massa -->
    <div id="bulkActionsBar" class="bulk-actions-bar" style="display: none;">
        <div class="bulk-actions-info">
            <span id="selectedCount">0</span> avaliação(ões) selecionada(s)
        </div>
        <div class="bulk-actions-buttons">
            <button onclick="bulkDelete()" class="btn-bulk-action btn-bulk-delete">
                <i class="bi bi-trash"></i>
                Excluir Selecionadas
            </button>
            <button onclick="clearSelection()" class="btn-bulk-action btn-bulk-cancel">
                <i class="bi bi-x-lg"></i>
                Cancelar
            </button>
        </div>
    </div>

    <!-- Tabela de Avaliações -->
    <div class="content-card">
        <div class="table-container">
            <?php if (!empty($avaliacoes)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="table-checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('id_avaliacao')">
                                    ID
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('nome_usuario')">
                                    Cliente
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    Avaliação
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('nota_avaliacao')">
                                    Nota
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('status_avaliacao')">
                                    Status
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th>
                                <div class="th-content" onclick="sortTable('criado_em')">
                                    Data
                                    <i class="bi bi-chevron-expand sort-icon"></i>
                                </div>
                            </th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avaliacoes as $avaliacao): ?>
                            <tr class="table-row">
                                <td>
                                    <input type="checkbox" class="table-checkbox row-checkbox" 
                                           value="<?= $avaliacao['id_avaliacao'] ?>" 
                                           onchange="updateSelection()">
                                </td>
                                <td>
                                    <span class="table-id">#<?= htmlspecialchars($avaliacao['id_avaliacao']) ?></span>
                                </td>
                                <td>
                                    <div class="client-info">
                                        <div class="client-avatar">
                                            <?= strtoupper(substr($avaliacao['nome_usuario'] ?? 'C', 0, 1)) ?>
                                        </div>
                                        <div class="client-details">
                                            <span class="client-name"><?= htmlspecialchars($avaliacao['nome_usuario'] ?? 'Cliente') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avaliacao-text">
                                        <?= htmlspecialchars(mb_substr($avaliacao['descricao_avaliacao'], 0, 80)) ?>
                                        <?= mb_strlen($avaliacao['descricao_avaliacao']) > 80 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="rating-stars">
                                        <?php 
                                        $nota = (int)$avaliacao['nota_avaliacao'];
                                        for ($i = 1; $i <= 5; $i++): 
                                        ?>
                                            <i class="bi bi-star-fill <?= $i <= $nota ? 'star-active' : 'star-inactive' ?>"></i>
                                        <?php endfor; ?>
                                        <span class="rating-number"><?= $nota ?>/5</span>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        $status = strtolower(trim($avaliacao['status_avaliacao']));
                                        $statusConfig = match ($status) {
                                            'publicada' => ['class' => 'status-publicada', 'icon' => 'eye-fill', 'text' => 'Publicada'],
                                            'pendente'  => ['class' => 'status-pendente', 'icon' => 'clock-fill', 'text' => 'Pendente'],
                                            'oculta'    => ['class' => 'status-oculta', 'icon' => 'eye-slash-fill', 'text' => 'Oculta'],
                                            default     => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status)]
                                        };
                                    ?>
                                    <span class="status-badge <?= $statusConfig['class'] ?>">
                                        <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
                                        <?= $statusConfig['text'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <i class="bi bi-calendar3 me-2 text-muted"></i>
                                        <span><?= date('d/m/Y', strtotime($avaliacao['criado_em'])) ?></span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="action-buttons">
                                        <a href="/backend/avaliacao/editar/<?= $avaliacao['id_avaliacao'] ?>" 
                                           class="btn-action btn-action-edit" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button onclick="confirmarExclusao(<?= $avaliacao['id_avaliacao'] ?>)" 
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

            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-star"></i>
                    </div>
                    <h3 class="empty-title">Nenhuma avaliação encontrada</h3>
                    <p class="empty-description">
                        <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['nota'])): ?>
                            Nenhum resultado corresponde aos filtros aplicados.
                        <?php else: ?>
                            Comece cadastrando a primeira avaliação de cliente
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($_GET['busca']) || !empty($_GET['status']) || !empty($_GET['nota'])): ?>
                        <a href="/backend/avaliacao/listar" class="btn-action-primary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                            Limpar Filtros
                        </a>
                    <?php else: ?>
                        <a href="/backend/avaliacao/criar" class="btn-action-primary">
                            <i class="bi bi-plus-lg me-2"></i>
                            Criar Primeira Avaliação
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Paginação -->
    <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Mostrando <?= min((($paginaAtual ?? 1) - 1) * 10 + 1, $totalRegistros ?? 0) ?> 
                a <?= min(($paginaAtual ?? 1) * 10, $totalRegistros ?? 0) ?> 
                de <?= $totalRegistros ?? 0 ?> resultados
            </div>
            
            <div class="pagination">
                <?php if (($paginaAtual ?? 1) > 1): ?>
                    <a href="?pagina=1<?= !empty($_GET['busca']) ? '&busca=' . urlencode($_GET['busca']) : '' ?><?= !empty($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?><?= !empty($_GET['nota']) ? '&nota=' . urlencode($_GET['nota']) : '' ?>" 
                    class="pagination-btn">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                    <a href="?pagina=<?= ($paginaAtual ?? 1) - 1 ?><?= !empty($_GET['busca']) ? '&busca=' . urlencode($_GET['busca']) : '' ?><?= !empty($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?><?= !empty($_GET['nota']) ? '&nota=' . urlencode($_GET['nota']) : '' ?>" 
                    class="pagination-btn">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                <?php endif; ?>
                
                <?php
                $inicio = max(1, ($paginaAtual ?? 1) - 2);
                $fim = min($totalPaginas ?? 1, ($paginaAtual ?? 1) + 2);
                
                for ($i = $inicio; $i <= $fim; $i++):
                ?>
                    <a href="?pagina=<?= $i ?><?= !empty($_GET['busca']) ? '&busca=' . urlencode($_GET['busca']) : '' ?><?= !empty($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?><?= !empty($_GET['nota']) ? '&nota=' . urlencode($_GET['nota']) : '' ?>" 
                    class="pagination-btn <?= $i === ($paginaAtual ?? 1) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                
                <?php if (($paginaAtual ?? 1) < ($totalPaginas ?? 1)): ?>
                    <a href="?pagina=<?= ($paginaAtual ?? 1) + 1 ?><?= !empty($_GET['busca']) ? '&busca=' . urlencode($_GET['busca']) : '' ?><?= !empty($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?><?= !empty($_GET['nota']) ? '&nota=' . urlencode($_GET['nota']) : '' ?>" 
                    class="pagination-btn">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="?pagina=<?= $totalPaginas ?? 1 ?><?= !empty($_GET['busca']) ? '&busca=' . urlencode($_GET['busca']) : '' ?><?= !empty($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?><?= !empty($_GET['nota']) ? '&nota=' . urlencode($_GET['nota']) : '' ?>" 
                    class="pagination-btn">
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
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
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
        letter-spacing: -0.025em;
    }

    .page-title i {
        color: #fbbf24;
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

    /* ==================== ESTATÍSTICAS ==================== */
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

    .stat-total .stat-icon {
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
    }

    .stat-publicada .stat-icon {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
        color: white;
    }

    .stat-pendente .stat-icon {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        color: white;
    }

    .stat-rating .stat-icon {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
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
        display: flex;
        align-items: center;
    }

    /* ==================== TABELA ==================== */
    .content-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
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

    .client-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9375rem;
    }

    /* Avaliação Text */
    .avaliacao-text {
        color: #64748b;
        font-size: 0.875rem;
        line-height: 1.5;
        max-width: 350px;
    }

    /* Rating Stars */
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .rating-stars i {
        font-size: 1rem;
    }

    .star-active {
        color: #fbbf24;
    }

    .star-inactive {
        color: #e2e8f0;
    }

    .rating-number {
        margin-left: 0.5rem;
        font-weight: 600;
        color: #64748b;
        font-size: 0.875rem;
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

    .status-publicada {
        background: #dcfce7;
        color: #166534;
    }

    .status-pendente {
        background: #fef3c7;
        color: #92400e;
    }

    .status-oculta {
        background: #f1f5f9;
        color: #64748b;
    }

    .status-default {
        background: #f1f5f9;
        color: #475569;
    }

    .date-info {
        display: flex;
        align-items: center;
        color: #64748b;
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
        transition: var(--transition);
        font-size: 1rem;
        text-decoration: none;
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
        background: #fef3c7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #f59e0b;
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

    /* Paginação */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: white;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-btn {
        min-width: 40px;
        height: 40px;
        padding: 0 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #64748b;
        font-weight: 600;
        font-size: 0.9375rem;
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
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        border-color: var(--cor-acento);
    }

    .pagination-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* ==================== RESPONSIVIDADE ==================== */
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

        .avaliacao-text {
            max-width: 200px;
        }
    }
    .table-checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        accent-color: var(--cor-acento);
    }

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
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bulk-actions-info { font-weight: 600; font-size: 0.9375rem; }

    .bulk-actions-buttons { display: flex; gap: 0.75rem; }

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

    .btn-bulk-delete { background: var(--cor-danger); color: white; }
    .btn-bulk-delete:hover { background: #dc2626; transform: translateY(-1px); }
    .btn-bulk-cancel { background: rgba(255, 255, 255, 0.2); color: white; }
    .btn-bulk-cancel:hover { background: rgba(255, 255, 255, 0.3); }
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
        alert('Nenhuma avaliação selecionada!');
        return;
    }
    
    if (!confirm(`Tem certeza que deseja excluir ${selectedIds.size} avaliação(ões)?`)) {
        return;
    }
    
    const formData = new FormData();
    selectedIds.forEach(id => formData.append('ids[]', id));
    
    fetch('/backend/avaliacao/deletar-multiplos', {
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
        alert('Erro ao excluir avaliações!');
    });
}

// ==================== EXCLUSÃO INDIVIDUAL ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir esta avaliação?')) {
        window.location.href = `/backend/avaliacao/excluir/${id}`;
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