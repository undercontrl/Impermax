<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/agendamento/listar">Agendamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Excluir Agendamento</li>
        </ol>
    </nav>

    <!-- Card de Confirmação -->
    <div class="delete-container">
        <div class="delete-card">
            <!-- Ícone de Alerta -->
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>

            <!-- Título e Mensagem -->
            <h1 class="delete-title">Confirmar Exclusão</h1>
            <p class="delete-message">
                Você está prestes a excluir o agendamento <strong>#<?= $id_agendamento ?></strong>.
            </p>
            <p class="delete-warning">
                <i class="bi bi-info-circle"></i>
                Esta ação não pode ser desfeita. Todos os dados relacionados a este agendamento serão removidos permanentemente.
            </p>

            <!-- Detalhes do Agendamento -->
            <div class="delete-details">
                <h3 class="details-title">
                    <i class="bi bi-file-text"></i>
                    Informações do Agendamento
                </h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">ID:</span>
                        <span class="detail-value">#<?= $id_agendamento ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">
                            <span class="status-badge-small">Em exclusão</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Formulário de Confirmação -->
            <form action="/backend/agendamento/deletar" method="POST" class="delete-form">
                <input type="hidden" name="id_agendamento" value="<?= $id_agendamento ?>">
                
                <!-- Checkbox de Confirmação -->
                <div class="confirm-checkbox">
                    <label class="checkbox-label">
                        <input type="checkbox" id="confirmDelete" required>
                        <span class="checkbox-text">
                            Sim, eu entendo que esta ação é irreversível e desejo continuar com a exclusão
                        </span>
                    </label>
                </div>

                <!-- Botões de Ação -->
                <div class="delete-actions">
                    <a href="/backend/agendamento/listar" class="btn-cancel">
                        <i class="bi bi-x-lg"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-delete" id="btnDelete" disabled>
                        <i class="bi bi-trash"></i>
                        Confirmar Exclusão
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-danger: #ef4444;
    }

    .page-wrapper {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Breadcrumb */
    .breadcrumb-nav {
        margin-bottom: 2rem;
    }

    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
        list-style: none;
        background: transparent;
    }

    .breadcrumb-item {
        font-size: 0.875rem;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        padding: 0 0.5rem;
        color: #94a3b8;
    }

    .breadcrumb-item a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: var(--cor-acento);
    }

    .breadcrumb-item.active {
        color: #1e293b;
        font-weight: 500;
    }

    /* Card de Exclusão */
    .delete-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
    }

    .delete-card {
        background: white;
        border-radius: 16px;
        padding: 3rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border: 1px solid #f1f5f9;
        text-align: center;
        width: 100%;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Ícone de Alerta */
    .alert-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .alert-icon i {
        font-size: 2.5rem;
        color: var(--cor-danger);
    }

    /* Título e Mensagens */
    .delete-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1rem 0;
    }

    .delete-message {
        font-size: 1rem;
        color: #64748b;
        margin: 0 0 1.5rem 0;
        line-height: 1.6;
    }

    .delete-message strong {
        color: var(--cor-danger);
        font-weight: 700;
    }

    .delete-warning {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 1rem 1.25rem;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #92400e;
        text-align: left;
        margin: 0 0 2rem 0;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        line-height: 1.6;
    }

    .delete-warning i {
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    /* Detalhes do Agendamento */
    .delete-details {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .details-title {
        font-size: 0.9375rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .details-title i {
        color: var(--cor-acento);
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-value {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #1e293b;
    }

    .status-badge-small {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        background: #fee2e2;
        color: #991b1b;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Checkbox de Confirmação */
    .confirm-checkbox {
        margin-bottom: 2rem;
    }

    .checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        cursor: pointer;
        text-align: left;
        padding: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .checkbox-label:hover {
        border-color: var(--cor-danger);
        background: #fef2f2;
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e1;
        border-radius: 4px;
        cursor: pointer;
        flex-shrink: 0;
        margin-top: 0.125rem;
        accent-color: var(--cor-danger);
    }

    .checkbox-text {
        font-size: 0.875rem;
        color: #334155;
        line-height: 1.5;
    }

    /* Botões de Ação */
    .delete-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn-cancel,
    .btn-delete {
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        flex: 1;
        justify-content: center;
    }

    .btn-cancel {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--cor-danger), #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
    }

    .btn-delete:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .delete-card {
            padding: 2rem 1.5rem;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .delete-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-delete {
            width: 100%;
        }
    }
</style>

<script>
// Habilitar botão de exclusão apenas quando checkbox estiver marcado
const checkbox = document.getElementById('confirmDelete');
const btnDelete = document.getElementById('btnDelete');

checkbox.addEventListener('change', function() {
    if (this.checked) {
        btnDelete.disabled = false;
        btnDelete.style.opacity = '1';
        btnDelete.style.cursor = 'pointer';
    } else {
        btnDelete.disabled = true;
        btnDelete.style.opacity = '0.5';
        btnDelete.style.cursor = 'not-allowed';
    }
});

// Confirmação adicional ao submeter
document.querySelector('.delete-form').addEventListener('submit', function(e) {
    if (!confirm('Tem certeza absoluta que deseja excluir este agendamento? Esta ação NÃO pode ser desfeita!')) {
        e.preventDefault();
    }
});
</script>