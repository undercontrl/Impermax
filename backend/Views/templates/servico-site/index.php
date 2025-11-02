<div class="page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-globe me-2"></i>
                    Serviços do Site
                </h1>
                <p class="page-subtitle">Gerencie a exibição de serviços no site público</p>
            </div>
            <a href="/backend/servico-site/criar" class="btn-action-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Serviço
            </a>
        </div>
    </div>

    <!-- Abas de Navegação -->
    <div class="tabs-navigation">
        <a href="/backend/servico/listar" class="tab-btn">
            <i class="bi bi-gear-fill me-2"></i>
            Serviços Internos
        </a>
        <a href="/backend/servico-site/listar" class="tab-btn active">
            <i class="bi bi-globe me-2"></i>
            Serviços do Site
            <span class="tab-badge"><?= $paginacao['total'] ?? count($servicos) ?></span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <div class="filters-group">
            <select class="filter-select" onchange="filtrarPorStatus(this.value)">
                <option value="">Todos os Status</option>
                <option value="ativo" <?= (($_GET['status'] ?? '') === 'ativo') ? 'selected' : '' ?>>Ativos</option>
                <option value="inativo" <?= (($_GET['status'] ?? '') === 'inativo') ? 'selected' : '' ?>>Inativos</option>
            </select>
            
            <?php if (!empty($_GET['status'])): ?>
                <a href="/backend/servico-site/listar" class="btn-filter-reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Limpar Filtros
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <?php
    $total = $paginacao['total'] ?? count($servicos);
    $ativos = count(array_filter($servicos, fn($s) => strcasecmp($s['status_servico'], 'Ativo') === 0));
    $inativos = $total - $ativos;
    $comFotos = count(array_filter($servicos, fn($s) => !empty($s['foto_servico'])));
    ?>
    <div class="quick-stats">
        <div class="stat-card stat-agendada">
            <div class="stat-icon">
                <i class="bi bi-globe"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total no Site</span>
                <span class="stat-value"><?= $total ?></span>
            </div>
        </div>

        <div class="stat-card stat-realizada">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Ativos</span>
                <span class="stat-value"><?= $ativos ?></span>
            </div>
        </div>

        <div class="stat-card stat-pendente">
            <div class="stat-icon">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Inativos</span>
                <span class="stat-value"><?= $inativos ?></span>
            </div>
        </div>

        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="bi bi-images"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Com Fotos</span>
                <span class="stat-value"><?= $comFotos ?></span>
            </div>
        </div>
    </div>

    <!-- Grid de Serviços do Site -->
    <div class="content-card">
        <?php if (!empty($servicos)): ?>
            <div class="servicos-site-grid">
                <?php foreach ($servicos as $servico): ?>
                    <?php 
                        $isAtivo = strcasecmp($servico['status_servico'], 'Ativo') === 0;
                        $statusTexto = $isAtivo ? 'Ativo' : 'Inativo';
                        $statusClass = $isAtivo ? 'status-ativo' : 'status-inativo';
                        $btnTexto = $isAtivo ? 'Desativar' : 'Ativar';
                        $btnClass = $isAtivo ? 'btn-deactivate' : 'btn-activate';
                    ?>
                    <div class="servico-site-card">
                        <!-- Imagem do Serviço -->
                        <div class="servico-site-image">
                            <?php if (!empty($servico['foto_servico'])): ?>
                                <img src="/upload/<?= htmlspecialchars($servico['foto_servico']) ?>" 
                                    alt="<?= htmlspecialchars($servico['nome_servico']) ?>"
                                    onerror="this.parentElement.innerHTML='<div class=\'servico-site-no-image\'><i class=\'bi bi-image\'></i><span>Erro ao carregar</span></div>'">
                            <?php else: ?>
                                <div class="servico-site-no-image">
                                    <i class="bi bi-image"></i>
                                    <span>Sem Foto</span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badge de Status -->
                            <div class="servico-site-status">
                                <span class="status-badge-site <?= $statusClass ?>">
                                    <i class="bi bi-<?= $isAtivo ? 'check-circle-fill' : 'x-circle-fill' ?>"></i>
                                    <?= $statusTexto ?>
                                </span>
                            </div>
                        </div>

                        <!-- Conteúdo do Card -->
                        <div class="servico-site-content">
                            <h3 class="servico-site-title"><?= htmlspecialchars($servico['nome_servico']) ?></h3>
                            <p class="servico-site-description">
                                <?= htmlspecialchars(substr($servico['descricao_servico'], 0, 120)) ?>
                                <?= strlen($servico['descricao_servico']) > 120 ? '...' : '' ?>
                            </p>

                            <!-- Ações do Card -->
                            <div class="servico-site-actions">
                                <button onclick="toggleStatus(<?= $servico['id_servico'] ?>, '<?= $btnTexto ?>')" 
                                        class="btn-toggle-status <?= $btnClass ?>">
                                    <i class="bi bi-<?= $isAtivo ? 'eye-slash' : 'eye' ?>"></i>
                                    <?= $btnTexto ?>
                                </button>
                                <a href="/backend/servico-site/editar/<?= $servico['id_servico'] ?>" 
                                   class="btn-edit-photo">
                                    <i class="bi bi-pencil"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Paginação -->
            <?php if ($paginacao && $paginacao['total_paginas'] > 1): ?>
                <div class="table-footer">
                    <div class="table-info">
                        Mostrando <strong><?= ($paginacao['pagina_atual'] - 1) * $paginacao['por_pagina'] + 1 ?></strong> 
                        a <strong><?= min($paginacao['pagina_atual'] * $paginacao['por_pagina'], $paginacao['total']) ?></strong> 
                        de <strong><?= $paginacao['total'] ?></strong> serviços
                    </div>
                    <div class="pagination">
                        <?php 
                        $queryString = !empty($_GET['status']) ? '?status=' . urlencode($_GET['status']) : '';
                        ?>
                        
                        <?php if ($paginacao['pagina_atual'] > 1): ?>
                            <a href="/backend/servico-site/listar/<?= $paginacao['pagina_atual'] - 1 ?><?= $queryString ?>" class="pagination-btn">
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
                            <a href="/backend/servico-site/listar/1<?= $queryString ?>" class="pagination-btn">1</a>
                            <?php if ($inicio > 2): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                            <?php if ($i == $paginacao['pagina_atual']): ?>
                                <button class="pagination-btn active"><?= $i ?></button>
                            <?php else: ?>
                                <a href="/backend/servico-site/listar/<?= $i ?><?= $queryString ?>" class="pagination-btn"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($fim < $paginacao['total_paginas']): ?>
                            <?php if ($fim < $paginacao['total_paginas'] - 1): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                            <a href="/backend/servico-site/listar/<?= $paginacao['total_paginas'] ?><?= $queryString ?>" class="pagination-btn"><?= $paginacao['total_paginas'] ?></a>
                        <?php endif; ?>

                        <?php if ($paginacao['pagina_atual'] < $paginacao['total_paginas']): ?>
                            <a href="/backend/servico-site/listar/<?= $paginacao['pagina_atual'] + 1 ?><?= $queryString ?>" class="pagination-btn">
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
                    <i class="bi bi-globe"></i>
                </div>
                <h3 class="empty-title">Nenhum serviço encontrado</h3>
                <p class="empty-description">
                    <?php if (!empty($_GET['status'])): ?>
                        Nenhum serviço com este status. Ajuste os filtros.
                    <?php else: ?>
                        Adicione serviços com fotos para exibir no site
                    <?php endif; ?>
                </p>
                <a href="/backend/servico-site/criar" class="btn-action-primary">
                    <i class="bi bi-plus-lg me-2"></i>
                    Adicionar Serviço
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript -->
<script>
// Função para alternar status do serviço
function toggleStatus(id, acao) {
    if (confirm(`Tem certeza que deseja ${acao.toLowerCase()} este serviço?`)) {
        window.location.href = `/backend/servico-site/alternar/${id}`;
    }
}

// Função para filtrar por status
function filtrarPorStatus(status) {
    const url = new URL(window.location);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location.href = url.toString();
}
</script>

<style>
    /* ========================================
   SISTEMA DE GERENCIAMENTO DE SERVIÇOS
   Arquivo CSS Completo e Padronizado
   ======================================== */

/* ========== VARIÁVEIS GLOBAIS ========== */
:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --success-color: #10b981;
    --success-hover: #059669;
    --danger-color: #ef4444;
    --danger-hover: #dc2626;
    --warning-color: #f59e0b;
    --info-color: #6366f1;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --border-radius: 12px;
    --transition: all 0.3s ease;
}

/* ========== CONTAINER PRINCIPAL ========== */
.page-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
}

/* ========== HEADER DA PÁGINA ========== */
.page-header {
    margin-bottom: 32px;
}

.page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.page-title-group {
    flex: 1;
}

.page-title {
    display: flex;
    align-items: center;
    font-size: 32px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 8px 0;
}

.page-subtitle {
    font-size: 16px;
    color: var(--gray-500);
    margin: 0;
}

.btn-action-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
}

.btn-action-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
}

/* ========== SISTEMA DE ABAS ========== */
.tabs-navigation {
    display: flex;
    gap: 8px;
    margin-bottom: 32px;
    border-bottom: 2px solid var(--gray-200);
    padding-bottom: 0;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 14px 24px;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--gray-500);
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    bottom: -2px;
}

.tab-btn:hover {
    color: var(--primary-color);
    background: var(--gray-50);
}

.tab-btn.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
    background: #eff6ff;
}

.tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 8px;
    background: var(--gray-200);
    color: var(--gray-700);
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
}

.tab-btn.active .tab-badge {
    background: var(--primary-color);
    color: white;
}

/* ========== FILTROS ========== */
.filters-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.filters-group {
    display: flex;
    gap: 12px;
    flex: 1;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 250px;
}

.search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 16px;
}

.search-input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 1px solid var(--gray-300);
    border-radius: 10px;
    font-size: 14px;
    transition: var(--transition);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.filter-select {
    padding: 12px 16px;
    border: 1px solid var(--gray-300);
    border-radius: 10px;
    font-size: 14px;
    color: var(--gray-700);
    background: white;
    cursor: pointer;
    transition: var(--transition);
    min-width: 150px;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.btn-filter-reset {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 12px 16px;
    background: var(--gray-100);
    color: var(--gray-700);
    border: 1px solid var(--gray-300);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
}

.btn-filter-reset:hover {
    background: var(--gray-200);
}

.view-options {
    display: flex;
    gap: 6px;
}

.view-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: white;
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    color: var(--gray-500);
    cursor: pointer;
    transition: var(--transition);
}

.view-toggle:hover {
    background: var(--gray-50);
    color: var(--gray-700);
}

.view-toggle.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* ========== CARDS DE ESTATÍSTICAS ========== */
.quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    border-radius: 12px;
    font-size: 24px;
    color: white;
}

.stat-pendente .stat-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.stat-agendada .stat-icon {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.stat-realizada .stat-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stat-total .stat-icon {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.stat-label {
    font-size: 13px;
    color: var(--gray-500);
    font-weight: 500;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--gray-900);
}

/* ========== BARRA DE AÇÕES EM MASSA ========== */
.bulk-actions-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
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
    font-size: 15px;
    font-weight: 600;
}

.bulk-actions-buttons {
    display: flex;
    gap: 10px;
}

.btn-bulk-action {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.btn-bulk-delete {
    background: rgba(239, 68, 68, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-bulk-delete:hover {
    background: var(--danger-color);
}

.btn-bulk-cancel {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-bulk-cancel:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* ========== CARD DE CONTEÚDO ========== */
.content-card {
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* ========== TABELA ========== */
.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--gray-50);
    border-bottom: 2px solid var(--gray-200);
}

.data-table th {
    padding: 16px;
    text-align: left;
    font-size: 13px;
    font-weight: 700;
    color: var(--gray-700);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.th-content {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
}

.th-content:hover {
    color: var(--primary-color);
}

.sort-icon {
    font-size: 12px;
    color: var(--gray-400);
    transition: var(--transition);
}

.sort-icon.active {
    color: var(--primary-color);
}

.data-table tbody tr {
    border-bottom: 1px solid var(--gray-200);
    transition: var(--transition);
}

.data-table tbody tr:hover {
    background: var(--gray-50);
}

.data-table td {
    padding: 16px;
    font-size: 14px;
    color: var(--gray-700);
}

.table-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: var(--primary-color);
}

.table-id {
    font-weight: 600;
    color: var(--gray-500);
    font-family: 'Courier New', monospace;
}

.table-amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 15px;
}

/* Informações do Serviço na Tabela */
.service-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.service-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    color: white;
    font-size: 18px;
    flex-shrink: 0;
}

.service-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 15px;
}

.service-description {
    color: var(--gray-500);
    font-size: 13px;
    line-height: 1.5;
    max-width: 400px;
}

/* ========== BOTÕES DE AÇÃO ========== */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.btn-action-view {
    background: #eff6ff;
    color: var(--primary-color);
}

.btn-action-view:hover {
    background: var(--primary-color);
    color: white;
}

.btn-action-edit {
    background: #fef3c7;
    color: var(--warning-color);
}

.btn-action-edit:hover {
    background: var(--warning-color);
    color: white;
}

.btn-action-delete {
    background: #fee2e2;
    color: var(--danger-color);
}

.btn-action-delete:hover {
    background: var(--danger-color);
    color: white;
}

/* ========== VISUALIZAÇÃO EM GRADE (SERVIÇOS INTERNOS) ========== */
.servicos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
    padding: 24px;
}

.servico-card {
    position: relative;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    padding: 24px;
    transition: var(--transition);
}

.servico-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
}

.card-checkbox-wrapper {
    position: absolute;
    top: 16px;
    right: 16px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.card-id {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-500);
}

.card-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--success-color);
}

.card-service-info {
    margin: 16px 0 24px;
}

.service-name-card {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 12px 0;
    line-height: 1.4;
}

.service-description-card {
    font-size: 14px;
    color: var(--gray-600);
    line-height: 1.6;
    margin: 0;
    min-height: 60px;
}

.card-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.btn-card-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.btn-card-view {
    background: #eff6ff;
    color: var(--primary-color);
}

.btn-card-view:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.btn-card-edit {
    background: #fef3c7;
    color: var(--warning-color);
}

.btn-card-edit:hover {
    background: var(--warning-color);
    color: white;
    transform: translateY(-2px);
}

.btn-card-delete {
    background: #fee2e2;
    color: var(--danger-color);
}

.btn-card-delete:hover {
    background: var(--danger-color);
    color: white;
    transform: translateY(-2px);
}

/* ========== ABAS COMO LINKS ========== */
.tabs-navigation a.tab-btn {
    text-decoration: none;
}

/* ========== VISUALIZAÇÃO DE SERVIÇOS DO SITE ========== */
.servicos-site-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
    padding: 24px;
}

.servico-site-card {
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    overflow: hidden;
    transition: var(--transition);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
}

.servico-site-card:hover {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    transform: translateY(-6px);
}

.servico-site-image {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.servico-site-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.servico-site-card:hover .servico-site-image img {
    transform: scale(1.08);
}

.servico-site-no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: white;
}

.servico-site-no-image i {
    font-size: 56px;
    opacity: 0.6;
}

.servico-site-no-image span {
    font-size: 15px;
    margin-top: 12px;
    font-weight: 600;
    opacity: 0.8;
}

.servico-site-status {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 10;
}

.status-badge-site {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.status-badge-site.status-ativo {
    background: rgba(16, 185, 129, 0.95);
    color: white;
}

.status-badge-site.status-inativo {
    background: rgba(239, 68, 68, 0.95);
    color: white;
}

.servico-site-content {
    padding: 24px;
}

.servico-site-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 12px 0;
    line-height: 1.3;
}

.servico-site-description {
    font-size: 14px;
    color: var(--gray-600);
    line-height: 1.7;
    margin: 0 0 24px 0;
    min-height: 70px;
}

.servico-site-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.btn-toggle-status,
.btn-edit-photo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.btn-activate {
    background: var(--success-color);
    color: white;
}

.btn-activate:hover {
    background: var(--success-hover);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
}

.btn-deactivate {
    background: var(--danger-color);
    color: white;
}

.btn-deactivate:hover {
    background: var(--danger-hover);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

.btn-edit-photo {
    background: var(--info-color);
    color: white;
}

.btn-edit-photo:hover {
    background: #4f46e5;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
}

/* ========== PAGINAÇÃO ========== */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-top: 1px solid var(--gray-200);
    flex-wrap: wrap;
    gap: 16px;
}

.table-info {
    font-size: 14px;
    color: var(--gray-600);
}

.table-info strong {
    color: var(--gray-900);
    font-weight: 700;
}

.pagination {
    display: flex;
    gap: 6px;
    align-items: center;
}

.pagination-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 12px;
    background: white;
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    color: var(--gray-700);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: var(--transition);
}

.pagination-btn:hover:not(:disabled) {
    background: var(--gray-50);
    border-color: var(--gray-400);
}

.pagination-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-dots {
    color: var(--gray-400);
    font-weight: 700;
}

/* ========== ESTADO VAZIO ========== */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 80px 24px;
    text-align: center;
}

.empty-icon {
    font-size: 80px;
    color: var(--gray-300);
    margin-bottom: 24px;
}

.empty-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 12px 0;
}

.empty-description {
    font-size: 16px;
    color: var(--gray-500);
    margin: 0 0 32px 0;
    max-width: 480px;
    line-height: 1.6;
}

/* ========== RESPONSIVIDADE ========== */
@media (max-width: 1200px) {
    .servicos-grid,
    .servicos-site-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}

@media (max-width: 768px) {
    .page-header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .tabs-navigation {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .filters-section {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filters-group {
        flex-direction: column;
    }
    
    .search-box {
        min-width: 100%;
    }
    
    .quick-stats {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .servicos-grid,
    .servicos-site-grid {
        grid-template-columns: 1fr;
        padding: 16px;
    }
    
    .table-container {
        overflow-x: scroll;
    }
    
    .data-table {
        min-width: 800px;
    }
    
    .table-footer {
        flex-direction: column;
        align-items: stretch;
    }
    
    .pagination {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 24px;
    }
    
    .stat-value {
        font-size: 20px;
    }
    
    .servico-site-actions {
        grid-template-columns: 1fr;
    }
}
</style>