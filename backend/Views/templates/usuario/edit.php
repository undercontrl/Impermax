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
/* Cole TODO o CSS do usuario/create.php aqui */
/* E adicione estes estilos extras: */

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