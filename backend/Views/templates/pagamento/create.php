<div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Novo Pagamento
                </h1>
                <p class="page-subtitle">Registre um novo pagamento de cliente</p>
            </div>
            <a href="/backend/pagamento/listar" class="btn-action-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/pagamento/salvar" method="POST" id="formPagamento">
            
            <!-- Seção: Informações do Cliente -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-person-fill"></i>
                        Informações do Cliente
                    </h3>
                    <p class="section-subtitle">Selecione o cliente que está realizando o pagamento</p>
                </div>

                <div class="form-group">
                    <label for="id_cliente" class="form-label required">
                        <i class="bi bi-person"></i>
                        Cliente
                    </label>
                    <select name="id_cliente" id="id_cliente" class="form-select" required>
                        <option value="">Selecione um cliente</option>
                        <?php foreach($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id_usuario'] ?>">
                                <?= htmlspecialchars($usuario['nome_usuario']) ?>
                                <?php if (!empty($usuario['email_usuario'])): ?>
                                    - <?= htmlspecialchars($usuario['email_usuario']) ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="data_pagamento" class="form-label required">
                        <i class="bi bi-calendar3"></i>
                        Data do Pagamento
                    </label>
                    <input type="date" 
                           name="data_pagamento" 
                           id="data_pagamento" 
                           class="form-input"
                           value="<?= date('Y-m-d') ?>"
                           required>
                </div>
            </div>

            <!-- Seção: Valores -->
            <div class="form-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="bi bi-calculator"></i>
                        Valores
                    </h3>
                    <p class="section-subtitle">Informe o valor total devido e as formas de pagamento</p>
                </div>

                <div class="form-group">
                    <label for="total_devedor" class="form-label required">
                        <i class="bi bi-wallet2"></i>
                        Valor Total Devido
                    </label>
                    <div class="input-group">
                        <span class="input-prefix">R$</span>
                        <input type="number" 
                               name="total_devedor" 
                               id="total_devedor" 
                               class="form-input with-prefix"
                               placeholder="0,00"
                               step="0.01"
                               min="0"
                               required
                               onchange="calcularStatus()">
                    </div>
                </div>

                <div class="payment-methods-grid">
                    <!-- Dinheiro -->
                    <div class="form-group">
                        <label for="dinheiro" class="form-label">
                            <i class="bi bi-cash"></i>
                            Dinheiro
                        </label>
                        <div class="input-group">
                            <span class="input-prefix">R$</span>
                            <input type="number" 
                                   name="dinheiro" 
                                   id="dinheiro" 
                                   class="form-input with-prefix"
                                   placeholder="0,00"
                                   step="0.01"
                                   min="0"
                                   value="0"
                                   onchange="calcularTotalPago()">
                        </div>
                    </div>

                    <!-- Débito -->
                    <div class="form-group">
                        <label for="debito" class="form-label">
                            <i class="bi bi-credit-card"></i>
                            Débito
                        </label>
                        <div class="input-group">
                            <span class="input-prefix">R$</span>
                            <input type="number" 
                                   name="debito" 
                                   id="debito" 
                                   class="form-input with-prefix"
                                   placeholder="0,00"
                                   step="0.01"
                                   min="0"
                                   value="0"
                                   onchange="calcularTotalPago()">
                        </div>
                    </div>

                    <!-- Crédito -->
                    <div class="form-group">
                        <label for="credito" class="form-label">
                            <i class="bi bi-credit-card-2-front"></i>
                            Crédito
                        </label>
                        <div class="input-group">
                            <span class="input-prefix">R$</span>
                            <input type="number" 
                                   name="credito" 
                                   id="credito" 
                                   class="form-input with-prefix"
                                   placeholder="0,00"
                                   step="0.01"
                                   min="0"
                                   value="0"
                                   onchange="calcularTotalPago()">
                        </div>
                    </div>

                    <!-- PIX -->
                    <div class="form-group">
                        <label for="pix" class="form-label">
                            <i class="bi bi-qr-code"></i>
                            PIX
                        </label>
                        <div class="input-group">
                            <span class="input-prefix">R$</span>
                            <input type="number" 
                                   name="pix" 
                                   id="pix" 
                                   class="form-input with-prefix"
                                   placeholder="0,00"
                                   step="0.01"
                                   min="0"
                                   value="0"
                                   onchange="calcularTotalPago()">
                        </div>
                    </div>
                </div>

                <!-- Resumo -->
                <div class="payment-summary">
                    <div class="summary-item">
                        <span class="summary-label">Total Devido:</span>
                        <span class="summary-value devedor" id="displayTotalDevedor">R$ 0,00</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total Pago:</span>
                        <span class="summary-value pago" id="displayTotalPago">R$ 0,00</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Diferença:</span>
                        <span class="summary-value" id="displayDiferenca">R$ 0,00</span>
                    </div>
                    <div class="summary-item status">
                        <span class="summary-label">Status:</span>
                        <span class="summary-value" id="displayStatus">
                            <span class="status-badge status-aberto">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                Em Aberto
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/pagamento/listar" class="btn-form-cancel">
                    <i class="bi bi-x-lg"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn-form-submit">
                    <i class="bi bi-check-lg"></i>
                    Salvar Pagamento
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
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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
        color: #64748b;
        margin: 0;
    }

    .btn-action-secondary {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-action-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .section-header {
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.375rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--cor-acento);
        font-size: 1.25rem;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label.required::after {
        content: "*";
        color: var(--cor-danger);
        margin-left: 0.25rem;
    }

    .form-select,
    .form-input {
        width: 100%;
        padding: 0.875rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-select:focus,
    .form-input:focus {
        outline: none;
        border-color: var(--cor-acento);
        box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-prefix {
        position: absolute;
        left: 1rem;
        font-weight: 600;
        color: #64748b;
        font-size: 0.9375rem;
        pointer-events: none;
    }

    .form-input.with-prefix {
        padding-left: 3rem;
    }

    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Payment Summary */
    .payment-summary {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid #e2e8f0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .summary-item.status {
        grid-column: 1 / -1;
        padding-top: 1rem;
        border-top: 2px solid #e2e8f0;
    }

    .summary-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }

    .summary-value.devedor {
        color: var(--cor-danger);
    }

    .summary-value.pago {
        color: var(--cor-success);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
    }

    .status-pago {
        background: #dcfce7;
        color: #166534;
    }

    .status-aberto {
        background: #fef3c7;
        color: #92400e;
    }

    .form-actions {
        padding: 1.5rem 2rem;
        background: #f8fafc;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-form-cancel {
        padding: 0.75rem 1.5rem;
        border: 1px solid #e2e8f0;
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

    .btn-form-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-form-submit {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--cor-acento), #0e6eb8);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(20, 135, 223, 0.3);
    }

    .btn-form-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 135, 223, 0.4);
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-action-secondary {
            width: 100%;
            justify-content: center;
        }

        .payment-methods-grid {
            grid-template-columns: 1fr;
        }

        .payment-summary {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-form-cancel,
        .btn-form-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
// Calcular total pago e atualizar status
function calcularTotalPago() {
    const dinheiro = parseFloat(document.getElementById('dinheiro').value) || 0;
    const debito = parseFloat(document.getElementById('debito').value) || 0;
    const credito = parseFloat(document.getElementById('credito').value) || 0;
    const pix = parseFloat(document.getElementById('pix').value) || 0;
    
    const totalPago = dinheiro + debito + credito + pix;
    
    document.getElementById('displayTotalPago').textContent = 
        'R$ ' + totalPago.toFixed(2).replace('.', ',');
    
    calcularStatus();
}

// Calcular status do pagamento
function calcularStatus() {
    const totalDevedor = parseFloat(document.getElementById('total_devedor').value) || 0;
    const dinheiro = parseFloat(document.getElementById('dinheiro').value) || 0;
    const debito = parseFloat(document.getElementById('debito').value) || 0;
    const credito = parseFloat(document.getElementById('credito').value) || 0;
    const pix = parseFloat(document.getElementById('pix').value) || 0;
    
    const totalPago = dinheiro + debito + credito + pix;
    const diferenca = totalPago - totalDevedor;
    
    // Atualizar displays
    document.getElementById('displayTotalDevedor').textContent = 
        'R$ ' + totalDevedor.toFixed(2).replace('.', ',');
    
    document.getElementById('displayTotalPago').textContent = 
        'R$ ' + totalPago.toFixed(2).replace('.', ',');
    
    const diferencaDisplay = document.getElementById('displayDiferenca');
    diferencaDisplay.textContent = 'R$ ' + Math.abs(diferenca).toFixed(2).replace('.', ',');
    
    if (diferenca > 0) {
        diferencaDisplay.style.color = 'var(--cor-success)';
    } else if (diferenca < 0) {
        diferencaDisplay.style.color = 'var(--cor-danger)';
    } else {
        diferencaDisplay.style.color = '#1e293b';
    }
    
    // Atualizar status
    const statusDisplay = document.getElementById('displayStatus');
    if (totalPago >= totalDevedor && totalDevedor > 0) {
        statusDisplay.innerHTML = `
            <span class="status-badge status-pago">
                <i class="bi bi-check-circle-fill"></i>
                Pago
            </span>
        `;
    } else {
        statusDisplay.innerHTML = `
            <span class="status-badge status-aberto">
                <i class="bi bi-exclamation-circle-fill"></i>
                Em Aberto
            </span>
        `;
    }
}

// Validação antes de enviar
document.getElementById('formPagamento').addEventListener('submit', function(e) {
    const totalDevedor = parseFloat(document.getElementById('total_devedor').value) || 0;
    const dinheiro = parseFloat(document.getElementById('dinheiro').value) || 0;
    const debito = parseFloat(document.getElementById('debito').value) || 0;
    const credito = parseFloat(document.getElementById('credito').value) || 0;
    const pix = parseFloat(document.getElementById('pix').value) || 0;
    
    const totalPago = dinheiro + debito + credito + pix;
    
    if (totalDevedor <= 0) {
        e.preventDefault();
        alert('O valor total devido deve ser maior que zero.');
        return false;
    }
    
    if (totalPago <= 0) {
        e.preventDefault();
        alert('É necessário informar pelo menos um valor de pagamento.');
        return false;
    }
    
    // Mostrar loading
    const btnSubmit = this.querySelector('.btn-form-submit');
    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Salvando...';
    btnSubmit.disabled = true;
});

// Inicializar cálculos ao carregar
document.addEventListener('DOMContentLoaded', function() {
    calcularTotalPago();
});
</script>