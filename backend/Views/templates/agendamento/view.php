<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/agendamento/listar">Agendamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detalhes #<?= htmlspecialchars($agendamento['id_agendamento']) ?></li>
        </ol>
    </nav>

    <!-- Header com Ações -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-eye-fill me-2"></i>
                    Agendamento #<?= htmlspecialchars($agendamento['id_agendamento']) ?>
                </h1>
                <p class="page-subtitle">Visualização completa do agendamento</p>
            </div>
            <div class="header-actions">
                <a href="/backend/agendamento/editar/<?= $agendamento['id_agendamento'] ?>" class="btn-action-edit">
                    <i class="bi bi-pencil"></i>
                    Editar
                </a>
                <button onclick="confirmarExclusao(<?= $agendamento['id_agendamento'] ?>)" class="btn-action-delete">
                    <i class="bi bi-trash"></i>
                    Excluir
                </button>
            </div>
        </div>
    </div>

    <!-- Status Badge Grande -->
    <div class="status-banner">
        <?php
            $status = strtolower(trim($agendamento['status_agendamento']));
            $statusConfig = match ($status) {
                'realizada' => ['class' => 'status-realizada', 'icon' => 'check-circle-fill', 'text' => 'Realizada', 'desc' => 'Este agendamento foi concluído com sucesso'],
                'agendada'  => ['class' => 'status-agendada', 'icon' => 'calendar-check-fill', 'text' => 'Agendada', 'desc' => 'Data confirmada e agendamento ativo'],
                'pendente'  => ['class' => 'status-pendente', 'icon' => 'clock-fill', 'text' => 'Pendente', 'desc' => 'Aguardando confirmação'],
                'cancelada' => ['class' => 'status-cancelada', 'icon' => 'x-circle-fill', 'text' => 'Cancelada', 'desc' => 'Este agendamento foi cancelado'],
                default     => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status), 'desc' => '']
            };
        ?>
        <div class="status-badge-large <?= $statusConfig['class'] ?>">
            <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
            <div class="status-info">
                <span class="status-title"><?= $statusConfig['text'] ?></span>
                <span class="status-desc"><?= $statusConfig['desc'] ?></span>
            </div>
        </div>
    </div>

    <!-- Grid de Cards de Informações -->
    <div class="info-grid">
        <!-- Card Cliente -->
        <div class="info-card card-cliente">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-person-circle"></i>
                    Informações do Cliente
                </h3>
            </div>
            <div class="card-body">
                <div class="client-profile">
                    <div class="client-avatar-xl">
                        <?= strtoupper(substr($agendamento['nome_cliente'] ?? 'C', 0, 1)) ?>
                    </div>
                    <div class="client-info-details">
                        <h4 class="client-name-xl"><?= htmlspecialchars($agendamento['nome_cliente'] ?? 'Cliente') ?></h4>
                        <p class="client-email-xl">
                            <i class="bi bi-envelope"></i>
                            <?= htmlspecialchars($agendamento['email_cliente'] ?? 'Não informado') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Detalhes do Agendamento -->
        <div class="info-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-calendar-event"></i>
                    Detalhes do Agendamento
                </h3>
            </div>
            <div class="card-body">
                <div class="detail-item">
                    <span class="detail-label">
                        <i class="bi bi-calendar3"></i>
                        Data Solicitada
                    </span>
                    <span class="detail-value"><?= date('d/m/Y', strtotime($agendamento['data_solicitada'])) ?></span>
                </div>
                
                <div class="detail-item">
                    <span class="detail-label">
                        <i class="bi bi-clock"></i>
                        Hora
                    </span>
                    <span class="detail-value"><?= date('H:i', strtotime($agendamento['data_solicitada'])) ?></span>
                </div>
            </div>
        </div>

        <!-- Card Valor -->
        <div class="info-card card-valor">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-cash-coin"></i>
                    Valor do Serviço
                </h3>
            </div>
            <div class="card-body">
                <div class="valor-display">
                    <span class="valor-cifrao">R$</span>
                    <span class="valor-numero"><?= number_format($agendamento['total_agendamento'], 2, ',', '.') ?></span>
                </div>
                <p class="valor-descricao">Valor total do agendamento</p>
            </div>
        </div>

        <!-- Card Timeline/Histórico -->
        <div class="info-card card-full">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-clock-history"></i>
                    Histórico do Agendamento
                </h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-success">
                            <i class="bi bi-plus-circle-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="timeline-title">Agendamento Criado</h5>
                            <p class="timeline-date">
                                <?= isset($agendamento['criado_em']) ? date('d/m/Y às H:i', strtotime($agendamento['criado_em'])) : 'Data não disponível' ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if (isset($agendamento['atualizado_em']) && $agendamento['atualizado_em']): ?>
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-info">
                            <i class="bi bi-pencil-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="timeline-title">Última Atualização</h5>
                            <p class="timeline-date">
                                <?= date('d/m/Y às H:i', strtotime($agendamento['atualizado_em'])) ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($status == 'realizada'): ?>
                    <div class="timeline-item">
                        <div class="timeline-icon timeline-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="timeline-content">
                            <h5 class="timeline-title">Serviço Realizado</h5>
                            <p class="timeline-date">
                                <?= date('d/m/Y', strtotime($agendamento['data_solicitada'])) ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="page-actions">
        <a href="/backend/agendamento/listar" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Voltar para Lista
        </a>
        <div class="action-group">
            <a href="/backend/agendamento/editar/<?= $agendamento['id_agendamento'] ?>" class="btn-primary">
                <i class="bi bi-pencil"></i>
                Editar Agendamento
            </a>
            <button onclick="imprimirAgendamento()" class="btn-secondary">
                <i class="bi bi-printer"></i>
                Imprimir
            </button>
        </div>
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
        max-width: 1200px;
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

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
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

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action-edit,
    .btn-action-delete {
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
    }

    .btn-action-edit {
        background: var(--cor-acento);
        color: white;
    }

    .btn-action-edit:hover {
        background: #0e6eb8;
        transform: translateY(-1px);
    }

    .btn-action-delete {
        background: white;
        color: var(--cor-danger);
        border: 1px solid #fee2e2;
    }

    .btn-action-delete:hover {
        background: #fee2e2;
        border-color: var(--cor-danger);
    }

    /* Status Banner */
    .status-banner {
        margin-bottom: 2rem;
    }

    .status-badge-large {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid;
    }

    .status-badge-large i {
        font-size: 2.5rem;
    }

    .status-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .status-title {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .status-desc {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .status-pendente {
        background: #fef3c7;
        border-color: #f59e0b;
        color: #92400e;
    }

    .status-agendada {
        background: #dbeafe;
        border-color: #3b82f6;
        color: #1e40af;
    }

    .status-realizada {
        background: #dcfce7;
        border-color: #22c55e;
        color: #166534;
    }

    .status-cancelada {
        background: #fee2e2;
        border-color: #ef4444;
        color: #991b1b;
    }

    /* Grid de Cards */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .card-full {
        grid-column: 1 / -1;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--cor-acento);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Cliente Profile */
    .client-profile {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .client-avatar-xl {
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
    }

    .client-name-xl {
        font-size: 1.375rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }

    .client-email-xl {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Detail Items */
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Valor Display */
    .card-valor .card-body {
        text-align: center;
    }

    .valor-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .valor-cifrao {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--cor-success);
    }

    .valor-numero {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--cor-success);
    }

    .valor-descricao {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    /* Timeline */
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .timeline-item {
        display: flex;
        gap: 1rem;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .timeline-success {
        background: #dcfce7;
        color: #166534;
    }

    .timeline-info {
        background: #dbeafe;
        color: #1e40af;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 0.25rem 0;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    /* Page Actions */
    .page-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 2rem 0;
    }

    .action-group {
        display: flex;
        gap: 0.75rem;
    }

    .btn-back,
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

    .btn-back {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
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
        color: var(--cor-acento);
        border: 1px solid #e0f2fe;
    }

    .btn-secondary:hover {
        background: #f0f9ff;
        border-color: var(--cor-acento);
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .page-header-content {
            flex-direction: column;
        }

        .header-actions {
            width: 100%;
        }

        .btn-action-edit,
        .btn-action-delete {
            flex: 1;
            justify-content: center;
        }

        .page-actions {
            flex-direction: column;
        }

        .action-group {
            width: 100%;
            flex-direction: column;
        }

        .btn-back,
        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .client-profile {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<script>
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este agendamento?\n\nEsta ação não pode ser desfeita.')) {
        window.location.href = `/backend/agendamento/excluir/${id}`;
    }
}

function imprimirAgendamento() {
    window.print();
}
</script>