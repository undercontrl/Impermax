<style>
    .view-container {
        padding: 2rem 0;
    }

    .view-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 2.5rem;
        border-radius: 16px 16px 0 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
    }

    .view-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .view-header .breadcrumb {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }

    .view-content {
        background: white;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .map-section {
        background: #f9fafb;
        padding: 2rem;
        border-bottom: 2px solid #e5e7eb;
        text-align: center;
    }

    .map-placeholder {
        background: white;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 3rem;
        color: #6b7280;
    }

    .map-placeholder i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }

    .info-card {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .info-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .user-section {
        padding: 2rem;
        border-bottom: 2px solid #e5e7eb;
        background: linear-gradient(to right, #f9fafb, #ffffff);
    }

    .user-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .user-info h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .user-info p {
        color: #6b7280;
        margin: 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-buttons {
        padding: 2rem;
        background: #f9fafb;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: #5f7396;
        color: white;
    }

    .btn-primary:hover {
        background: #4a5a75;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(95, 115, 150, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #5f7396;
        color: #5f7396;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .user-card {
            flex-direction: column;
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container view-container">
    <!-- Header -->
    <div class="view-header">
        <h1>
            <i class="bi bi-geo-alt-fill"></i>
            Detalhes do Endereço
        </h1>
        <div class="breadcrumb">
            ID: #<?= htmlspecialchars($endereco['id_endereco']) ?> | 
            Cadastrado em: <?= date('d/m/Y H:i', strtotime($endereco['criado_em'])) ?>
        </div>
    </div>

    <div class="view-content">
        <!-- Usuário -->
        <div class="user-section">
            <div class="user-card">
                <div class="user-avatar">
                    <?= strtoupper(substr($endereco['nome_usuario'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-info">
                    <h3><?= htmlspecialchars($endereco['nome_usuario'] ?? 'Não informado') ?></h3>
                    <p>
                        <i class="bi bi-envelope-fill"></i>
                        <?= htmlspecialchars($endereco['email_usuario'] ?? 'Não informado') ?>
                    </p>
                    <p>
                        <i class="bi bi-shield-fill-check"></i>
                        <?= htmlspecialchars($endereco['tipo_usuario'] ?? 'Não informado') ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Mapa (Placeholder) -->
        <div class="map-section">
            <div class="map-placeholder">
                <i class="bi bi-geo-alt"></i>
                <p>Mapa de localização (integração futura)</p>
                <small><?= htmlspecialchars($endereco['logadouro_endereco']) ?>, <?= htmlspecialchars($endereco['numero_endereco']) ?> - <?= htmlspecialchars($endereco['cidade_endereco']) ?>/<?= htmlspecialchars($endereco['uf_endereco']) ?></small>
            </div>
        </div>

        <!-- Informações -->
        <div class="info-grid">
            <!-- Card: Endereço Principal -->
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-icon">
                        <i class="bi bi-house-door-fill"></i>
                    </div>
                    <h4 class="info-card-title">Endereço Principal</h4>
                </div>
                <div class="info-item">
                    <span class="info-label">CEP</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['cep_endereco']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Logradouro</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['logadouro_endereco']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Número</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['numero_endereco']) ?></span>
                </div>
                <?php if (!empty($endereco['complemento_endereco'])): ?>
                <div class="info-item">
                    <span class="info-label">Complemento</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['complemento_endereco']) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Card: Localização -->
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-icon">
                        <i class="bi bi-map-fill"></i>
                    </div>
                    <h4 class="info-card-title">Localização</h4>
                </div>
                <div class="info-item">
                    <span class="info-label">Bairro</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['bairro_endereco']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Cidade</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['cidade_endereco']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Estado (UF)</span>
                    <span class="info-value"><?= htmlspecialchars($endereco['uf_endereco']) ?></span>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="action-buttons">
            <a href="/backend/endereco/editar/<?= $endereco['id_endereco'] ?>" class="btn btn-primary">
                <i class="bi bi-pencil-fill"></i>
                Editar Endereço
            </a>
            <button onclick="window.print()" class="btn btn-secondary">
                <i class="bi bi-printer-fill"></i>
                Imprimir
            </button>
            <a href="/backend/endereco/listar" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar para Lista
            </a>
            <a href="/backend/endereco/excluir/<?= $endereco['id_endereco'] ?>" 
               class="btn btn-danger"
               onclick="return confirm('⚠️ ATENÇÃO!\n\nTem certeza que deseja EXCLUIR este endereço?\n\nEsta ação NÃO pode ser desfeita!');">
                <i class="bi bi-trash-fill"></i>
                Excluir Endereço
            </a>
        </div>
    </div>
</div>