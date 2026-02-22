<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/agendamento/listar">Agendamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Novo Agendamento</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-calendar-plus me-2"></i>
                    Novo Agendamento
                </h1>
                <p class="page-subtitle">Preencha os dados para criar um novo agendamento</p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/agendamento/salvar" method="POST" id="formAgendamento">
            
            <!-- Seção: Informações do Cliente -->
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
                            <select id="id_cliente" name="id_cliente" class="form-control" required onchange="carregarOrcamentos()">
                                <option value="">Selecione um cliente</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['id_usuario'] ?>" 
                                            <?= (isset($id_cliente_selecionado) && $id_cliente_selecionado == $usuario['id_usuario']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($usuario['nome_usuario']) ?> - <?= htmlspecialchars($usuario['email_usuario']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="bi bi-chevron-down select-arrow"></i>
                        </div>
                        <small class="form-hint">Selecione o cliente para visualizar seus orçamentos disponíveis</small>
                    </div>
                </div>
            </div>

            <!-- Seção: Orçamentos Disponíveis -->
            <div class="form-section" id="orcamentosSection" style="display: none;">
                <h3 class="section-title">
                    <i class="bi bi-receipt"></i>
                    Orçamentos Disponíveis
                </h3>
                
                <div id="orcamentosLoading" style="display: none; text-align: center; padding: 2rem;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p style="margin-top: 1rem; color: #64748b;">Carregando orçamentos...</p>
                </div>

                <div id="orcamentosLista" class="orcamentos-grid">
                    <!-- Os orçamentos serão carregados aqui via JavaScript -->
                </div>

                <input type="hidden" name="orcamentos_selecionados" id="orcamentos_selecionados">
                <small class="form-hint">Selecione um ou mais orçamentos para este agendamento</small>
            </div>

            <!-- Seção: Detalhes do Agendamento -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="bi bi-calendar-event"></i>
                    Detalhes do Agendamento
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="data_solicitada" class="form-label">
                            Data e Hora <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-calendar3 input-icon"></i>
                            <input type="datetime-local" 
                                   id="data_solicitada" 
                                   name="data_solicitada" 
                                   class="form-control" 
                                   required>
                        </div>
                        <small class="form-hint">Data e hora do agendamento</small>
                    </div>

                    <div class="form-group">
                        <label for="total_agendamento" class="form-label">
                            Valor Total <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="bi bi-cash-coin input-icon"></i>
                            <input type="text" 
                                   id="total_agendamento" 
                                   name="total_agendamento" 
                                   class="form-control" 
                                   placeholder="R$ 0,00" 
                                   readonly 
                                   required>
                        </div>
                        <small class="form-hint">Calculado automaticamente pelos orçamentos</small>
                    </div>

                    <div class="form-group full-width">
                        <label for="status_agendamento" class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <div class="status-selector">
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="pendente" checked>
                                <span class="status-card status-pendente">
                                    <i class="bi bi-clock-history"></i>
                                    <span class="status-text">Pendente</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="agendada">
                                <span class="status-card status-agendada">
                                    <i class="bi bi-calendar-check"></i>
                                    <span class="status-text">Agendada</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="realizada">
                                <span class="status-card status-realizada">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span class="status-text">Realizada</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="cancelada">
                                <span class="status-card status-cancelada">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span class="status-text">Cancelada</span>
                                </span>
                            </label>
                        </div>
                        <small class="form-hint">Status atual do agendamento</small>
                    </div>
                </div>
            </div>

            <!-- Seção: Resumo dos Serviços -->
            <div class="form-section" id="servicosDescricaoSection" style="display: none;">
                <h3 class="section-title">
                    <i class="bi bi-card-text"></i>
                    Resumo dos Serviços Selecionados
                </h3>
                
                <div id="servicosDescricao" class="servicos-resumo">
                    <!-- Será preenchido dinamicamente -->
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/agendamento/listar" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i>
                    Criar Agendamento
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

    .form-hint {
        font-size: 0.8125rem;
        color: #94a3b8;
        margin-top: 0.375rem;
    }

    /* Grid de Orçamentos */
    .orcamentos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .orcamento-card {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.25rem;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .orcamento-card:hover {
        border-color: var(--cor-acento);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .orcamento-card.selected {
        border-color: var(--cor-acento);
        background: linear-gradient(135deg, rgba(20, 135, 223, 0.05), rgba(20, 135, 223, 0.1));
    }

    .orcamento-card.selected::before {
        content: '✓';
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 28px;
        height: 28px;
        background: var(--cor-acento);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .orcamento-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .orcamento-id {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #64748b;
    }

    .orcamento-status {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-aprovado {
        background: #dcfce7;
        color: #166534;
    }

    .status-pendente-orc {
        background: #fef3c7;
        color: #92400e;
    }

    .orcamento-valor {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--cor-acento);
        margin-bottom: 0.5rem;
    }

    .orcamento-descricao {
        font-size: 0.875rem;
        color: #64748b;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .orcamentos-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
        background: #f8fafc;
        border-radius: 10px;
    }

    .orcamentos-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }

    .orcamentos-empty p {
        margin: 0;
        font-size: 0.9375rem;
    }

    /* Resumo dos Serviços */
    .servicos-resumo {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.25rem;
    }

    .servico-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .servico-item:last-child {
        border-bottom: none;
    }

    .servico-info {
        flex: 1;
    }

    .servico-titulo {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .servico-detalhes {
        font-size: 0.8125rem;
        color: #64748b;
    }

    .servico-valor {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--cor-acento);
    }

    .servico-total {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .servico-total-label {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
    }

    .servico-total-valor {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--cor-success);
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

    .status-pendente {
        color: #92400e;
    }

    .status-option input:checked + .status-pendente {
        background: #fef3c7;
        border-color: #f59e0b;
    }

    .status-agendada {
        color: #1e40af;
    }

    .status-option input:checked + .status-agendada {
        background: #dbeafe;
        border-color: #3b82f6;
    }

    .status-realizada {
        color: #166534;
    }

    .status-option input:checked + .status-realizada {
        background: #dcfce7;
        border-color: #22c55e;
    }

    .status-cancelada {
        color: #991b1b;
    }

    .status-option input:checked + .status-cancelada {
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

    /* Spinner */
    .spinner-border {
        width: 2rem;
        height: 2rem;
        border: 0.25rem solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
        color: var(--cor-acento);
    }

    @keyframes spinner-border {
        to { transform: rotate(360deg); }
    }

    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
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

        .orcamentos-grid {
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
let orcamentosSelecionados = [];
let orcamentosData = [];

// Carregar orçamentos quando selecionar cliente
async function carregarOrcamentos() {
    const clienteId = document.getElementById('id_cliente').value;
    const section = document.getElementById('orcamentosSection');
    const loading = document.getElementById('orcamentosLoading');
    const lista = document.getElementById('orcamentosLista');

    if (!clienteId) {
        section.style.display = 'none';
        orcamentosSelecionados = [];
        atualizarValorTotal();
        return;
    }

    section.style.display = 'block';
    loading.style.display = 'block';
    lista.innerHTML = '';

    try {
        const formData = new FormData();
        formData.append('id_cliente', clienteId);

        console.log('Enviando requisição para carregar orçamentos...'); // Debug

        const response = await fetch('/backend/agendamento/buscar-orcamentos-ajax', {
            method: 'POST',
            body: formData
        });

        console.log('Status da resposta:', response.status); // Debug

        // Verifica se a resposta é válida
        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const data = await response.json();
        console.log('Dados recebidos:', data); // Debug

        loading.style.display = 'none';

        if (data.success && data.orcamentos && data.orcamentos.length > 0) {
            orcamentosData = data.orcamentos;
            renderizarOrcamentos(data.orcamentos);
        } else {
            lista.innerHTML = `
                <div class="orcamentos-empty">
                    <i class="bi bi-inbox"></i>
                    <p><strong>Nenhum orçamento encontrado</strong></p>
                    <p>Este cliente ainda não possui orçamentos cadastrados</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Erro completo:', error); // Debug detalhado
        loading.style.display = 'none';
        lista.innerHTML = `
            <div class="orcamentos-empty">
                <i class="bi bi-exclamation-triangle" style="color: #ef4444;"></i>
                <p style="color: #ef4444;"><strong>Erro ao carregar orçamentos</strong></p>
                <p>${error.message || 'Tente novamente mais tarde'}</p>
            </div>
        `;
    }
}

// Renderizar os cards de orçamentos
function renderizarOrcamentos(orcamentos) {
    const lista = document.getElementById('orcamentosLista');
    
    lista.innerHTML = orcamentos.map(orc => `
        <div class="orcamento-card" onclick="toggleOrcamento(${orc.id_orcamento})" data-id="${orc.id_orcamento}">
            <div class="orcamento-header">
                <span class="orcamento-id">#${orc.id_orcamento}</span>
                <span class="orcamento-status status-${orc.status_orcamento.toLowerCase()}">
                    ${orc.status_orcamento}
                </span>
            </div>
            <div class="orcamento-valor">
                R$ ${parseFloat(orc.valor_orcamento).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
            </div>
            <div class="orcamento-descricao">
                ${orc.descricao_orcamento || 'Sem descrição'}
            </div>
        </div>
    `).join('');
}

// Toggle seleção de orçamento
function toggleOrcamento(id) {
    const card = document.querySelector(`.orcamento-card[data-id="${id}"]`);
    const index = orcamentosSelecionados.indexOf(id);

    if (index > -1) {
        orcamentosSelecionados.splice(index, 1);
        card.classList.remove('selected');
    } else {
        orcamentosSelecionados.push(id);
        card.classList.add('selected');
    }

    atualizarValorTotal();
    atualizarResumo();
}

// Atualizar valor total
function atualizarValorTotal() {
    let total = 0;

    orcamentosSelecionados.forEach(id => {
        const orc = orcamentosData.find(o => o.id_orcamento == id);
        if (orc) {
            total += parseFloat(orc.valor_orcamento);
        }
    });

    document.getElementById('total_agendamento').value = 'R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    document.getElementById('orcamentos_selecionados').value = JSON.stringify(orcamentosSelecionados);
}

// Atualizar resumo dos serviços
function atualizarResumo() {
    const section = document.getElementById('servicosDescricaoSection');
    const container = document.getElementById('servicosDescricao');

    if (orcamentosSelecionados.length === 0) {
        section.style.display = 'none';
        return;
    }

    section.style.display = 'block';

    let total = 0;
    const itens = orcamentosSelecionados.map(id => {
        const orc = orcamentosData.find(o => o.id_orcamento == id);
        if (!orc) return '';

        const valor = parseFloat(orc.valor_orcamento);
        total += valor;

        return `
            <div class="servico-item">
                <div class="servico-info">
                    <div class="servico-titulo">Orçamento #${orc.id_orcamento}</div>
                    <div class="servico-detalhes">${orc.descricao_orcamento || 'Sem descrição'}</div>
                </div>
                <div class="servico-valor">
                    R$ ${valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                </div>
            </div>
        `;
    }).join('');

    container.innerHTML = `
        ${itens}
        <div class="servico-total">
            <span class="servico-total-label">Total:</span>
            <span class="servico-total-valor">
                R$ ${total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
            </span>
        </div>
    `;
}

// Validação antes de enviar
document.getElementById('formAgendamento').addEventListener('submit', function(e) {
    if (orcamentosSelecionados.length === 0) {
        e.preventDefault();
        alert('Por favor, selecione pelo menos um orçamento para o agendamento!');
        return false;
    }
    
    // Converter valor para formato numérico antes de enviar
    const valorInput = document.getElementById('total_agendamento');
    const valorLimpo = valorInput.value.replace(/[R$\s.]/g, '').replace(',', '.');
    
    // Cria um input hidden com o valor numérico
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'total_agendamento';
    hiddenInput.value = valorLimpo;
    
    // Remove o name do input original para não enviar
    valorInput.removeAttribute('name');
    
    // Adiciona o hidden input ao formulário
    this.appendChild(hiddenInput);
});

// Se já tiver cliente pré-selecionado, carregar orçamentos
window.addEventListener('DOMContentLoaded', function() {
    const clienteId = document.getElementById('id_cliente').value;
    if (clienteId) {
        carregarOrcamentos();
    }

    // Definir data mínima como hoje
    const hoje = new Date();
    const dataFormatada = hoje.toISOString().slice(0, 16);
    document.getElementById('data_solicitada').min = dataFormatada;
});
</script>