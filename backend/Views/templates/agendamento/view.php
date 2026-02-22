<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/agendamento/listar">Agendamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agendamento #<?= $agendamento['id_agendamento'] ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-eye-fill me-2"></i>
                    Detalhes do Agendamento
                </h1>
                <p class="page-subtitle">Visualização completa do agendamento #<?= $agendamento['id_agendamento'] ?></p>
            </div>
            <div class="header-actions">
                <a href="/backend/agendamento/editar/<?= $agendamento['id_agendamento'] ?>" class="btn-action btn-edit">
                    <i class="bi bi-pencil"></i>
                    Editar
                </a>
                <a href="/backend/agendamento/excluir/<?= $agendamento['id_agendamento'] ?>" class="btn-action btn-delete">
                    <i class="bi bi-trash"></i>
                    Excluir
                </a>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="content-grid">
        <!-- Card de Status -->
        <div class="status-card-large full-width">
            <?php
                $status = strtolower(trim($agendamento['status_agendamento']));
                $statusConfig = match ($status) {
                    'realizada' => ['class' => 'status-realizada', 'icon' => 'check-circle-fill', 'text' => 'Realizada', 'desc' => 'Este agendamento foi concluído com sucesso'],
                    'agendada'  => ['class' => 'status-agendada', 'icon' => 'calendar-check-fill', 'text' => 'Agendada', 'desc' => 'Agendamento confirmado e aguardando execução'],
                    'pendente'  => ['class' => 'status-pendente', 'icon' => 'clock-fill', 'text' => 'Pendente', 'desc' => 'Aguardando confirmação do agendamento'],
                    'cancelada' => ['class' => 'status-cancelada', 'icon' => 'x-circle-fill', 'text' => 'Cancelada', 'desc' => 'Este agendamento foi cancelado'],
                    default     => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status), 'desc' => '']
                };
            ?>
            <div class="status-badge-view <?= $statusConfig['class'] ?>">
                <i class="bi bi-<?= $statusConfig['icon'] ?>"></i>
                <div>
                    <span class="status-text"><?= $statusConfig['text'] ?></span>
                    <span class="status-desc"><?= $statusConfig['desc'] ?></span>
                </div>
            </div>
        </div>

        <!-- Informações do Cliente -->
        <div class="info-card">
            <h3 class="card-title">
                <i class="bi bi-person-circle"></i>
                Informações do Cliente
            </h3>
            <div class="info-content">
                <div class="client-profile">
                    <div class="client-avatar-view">
                        <?= strtoupper(substr($agendamento['nome_usuario'] ?? 'C', 0, 1)) ?>
                    </div>
                    <div class="client-info-view">
                        <h4 class="client-name-view"><?= htmlspecialchars($agendamento['nome_usuario'] ?? 'Cliente') ?></h4>
                        <p class="client-email-view">
                            <i class="bi bi-envelope"></i>
                            <?= htmlspecialchars($agendamento['email_usuario'] ?? 'email@exemplo.com') ?>
                        </p>
                        <?php if (!empty($agendamento['telefone_usuario'])): ?>
                            <p class="client-phone-view">
                                <i class="bi bi-telephone"></i>
                                <?= htmlspecialchars($agendamento['telefone_usuario']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhes do Agendamento -->
        <div class="info-card">
            <h3 class="card-title">
                <i class="bi bi-calendar-event"></i>
                Detalhes do Agendamento
            </h3>
            <div class="info-content">
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-hash"></i>
                        ID do Agendamento
                    </span>
                    <span class="info-value">#<?= htmlspecialchars($agendamento['id_agendamento']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-calendar3"></i>
                        Data e Hora
                    </span>
                    <span class="info-value"><?= date('d/m/Y às H:i', strtotime($agendamento['data_solicitada'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-cash-coin"></i>
                        Valor Total
                    </span>
                    <span class="info-value value-highlight">R$ <?= number_format($agendamento['total_agendamento'], 2, ',', '.') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-clock-history"></i>
                        Criado em
                    </span>
                    <span class="info-value"><?= date('d/m/Y às H:i', strtotime($agendamento['criado_em'])) ?></span>
                </div>
                <?php if (!empty($agendamento['atualizado_em'])): ?>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-arrow-repeat"></i>
                            Última atualização
                        </span>
                        <span class="info-value"><?= date('d/m/Y às H:i', strtotime($agendamento['atualizado_em'])) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Botão Voltar -->
    <div class="back-section">
        <a href="/backend/agendamento/listar" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Voltar para listagem
        </a>
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
        max-width: 1000px;
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

    .btn-action {
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: 1px solid;
        transition: all 0.2s;
    }

    .btn-edit {
        background: white;
        color: var(--cor-acento);
        border-color: var(--cor-acento);
    }

    .btn-edit:hover {
        background: var(--cor-acento);
        color: white;
    }

    .btn-delete {
        background: white;
        color: var(--cor-danger);
        border-color: var(--cor-danger);
    }

    .btn-delete:hover {
        background: var(--cor-danger);
        color: white;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .status-card-large {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .status-card-large.full-width {
        grid-column: 1 / -1;
    }

    .status-badge-view {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        border-radius: 10px;
        font-size: 1rem;
    }

    .status-badge-view i {
        font-size: 2.5rem;
    }

    .status-badge-view > div {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .status-text {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .status-desc {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .status-realizada {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
    }

    .status-agendada {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .status-pendente {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .status-cancelada {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .card-title {
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

    .card-title i {
        color: var(--cor-acento);
    }

    .info-content {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .client-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .client-avatar-view {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--cor-primaria), var(--cor-acento));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .client-info-view {
        flex: 1;
    }

    .client-name-view {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.5rem 0;
    }

    .client-email-view,
    .client-phone-view {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .client-email-view i,
    .client-phone-view i {
        color: var(--cor-acento);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: #94a3b8;
    }

    .info-value {
        font-size: 0.9375rem;
        color: #1e293b;
        font-weight: 600;
    }

    .value-highlight {
        color: var(--cor-success);
        font-size: 1.125rem;
    }

    .back-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f1f5f9;
    }

    .btn-back {
        padding: 0.875rem 1.75rem;
        border-radius: 10px;
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .client-profile {
            flex-direction: column;
            text-align: center;
            gap: 1.25rem;
        }

        .info-row {
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .status-badge-view {
            padding: 1.25rem;
        }

        .status-text {
            font-size: 1.15rem;
        }
    }
</style>