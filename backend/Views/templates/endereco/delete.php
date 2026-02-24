<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/endereco/listar">Endereços</a></li>
            <li class="breadcrumb-item active" aria-current="page">Excluir Endereço</li>
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
                Você está prestes a excluir o endereço <strong>#<?= $endereco['id_endereco'] ?></strong> 
                de <strong><?= htmlspecialchars($endereco['nome_usuario'] ?? 'Usuário Desconhecido') ?></strong>.
            </p>
            <p class="delete-warning">
                <i class="bi bi-info-circle"></i>
                Esta ação não pode ser desfeita. Todos os dados relacionados a este endereço serão removidos permanentemente.
            </p>

            <!-- Detalhes do Endereço -->
            <div class="delete-details">
                <h3 class="details-title">
                    <i class="bi bi-geo-alt-fill"></i>
                    Informações do Endereço
                </h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">ID:</span>
                        <span class="detail-value">#<?= htmlspecialchars($endereco['id_endereco']) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Usuário:</span>
                        <span class="detail-value"><?= htmlspecialchars($endereco['nome_usuario'] ?? 'Não informado') ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">CEP:</span>
                        <span class="detail-value"><?= htmlspecialchars($endereco['cep_endereco']) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Logradouro:</span>
                        <span class="detail-value"><?= htmlspecialchars($endereco['logadouro_endereco']) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Número:</span>
                        <span class="detail-value"><?= htmlspecialchars($endereco['numero_endereco']) ?></span>
                    </div>
                    <?php if (!empty($endereco['complemento_endereco'])): ?>
                    <div class="detail-item">
                        <span class="detail-label">Complemento:</span>
                        <span class="detail-value"><?= htmlspecialchars($endereco['complemento_endereco']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="detail-item">
                        <span class="detail-label">Bairro:</span>
                        <span class="detail-value"><?= htmlspecialchars($endereco['bairro_endereco']) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Cidade/UF:</span>
                        <span class="detail-value">
                            <?= htmlspecialchars($endereco['cidade_endereco']) ?> - <?= htmlspecialchars($endereco['uf_endereco']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Formulário de Confirmação -->
            <form action="/backend/endereco/deletar/<?= $endereco['id_endereco'] ?>" method="POST" class="delete-form">
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
                    <a href="/backend/endereco/listar" class="btn-cancel">
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
        color: var(--text-tertiary);
    }

    .breadcrumb-item a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: var(--cor-acento);
    }

    .breadcrumb-item.active {
        color: var(--text-primary);
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
        background: var(--card-bg);
        border-radius: 16px;
        padding: 3rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
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
        color: var(--text-primary);
        margin: 0 0 1rem 0;
    }

    .delete-message {
        font-size: 1rem;
        color: var(--text-secondary);
        margin: 0 0 1.5rem 0;
        line-height: 1.6;
    }

    .delete-message strong {
        color: var(--danger-color);
        font-weight: 700;
    }

    .delete-warning {
        background: rgba(245, 158, 11, 0.1);
        border-left: 4px solid var(--warning-color);
        padding: 1rem 1.25rem;
        border-radius: 8px;
        font-size: 0.875rem;
        color: var(--warning-color);
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

    /* Detalhes do Endereço */
    .delete-details {
        background: var(--bg-tertiary);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: left;
        border: 1px solid var(--border-color);
    }

    .details-title {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .details-title i {
        color: var(--accent-color);
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
        color: var(--text-tertiary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-value {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--text-primary);
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
        border: 2px solid var(--border-color);
        border-radius: 10px;
        transition: all 0.2s;
    }

    .checkbox-label:hover {
        border-color: var(--danger-color);
        background: var(--bg-tertiary);
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        cursor: pointer;
        flex-shrink: 0;
        margin-top: 0.125rem;
        accent-color: var(--danger-color);
    }

    .checkbox-text {
        font-size: 0.875rem;
        color: var(--text-primary);
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
        background: var(--card-bg);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
        color: white;
        box-shadow: 0 4px 12px var(--shadow-color);
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
    if (!confirm('Tem certeza absoluta que deseja excluir este endereço? Esta ação NÃO pode ser desfeita!')) {
        e.preventDefault();
    }
});
</script>