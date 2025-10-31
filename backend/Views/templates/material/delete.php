<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-trash me-2"></i>
                    Excluir Material
                </h1>
                <p class="page-subtitle">Confirme a exclusão do material abaixo</p>
            </div>
        </div>
    </div>

    <!-- Card de Confirmação -->
    <div class="confirmation-card">
        <div class="warning-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        
        <h2 class="confirmation-title">Atenção!</h2>
        <p class="confirmation-text">
            Você está prestes a excluir o seguinte material. Esta ação não pode ser desfeita.
        </p>

        <!-- Informações do Material -->
        <div class="material-details">
            <div class="detail-row">
                <span class="detail-label">ID:</span>
                <span class="detail-value">#<?= htmlspecialchars($material['id_material']) ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Nome:</span>
                <span class="detail-value"><?= htmlspecialchars($material['nome_material']) ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Quantidade:</span>
                <span class="detail-value"><?= htmlspecialchars($material['qtd_material']) ?> unidades</span>
            </div>
            
            <?php if (!empty($material['descricao_material'])): ?>
            <div class="detail-row">
                <span class="detail-label">Descrição:</span>
                <span class="detail-value"><?= htmlspecialchars($material['descricao_material']) ?></span>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($material['nome_servico'])): ?>
            <div class="detail-row">
                <span class="detail-label">Serviço:</span>
                <span class="detail-value">
                    <span class="service-badge">
                        <i class="bi bi-gear-fill"></i>
                        <?= htmlspecialchars($material['nome_servico']) ?>
                    </span>
                </span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Botões de Ação -->
        <div class="action-buttons">
            <a href="/backend/material/listar" class="btn-cancel">
                <i class="bi bi-arrow-left me-2"></i>
                Cancelar
            </a>
            
            <form method="POST" action="/backend/material/deletar/<?= $material['id_material'] ?>" style="display: inline;">
                <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza? Esta ação não pode ser desfeita!');">
                    <i class="bi bi-trash me-2"></i>
                    Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-danger: #ef4444;
        --cor-warning: #f59e0b;
    }

    .page-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header-content {
        text-align: center;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-title i {
        color: var(--cor-danger);
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0;
    }

    /* Card de Confirmação */
    .confirmation-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f5f9;
        padding: 3rem 2rem;
        text-align: center;
    }

    .warning-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #fbbf24, var(--cor-warning));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 10px rgba(251, 191, 36, 0);
        }
    }

    .confirmation-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.75rem 0;
    }

    .confirmation-text {
        font-size: 1rem;
        color: #64748b;
        margin: 0 0 2rem 0;
        line-height: 1.6;
    }

    /* Detalhes do Material */
    .material-details {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-value {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9375rem;
        text-align: right;
    }

    .service-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    /* Botões */
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-cancel,
    .btn-delete {
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--cor-danger), #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
    }

    /* Responsivo */
    @media (max-width: 640px) {
        .page-wrapper {
            padding: 1rem;
        }

        .confirmation-card {
            padding: 2rem 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-delete {
            width: 100%;
            justify-content: center;
        }

        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .detail-value {
            text-align: left;
        }
    }
</style>