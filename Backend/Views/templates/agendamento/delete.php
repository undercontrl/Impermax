<div class="page-wrapper">
    <div class="delete-container">
        <!-- Ícone de Aviso -->
        <div class="warning-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <!-- Título e Descrição -->
        <h1 class="delete-title">Confirmar Exclusão</h1>
        <p class="delete-description">
            Tem certeza que deseja excluir o agendamento <strong>#<?= htmlspecialchars($id_agendamento) ?></strong>?
        </p>

        <!-- Alert de Aviso -->
        <div class="alert-danger">
            <i class="bi bi-shield-exclamation"></i>
            <div>
                <strong>Atenção!</strong> Esta ação não pode ser desfeita. O agendamento será removido permanentemente do sistema.
            </div>
        </div>

        <!-- Formulário de Exclusão -->
        <form action="/backend/agendamento/deletar/<?= htmlspecialchars($id_agendamento) ?>" method="post" class="delete-form">
            <input type="hidden" name="id_agendamento" value="<?= htmlspecialchars($id_agendamento) ?>">
            
            <div class="form-actions">
                <a href="/backend/agendamento/listar" class="btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-delete">
                    <i class="bi bi-trash-fill"></i>
                    Sim, Excluir Agendamento
                </button>
            </div>
        </form>

        <!-- Link Alternativo -->
        <div class="alternative-action">
            <p>Prefere visualizar os detalhes antes de decidir?</p>
            <a href="/backend/agendamento/ver/<?= htmlspecialchars($id_agendamento) ?>" class="link-view">
                <i class="bi bi-eye"></i>
                Ver Detalhes do Agendamento
            </a>
        </div>
    </div>
</div>

<style>
    :root {
        --cor-danger: #ef4444;
        --cor-danger-dark: #dc2626;
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
        max-width: 580px;
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
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    .warning-icon i {
        font-size: 3.5rem;
        color: var(--cor-danger);
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
        margin: 0 0 2rem 0;
        line-height: 1.6;
    }

    .delete-description strong {
        color: #1e293b;
        font-weight: 600;
    }

    /* Alert de Perigo */
    .alert-danger {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1.25rem;
        background: #fef2f2;
        border: 2px solid #fee2e2;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: left;
    }

    .alert-danger i {
        font-size: 1.5rem;
        color: var(--cor-danger);
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .alert-danger div {
        color: #991b1b;
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .alert-danger strong {
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
    .btn-delete {
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

    .btn-delete {
        background: linear-gradient(135deg, var(--cor-danger), var(--cor-danger-dark));
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-delete:active {
        transform: translateY(0);
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

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-delete {
            width: 100%;
        }
    }
</style>

<script>
// Prevenir duplo clique no botão de exclusão
document.querySelector('.delete-form').addEventListener('submit', function(e) {
    const btn = this.querySelector('.btn-delete');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Excluindo...';
});

// Confirmação adicional ao pressionar Enter
document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        if (confirm('Pressione OK para confirmar a exclusão do agendamento.')) {
            document.querySelector('.delete-form').submit();
        }
    }
});
</script>