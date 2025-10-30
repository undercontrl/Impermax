<div class="page-wrapper">
    <div class="delete-container">
        <!-- Ícone de Aviso -->
        <div class="warning-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <!-- Título e Descrição -->
        <h1 class="delete-title">Confirmar Exclusão</h1>
        <p class="delete-description">
            Tem certeza que deseja excluir o projeto <strong>#<?= htmlspecialchars($projeto['id_projeto']) ?></strong>?
        </p>

        <!-- Preview das Fotos -->
        <div class="projeto-preview">
            <div class="preview-images">
                <div class="preview-image">
                    <img src="<?= htmlspecialchars($projeto['foto_antes_projeto']) ?>" alt="Antes">
                    <span class="preview-label">ANTES</span>
                </div>
                <div class="preview-image">
                    <img src="<?= htmlspecialchars($projeto['foto_depois_projeto']) ?>" alt="Depois">
                    <span class="preview-label">DEPOIS</span>
                </div>
            </div>
            <div class="preview-descricao">
                <p><?= htmlspecialchars(substr($projeto['descricao_projeto'], 0, 150)) ?><?= strlen($projeto['descricao_projeto']) > 150 ? '...' : '' ?></p>
            </div>
        </div>

        <!-- Alert de Aviso -->
        <div class="alert-danger">
            <i class="bi bi-shield-exclamation"></i>
            <div>
                <strong>Atenção!</strong> Esta ação não pode ser desfeita. O projeto e suas imagens serão removidos permanentemente do sistema.
            </div>
        </div>

        <!-- Formulário de Exclusão -->
        <form action="/backend/projeto/deletar/<?= htmlspecialchars($projeto['id_projeto']) ?>" method="post" class="delete-form">
            
            <div class="form-actions">
                <a href="/backend/projeto/listar" class="btn-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-delete">
                    <i class="bi bi-trash-fill"></i>
                    Sim, Excluir Projeto
                </button>
            </div>
        </form>

        <!-- Link Alternativo -->
        <div class="alternative-action">
            <p>Prefere visualizar os detalhes antes de decidir?</p>
            <a href="/backend/projeto/ver/<?= htmlspecialchars($projeto['id_projeto']) ?>" class="link-view">
                <i class="bi bi-eye"></i>
                Ver Detalhes do Projeto
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
        max-width: 650px;
        width: 100%;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        padding: 3rem;
        text-align: center;
    }

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

    .projeto-preview {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .preview-images {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .preview-image {
        position: relative;
        aspect-ratio: 4/3;
        border-radius: 8px;
        overflow: hidden;
    }

    .preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-label {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        padding: 0.25rem 0.625rem;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 4px;
    }

    .preview-descricao {
        text-align: left;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .preview-descricao p {
        font-size: 0.9375rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

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

        .preview-images {
            grid-template-columns: 1fr;
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
document.querySelector('.delete-form').addEventListener('submit', function(e) {
    const btn = this.querySelector('.btn-delete');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Excluindo...';
});

document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        if (confirm('Pressione OK para confirmar a exclusão do projeto.')) {
            document.querySelector('.delete-form').submit();
        }
    }
});
</script>