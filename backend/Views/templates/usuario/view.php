<style>
    .view-container {
        padding: 2rem 0;
    }

    .view-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2.5rem;
        border-radius: 16px 16px 0 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }

    .view-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .status-badge-large {
        padding: 0.5rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-ativo { background-color: #22c55e; color: white; }
    .status-inativo { background-color: #ef4444; color: white; }
    .status-pendente { background-color: #f59e0b; color: white; }

    .tipo-badge-large {
        padding: 0.5rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 50px;
        text-transform: capitalize;
        display: inline-block;
        margin-left: 1rem;
    }

    .tipo-admin { background-color: #8b5cf6; color: white; }
    .tipo-cliente { background-color: #3b82f6; color: white; }
    .tipo-funcionario { background-color: #10b981; color: white; }

    .view-content {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .info-section {
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-section:last-child {
        border-bottom: none;
    }

    .info-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-section-title i {
        color: #5f7396;
        font-size: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.125rem;
        color: #1f2937;
        font-weight: 500;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 3px solid #5f7396;
    }

    .avatar-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 2rem;
        background: linear-gradient(to right, #f9fafb, #ffffff);
        border-bottom: 1px solid #e5e7eb;
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        flex-shrink: 0;
    }

    .avatar-info h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.5rem 0;
    }

    .avatar-info p {
        color: #6b7280;
        font-size: 1rem;
        margin: 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .avatar-info p i {
        color: #5f7396;
    }

    .action-buttons {
        padding: 2rem;
        background: #f9fafb;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: #5f7396;
        color: white;
    }

    .btn-primary:hover {
        background: #4a5a75;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(95, 115, 150, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #5f7396;
        color: #5f7396;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-success {
        background: #22c55e;
        color: white;
    }

    .btn-success:hover {
        background: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
        background: #f9fafb;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #5f7396;
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0.5rem 0;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .timeline {
        padding: 2rem;
    }

    .timeline-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-left: 3px solid #e5e7eb;
        position: relative;
        margin-left: 1rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 1.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #5f7396;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #5f7396;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 600;
    }

    .timeline-text {
        color: #1f2937;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .view-header {
            padding: 1.5rem;
        }

        .view-header h1 {
            font-size: 1.5rem;
        }

        .avatar-section {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            padding: 1rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .status-badge-large,
        .tipo-badge-large {
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }
    }

    @media print {
        .action-buttons,
        .btn {
            display: none !important;
        }
    }
</style>

<div class="container view-container">
    <!-- Header com Status -->
    <div class="view-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h1>
                    <i class="bi bi-person-circle"></i>
                    Detalhes do Usuário
                </h1>
                <div>
                    <span class="status-badge-large status-<?= strtolower($usuario['status_usuario']) ?>">
                        <?= htmlspecialchars($usuario['status_usuario']) ?>
                    </span>
                    <span class="tipo-badge-large tipo-<?= strtolower($usuario['tipo_usuario']) ?>">
                        <?= htmlspecialchars($usuario['tipo_usuario']) ?>
                    </span>
                </div>
            </div>
            <div class="text-end">
                <small class="text-white-50 d-block">ID: #<?= htmlspecialchars($usuario['id_usuario']) ?></small>
            </div>
        </div>
    </div>

    <div class="view-content">
        <!-- Avatar e Informações Principais -->
        <div class="avatar-section">
            <div class="avatar-circle">
                <?= strtoupper(substr($usuario['nome_usuario'], 0, 1)) ?>
            </div>
            <div class="avatar-info">
                <h2><?= htmlspecialchars($usuario['nome_usuario']) ?></h2>
                <p>
                    <i class="bi bi-envelope-fill"></i>
                    <?= htmlspecialchars($usuario['email_usuario']) ?>
                </p>
                <p>
                    <i class="bi bi-shield-fill-check"></i>
                    Tipo de Acesso: <strong><?= htmlspecialchars($usuario['tipo_usuario']) ?></strong>
                </p>
            </div>
        </div>

        <!-- Estatísticas (se houver) -->
        <?php if (isset($stats)): ?>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value"><?= $stats['total_agendamentos'] ?? 0 ?></div>
                <div class="stat-label">Agendamentos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-value">R$ <?= number_format($stats['total_gasto'] ?? 0, 2, ',', '.') ?></div>
                <div class="stat-label">Total Gasto</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-value"><?= number_format($stats['media_avaliacoes'] ?? 0, 1) ?></div>
                <div class="stat-label">Avaliação Média</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-value"><?= $stats['total_orcamentos'] ?? 0 ?></div>
                <div class="stat-label">Orçamentos</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Informações Detalhadas -->
        <div class="info-section">
            <h3 class="info-section-title">
                <i class="bi bi-info-circle-fill"></i>
                Informações da Conta
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">ID do Usuário</span>
                    <span class="info-value">#<?= htmlspecialchars($usuario['id_usuario']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nome Completo</span>
                    <span class="info-value"><?= htmlspecialchars($usuario['nome_usuario']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">E-mail</span>
                    <span class="info-value"><?= htmlspecialchars($usuario['email_usuario']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tipo de Usuário</span>
                    <span class="info-value">
                        <span class="tipo-badge-large tipo-<?= strtolower($usuario['tipo_usuario']) ?>">
                            <?= htmlspecialchars($usuario['tipo_usuario']) ?>
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status da Conta</span>
                    <span class="info-value">
                        <span class="status-badge-large status-<?= strtolower($usuario['status_usuario']) ?>">
                            <?= htmlspecialchars($usuario['status_usuario']) ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Timeline de Eventos -->
        <div class="info-section">
            <h3 class="info-section-title">
                <i class="bi bi-clock-history"></i>
                Histórico da Conta
            </h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?>
                        </div>
                        <div class="timeline-text">
                            <strong>Conta Criada</strong> - Usuário registrado no sistema
                        </div>
                    </div>
                </div>
                <?php if ($usuario['atualizado_em'] && $usuario['atualizado_em'] !== $usuario['criado_em']): ?>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('d/m/Y H:i', strtotime($usuario['atualizado_em'])) ?>
                        </div>
                        <div class="timeline-text">
                            <strong>Última Atualização</strong> - Dados do perfil foram modificados
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (isset($usuario['ultimo_acesso'])): ?>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('d/m/Y H:i', strtotime($usuario['ultimo_acesso'])) ?>
                        </div>
                        <div class="timeline-text">
                            <strong>Último Acesso</strong> - Login mais recente no sistema
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="action-buttons">
            <a href="/backend/usuario/editar/<?= $usuario['id_usuario'] ?>" class="btn btn-primary">
                <i class="bi bi-pencil-fill"></i>
                Editar Usuário
            </a>
            
            <?php if ($usuario['status_usuario'] === 'Ativo'): ?>
            <form action="/backend/usuario/alterar-status/<?= $usuario['id_usuario'] ?>" method="POST" style="display: inline;">
                <input type="hidden" name="novo_status" value="Inativo">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Deseja realmente desativar este usuário?');">
                    <i class="bi bi-x-circle-fill"></i>
                    Desativar Usuário
                </button>
            </form>
            <?php else: ?>
            <form action="/backend/usuario/alterar-status/<?= $usuario['id_usuario'] ?>" method="POST" style="display: inline;">
                <input type="hidden" name="novo_status" value="Ativo">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle-fill"></i>
                    Ativar Usuário
                </button>
            </form>
            <?php endif; ?>

            <button onclick="window.print()" class="btn btn-secondary">
                <i class="bi bi-printer-fill"></i>
                Imprimir
            </button>

            <a href="/backend/usuario/listar" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Voltar para Lista
            </a>

            <a href="/backend/usuario/excluir/<?= $usuario['id_usuario'] ?>" 
               class="btn btn-danger ms-auto"
               onclick="return confirm('⚠️ ATENÇÃO!\n\nTem certeza que deseja EXCLUIR este usuário?\n\nEsta ação NÃO pode ser desfeita!');">
                <i class="bi bi-trash-fill"></i>
                Excluir Usuário
            </a>
        </div>
    </div>
</div>

<script>
function confirmarExclusao() {
    return confirm('⚠️ ATENÇÃO!\n\nTem certeza que deseja EXCLUIR este usuário?\n\nEsta ação NÃO pode ser desfeita!');
}
</script>