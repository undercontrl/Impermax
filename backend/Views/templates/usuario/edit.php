<?php
// Use o MESMO CSS do usuario/create.php
// Apenas mude o conteúdo HTML abaixo
?>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Usuário #<?= htmlspecialchars($usuario['id_usuario']) ?>
                </h1>
                <p class="page-subtitle">Atualize os dados do usuário</p>
            </div>
            <a href="/backend/usuario/listar" class="btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <div class="form-card">
        <form action="/backend/usuario/atualizar/<?= $usuario['id_usuario'] ?>" method="POST" id="usuarioForm">
            
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="bi bi-person-circle"></i>
                    Informações Básicas
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome_usuario" class="form-label required">Nome Completo</label>
                        <div class="input-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" 
                                   name="nome_usuario" 
                                   id="nome_usuario" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($usuario['nome_usuario']) ?>"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email_usuario" class="form-label required">Email</label>
                        <div class="input-icon">
                            <i class="bi bi-envelope"></i>
                            <input type="email" 
                                   name="email_usuario" 
                                   id="email_usuario" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($usuario['email_usuario']) ?>"
                                   required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="bi bi-shield-lock"></i>
                    Alterar Senha (opcional)
                </h3>
                
                <div class="alert-info">
                    <i class="bi bi-info-circle"></i>
                    <span>Deixe em branco para manter a senha atual</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="senha_usuario" class="form-label">Nova Senha</label>
                        <div class="input-icon">
                            <i class="bi bi-lock"></i>
                            <input type="password" 
                                   name="senha_usuario" 
                                   id="senha_usuario" 
                                   class="form-control" 
                                   placeholder="Digite a nova senha"
                                   minlength="6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                        <div class="input-icon">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" 
                                   id="confirmar_senha" 
                                   class="form-control" 
                                   placeholder="Confirme a nova senha"
                                   minlength="6">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="bi bi-diagram-3"></i>
                    Tipo e Status
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipo_usuario" class="form-label required">Tipo de Usuário</label>
                        <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                            <option value="admin" <?= $usuario['tipo_usuario'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                            <option value="funcionario" <?= $usuario['tipo_usuario'] === 'funcionario' ? 'selected' : '' ?>>Funcionário</option>
                            <option value="cliente" <?= $usuario['tipo_usuario'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status_usuario" class="form-label required">Status</label>
                        <select name="status_usuario" id="status_usuario" class="form-control" required>
                            <option value="Ativo" <?= $usuario['status_usuario'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="Inativo" <?= $usuario['status_usuario'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                            <option value="Pendente" <?= $usuario['status_usuario'] === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <div class="info-item">
                    <i class="bi bi-calendar-plus"></i>
                    <div>
                        <span class="info-label">Criado em</span>
                        <span class="info-value"><?= isset($usuario['criado_em']) ? date('d/m/Y H:i', strtotime($usuario['criado_em'])) : '-' ?></span>
                    </div>
                </div>
                <?php if (isset($usuario['atualizado_em']) && $usuario['atualizado_em']): ?>
                <div class="info-item">
                    <i class="bi bi-clock-history"></i>
                    <div>
                        <span class="info-label">Última atualização</span>
                        <span class="info-value"><?= date('d/m/Y H:i', strtotime($usuario['atualizado_em'])) ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <a href="/backend/usuario/listar" class="btn-secondary">
                    <i class="bi bi-x-lg me-2"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg me-2"></i>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<style>

    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-clara: #ffffff;
        --cor-cinza: #a7a7a7;
        --cor-fundo: #f4f6f9;
        --cor-success: #22c55e;
        --cor-danger: #ef4444;
        --border-radius: 12px;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: var(--spacing-xl);
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-md);
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
        color: var(--cor-acento);
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: var(--cor-cinza);
        margin: 0;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: var(--cor-cinza);
        transform: translateY(-2px);
    }

    .form-card {
        background: white;
        border-radius: var(--border-radius);
        padding: var(--spacing-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid #f1f5f9;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-section-title i {
        color: var(--cor-acento);
        font-size: 1.25rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-label.required::after {
        content: '*';
        color: var(--cor-danger);
        margin-left: 0.25rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: var(--transition);
        background: white;
        color: #1e293b;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--cor-cinza);
        font-size: 1rem;
    }

    .input-icon .form-control {
        padding-left: 2.75rem;
    }

    .form-hint {
        font-size: 0.8125rem;
        color: var(--cor-cinza);
        margin-top: 0.375rem;
    }

    .permission-info {
        margin-top: 1.5rem;
    }

    .permission-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .permission-card i {
        font-size: 2rem;
        color: var(--cor-acento);
        flex-shrink: 0;
    }

    .permission-card strong {
        display: block;
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .permission-card p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
        line-height: 1.6;
    }

    .form-summary {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .summary-label {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #0c4a6e;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .summary-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 2rem;
        border-top: 1px solid #f1f5f9;
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-summary {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }

.alert-info {
    background: #e0f2fe;
    border: 1px solid #bae6fd;
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    color: #0c4a6e;
    font-size: 0.9375rem;
}

.alert-info i {
    font-size: 1.25rem;
    color: #0284c7;
}

.info-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-item i {
    font-size: 1.5rem;
    color: var(--cor-acento);
}

.info-label {
    font-size: 0.8125rem;
    color: #64748b;
    display: block;
}

.info-value {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e293b;
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const senhaInput = document.getElementById('senha_usuario');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');
    const form = document.getElementById('usuarioForm');

    form.addEventListener('submit', function(e) {
        const senha = senhaInput.value;
        const confirmarSenha = confirmarSenhaInput.value;

        // Só valida se algum campo de senha foi preenchido
        if (senha || confirmarSenha) {
            if (senha !== confirmarSenha) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                confirmarSenhaInput.focus();
                return false;
            }

            if (senha.length < 6) {
                e.preventDefault();
                alert('A senha deve ter no mínimo 6 caracteres!');
                senhaInput.focus();
                return false;
            }
        }
    });
});
</script>