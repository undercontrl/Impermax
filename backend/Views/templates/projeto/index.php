<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-images me-2"></i>
                    Projetos
                </h1>
                <p class="page-subtitle">Galeria de projetos antes e depois</p>
            </div>
            <a href="/backend/projeto/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Projeto
            </a>
        </div>
    </div>

    <!-- Filtros e Barra de Ações -->
    <form method="GET" action="/backend/projeto/listar" id="filterForm">
        <input type="hidden" name="ordem_campo" id="ordem_campo" value="<?= htmlspecialchars($_GET['ordem_campo'] ?? '') ?>">
        <input type="hidden" name="ordem_direcao" id="ordem_direcao" value="<?= htmlspecialchars($_GET['ordem_direcao'] ?? '') ?>">
        
        <div class="filters-section">
            <div class="filters-group">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" 
                           name="busca" 
                           placeholder="Buscar por descrição, ID..." 
                           class="search-input"
                           value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                           onkeyup="autoSubmitFilter()">
                </div>

                <?php if (!empty($_GET['busca'])): ?>
                    <a href="/backend/projeto/listar" class="btn-filter-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Limpar
                    </a>
                <?php endif; ?>
            </div>

            <!-- <div class="view-options">
                <span class="view-label">Visualização:</span>
                <button type="button" class="view-toggle active" title="Grade de Fotos">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
            </div> -->
        </div>
    </form>

    <!-- Cards de Estatísticas Rápidas -->
    <div class="quick-stats">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="bi bi-folder-fill"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total de Projetos</span>
                <span class="stat-value"><?= $stats['total_projetos'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-hoje">
            <div class="stat-icon">
                <i class="bi bi-calendar-day"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Hoje</span>
                <span class="stat-value"><?= $stats['projetos_hoje'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-semana">
            <div class="stat-icon">
                <i class="bi bi-calendar-week"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Esta Semana</span>
                <span class="stat-value"><?= $stats['projetos_semana'] ?? 0 ?></span>
            </div>
        </div>

        <div class="stat-card stat-mes">
            <div class="stat-icon">
                <i class="bi bi-calendar-month"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Este Mês</span>
                <span class="stat-value"><?= $stats['projetos_mes'] ?? 0 ?></span>
            </div>
        </div>
    </div>

    <!-- Barra de Ações em Massa -->
    <div id="bulkActionsBar" class="bulk-actions-bar" style="display: none;">
        <div class="bulk-actions-info">
            <span id="selectedCount">0</span> projeto(s) selecionado(s)
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

    <!-- Grid de Projetos -->
    <div class="content-card">
        <?php if (!empty($projetos)): ?>
            <div class="projetos-grid">
                <?php foreach ($projetos as $projeto): ?>
                    <div class="projeto-card">
                        <!-- Checkbox no canto -->
                        <div class="card-checkbox-wrapper">
                            <input type="checkbox" 
                                   class="card-checkbox row-checkbox" 
                                   value="<?= $projeto['id_projeto'] ?>" 
                                   onchange="updateSelection()">
                        </div>

                        <!-- Comparador Before/After -->
                        <div class="before-after-container">
                            <div class="before-after-slider" data-projeto="<?= $projeto['id_projeto'] ?>">
                                <!-- CORREÇÃO: Caminho correto das imagens -->
                                <div class="image-before" style="background-image: url('/upload/<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>');"></div>
                                <div class="image-after" style="background-image: url('/upload/<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>');"></div>
                                <div class="slider-handle">
                                    <div class="slider-line"></div>
                                    <div class="slider-button">
                                        <i class="bi bi-chevron-left"></i>
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                </div>
                                <div class="labels">
                                    <span class="label-before">ANTES</span>
                                    <span class="label-after">DEPOIS</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info do Projeto -->
                        <div class="projeto-info">
                            <div class="projeto-header">
                                <span class="projeto-id">#<?= htmlspecialchars($projeto['id_projeto']) ?></span>
                                <span class="projeto-data">
                                    <i class="bi bi-calendar3"></i>
                                    <?= date('d/m/Y', strtotime($projeto['criado_em'])) ?>
                                </span>
                            </div>
                            
                            <p class="projeto-descricao">
                                <?= htmlspecialchars(substr($projeto['descricao_projeto'], 0, 100)) ?><?= strlen($projeto['descricao_projeto']) > 100 ? '...' : '' ?>
                            </p>
                            
                            <!-- Ações -->
                            <div class="projeto-actions">
                                <!-- <a href="/backend/projeto/ver/" 
                                   class="btn-projeto-action btn-projeto-view">
                                    <i class="bi bi-eye"></i>
                                    Ver
                                </a> -->
                                <a href="/backend/projeto/editar/<?= $projeto['id_projeto'] ?>" 
                                   class="btn-projeto-action btn-projeto-edit">
                                    <i class="bi bi-pencil"></i>
                                    Editar
                                </a>
                                <button onclick="confirmarExclusao(<?= $projeto['id_projeto'] ?>)" 
                                        class="btn-projeto-action btn-projeto-delete">
                                    <i class="bi bi-trash"></i>
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginação -->
            <div class="table-footer">
                <div class="table-info">
                    Mostrando <strong><?= $paginacao['inicio'] ?? 1 ?></strong> a <strong><?= $paginacao['fim'] ?? count($projetos) ?></strong> de <strong><?= $paginacao['total'] ?? count($projetos) ?></strong> projetos
                </div>
                <?php if (isset($paginacao) && $paginacao['total_paginas'] > 1): ?>
                    <div class="pagination">
                        <?php
                        $params = [];
                        if (!empty($_GET['busca'])) $params[] = 'busca=' . urlencode($_GET['busca']);
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
                    <i class="bi bi-images"></i>
                </div>
                <h3 class="empty-title">Nenhum projeto encontrado</h3>
                <p class="empty-description">
                    <?php if (!empty($_GET['busca'])): ?>
                        Nenhum resultado corresponde à sua busca.
                    <?php else: ?>
                        Comece adicionando seu primeiro projeto
                    <?php endif; ?>
                </p>
                <?php if (!empty($_GET['busca'])): ?>
                    <a href="/backend/projeto/listar" class="btn-action-primary">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Limpar Busca
                    </a>
                <?php else: ?>
                    <a href="/backend/projeto/criar" class="btn-action-primary">
                        <i class="bi bi-plus-lg me-2"></i>
                        Criar Primeiro Projeto
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

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
    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    /* Filtros */
    .filters-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filters-group {
        display: flex;
        gap: 1rem;
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
        color: #94a3b8;
        font-size: 1rem;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        background: white;
    }

    .search-input:focus {
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
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-filter-reset:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .view-options {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .view-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
    }

    .view-toggle {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 8px;
        background: var(--cor-acento);
        color: white;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
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

    .stat-hoje .stat-icon {
        background: linear-gradient(135deg, #34d399, var(--cor-success));
        color: white;
    }

    .stat-semana .stat-icon {
        background: linear-gradient(135deg, #60a5fa, var(--cor-info));
        color: white;
    }

    .stat-mes .stat-icon {
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
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

    /* Ações em Massa */
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
        transition: all 0.2s;
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

    /* Card de Conteúdo */
    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    /* Grid de Projetos */
    .projetos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }

    .projeto-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
    }

    .projeto-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    .card-checkbox-wrapper {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
    }

    .card-checkbox {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        cursor: pointer;
        accent-color: var(--cor-acento);
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    /* Comparador Before/After */
    .before-after-container {
        position: relative;
        width: 100%;
        padding-top: 75%; /* Aspect ratio 4:3 */
        overflow: hidden;
        background: #f1f5f9;
    }

    .before-after-slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: ew-resize;
    }

    .image-before,
    .image-after {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
    }

    .image-after {
        clip-path: inset(0 50% 0 0);
    }

    .slider-handle {
        position: absolute;
        top: 0;
        left: 50%;
        width: 4px;
        height: 100%;
        transform: translateX(-50%);
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 5;
    }

    .slider-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        font-size: 1.25rem;
        color: var(--cor-acento);
    }

    .slider-button i:first-child {
        margin-right: -4px;
    }

    .labels {
        position: absolute;
        top: 1rem;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
        z-index: 6;
        pointer-events: none;
    }

    .label-before,
    .label-after {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        margin-top: 25px;
    }

    /* Info do Projeto */
    .projeto-info {
        padding: 1.5rem;
    }

    .projeto-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .projeto-id {
        font-weight: 700;
        color: var(--cor-acento);
        font-size: 0.875rem;
    }

    .projeto-data {
        font-size: 0.8125rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .projeto-descricao {
        font-size: 0.9375rem;
        color: #334155;
        line-height: 1.6;
        margin: 0 0 1.25rem 0;
        min-height: 48px;
    }

    .projeto-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .btn-projeto-action {
        padding: 0.625rem 0.75rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        text-decoration: none;
    }

    .btn-projeto-view {
        color: var(--cor-info);
        border-color: #dbeafe;
    }

    .btn-projeto-view:hover {
        background: #dbeafe;
        border-color: var(--cor-info);
        transform: translateY(-1px);
    }

    .btn-projeto-edit {
        color: var(--cor-acento);
        border-color: #e0f2fe;
    }

    .btn-projeto-edit:hover {
        background: #e0f2fe;
        border-color: var(--cor-acento);
        transform: translateY(-1px);
    }

    .btn-projeto-delete {
        color: var(--cor-danger);
        border-color: #fee2e2;
    }

    .btn-projeto-delete:hover {
        background: #fee2e2;
        border-color: var(--cor-danger);
        transform: translateY(-1px);
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

    /* Responsivo */
    @media (max-width: 768px) {
        .projetos-grid {
            grid-template-columns: 1fr;
        }

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

        .search-box {
            max-width: 100%;
        }

        .quick-stats {
            grid-template-columns: 1fr;
        }

        .bulk-actions-bar {
            flex-direction: column;
            gap: 1rem;
        }

        .projeto-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
// ==================== COMPARADOR BEFORE/AFTER ====================
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.before-after-slider');
    
    sliders.forEach(slider => {
        let isDragging = false;
        const afterImage = slider.querySelector('.image-after');
        const handle = slider.querySelector('.slider-handle');
        
        function updateSlider(x) {
            const rect = slider.getBoundingClientRect();
            const position = Math.max(0, Math.min(x - rect.left, rect.width));
            const percentage = (position / rect.width) * 100;
            
            afterImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
            handle.style.left = `${percentage}%`;
        }
        
        slider.addEventListener('mousedown', (e) => {
            isDragging = true;
            updateSlider(e.clientX);
        });
        
        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                updateSlider(e.clientX);
            }
        });
        
        document.addEventListener('mouseup', () => {
            isDragging = false;
        });
        
        // Touch support
        slider.addEventListener('touchstart', (e) => {
            isDragging = true;
            updateSlider(e.touches[0].clientX);
        });
        
        document.addEventListener('touchmove', (e) => {
            if (isDragging) {
                updateSlider(e.touches[0].clientX);
            }
        });
        
        document.addEventListener('touchend', () => {
            isDragging = false;
        });
    });
});

// ==================== SELEÇÃO DE CHECKBOXES ====================
selectedIds = selectedIds || new Set();
function updateSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    selectedIds.clear();
    checkboxes.forEach(cb => selectedIds.add(cb.value));
    
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
    document.querySelectorAll('.card-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('bulkActionsBar').style.display = 'none';
}

// ==================== EXCLUSÃO EM MASSA ====================
function bulkDelete() {
    if (selectedIds.size === 0) {
        alert('Nenhum projeto selecionado!');
        return;
    }
    
    if (!confirm(`Tem certeza que deseja excluir ${selectedIds.size} projeto(s)?\n\nEsta ação não pode ser desfeita.`)) {
        return;
    }
    
    const formData = new FormData();
    selectedIds.forEach(id => formData.append('ids[]', id));
    
    fetch('/backend/projeto/deletar-multiplos', {
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
        alert('Erro ao excluir projetos!');
    });
}

// ==================== EXCLUSÃO INDIVIDUAL ====================
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este projeto?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/projeto/excluir/${id}`;
    }
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
<script>
// ==================== COMPARADOR BEFORE/AFTER ====================
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.before-after-slider');
    
    sliders.forEach(slider => {
        let isDragging = false;
        const afterImage = slider.querySelector('.image-after');
        const handle = slider.querySelector('.slider-handle');
        
        function updateSlider(x) {
            const rect = slider.getBoundingClientRect();
            const position = Math.max(0, Math.min(x - rect.left, rect.width));
            const percentage = (position / rect.width) * 100;
            
            afterImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
            handle.style.left = `${percentage}%`;
        }
        
        slider.addEventListener('mousedown', (e) => {
            isDragging = true;
            updateSlider(e.clientX);
        });
        
        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                updateSlider(e.clientX);
            }
        });
        
        document.addEventListener('mouseup', () => {
            isDragging = false;
        });
        
        // Touch support
        slider.addEventListener('touchstart', (e) => {
            isDragging = true;
            updateSlider(e.touches[0].clientX);
        });
        
        document.addEventListener('touchmove', (e) => {
            if (isDragging) {
                updateSlider(e.touches[0].clientX);
            }
        });
        
        document.addEventListener('touchend', () => {
            isDragging = false;
        });
    });
});
// ==================== SELEÇÃO DE CHECKBOXES ====================
let selectedIds = new Set();
function updateSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    selectedIds.clear();
    checkboxes.forEach(cb => selectedIds.add(cb.value));
    
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedIds.size > 0) {
        bulkBar.style.display = 'flex';
        selectedCount.textContent = selectedIds.size;
    } else {
        bulkBar.style.display = 'none';
    }
}
</script>