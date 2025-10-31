<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Confirmar Exclusão
                </h1>
                <p class="page-subtitle">Você está prestes a excluir um projeto</p>
            </div>
        </div>
    </div>

    <!-- Card de Confirmação -->
    <div class="delete-card">
        <!-- Alerta -->
        <div class="alert-danger">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="alert-content">
                <h3 class="alert-title">Atenção! Esta ação não pode ser desfeita.</h3>
                <p class="alert-message">
                    Ao confirmar, o projeto #<?= htmlspecialchars($projeto['id_projeto']) ?> será excluído permanentemente do sistema.
                </p>
            </div>
        </div>

        <!-- Preview do Projeto -->
        <div class="delete-preview">
            <h4 class="preview-title">Projeto que será excluído:</h4>
            
            <div class="preview-content">
                <!-- Imagens -->
                <div class="preview-images">
                    <div class="preview-image-card">
                        <img src="/upload/<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>" alt="Antes">
                        <span class="preview-label">ANTES</span>
                    </div>
                    <div class="preview-image-card">
                        <img src="/upload/<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>" alt="Depois">
                        <span class="preview-label">DEPOIS</span>
                    </div>
                </div>

                <!-- Informações -->
                <div class="preview-info">
                    <div class="info-row">
                        <span class="info-label">ID:</span>
                        <span class="info-value">#<?= htmlspecialchars($projeto['id_projeto']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Criado em:</span>
                        <span class="info-value"><?= date('d/m/Y \à\s H:i', strtotime($projeto['criado_em'])) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Descrição:</span>
                        <span class="info-value"><?= htmlspecialchars(substr($projeto['descricao_projeto'], 0, 150)) ?><?= strlen($projeto['descricao_projeto']) > 150 ? '...' : '' ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Confirmação -->
        <form action="/backend/projeto/deletar" method="POST" id="deleteForm">
            <input type="hidden" name="id_projeto" value="<?= htmlspecialchars($projeto['id_projeto']) ?>">
            
            <!-- Checkbox de Confirmação -->
            <div class="confirmation-checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" id="confirmDelete" required>
                    <span class="checkbox-text">
                        Confirmo que li o aviso e desejo excluir este projeto permanentemente
                    </span>
                </label>
            </div>

            <!-- Botões de Ação -->
            <div class="delete-actions">
                <a href="/backend/projeto/listar" class="btn-cancel">
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
        --cor-warning: #f59e0b;
    }

    .page-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header-content {
        text-align: center;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--cor-danger);
        margin: 0 0 0.25rem 0;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0;
    }

    /* Card de Exclusão */
    .delete-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        border: 2px solid #fee2e2;
        overflow: hidden;
    }

    /* Alerta de Perigo */
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        padding: 2rem;
        display: flex;
        gap: 1.5rem;
        border-bottom: 2px solid #fca5a5;
    }

    .alert-icon {
        flex-shrink: 0;
    }

    .alert-icon i {
        font-size: 3rem;
        color: var(--cor-danger);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
    }

    .alert-content {
        flex: 1;
    }

    .alert-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #991b1b;
        margin: 0 0 0.5rem 0;
    }

    .alert-message {
        font-size: 0.9375rem;
        color: #7f1d1d;
        margin: 0;
        line-height: 1.6;
    }

    /* Preview do Projeto */
    .delete-preview {
        padding: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .preview-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.5rem 0;
    }

    .preview-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .preview-images {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .preview-image-card {
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        position: relative;
    }

    .preview-image-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }

    .preview-label {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        background: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
    }

    .preview-info {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .info-row {
        display: flex;
        gap: 1rem;
    }

    .info-label {
        font-weight: 600;
        color: #64748b;
        min-width: 100px;
    }

    .info-value {
        color: #1e293b;
        flex: 1;
    }

    /* Checkbox de Confirmação */
    .confirmation-checkbox {
        padding: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-label input[type="checkbox"] {
        width: 24px;
        height: 24px;
        margin-top: 2px;
        cursor: pointer;
        accent-color: var(--cor-danger);
        flex-shrink: 0;
    }

    .checkbox-text {
        font-size: 0.9375rem;
        color: #334155;
        line-height: 1.6;
    }

    /* Ações */
    .delete-actions {
        padding: 1.5rem 2rem;
        background: #f8fafc;
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .btn-cancel {
        padding: 0.875rem 2rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        background: white;
        color: #64748b;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .btn-delete {
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 10px;
        background: var(--cor-danger);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:disabled {
        background: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-delete:not(:disabled):hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .alert-danger {
            flex-direction: column;
            text-align: center;
        }

        .alert-icon i {
            font-size: 2.5rem;
        }

        .preview-images {
            grid-template-columns: 1fr;
        }

        .delete-actions {
            flex-direction: column;
        }

        .btn-cancel,
        .btn-delete {
            width: 100%;
            justify-content: center;
        }

        .info-row {
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            min-width: auto;
            font-size: 0.875rem;
        }
    }
</style>

<script>
// Habilitar/desabilitar botão de exclusão
document.getElementById('confirmDelete').addEventListener('change', function() {
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.disabled = !this.checked;
});

// Confirmação adicional antes de enviar
document.getElementById('deleteForm').addEventListener('submit', function(e) {
    if (!confirm('ÚLTIMA CONFIRMAÇÃO: Deseja realmente excluir este projeto?\n\nEsta ação é IRREVERSÍVEL!')) {
        e.preventDefault();
        return false;
    }
    
    // Mostrar loading
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.innerHTML = '<i class="bi bi-hourglass-split"></i> Excluindo...';
    btnDelete.disabled = true;
});

// Atalho ESC para cancelar
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.location.href = '/backend/projeto/listar';
    }
});
</script>