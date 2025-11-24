<style>
    /* =================================
       COPIE TODO ESTE CSS
       ================================= */
    .page-wrapper {
        padding: 2rem 0;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .page-header {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .page-title-group {
        flex: 1;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: #5f7396;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 1rem;
        margin: 0;
    }

    .btn-new {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .btn-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        color: white;
    }

    /* Cards de Estatísticas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.75rem;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border-color: #5f7396;
    }

    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0.5rem 0;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Filtros */
    .filters-section {
        background: white;
        padding: 1.75rem;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .filter-input,
    .filter-select {
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #5f7396;
        box-shadow: 0 0 0 3px rgba(95, 115, 150, 0.1);
    }

    .btn-clear {
        background: #ef4444;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-clear:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    /* Tabela */
    .table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 2px solid #f3f4f6;
    }

    .selected-actions {
        background: #3b82f6;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        display: none;
        align-items: center;
        gap: 1rem;
    }

    .selected-actions.show {
        display: flex;
    }

    .selected-count {
        font-weight: 600;
    }

    .action-btn {
        background: white;
        color: #3b82f6;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: #f0f0f0;
    }

    .action-btn.danger {
        background: #ef4444;
        color: white;
    }

    .action-btn.danger:hover {
        background: #dc2626;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        background: #f9fafb;
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
        cursor: pointer;
        user-select: none;
        transition: all 0.3s ease;
    }

    .custom-table thead th:hover {
        background: #f3f4f6;
        color: #5f7396;
    }

    .custom-table thead th.sortable {
        position: relative;
        padding-right: 2.5rem;
    }

    .custom-table thead th.sortable::after {
        content: '⇅';
        position: absolute;
        right: 1rem;
        opacity: 0.3;
        font-size: 1rem;
    }

    .custom-table thead th.sorted-asc::after {
        content: '▲';
        opacity: 1;
        color: #5f7396;
    }

    .custom-table thead th.sorted-desc::after {
        content: '▼';
        opacity: 1;
        color: #5f7396;
    }

    .custom-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .custom-table tbody tr:hover {
        background: #f9fafb;
    }

    .custom-table tbody td {
        padding: 1.25rem 1.5rem;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #1f2937;
    }

    .user-email {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .address-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #4b5563;
    }

    .uf-badge {
        display: inline-block;
        padding: 0.375rem 0.875rem;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-view {
        background: #e0e7ff;
        color: #5f7396;
    }

    .btn-view:hover {
        background: #c7d2fe;
        transform: scale(1.1);
    }

    .btn-edit {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-edit:hover {
        background: #bfdbfe;
        transform: scale(1.1);
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: scale(1.1);
    }

    /* Paginação */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-top: 2px solid #f3f4f6;
    }

    .pagination-info {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .page-item {
        display: flex;
    }

    .page-link {
        padding: 0.625rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        color: #6b7280;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        background: white;
    }

    .page-link:hover {
        border-color: #5f7396;
        color: #5f7396;
        background: #f9fafb;
    }

    .page-item.active .page-link {
        background: #5f7396;
        border-color: #5f7396;
        color: white;
    }

    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Estado Vazio */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    /* Responsivo */
    @media (max-width: 1024px) {
        .filters-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .custom-table {
            display: block;
            overflow-x: auto;
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<div class="container page-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-geo-alt-fill"></i>
                    Endereços
                </h1>
                <p class="page-subtitle">Gerencie todos os endereços cadastrados no sistema</p>
            </div>
            <a href="/backend/endereco/criar" class="btn-new">
                <i class="bi bi-plus-circle-fill"></i>
                Novo Endereço
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon blue">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total'] ?? 0, 0, ',', '.') ?></div>
            <div class="stat-label">Total de Endereços</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon green">
                    <i class="bi bi-map-fill"></i>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_ufs'] ?? 0, 0, ',', '.') ?></div>
            <div class="stat-label">Estados (UFs)</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon purple">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_cidades'] ?? 0, 0, ',', '.') ?></div>
            <div class="stat-label">Cidades</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-icon orange">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="stat-value"><?= number_format($stats['total_usuarios_com_endereco'] ?? 0, 0, ',', '.') ?></div>
            <div class="stat-label">Usuários com Endereço</div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <form method="GET" action="/backend/endereco/listar" id="filterForm">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-search"></i> Buscar
                    </label>
                    <input 
                        type="text" 
                        name="busca" 
                        class="filter-input" 
                        placeholder="CEP, logradouro, bairro, usuário..."
                        value="<?= htmlspecialchars($filtros['busca']) ?>"
                        oninput="autoSubmitFilter()"
                    >
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-map"></i> Estado (UF)
                    </label>
                    <select name="uf" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <?php foreach ($ufs as $uf): ?>
                            <option value="<?= htmlspecialchars($uf) ?>" 
                                <?= $filtros['uf'] === $uf ? 'selected' : '' ?>>
                                <?= htmlspecialchars($uf) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">
                        <i class="bi bi-building"></i> Cidade
                    </label>
                    <select name="cidade" class="filter-select" onchange="this.form.submit()" 
                        <?= empty($filtros['uf']) ? 'disabled' : '' ?>>
                        <option value="">Todas</option>
                        <?php foreach ($cidades as $cidade): ?>
                            <option value="<?= htmlspecialchars($cidade) ?>" 
                                <?= $filtros['cidade'] === $cidade ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cidade) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (!empty($filtros['busca']) || !empty($filtros['uf']) || !empty($filtros['cidade'])): ?>
                <div class="filter-group">
                    <label class="filter-label" style="visibility: hidden;">Ações</label>
                    <a href="/backend/endereco/listar" class="btn-clear">
                        <i class="bi bi-x-circle"></i>
                        Limpar
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="table-container">
        <div class="table-header">
            <div class="selected-actions" id="selectedActions">
                <span class="selected-count">
                    <strong id="selectedCount">0</strong> selecionado(s)
                </span>
                <button class="action-btn danger" onclick="excluirEmMassa()">
                    <i class="bi bi-trash"></i> Excluir
                </button>
            </div>
        </div>

        <?php if (!empty($enderecos)): ?>
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 50px;">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                    </th>
                    <th class="sortable <?= $ordenacao['campo'] === 'id_endereco' ? 'sorted-' . strtolower($ordenacao['direcao']) : '' ?>" 
                        onclick="ordenarPor('id_endereco')">
                        ID
                    </th>
                    <th>Usuário</th>
                    <th>CEP</th>
                    <th>Endereço Completo</th>
                    <th class="sortable <?= $ordenacao['campo'] === 'cidade_endereco' ? 'sorted-' . strtolower($ordenacao['direcao']) : '' ?>" 
                        onclick="ordenarPor('cidade_endereco')">
                        Cidade
                    </th>
                    <th class="sortable <?= $ordenacao['campo'] === 'uf_endereco' ? 'sorted-' . strtolower($ordenacao['direcao']) : '' ?>" 
                        onclick="ordenarPor('uf_endereco')">
                        UF
                    </th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enderecos as $endereco): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="row-checkbox" value="<?= $endereco['id_endereco'] ?>" 
                               onchange="updateSelectedCount()">
                    </td>
                    <td><strong>#<?= htmlspecialchars($endereco['id_endereco']) ?></strong></td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                <?= strtoupper(substr($endereco['nome_usuario'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="user-details">
                                <span class="user-name"><?= htmlspecialchars($endereco['nome_usuario'] ?? 'Não informado') ?></span>
                                <span class="user-email"><?= htmlspecialchars($endereco['email_usuario'] ?? '') ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="address-badge">
                            <i class="bi bi-mailbox"></i>
                            <?= htmlspecialchars($endereco['cep_endereco']) ?>
                        </span>
                    </td>
                    <td>
                        <?= htmlspecialchars($endereco['logadouro_endereco']) ?>, 
                        <?= htmlspecialchars($endereco['numero_endereco']) ?>
                        <?php if (!empty($endereco['complemento_endereco'])): ?>
                            - <?= htmlspecialchars($endereco['complemento_endereco']) ?>
                        <?php endif; ?>
                        <br>
                        <small style="color: #6b7280;">
                            <?= htmlspecialchars($endereco['bairro_endereco']) ?>
                        </small>
                    </td>
                    <td><?= htmlspecialchars($endereco['cidade_endereco']) ?></td>
                    <td>
                        <span class="uf-badge"><?= htmlspecialchars($endereco['uf_endereco']) ?></span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="/backend/endereco/visualizar/<?= $endereco['id_endereco'] ?>" 
                               class="btn-icon btn-view" title="Visualizar">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="/backend/endereco/editar/<?= $endereco['id_endereco'] ?>" 
                               class="btn-icon btn-edit" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="/backend/endereco/excluir/<?= $endereco['id_endereco'] ?>" 
                               class="btn-icon btn-delete" title="Excluir"
                               onclick="return confirmarExclusao()">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <?php if ($paginacao['total_paginas'] > 1): ?>
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Mostrando <?= $paginacao['inicio'] ?> - <?= $paginacao['fim'] ?> de <?= $paginacao['total_registros'] ?> registros
            </div>
            
            <ul class="pagination">
                <!-- Anterior -->
                <li class="page-item <?= $paginacao['pagina_atual'] <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $paginacao['pagina_atual'] - 1 ?><?= http_build_query(array_filter($filtros)) ? '&' . http_build_query(array_filter($filtros)) : '' ?><?= !empty($ordenacao['campo']) ? '&ordem_campo=' . $ordenacao['campo'] . '&ordem_direcao=' . $ordenacao['direcao'] : '' ?>">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                <!-- Páginas -->
                <?php
                $inicio = max(1, $paginacao['pagina_atual'] - 2);
                $fim = min($paginacao['total_paginas'], $paginacao['pagina_atual'] + 2);
                
                if ($inicio > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=1<?= http_build_query(array_filter($filtros)) ? '&' . http_build_query(array_filter($filtros)) : '' ?><?= !empty($ordenacao['campo']) ? '&ordem_campo=' . $ordenacao['campo'] . '&ordem_direcao=' . $ordenacao['direcao'] : '' ?>">1</a>
                    </li>
                    <?php if ($inicio > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $inicio; $i <= $fim; $i++): ?>
                    <li class="page-item <?= $i == $paginacao['pagina_atual'] ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?><?= http_build_query(array_filter($filtros)) ? '&' . http_build_query(array_filter($filtros)) : '' ?><?= !empty($ordenacao['campo']) ? '&ordem_campo=' . $ordenacao['campo'] . '&ordem_direcao=' . $ordenacao['direcao'] : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($fim < $paginacao['total_paginas']): ?>
                    <?php if ($fim < $paginacao['total_paginas'] - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $paginacao['total_paginas'] ?><?= http_build_query(array_filter($filtros)) ? '&' . http_build_query(array_filter($filtros)) : '' ?><?= !empty($ordenacao['campo']) ? '&ordem_campo=' . $ordenacao['campo'] . '&ordem_direcao=' . $ordenacao['direcao'] : '' ?>">
                            <?= $paginacao['total_paginas'] ?>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Próxima -->
                <li class="page-item <?= $paginacao['pagina_atual'] >= $paginacao['total_paginas'] ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $paginacao['pagina_atual'] + 1 ?><?= http_build_query(array_filter($filtros)) ? '&' . http_build_query(array_filter($filtros)) : '' ?><?= !empty($ordenacao['campo']) ? '&ordem_campo=' . $ordenacao['campo'] . '&ordem_direcao=' . $ordenacao['direcao'] : '' ?>">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- Estado Vazio -->
        <div class="empty-state">
            <div class="empty-icon">📍</div>
            <h3 class="empty-title">Nenhum endereço encontrado</h3>
            <p class="empty-text">
                <?php if (!empty($filtros['busca']) || !empty($filtros['uf']) || !empty($filtros['cidade'])): ?>
                    Não encontramos endereços com os filtros aplicados. Tente limpar os filtros.
                <?php else: ?>
                    Comece cadastrando o primeiro endereço clicando no botão acima.
                <?php endif; ?>
            </p>
            <?php if (!empty($filtros['busca']) || !empty($filtros['uf']) || !empty($filtros['cidade'])): ?>
                <a href="/backend/endereco/listar" class="btn-clear">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Limpar Filtros
                </a>
            <?php else: ?>
                <a href="/backend/endereco/criar" class="btn-new">
                    <i class="bi bi-plus-circle-fill"></i>
                    Cadastrar Primeiro Endereço
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
/* =================================
   COPIE TODO ESTE JAVASCRIPT
   ================================= */

// Confirmação de exclusão
function confirmarExclusao() {
    return confirm('⚠️ Tem certeza que deseja excluir este endereço?\n\nEsta ação não pode ser desfeita.');
}

// Auto-submit com debounce na busca
let searchTimeout;
function autoSubmitFilter() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
}

// Ordenação de colunas
function ordenarPor(campo) {
    const urlParams = new URLSearchParams(window.location.search);
    const campoAtual = urlParams.get('ordem_campo');
    const direcaoAtual = urlParams.get('ordem_direcao') || 'DESC';
    
    let novaDirecao = 'ASC';
    if (campoAtual === campo && direcaoAtual === 'ASC') {
        novaDirecao = 'DESC';
    }
    
    urlParams.set('ordem_campo', campo);
    urlParams.set('ordem_direcao', novaDirecao);
    urlParams.set('pagina', '1'); // Volta para primeira página
    
    window.location.search = urlParams.toString();
}

// Selecionar todos os checkboxes
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateSelectedCount();
}

// Atualizar contador de selecionados
function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const count = checkboxes.length;
    const selectedActions = document.getElementById('selectedActions');
    const selectedCount = document.getElementById('selectedCount');
    const selectAll = document.getElementById('selectAll');
    
    selectedCount.textContent = count;
    
    if (count > 0) {
        selectedActions.classList.add('show');
    } else {
        selectedActions.classList.remove('show');
    }
    
    // Atualiza estado do "selecionar todos"
    const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
    selectAll.checked = count === totalCheckboxes && count > 0;
    selectAll.indeterminate = count > 0 && count < totalCheckboxes;
}

// Excluir múltiplos endereços
function excluirEmMassa() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('Selecione pelo menos um endereço para excluir.');
        return;
    }
    
    const confirmacao = confirm(
        `⚠️ ATENÇÃO!\n\n` +
        `Você está prestes a excluir ${ids.length} endereço(s).\n\n` +
        `Esta ação NÃO pode ser desfeita!\n\n` +
        `Deseja continuar?`
    );
    
    if (confirmacao) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/backend/endereco/excluir-massa';
        
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    // Atualiza contador ao carregar a página
    updateSelectedCount();
    
    // Auto-focus no campo de busca se tiver conteúdo
    const buscaInput = document.querySelector('input[name="busca"]');
    if (buscaInput && buscaInput.value) {
        buscaInput.focus();
    }
});
</script>