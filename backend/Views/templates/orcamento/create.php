<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/orcamento/listar">Orçamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Orçamento</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Novo Orçamento
                </h1>
                <p class="page-subtitle">Preencha os dados para criar um novo orçamento</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/orcamento/salvar" method="post" id="formOrcamento">
            
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-person-circle"></i>
                    Informações do Cliente
                </h3>
                
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="id_cliente" class="form-label">
                            Cliente <span class="required">*</span>
                        </label>
                        <div class="select-wrapper">
                            <i class="bi bi-person-fill select-icon"></i>
                            <select id="id_cliente" name="id_cliente" class="form-control" required>
                                <option value="">Selecione um cliente</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= htmlspecialchars($usuario['id_usuario']) ?>">
                                        <?= htmlspecialchars($usuario['nome_usuario']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="bi bi-chevron-down select-arrow"></i>
                        </div>
                        <small class="form-hint">Selecione o cliente para este orçamento</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-file-text"></i>
                    Descrição do Orçamento
                </h3>
                
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="descricao_orcamento" class="form-label">
                            Descrição <span class="required">*</span>
                        </label>
                        <textarea id="descricao_orcamento" 
                                  name="descricao_orcamento" 
                                  class="form-control" 
                                  rows="5"
                                  placeholder="Descreva detalhadamente os serviços e produtos incluídos neste orçamento..."
                                  required></textarea>
                        <small class="form-hint">Detalhe os itens e serviços inclusos no orçamento</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-calendar-event"></i>
                    Detalhes do Orçamento
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="data_orcamento" class="form-label">
                            Data do Orçamento <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-calendar3 input-icon"></i>
                            <input type="date" 
                                   id="data_orcamento" 
                                   name="data_orcamento" 
                                   class="form-control" 
                                   value="<?= date('Y-m-d') ?>"
                                   required>
                        </div>
                        <small class="form-hint">Data de criação do orçamento</small>
                    </div>

                    <div class="form-group">
                        <label for="total_item_orcamento" class="form-label">
                            Total de Itens <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-list-ol input-icon"></i>
                            <input type="number" 
                                   id="total_item_orcamento" 
                                   name="total_item_orcamento" 
                                   class="form-control" 
                                   min="1"
                                   placeholder="0"
                                   required>
                        </div>
                        <small class="form-hint">Quantidade de itens/serviços</small>
                    </div>

                    <div class="form-group">
                        <label for="valor_orcamento" class="form-label">
                            Valor Total <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-cash-coin input-icon"></i>
                            <input type="text" 
                                   id="valor_orcamento" 
                                   name="valor_orcamento" 
                                   class="form-control" 
                                   placeholder="R$ 0,00"
                                   required>
                        </div>
                        <small class="form-hint">Valor total do orçamento</small>
                    </div>

                    <div class="form-group full-width">
                        <label for="status_orcamento" class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <div class="status-selector">
                            <label class="status-option">
                                <input type="radio" name="status_orcamento" value="aguardando" checked>
                                <span class="status-card status-aguardando">
                                    <i class="bi bi-hourglass-split"></i>
                                    <span class="status-text">Aguardando</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_orcamento" value="em_analise">
                                <span class="status-card status-em-analise">
                                    <i class="bi bi-search"></i>
                                    <span class="status-text">Em Análise</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_orcamento" value="aprovado">
                                <span class="status-card status-aprovado">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span class="status-text">Aprovado</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_orcamento" value="recusado">
                                <span class="status-card status-recusado">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span class="status-text">Recusado</span>
                                </span>
                            </label>
                        </div>
                        <small class="form-hint">Status atual do orçamento</small>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/orcamento/listar" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Criar Orçamento
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

    .form-section:last-of-type {
        margin-bottom: 0;
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
    .select-wrapper {
        position: relative;
    }

    .input-icon,
    .select-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.125rem;
        z-index: 1;
    }

    .select-arrow {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
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

    .form-control:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    select.form-control {
        appearance: none;
        cursor: pointer;
    }

    textarea.form-control {
        padding: 0.75rem 1rem;
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
        line-height: 1.5;
    }

    .form-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
        margin-top: 0.375rem;
    }

    /* Seletor de Status */
    .status-selector {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }

    .status-option {
        cursor: pointer;
    }

    .status-option input[type="radio"] {
        display: none;
    }

    .status-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.2s;
        background: white;
    }

    .status-card i {
        font-size: 1.5rem;
    }

    .status-text {
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .status-option input:checked + .status-card {
        border-width: 2px;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-aguardando {
        color: #92400e;
    }

    .status-option input:checked + .status-aguardando {
        background: #fef3c7;
        border-color: #f59e0b;
    }

    .status-em-analise {
        color: #1e40af;
    }

    .status-option input:checked + .status-em-analise {
        background: #dbeafe;
        border-color: #3b82f6;
    }

    .status-aprovado {
        color: #166534;
    }

    .status-option input:checked + .status-aprovado {
        background: #dcfce7;
        border-color: #22c55e;
    }

    .status-recusado {
        color: #991b1b;
    }

    .status-option input:checked + .status-recusado {
        background: #fee2e2;
        border-color: #ef4444;
    }

    /* Botões de Ação */
    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }

    .btn-primary,
    .btn-secondary {
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
        flex: 1;
        justify-content: center;
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

    /* Responsivo */
    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .status-selector {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .status-card {
            padding: 1.25rem 0.75rem;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Máscara de moeda para o campo de valor
document.getElementById('valor_orcamento').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = (value / 100).toFixed(2);
    e.target.value = 'R$ ' + value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
});

// Validação do formulário
document.getElementById('formOrcamento').addEventListener('submit', function(e) {
    const valorInput = document.getElementById('valor_orcamento');
    const valorLimpo = valorInput.value.replace(/[R$\s.]/g, '').replace(',', '.');
    
    // Cria um input hidden com o valor numérico
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'valor_orcamento';
    hiddenInput.value = valorLimpo;
    
    // Remove o name do input original para não enviar
    valorInput.removeAttribute('name');
    
    // Adiciona o hidden input ao formulário
    this.appendChild(hiddenInput);
});
</script>