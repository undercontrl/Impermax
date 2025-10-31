<!-- COPIE TODO O CSS DA endereco/create.php -->
<style>
    /* Cole aqui TODO o CSS do create.php */
    .form-wrapper { padding: 2rem 0; background: #f8f9fa; min-height: 100vh; }
    .form-header { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 2rem; border-radius: 16px 16px 0 0; margin-bottom: 0; }
    .form-header h1 { font-size: 1.75rem; font-weight: 700; margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.75rem; }
    .form-header p { margin: 0; opacity: 0.9; }
    .form-container { background: white; border-radius: 0 0 16px 16px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08); overflow: hidden; }
    .form-section { padding: 2rem; border-bottom: 2px solid #f3f4f6; }
    .form-section:last-child { border-bottom: none; }
    .section-title { font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1.5rem 0; display: flex; align-items: center; gap: 0.75rem; }
    .section-title i { color: #5f7396; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.5rem; }
    .form-group.full-width { grid-column: 1 / -1; }
    .form-label { font-weight: 600; color: #374151; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem; }
    .form-label .required { color: #ef4444; }
    .form-input, .form-select, .form-textarea { padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 0.95rem; transition: all 0.3s ease; font-family: inherit; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #5f7396; box-shadow: 0 0 0 3px rgba(95, 115, 150, 0.1); }
    .form-textarea { resize: vertical; min-height: 100px; }
    .input-group { display: flex; align-items: center; gap: 0.5rem; }
    .input-icon { position: relative; }
    .input-icon i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #6b7280; }
    .input-icon .form-input { padding-left: 2.75rem; }
    .btn-search-cep { padding: 0.875rem 1.5rem; background: #3b82f6; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap; }
    .btn-search-cep:hover { background: #2563eb; transform: translateY(-2px); }
    .btn-search-cep:disabled { background: #9ca3af; cursor: not-allowed; transform: none; }
    .form-actions { padding: 2rem; background: #f9fafb; display: flex; gap: 1rem; justify-content: flex-end; }
    .btn { padding: 0.875rem 2rem; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; border: none; cursor: pointer; font-size: 0.95rem; }
    .btn-primary { background: #5f7396; color: white; }
    .btn-primary:hover { background: #4a5a75; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(95, 115, 150, 0.3); }
    .btn-secondary { background: white; color: #6b7280; border: 2px solid #e5e7eb; }
    .btn-secondary:hover { background: #f9fafb; border-color: #5f7396; color: #5f7396; }
    .info-box { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; }
    .info-box p { margin: 0; color: #1e40af; font-size: 0.95rem; }
    .info-box.warning { background: #fef3c7; border-left-color: #f59e0b; }
    .info-box.warning p { color: #92400e; }
    .loading-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); display: none; align-items: center; justify-content: center; z-index: 9999; }
    .loading-overlay.show { display: flex; }
    .loading-spinner { background: white; padding: 2rem; border-radius: 12px; text-align: center; }
    .spinner { border: 4px solid #f3f4f6; border-top: 4px solid #5f7396; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 1rem; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
        .btn { width: 100%; justify-content: center; }
        .input-group { flex-direction: column; }
        .btn-search-cep { width: 100%; justify-content: center; }
    }
</style>

<div class="container form-wrapper">
    <div class="form-header">
        <h1>
            <i class="bi bi-pencil-fill"></i>
            Editar Endereço
        </h1>
        <p>Atualize os dados do endereço</p>
    </div>

    <form action="/backend/endereco/atualizar/<?= $endereco['id_endereco'] ?>" method="POST" class="form-container" onsubmit="return validarFormulario()">
        <!-- Info Box -->
        <div class="form-section">
            <div class="info-box warning">
                <p>
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>ID:</strong> #<?= htmlspecialchars($endereco['id_endereco']) ?> | 
                    <strong>Criado em:</strong> <?= date('d/m/Y H:i', strtotime($endereco['criado_em'])) ?>
                    <?php if ($endereco['atualizado_em']): ?>
                        | <strong>Última atualização:</strong> <?= date('d/m/Y H:i', strtotime($endereco['atualizado_em'])) ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Seção: Usuário -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-person-fill"></i>
                Usuário
            </h3>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">
                        <i class="bi bi-person"></i>
                        Selecionar Usuário <span class="required">*</span>
                    </label>
                    <select name="id_usuario" class="form-select" required disabled>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>"
                                <?= $usuario['id_usuario'] == $endereco['id_usuario'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($usuario['nome_usuario']) ?> 
                                (<?= htmlspecialchars($usuario['email_usuario']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small style="color: #6b7280; font-size: 0.85rem;">
                        <i class="bi bi-info-circle"></i> O usuário não pode ser alterado após o cadastro
                    </small>
                </div>
            </div>
        </div>

        <!-- Seção: Buscar CEP -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-search"></i>
                Atualizar por CEP
            </h3>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-mailbox"></i>
                        CEP <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="cep_endereco" 
                            id="cep" 
                            class="form-input" 
                            placeholder="00000-000"
                            maxlength="9"
                            value="<?= htmlspecialchars($endereco['cep_endereco']) ?>"
                            required
                        >
                        <button type="button" class="btn-search-cep" onclick="buscarCep()">
                            <i class="bi bi-search"></i>
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção: Dados do Endereço -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="bi bi-geo-alt-fill"></i>
                Dados do Endereço
            </h3>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">
                        <i class="bi bi-signpost"></i>
                        Logradouro <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="logadouro_endereco" 
                        id="logradouro" 
                        class="form-input" 
                        placeholder="Rua, Avenida, etc."
                        value="<?= htmlspecialchars($endereco['logadouro_endereco']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-hash"></i>
                        Número <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="numero_endereco" 
                        id="numero" 
                        class="form-input" 
                        placeholder="123"
                        value="<?= htmlspecialchars($endereco['numero_endereco']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-building"></i>
                        Complemento
                    </label>
                    <input 
                        type="text" 
                        name="complemento_endereco" 
                        id="complemento" 
                        class="form-input" 
                        placeholder="Apto, Bloco, etc."
                        value="<?= htmlspecialchars($endereco['complemento_endereco'] ?? '') ?>"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-map"></i>
                        Bairro <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="bairro_endereco" 
                        id="bairro" 
                        class="form-input" 
                        placeholder="Nome do bairro"
                        value="<?= htmlspecialchars($endereco['bairro_endereco']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-building"></i>
                        Cidade <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="cidade_endereco" 
                        id="cidade" 
                        class="form-input" 
                        placeholder="Nome da cidade"
                        value="<?= htmlspecialchars($endereco['cidade_endereco']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-geo"></i>
                        Estado (UF) <span class="required">*</span>
                    </label>
                    <select name="uf_endereco" id="uf" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php 
                        $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                        foreach ($ufs as $uf): 
                        ?>
                            <option value="<?= $uf ?>" <?= $endereco['uf_endereco'] === $uf ? 'selected' : '' ?>>
                                <?= $uf ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="form-actions">
            <a href="/backend/endereco/listar" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i>
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle-fill"></i>
                Salvar Alterações
            </button>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p>Buscando CEP...</p>
    </div>
</div>

<script>
// COPIE TODO O JAVASCRIPT DO create.php
document.getElementById('cep').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.substring(0, 5) + '-' + value.substring(5, 8);
    }
    e.target.value = value;
});

async function buscarCep() {
    const cepInput = document.getElementById('cep');
    const cep = cepInput.value.replace(/\D/g, '');
    
    if (cep.length !== 8) {
        alert('⚠️ Por favor, digite um CEP válido com 8 dígitos.');
        cepInput.focus();
        return;
    }
    
    const overlay = document.getElementById('loadingOverlay');
    overlay.classList.add('show');
    
    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();
        
        if (data.erro) {
            throw new Error('CEP não encontrado');
        }
        
        document.getElementById('logradouro').value = data.logradouro || '';
        document.getElementById('bairro').value = data.bairro || '';
        document.getElementById('cidade').value = data.localidade || '';
        document.getElementById('uf').value = data.uf || '';
        
        document.getElementById('numero').focus();
        
    } catch (error) {
        alert('❌ Erro ao buscar CEP: ' + error.message + '\n\nPor favor, preencha manualmente os campos.');
        document.getElementById('logradouro').focus();
    } finally {
        overlay.classList.remove('show');
    }
}

document.getElementById('cep').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        buscarCep();
    }
});

function validarFormulario() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');
    
    if (cep.length !== 8) {
        alert('⚠️ CEP inválido! Digite um CEP com 8 dígitos.');
        document.getElementById('cep').focus();
        return false;
    }
    
    return true;
}
</script>