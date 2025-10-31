<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/servico/listar">Serviços Internos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Serviço #<?= $servico['id_servico'] ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Serviço Interno
                </h1>
                <p class="page-subtitle">Atualize as informações do serviço #<?= $servico['id_servico'] ?></p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/servico/atualizar/<?= $servico['id_servico'] ?>" method="POST" id="formServico">
            
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-tools"></i>
                    Informações do Serviço
                </h3>
                
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="nome_servico" class="form-label">
                            Nome do Serviço <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-gear-fill input-icon"></i>
                            <input type="text" 
                                   id="nome_servico" 
                                   name="nome_servico" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($servico['nome_servico']) ?>"
                                   placeholder="Ex: Instalação Elétrica Residencial"
                                   minlength="3"
                                   maxlength="255"
                                   required>
                        </div>
                        <small class="form-hint">Nome que identificará o serviço internamente</small>
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao_servico" class="form-label">
                            Descrição do Serviço <span class="required">*</span>
                        </label>
                        <div class="textarea-wrapper">
                            <i class="bi bi-text-left textarea-icon"></i>
                            <textarea id="descricao_servico" 
                                      name="descricao_servico" 
                                      class="form-control form-textarea" 
                                      rows="5"
                                      placeholder="Descreva os detalhes do serviço..."
                                      minlength="10"
                                      maxlength="1000"
                                      required><?= htmlspecialchars($servico['descricao_servico']) ?></textarea>
                        </div>
                        <small class="form-hint">
                            <span id="char-count"><?= strlen($servico['descricao_servico']) ?></span>/1000 caracteres
                        </small>
                    </div>

                    <div class="form-group full-width">
                        <label for="valor_base_servico" class="form-label">
                            Valor Base do Serviço <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-cash-coin input-icon"></i>
                            <input type="text" 
                                   id="valor_base_servico" 
                                   name="valor_base_servico" 
                                   class="form-control" 
                                   value="R$ <?= number_format($servico['valor_base_servico'], 2, ',', '.') ?>"
                                   placeholder="R$ 0,00"
                                   required>
                        </div>
                        <small class="form-hint">Valor base usado como referência para orçamentos</small>
                    </div>
                </div>
            </div>

            <!-- Informação de Atualização -->
            <?php if (!empty($servico['atualizado_em'])): ?>
            <div class="info-box info-secondary">
                <div class="info-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="info-content">
                    <strong>Última atualização:</strong> 
                    <?= date('d/m/Y \à\s H:i', strtotime($servico['atualizado_em'])) ?>
                    <br>
                    <strong>Criado em:</strong> 
                    <?= date('d/m/Y \à\s H:i', strtotime($servico['criado_em'])) ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/servico/listar" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <div class="actions-right">
                    <a href="/backend/servico/excluir/<?= $servico['id_servico'] ?>" 
                       class="btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                        <i class="bi bi-trash"></i>
                        Excluir
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check-lg"></i>
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-acento: #1487df;
        --cor-success: #22c55e;
        --cor-warning: #f59e0b;
        --cor-danger: #ef4444;
        --cor-info: #3b82f6;
    }

    .page-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Breadcrumb */
    .breadcrumb-nav {
        margin-bottom: 1.5rem;
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

    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
    }

    .page-title i {
        color: var(--cor-acento);
    }

    .page-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0;
    }

    /* Formulário */
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-title i {
        color: var(--cor-acento);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .required {
        color: var(--cor-danger);
    }

    .input-wrapper,
    .textarea-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.125rem;
        z-index: 1;
    }

    .textarea-icon {
        position: absolute;
        left: 1rem;
        top: 1rem;
        color: #94a3b8;
        font-size: 1.125rem;
        z-index: 1;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
        background: white;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .form-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
        margin-top: 0.375rem;
    }

    /* Info Box */
    .info-box {
        display: flex;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        margin-bottom: 2rem;
    }

    .info-box.info-secondary {
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .info-box.info-secondary .info-icon {
        color: #64748b;
    }

    .info-box.info-secondary .info-content {
        color: #475569;
    }

    .info-icon {
        color: #3b82f6;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .info-content {
        font-size: 0.875rem;
        color: #1e40af;
        line-height: 1.6;
    }

    /* Botões de Ação */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }

    .actions-right {
        display: flex;
        gap: 0.75rem;
    }

    .btn-primary,
    .btn-secondary,
    .btn-danger {
        padding: 0.875rem 1.75rem;
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
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-danger {
        background: white;
        color: var(--cor-danger);
        border: 1px solid #fecaca;
    }

    .btn-danger:hover {
        background: #fef2f2;
        border-color: var(--cor-danger);
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .actions-right {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary,
        .btn-danger {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Máscara de moeda para o valor
document.getElementById('valor_base_servico').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = (value / 100).toFixed(2);
    e.target.value = 'R$ ' + value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
});

// Contador de caracteres
const textarea = document.getElementById('descricao_servico');
const charCount = document.getElementById('char-count');

textarea.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});

// Validação do formulário
document.getElementById('formServico').addEventListener('submit', function(e) {
    const valorInput = document.getElementById('valor_base_servico');
    const valorLimpo = valorInput.value.replace(/[R$\s.]/g, '').replace(',', '.');
    
    // Valida se o valor é maior que zero
    if (parseFloat(valorLimpo) <= 0) {
        e.preventDefault();
        alert('O valor do serviço deve ser maior que zero.');
        valorInput.focus();
        return false;
    }
    
    // Cria input hidden com valor numérico
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'valor_base_servico';
    hiddenInput.value = valorLimpo;
    
    // Remove name do input original
    valorInput.removeAttribute('name');
    
    // Adiciona hidden ao form
    this.appendChild(hiddenInput);
});
</script>