<?php if (!isset($avaliacao) || empty($avaliacao)): ?>
    <div class="page-wrapper">
        <div class="alert alert-danger">
            <h3>Avaliação não encontrada</h3>
            <p>A avaliação solicitada não existe ou foi excluída.</p>
            <a href="/backend/avaliacao/listar" class="btn-action-primary">Voltar para Lista</a>
        </div>
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Confirmar Exclusão
                </h1>
                <p class="page-subtitle">Você está prestes a excluir uma avaliação</p>
            </div>
        </div>
    </div>

    <!-- Card de Exclusão -->
    <div class="delete-card">
        <!-- Alerta de Perigo -->
        <div class="alert-danger">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="alert-content">
                <h3 class="alert-title">Atenção! Esta ação não pode ser desfeita.</h3>
                <p class="alert-message">
                    Ao confirmar, a avaliação #<?= htmlspecialchars($avaliacao['id_avaliacao']) ?> será excluída permanentemente do sistema.
                </p>
            </div>
        </div>

        <!-- Preview da Avaliação -->
        <div class="delete-preview">
            <h4 class="preview-title">
                <i class="bi bi-info-circle me-2"></i>
                Avaliação que será excluída:
            </h4>
            
            <div class="preview-content">
                <div class="preview-info">
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-hash"></i>
                            ID:
                        </span>
                        <span class="info-value">#<?= htmlspecialchars($avaliacao['id_avaliacao']) ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-person-fill"></i>
                            Cliente:
                        </span>
                        <span class="info-value">
                            <strong><?= htmlspecialchars($avaliacao['nome_usuario']) ?></strong>
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-star-fill"></i>
                            Nota:
                        </span>
                        <span class="info-value">
                            <div class="rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star-fill <?= $i <= $avaliacao['nota_avaliacao'] ? 'star-active' : 'star-inactive' ?>"></i>
                                <?php endfor; ?>
                                <span class="rating-number"><?= $avaliacao['nota_avaliacao'] ?>/5</span>
                            </div>
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-chat-quote-fill"></i>
                            Avaliação:
                        </span>
                        <span class="info-value description">
                            <?= nl2br(htmlspecialchars($avaliacao['descricao_avaliacao'])) ?>
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-eye-fill"></i>
                            Status:
                        </span>
                        <span class="info-value">
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
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar3"></i>
                            Data de Criação:
                        </span>
                        <span class="info-value">
                            <?= date('d/m/Y H:i', strtotime($avaliacao['criado_em'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Exclusão -->
        <form action="/backend/avaliacao/deletar" method="POST" id="deleteForm">
            <input type="hidden" name="id_avaliacao" value="<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">
            
            <div class="confirmation-checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" id="confirmDelete" required>
                    <span class="checkbox-text">
                        Confirmo que li o aviso acima e desejo excluir esta avaliação permanentemente
                    </span>
                </label>
            </div>

            <div class="delete-actions">
                <a href="/backend/avaliacao/listar" class="btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-delete" id="btnDelete" disabled>
                    <i class="bi bi-trash-fill"></i>
                    Confirmar Exclusão
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-danger: #ef4444;
        --border-radius: 12px;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Header */
    .page-header {
        margin-bottom: var(--spacing-xl);
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
        color: var(--cor-danger);
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0;
    }

    /* Delete Card */
    .delete-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    /* Alert Danger */
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-left: 4px solid var(--cor-danger);
        padding: var(--spacing-lg);
        display: flex;
        align-items: flex-start;
        gap: var(--spacing-md);
    }

    .alert-icon {
        width: 48px;
        height: 48px;
        background: var(--cor-danger);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #991b1b;
        margin: 0 0 0.5rem 0;
    }

    .alert-message {
        font-size: 0.9375rem;
        color: #7f1d1d;
        margin: 0;
        line-height: 1.5;
    }

    /* Preview */
    .delete-preview {
        padding: var(--spacing-xl);
        background: #f8fafc;
    }

    .preview-title {
        font-size: 1rem;
        font-weight: 600;
        color: #334155;
        margin: 0 0 var(--spacing-lg) 0;
        display: flex;
        align-items: center;
    }

    .preview-content {
        background: white;
        border-radius: 10px;
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-md);
    }

    .preview-info {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .info-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: var(--spacing-md);
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #64748b;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: var(--cor-acento);
    }

    .info-value {
        color: #1e293b;
        font-size: 0.9375rem;
        display: flex;
        align-items: center;
    }

    .info-value.description {
        display: block;
        line-height: 1.6;
        color: #475569;
    }

    .info-value strong {
        font-weight: 600;
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

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
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

    /* Confirmation Checkbox */
    .confirmation-checkbox {
        padding: var(--spacing-lg);
        background: #fffbeb;
        border-top: 1px solid #fef3c7;
        border-bottom: 1px solid #fef3c7;
    }

    .checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-top: 2px;
        cursor: pointer;
        accent-color: var(--cor-danger);
        flex-shrink: 0;
    }

    .checkbox-text {
        font-size: 0.9375rem;
        color: #92400e;
        font-weight: 500;
        line-height: 1.5;
    }

    /* Delete Actions */
    .delete-actions {
        padding: var(--spacing-lg);
        display: flex;
        justify-content: flex-end;
        gap: var(--spacing-md);
        background: white;
    }

    .btn-cancel {
        padding: 0.75rem 1.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        color: #64748b;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    .btn-delete {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        background: var(--cor-danger);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-delete:not(:disabled):hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .page-wrapper {
            padding: 1rem;
        }

        .info-row {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .delete-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-delete {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Habilita o botão de exclusão apenas quando o checkbox é marcado
document.getElementById('confirmDelete').addEventListener('change', function() {
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.disabled = !this.checked;
});

// Confirmação final antes de enviar
document.getElementById('deleteForm').addEventListener('submit', function(e) {
    if (!confirm('ÚLTIMA CONFIRMAÇÃO: Deseja realmente excluir esta avaliação?')) {
        e.preventDefault();
        return false;
    }
    
    // Feedback visual durante o envio
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.innerHTML = '<i class="bi bi-hourglass-split"></i> Excluindo...';
    btnDelete.disabled = true;
});
</script>