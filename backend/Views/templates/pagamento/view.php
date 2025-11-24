<div class="page-wrapper">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/backend/dashboard"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/backend/pagamento/listar">Pagamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pagamento #<?= $pagamento['id_pagamento'] ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title-group">
                <h1 class="page-title">
                    <i class="bi bi-receipt me-2"></i>
                    Detalhes do Pagamento
                </h1>
                <p class="page-subtitle">Visualização completa do pagamento #<?= $pagamento['id_pagamento'] ?></p>
            </div>
            <div class="header-actions">
                <a href="/backend/pagamento/editar/<?= $pagamento['id_pagamento'] ?>" class="btn-action btn-edit">
                    <i class="bi bi-pencil"></i>
                    Editar
                </a>
                <a href="/backend/pagamento/excluir/<?= $pagamento['id_pagamento'] ?>" class="btn-action btn-delete">
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
                $status = strtolower(trim($pagamento['status_pagamento']));
                $statusConfig = match ($status) {
                    'pago' => ['class' => 'status-pago', 'icon' => 'check-circle-fill', 'text' => 'Pago', 'desc' => 'Pagamento quitado integralmente'],
                    'aberto' => ['class' => 'status-aberto', 'icon' => 'exclamation-circle-fill', 'text' => 'Em Aberto', 'desc' => 'Aguardando pagamento'],
                    default => ['class' => 'status-default', 'icon' => 'circle-fill', 'text' => ucfirst($status), 'desc' => '']
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
                        <?= strtoupper(substr($pagamento['cliente_nome'] ?? 'C', 0, 1)) ?>
                    </div>
                    <div class="client-info-view">
                        <h4 class="client-name-view"><?= htmlspecialchars($pagamento['cliente_nome'] ?? 'Cliente') ?></h4>
                        <p class="client-email-view">
                            <i class="bi bi-envelope"></i>
                            <?= htmlspecialchars($pagamento['cliente_email'] ?? 'email@exemplo.com') ?>
                        </p>
                        <?php if (!empty($pagamento['cliente_telefone'])): ?>
                            <p class="client-phone-view">
                                <i class="bi bi-telephone"></i>
                                <?= htmlspecialchars($pagamento['cliente_telefone']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumo Financeiro -->
        <div class="info-card">
            <h3 class="card-title">
                <i class="bi bi-cash-stack"></i>
                Resumo Financeiro
            </h3>
            <div class="info-content">
                <div class="financial-summary">
                    <div class="financial-item">
                        <span class="financial-label">
                            <i class="bi bi-wallet2"></i>
                            Total Devedor
                        </span>
                        <span class="financial-value devedor">
                            R$ <?= number_format($pagamento['total_devedor'], 2, ',', '.') ?>
                        </span>
                    </div>
                    <div class="financial-item">
                        <span class="financial-label">
                            <i class="bi bi-cash-coin"></i>
                            Total Pago
                        </span>
                        <span class="financial-value pago">
                            R$ <?= number_format($pagamento['total_pago'], 2, ',', '.') ?>
                        </span>
                    </div>
                    <?php 
                    $saldo = $pagamento['total_devedor'] - $pagamento['total_pago'];
                    if ($saldo > 0):
                    ?>
                    <div class="financial-item highlight">
                        <span class="financial-label">
                            <i class="bi bi-exclamation-circle"></i>
                            Saldo Restante
                        </span>
                        <span class="financial-value restante">
                            R$ <?= number_format($saldo, 2, ',', '.') ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Formas de Pagamento -->
        <div class="info-card full-width">
            <h3 class="card-title">
                <i class="bi bi-credit-card"></i>
                Formas de Pagamento Utilizadas
            </h3>
            <div class="info-content">
                <div class="payment-methods-grid">
                    <?php if ($pagamento['dinheiro'] > 0): ?>
                        <div class="payment-method-card dinheiro">
                            <div class="payment-icon">
                                <i class="bi bi-cash"></i>
                            </div>
                            <div class="payment-info">
                                <span class="payment-label">Dinheiro</span>
                                <span class="payment-value">R$ <?= number_format($pagamento['dinheiro'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($pagamento['debito'] > 0): ?>
                        <div class="payment-method-card debito">
                            <div class="payment-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="payment-info">
                                <span class="payment-label">Cartão de Débito</span>
                                <span class="payment-value">R$ <?= number_format($pagamento['debito'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($pagamento['credito'] > 0): ?>
                        <div class="payment-method-card credito">
                            <div class="payment-icon">
                                <i class="bi bi-credit-card-2-front"></i>
                            </div>
                            <div class="payment-info">
                                <span class="payment-label">Cartão de Crédito</span>
                                <span class="payment-value">R$ <?= number_format($pagamento['credito'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($pagamento['pix'] > 0): ?>
                        <div class="payment-method-card pix">
                            <div class="payment-icon">
                                <i class="bi bi-qr-code"></i>
                            </div>
                            <div class="payment-info">
                                <span class="payment-label">PIX</span>
                                <span class="payment-value">R$ <?= number_format($pagamento['pix'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($pagamento['dinheiro']) && empty($pagamento['debito']) && empty($pagamento['credito']) && empty($pagamento['pix'])): ?>
                        <div class="payment-empty">
                            <i class="bi bi-dash-circle"></i>
                            <p>Nenhuma forma de pagamento registrada</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Informações Adicionais -->
        <div class="info-card full-width">
            <h3 class="card-title">
                <i class="bi bi-info-circle"></i>
                Informações Adicionais
            </h3>
            <div class="info-content">
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-hash"></i>
                        ID do Pagamento
                    </span>
                    <span class="info-value">#<?= htmlspecialchars($pagamento['id_pagamento']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-calendar3"></i>
                        Data do Pagamento
                    </span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($pagamento['data_pagamento'])) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-clock-history"></i>
                        Criado em
                    </span>
                    <span class="info-value"><?= date('d/m/Y às H:i', strtotime($pagamento['criado_em'])) ?></span>
                </div>
                <?php if (!empty($pagamento['atualizado_em'])): ?>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-arrow-repeat"></i>
                            Última atualização
                        </span>
                        <span class="info-value"><?= date('d/m/Y às H:i', strtotime($pagamento['atualizado_em'])) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Botão Voltar -->
    <div class="back-section">
        <a href="/backend/pagamento/listar" class="btn-back">
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

    .status-card-large.full-width,
    .info-card.full-width {
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

    .status-pago {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
    }

    .status-aberto {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
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

    .financial-summary {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .financial-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
    }

    .financial-item.highlight {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 2px solid var(--cor-warning);
    }

    .financial-label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .financial-label i {
        color: #94a3b8;
    }

    .financial-value {
        font-size: 1.25rem;
        font-weight: 700;
    }

    .financial-value.devedor {
        color: var(--cor-danger);
    }

    .financial-value.pago {
        color: var(--cor-success);
    }

    .financial-value.restante {
        color: var(--cor-warning);
    }

    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .payment-method-card {
        padding: 1.25rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 2px solid;
    }

    .payment-method-card.dinheiro {
        background: #dcfce7;
        border-color: var(--cor-success);
        color: #166534;
    }

    .payment-method-card.debito {
        background: #dbeafe;
        border-color: var(--cor-info);
        color: #1e40af;
    }

    .payment-method-card.credito {
        background: #fef3c7;
        border-color: var(--cor-warning);
        color: #92400e;
    }

    .payment-method-card.pix {
        background: #e0e7ff;
        border-color: #6366f1;
        color: #3730a3;
    }

    .payment-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: white;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .payment-info {
        display: flex;
        flex-direction: column;
    }

    .payment-label {
        font-size: 0.8125rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .payment-value {
        font-size: 1.125rem;
        font-weight: 700;
        margin-top: 0.25rem;
    }

    .payment-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
    }

    .payment-empty i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
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
        .content-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            width: 100%;
        }

        .btn-action {
            flex: 1;
            justify-content: center;
        }

        .client-profile {
            flex-direction: column;
            text-align: center;
        }

        .payment-methods-grid {
            grid-template-columns: 1fr;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>