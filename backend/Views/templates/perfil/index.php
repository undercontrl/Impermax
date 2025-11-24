<div class="profile-wrapper">
    <!-- Header da Página -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="bi bi-person-circle me-2"></i>
                Meu Perfil
            </h1>
            <p class="page-subtitle">Gerencie suas informações pessoais e configurações de conta</p>
        </div>
        <a href="/backend/<?= ($_SESSION['usuario_tipo'] === 'admin') ? 'admin' : 'funcionario' ?>/dashboard" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Voltar ao Dashboard
        </a>
    </div>

    <div class="profile-grid">
        <!-- Card de Foto de Perfil -->
        <div class="profile-card profile-avatar-card">
            <div class="card-header">
                <h3 class="card-title">Foto de Perfil</h3>
            </div>
            <div class="card-body text-center">
                <div class="avatar-preview">
                    <?php if (!empty($usuario['foto_usuario'])): ?>
                        <img src="/../../public/uploads/avatars/<?= htmlspecialchars($usuario['foto_usuario']) ?>" 
                             alt="Foto de Perfil" id="avatarPreview">
                    <?php else: ?>
                        <div class="avatar-placeholder">
                            <?= strtoupper(substr($usuario['nome_usuario'], 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="avatar-info">
                    <p class="avatar-title"><?= htmlspecialchars($usuario['nome_usuario']) ?></p>
                    <p class="avatar-subtitle">
                        <span class="badge-role badge-<?= $usuario['tipo_usuario'] === 'admin' ? 'admin' : 'user' ?>">
                            <i class="bi bi-<?= $usuario['tipo_usuario'] === 'admin' ? 'shield-check' : 'person' ?>"></i>
                            <?= ucfirst($usuario['tipo_usuario']) ?>
                        </span>
                    </p>
                </div>

                <form action="/backend/perfil/atualizar-foto" method="POST" enctype="multipart/form-data" id="formFoto">
                    <input type="file" name="foto_usuario" id="fotoInput" accept="image/*" style="display: none;" onchange="previewAndSubmit(this)">
                    <div class="avatar-actions">
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('fotoInput').click()">
                            <i class="bi bi-camera me-2"></i>Alterar Foto
                        </button>
                        <?php if (!empty($usuario['foto_usuario'])): ?>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerFoto()">
                                <i class="bi bi-trash"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
                
                <p class="avatar-hint">
                    <i class="bi bi-info-circle me-1"></i>
                    JPG, PNG ou WEBP. Máx 2MB
                </p>
            </div>
        </div>

        <!-- Card de Informações Pessoais -->
        <div class="profile-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    Informações Pessoais
                </h3>
            </div>
            <div class="card-body">
                <form action="/backend/perfil/atualizar" method="POST" id="formPerfil">
                    <div class="form-group">
                        <label for="nome_usuario" class="form-label">
                            <i class="bi bi-person me-2"></i>Nome Completo
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="nome_usuario" 
                               name="nome_usuario" 
                               value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" 
                               required
                               placeholder="Digite seu nome completo">
                        <small class="form-hint">Este nome será exibido em todo o sistema</small>
                    </div>

                    <div class="form-group">
                        <label for="email_usuario" class="form-label">
                            <i class="bi bi-envelope me-2"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control" 
                               id="email_usuario" 
                               name="email_usuario" 
                               value="<?= htmlspecialchars($usuario['email_usuario']) ?>" 
                               required
                               placeholder="seu@email.com">
                        <small class="form-hint">Usado para login e notificações</small>
                    </div>

                    <div class="info-row">
                        <div class="info-item">
                            <i class="bi bi-calendar-check text-muted"></i>
                            <div>
                                <span class="info-label">Membro desde</span>
                                <span class="info-value">
                                    <?= date('d/m/Y', strtotime($usuario['criado_em'])) ?>
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-clock-history text-muted"></i>
                            <div>
                                <span class="info-label">Última atualização</span>
                                <span class="info-value">
                                    <?= !empty($usuario['atualizado_em']) ? date('d/m/Y', strtotime($usuario['atualizado_em'])) : 'Nunca' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card de Segurança -->
        <div class="profile-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-shield-lock me-2"></i>
                    Segurança da Conta
                </h3>
            </div>
            <div class="card-body">
                <form action="/backend/perfil/atualizar-senha" method="POST" id="formSenha">
                    <div class="security-info">
                        <i class="bi bi-info-circle-fill"></i>
                        <p>Recomendamos usar uma senha forte com pelo menos 8 caracteres, incluindo letras, números e símbolos.</p>
                    </div>

                    <div class="form-group">
                        <label for="senha_atual" class="form-label">
                            <i class="bi bi-lock me-2"></i>Senha Atual
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control" 
                                   id="senha_atual" 
                                   name="senha_atual" 
                                   required
                                   placeholder="Digite sua senha atual">
                            <button type="button" class="password-toggle" onclick="togglePassword('senha_atual')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="senha_nova" class="form-label">
                            <i class="bi bi-key me-2"></i>Nova Senha
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control" 
                                   id="senha_nova" 
                                   name="senha_nova" 
                                   required
                                   minlength="6"
                                   placeholder="Digite sua nova senha">
                            <button type="button" class="password-toggle" onclick="togglePassword('senha_nova')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength"></div>
                    </div>

                    <div class="form-group">
                        <label for="senha_confirma" class="form-label">
                            <i class="bi bi-check2-circle me-2"></i>Confirmar Nova Senha
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control" 
                                   id="senha_confirma" 
                                   name="senha_confirma" 
                                   required
                                   minlength="6"
                                   placeholder="Confirme sua nova senha">
                            <button type="button" class="password-toggle" onclick="togglePassword('senha_confirma')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-shield-check me-2"></i>Alterar Senha
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card de Estatísticas (OPCIONAL) -->
        <!--<div class="profile-card stats-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-graph-up me-2"></i>
                    Suas Estatísticas
                </h3>
            </div>
            <div class="card-body">
                <div class="stat-item">
                    <div class="stat-icon stat-icon-primary">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Agendamentos</span>
                        <span class="stat-value">0</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon stat-icon-success">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Orçamentos</span>
                        <span class="stat-value">0</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon stat-icon-warning">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Avaliações</span>
                        <span class="stat-value">0</span>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>

<style>
    /* Variáveis */
    :root {
        --profile-spacing: 1.5rem;
        --card-radius: 16px;
    }

    /* Container Principal */
    .profile-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header da Página */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0.5rem 0 0 0;
    }

    .btn-outline-secondary {
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        background: white;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }

    .btn-outline-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
        transform: translateY(-2px);
    }

    /* Grid de Cards */
    .profile-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: var(--profile-spacing);
    }

    .profile-card {
        background: white;
        border-radius: var(--card-radius);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .profile-avatar-card {
        grid-row: 1 / 3;
    }

    .stats-card {
        grid-column: 1;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Avatar Preview */
    .avatar-preview {
        width: 150px;
        height: 150px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        position: relative;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #5f7396, #1487df);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        font-weight: 700;
    }

    .avatar-info {
        margin-bottom: 1.5rem;
    }

    .avatar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }

    .avatar-subtitle {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 500;
    }

    .badge-admin {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-user {
        background: #e2e8f0;
        color: #475569;
    }

    .avatar-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .avatar-hint {
        font-size: 0.8125rem;
        color: #64748b;
        margin: 0;
    }

    /* Formulários */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1487df;
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .form-hint {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: #64748b;
    }

    /* Password Input */
    .password-input-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        font-size: 1.125rem;
        padding: 0;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: #1487df;
    }

    .password-strength {
        margin-top: 0.5rem;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
    }

    .password-strength.weak {
        background: linear-gradient(to right, #ef4444 30%, #e2e8f0 30%);
    }

    .password-strength.medium {
        background: linear-gradient(to right, #f59e0b 60%, #e2e8f0 60%);
    }

    .password-strength.strong {
        background: linear-gradient(to right, #22c55e 100%, #e2e8f0 0%);
    }

    /* Info Row */
    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding: 1.25rem;
        background: #f8fafc;
        border-radius: 10px;
        margin: 1.5rem 0;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-item i {
        font-size: 1.5rem;
    }

    .info-label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
    }

    .info-value {
        display: block;
        font-size: 0.9375rem;
        color: #1e293b;
        font-weight: 600;
    }

    /* Security Info */
    .security-info {
        display: flex;
        gap: 0.75rem;
        padding: 1rem;
        background: #dbeafe;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .security-info i {
        font-size: 1.25rem;
        color: #1e40af;
        flex-shrink: 0;
    }

    .security-info p {
        margin: 0;
        font-size: 0.875rem;
        color: #1e40af;
        line-height: 1.5;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.9375rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1487df, #0e6eb8);
        color: white;
        box-shadow: 0 2px 8px rgba(20, 135, 223, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .btn-outline-danger {
        background: white;
        border: 1.5px solid #ef4444;
        color: #ef4444;
    }

    .btn-outline-danger:hover {
        background: #fef2f2;
        border-color: #dc2626;
        color: #dc2626;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    /* Stats Card */
    .stat-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 0.75rem;
    }

    .stat-item:last-child {
        margin-bottom: 0;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
    }

    .stat-icon-primary {
        background: linear-gradient(135deg, #6b7fa8, #5f7396);
    }

    .stat-icon-success {
        background: linear-gradient(135deg, #34d399, #22c55e);
    }

    .stat-icon-warning {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
    }

    .stat-content {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #64748b;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }

    /* Responsividade */
    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-avatar-card {
            grid-row: auto;
        }

        .stats-card {
            grid-column: auto;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-outline-secondary {
            width: 100%;
            justify-content: center;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }

</style>
<script>
    // Preview de imagem antes do upload
function previewAndSubmit(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                // Se não existe preview, cria
                const avatarDiv = document.querySelector('.avatar-preview');
                avatarDiv.innerHTML = `<img src="${e.target.result}" alt="Preview" id="avatarPreview">`;
            }
            // Submit automático
            document.getElementById('formFoto').submit();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remover foto
function removerFoto() {
    if (confirm('Tem certeza que deseja remover sua foto de perfil?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/backend/perfil/remover-foto';
        document.body.appendChild(form);
        form.submit();
    }
}

// Toggle mostrar/ocultar senha
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        button.classList.remove('bi-eye');
        button.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        button.classList.remove('bi-eye-slash');
        button.classList.add('bi-eye');
    }
}

// Verificar força da senha
document.addEventListener('DOMContentLoaded', function() {
    const senhaInput = document.getElementById('senha_nova');
    const strengthBar = document.getElementById('passwordStrength');
    
    if (senhaInput && strengthBar) {
        senhaInput.addEventListener('input', function() {
            const senha = this.value;
            let strength = 0;
            
            if (senha.length >= 6) strength++;
            if (senha.length >= 10) strength++;
            if (/[a-z]/.test(senha) && /[A-Z]/.test(senha)) strength++;
            if (/\d/.test(senha)) strength++;
            if (/[^a-zA-Z\d]/.test(senha)) strength++;
            
            strengthBar.className = 'password-strength';
            if (strength <= 2) {
                strengthBar.classList.add('weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        });
    }
});
</script>