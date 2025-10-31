<div class="page-wrapper">
    <div class="delete-container">
        <!-- Ícone de Aviso -->
        <div class="warning-icon <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'warning-deactivate' : 'warning-activate' ?>">
            <i class="bi bi-<?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'eye-slash-fill' : 'eye-fill' ?>"></i>
        </div>

        <!-- Título e Descrição -->
        <h1 class="delete-title">
            <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'Desativar' : 'Ativar' ?> Serviço
        </h1>
        <p class="delete-description">
            Deseja <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'desativar' : 'ativar' ?> o serviço 
            <strong>"<?= htmlspecialchars($servico['nome_servico']) ?>"</strong> no site?
        </p>

        <!-- Preview do Serviço -->
        <div class="service-preview-card">
            <?php if (!empty($servico['foto_servico'])): ?>
                <div class="preview-image">
                    <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']) ?>" 
                         alt="<?= htmlspecialchars($servico['nome_servico']) ?>">
                </div>
            <?php endif; ?>
            
            <div class="preview-content">
                <h3 class="preview-title"><?= htmlspecialchars($servico['nome_servico']) ?></h3>
                <p class="preview-description">
                    <?= htmlspecialchars(substr($servico['descricao_servico'], 0, 100)) ?>
                    <?= strlen($servico['descricao_servico']) > 100 ? '...' : '' ?>
                </p>
                <div class="preview-status">
                    <span class="status-badge <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'status-ativo' : 'status-inativo' ?>">
                        <i class="bi bi-<?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'check-circle-fill' : 'x-circle-fill' ?>"></i>
                        Status: <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'Ativo' : 'Inativo' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Alert de Informação -->
        <?php if (strcasecmp($servico['status_servico'], 'Ativo') === 0): ?>
        <div class="alert-warning">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <strong>Importante!</strong> Ao desativar, este serviço não será mais exibido no site público. 
                Você pode reativá-lo a qualquer momento.
            </div>
        </div>
        <?php else: ?>
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <div>
                <strong>Ótimo!</strong> Ao ativar, este serviço será exibido no site público para todos os visitantes.
            </div>
        </div>
        <?php endif; ?>

        <!-- Formulário de Ação -->
        <form action="/backend/servico-site/alternar/<?= htmlspecialchars($servico['id_servico']) ?>" method="get" class="delete-form">
            <div class="form-actions">
                <a href="/backend/servico-site/listar" class="btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-action <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'btn-deactivate' : 'btn-activate' ?>">
                    <i class="bi bi-<?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'eye-slash-fill' : 'check-circle-fill' ?>"></i>
                    <?= strcasecmp($servico['status_servico'], 'Ativo') === 0 ? 'Sim, Desativar' : 'Sim, Ativar Agora' ?>
                </button>
            </div>
        </form>

        <!-- Link Alternativo -->
        <div class="alternative-action">
            <p>Quer fazer outras alterações?</p>
            <a href="/backend/servico-site/editar/<?= htmlspecialchars($servico['id_servico']) ?>" class="link-view">
                <i class="bi bi-pencil"></i>
                Editar Este Serviço
            </a>
        </div>
    </div>
</div>

<style>
    :root {
        --cor-danger: #ef4444;
        --cor-danger-dark: #dc2626;
        --cor-success: #22c55e;
        --cor-success-dark: #16a34a;
        --cor-warning: #f59e0b;
    }

    body {
        background: #f4f6f9;
    }

    .page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .delete-container {
        max-width: 620px;
        width: 100%;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        padding: 3rem;
        text-align: center;
    }

    /* Ícone de Aviso */
    .warning-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    .warning-icon.warning-deactivate {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
    }

    .warning-icon.warning-activate {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    }

    .warning-icon.warning-deactivate i {
        font-size: 3.5rem;
        color: var(--cor-danger);
    }

    .warning-icon.warning-activate i {
        font-size: 3.5rem;
        color: var(--cor-success);
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 20px rgba(239, 68, 68, 0);
        }
    }

    /* Textos */
    .delete-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1rem 0;
    }

    .delete-description {
        font-size: 1.125rem;
        color: #64748b;
        margin: 0 0 1.5rem 0;
        line-height: 1.6;
    }

    .delete-description strong {
        color: #1e293b;
        font-weight: 600;
    }

    /* Preview Card */
    .service-preview-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .preview-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-content {
        padding: 1.5rem;
    }

    .preview-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.75rem 0;
    }

    .preview-description {
        font-size: 0.9375rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 1rem 0;
    }

    .preview-status {
        display: flex;
        justify-content: flex-start;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-badge.status-ativo {
        background: #dcfce7;
        color: #166534;
    }

    .status-badge.status-inativo {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Alerts */
    .alert-warning,
    .alert-success {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: left;
    }

    .alert-warning {
        background: #fef3c7;
        border: 2px solid #fde047;
    }

    .alert-warning i {
        font-size: 1.5rem;
        color: var(--cor-warning);
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .alert-warning div {
        color: #92400e;
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .alert-success {
        background: #dcfce7;
        border: 2px solid #86efac;
    }

    .alert-success i {
        font-size: 1.5rem;
        color: var(--cor-success);
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .alert-success div {
        color: #166534;
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .alert-warning strong,
    .alert-success strong {
        font-weight: 700;
        display: block;
        margin-bottom: 0.25rem;
    }

    /* Formulário */
    .delete-form {
        margin-bottom: 2rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-cancel,
    .btn-action {
        flex: 1;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
    }

    .btn-cancel {
        background: white;
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .btn-deactivate {
        background: linear-gradient(135deg, var(--cor-danger), var(--cor-danger-dark));
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-deactivate:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-activate {
        background: linear-gradient(135deg, var(--cor-success), var(--cor-success-dark));
        color: white;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .btn-activate:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }

    .btn-action:active {
        transform: translateY(0);
    }

    .btn-action:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Ação Alternativa */
    .alternative-action {
        padding-top: 2rem;
        border-top: 1px solid #f1f5f9;
    }

    .alternative-action p {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0 0 0.75rem 0;
    }

    .link-view {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #1487df;
        font-weight: 600;
        font-size: 0.9375rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .link-view:hover {
        color: #0e6eb8;
        gap: 0.75rem;
    }

    .link-view i {
        font-size: 1.125rem;
    }

    /* Responsivo */
    @media (max-width: 600px) {
        .delete-container {
            padding: 2rem 1.5rem;
        }

        .warning-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 1.5rem;
        }

        .warning-icon i {
            font-size: 2.5rem;
        }

        .delete-title {
            font-size: 1.5rem;
        }

        .delete-description {
            font-size: 1rem;
        }

        .preview-image {
            height: 160px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-action {
            width: 100%;
        }
    }
</style>

<script>
// Prevenir duplo clique
document.querySelector('.delete-form').addEventListener('submit', function(e) {
    const btn = this.querySelector('.btn-action');
    btn.disabled = true;
    
    const isActivating = btn.classList.contains('btn-activate');
    btn.innerHTML = isActivating 
        ? '<i class="bi bi-hourglass-split"></i> Ativando...'
        : '<i class="bi bi-hourglass-split"></i> Desativando...';
});

// Atalho ESC para cancelar
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.location.href = '/backend/servico-site/listar';
    }
});
</script>