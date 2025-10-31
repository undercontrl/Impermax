<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <!-- <h1 class="page-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Confirmar Exclusão
                </h1>
                <p class="page-subtitle">Você está prestes a excluir um usuário</p> -->
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
                    Ao confirmar, o usuário #<?= htmlspecialchars($usuario['id_usuario']) ?> será excluído permanentemente do sistema, incluindo todos os seus dados relacionados.
                </p>
            </div>
        </div>

        <!-- Preview do Usuário -->
        <div class="delete-preview">
            <h4 class="preview-title">Usuário que será excluído:</h4>
            
            <div class="preview-content">
                <!-- Avatar e Informações Principais -->
                <div class="user-preview-header">
                    <div class="user-avatar-large">
                        <?= strtoupper(substr($usuario['nome_usuario'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="user-main-info">
                        <h3 class="user-name"><?= htmlspecialchars($usuario['nome_usuario']) ?></h3>
                        <p class="user-email"><?= htmlspecialchars($usuario['email_usuario']) ?></p>
                        <div class="user-badges">
                            <?php
                                $tipo = strtolower($usuario['tipo_usuario']);
                                $tipoConfig = match ($tipo) {
                                    'admin' => ['class' => 'badge-admin', 'icon' => 'shield-fill-check', 'text' => 'Administrador'],
                                    'cliente' => ['class' => 'badge-cliente', 'icon' => 'person-fill', 'text' => 'Cliente'],
                                    'funcionario' => ['class' => 'badge-funcionario', 'icon' => 'briefcase-fill', 'text' => 'Funcionário'],
                                    default => ['class' => 'badge-default', 'icon' => 'person', 'text' => ucfirst($tipo)]
                                };
                            ?>
                            <span class="status-badge <?= $tipoConfig['class'] ?>">
                                <i class="bi bi-<?= $tipoConfig['icon'] ?>"></i>
                                <?= $tipoConfig['text'] ?>
                            </span>

                            <?php
                                $status = $usuario['status_usuario'];
                                $statusConfig = match ($status) {
                                    'Ativo' => ['class' => 'status-ativo', 'icon' => 'check-circle-fill', 'text' => 'Ativo'],
                                    'Inativo' => ['class' => 'status-inativo', 'icon' => 'x-circle-fill', 'text' => 'Inativo'],
                                    'Pendente' => ['class' => 'status-pendente', 'icon' => 'clock-fill', 'text' => 'Pendente'],
                                    default => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => $status]
                                };
                            ?>
                            <span class="status-badge <?= $statusConfig['class'] ?>">
                                <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
                                <?= $statusConfig['text'] ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informações Detalhadas -->
                <div class="preview-info">
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-hash"></i>
                            ID:
                        </span>
                        <span class="info-value">#<?= htmlspecialchars($usuario['id_usuario']) ?></span>
                    </div>

                    <?php if (!empty($usuario['cpf_usuario'])): ?>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-card-text"></i>
                            CPF:
                        </span>
                        <span class="info-value"><?= htmlspecialchars($usuario['cpf_usuario']) ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($usuario['telefone_usuario'])): ?>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-telephone"></i>
                            Telefone:
                        </span>
                        <span class="info-value"><?= htmlspecialchars($usuario['telefone_usuario']) ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar-plus"></i>
                            Cadastrado em:
                        </span>
                        <span class="info-value"><?= date('d/m/Y \à\s H:i', strtotime($usuario['criado_em'])) ?></span>
                    </div>

                    <?php if (!empty($usuario['atualizado_em'])): ?>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar-check"></i>
                            Última atualização:
                        </span>
                        <span class="info-value"><?= date('d/m/Y \à\s H:i', strtotime($usuario['atualizado_em'])) ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Aviso de Dados Relacionados -->
                <div class="warning-box">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        <strong>Importante:</strong>
                        <p>Esta exclusão pode afetar dados relacionados como agendamentos, pagamentos, avaliações e outros registros vinculados a este usuário.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Confirmação -->
        <form action="/backend/usuario/deletar" method="POST" id="deleteForm">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
            
            <!-- Checkbox de Confirmação -->
            <div class="confirmation-checkbox">
                <label class="checkbox-label">
                    <input type="checkbox" id="confirmDelete" required>
                    <span class="checkbox-text">
                        Confirmo que li o aviso e compreendo que esta ação é irreversível. Desejo excluir este usuário e todos os seus dados relacionados permanentemente.
                    </span>
                </label>
            </div>

            <!-- Botões de Ação -->
            <div class="delete-actions">
                <a href="/backend/usuario/listar" class="btn-cancel">
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
        --cor-success: #22c55e;
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

    /* .page-title {
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
    } */

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

    /* Preview do Usuário */
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

    /* Header do Usuário */
    .user-preview-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .user-main-info {
        flex: 1;
    }

    .user-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }

    .user-email {
        font-size: 1rem;
        color: #64748b;
        margin: 0 0 0.75rem 0;
    }

    .user-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-admin {
        background: #ede9fe;
        color: #6b21a8;
    }

    .badge-cliente {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-funcionario {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-default {
        background: #f1f5f9;
        color: #475569;
    }

    .status-ativo {
        background: #dcfce7;
        color: #166534;
    }

    .status-inativo {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pendente {
        background: #fef3c7;
        color: #92400e;
    }

    .status-default {
        background: #f1f5f9;
        color: #475569;
    }

    /* Informações Detalhadas */
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
        align-items: center;
        gap: 1rem;
    }

    .info-label {
        font-weight: 600;
        color: #64748b;
        min-width: 180px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: var(--cor-acento);
    }

    .info-value {
        color: #1e293b;
        flex: 1;
    }

    /* Warning Box */
    .warning-box {
        background: #fffbeb;
        border: 2px solid #fde047;
        border-radius: 10px;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
    }

    .warning-box i {
        font-size: 1.5rem;
        color: #ca8a04;
        flex-shrink: 0;
    }

    .warning-box strong {
        color: #854d0e;
        display: block;
        margin-bottom: 0.25rem;
    }

    .warning-box p {
        color: #a16207;
        margin: 0;
        font-size: 0.9375rem;
        line-height: 1.5;
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

        .user-preview-header {
            flex-direction: column;
            text-align: center;
        }

        .user-badges {
            justify-content: center;
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
            align-items: flex-start;
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
    if (!confirm('ÚLTIMA CONFIRMAÇÃO: Deseja realmente excluir este usuário?\n\nTodos os dados relacionados serão perdidos permanentemente!')) {
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
        window.location.href = '/backend/usuario/listar';
    }
});
</script>