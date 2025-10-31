<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/agendamento/listar">Agendamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Agendamento #<?= $agendamento['id_agendamento'] ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Agendamento
                </h1>
                <p class="page-subtitle">Atualize as informações do agendamento #<?= $agendamento['id_agendamento'] ?></p>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <div class="form-card">
        <form action="/backend/agendamento/atualizar" method="POST" id="formAgendamento">
            <input type="hidden" name="id_agendamento" value="<?= $agendamento['id_agendamento'] ?>">
            
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
                            <select id="id_cliente" name="id_cliente" class="form-control" required>
                                <option value="">Selecione um cliente</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['id_usuario'] ?>" 
                                            <?= ($agendamento['id_cliente'] == $usuario['id_usuario']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($usuario['nome_usuario']) ?> - <?= htmlspecialchars($usuario['email_usuario']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="bi bi-chevron-down select-arrow"></i>
                        </div>
                        <small class="form-hint">Cliente vinculado a este agendamento</small>
                    </div>
                </div>
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
                                   value="<?= date('Y-m-d\TH:i', strtotime($agendamento['data_solicitada'])) ?>"
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
                                   value="R$ <?= number_format($agendamento['total_agendamento'], 2, ',', '.') ?>" 
                                   required>
                        </div>
                        <small class="form-hint">Valor total do agendamento</small>
                    </div>

                    <div class="form-group full-width">
                        <label for="status_agendamento" class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <div class="status-selector">
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="pendente" 
                                       <?= ($agendamento['status_agendamento'] == 'pendente') ? 'checked' : '' ?>>
                                <span class="status-card status-pendente">
                                    <i class="bi bi-clock-history"></i>
                                    <span class="status-text">Pendente</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="agendada"
                                       <?= ($agendamento['status_agendamento'] == 'agendada') ? 'checked' : '' ?>>
                                <span class="status-card status-agendada">
                                    <i class="bi bi-calendar-check"></i>
                                    <span class="status-text">Agendada</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="realizada"
                                       <?= ($agendamento['status_agendamento'] == 'realizada') ? 'checked' : '' ?>>
                                <span class="status-card status-realizada">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span class="status-text">Realizada</span>
                                </span>
                            </label>
                            
                            <label class="status-option">
                                <input type="radio" name="status_agendamento" value="cancelada"
                                       <?= ($agendamento['status_agendamento'] == 'cancelada') ? 'checked' : '' ?>>
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

            <!-- Botões de Ação -->
            <div class="form-actions">
                <a href="/backend/agendamento/listar" class="btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i>
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

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .status-selector {
            grid-template-columns: repeat(2, 1fr);
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
</style>

<script>
// Máscara de moeda para o campo de valor
document.getElementById('total_agendamento').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = (value / 100).toFixed(2);
    e.target.value = 'R$ ' + value.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
});

// Validação do formulário
document.getElementById('formAgendamento').addEventListener('submit', function(e) {
    const valorInput = document.getElementById('total_agendamento');
    const valorLimpo = valorInput.value.replace(/[R$\s.]/g, '').replace(',', '.');
    
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'total_agendamento';
    hiddenInput.value = valorLimpo;
    
    valorInput.removeAttribute('name');
    this.appendChild(hiddenInput);
});
</script>