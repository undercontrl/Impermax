<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Bem-vindo, <?= htmlspecialchars($nomeUsuario); ?>👋</h2> 
        <span class="text-muted" style="font-size: 0.95rem;">
            <?= date('d/m/Y H:i') ?>
        </span>
    </div>

    <!-- Resumo geral -->
    <div class="row g-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary text-white me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Usuários</h6>
                        <h4 class="fw-bold"><?= count($usuarios) ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success text-white me-3">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Agendamentos</h6>
                        <h4 class="fw-bold"><?= htmlspecialchars($totalAgendamentos ?? 0) ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-info text-white me-3">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Orçamentos</h6>
                        <h4 class="fw-bold"><?= htmlspecialchars($totalOrcamentos ?? 0) ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning text-white me-3">
                        <i class="bi bi-chat-left-dots"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Contatos</h6>
                        <h4 class="fw-bold"><?= htmlspecialchars($totalContatos ?? 0) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de usuários -->
    <div class="card border-0 shadow-sm mt-5">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Usuários Registrados</h5>
            <a href="/backend/usuarios" class="btn btn-light btn-sm">
                <i class="bi bi-eye"></i> Ver todos
            </a>
        </div>

        <div class="card-body">
            <?php if (!empty($usuarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nome_usuario']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email_usuario']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary px-2 py-1">
                                            <?= htmlspecialchars(ucfirst($usuario['tipo_usuario'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            $status = strtolower($usuario['status_usuario']);
                                            $classe = match($status) {
                                                'ativo' => 'success',
                                                'pendente' => 'warning',
                                                'inativo' => 'secondary',
                                                default => 'dark'
                                            };
                                        ?>
                                        <span class="badge bg-<?= $classe ?> px-2 py-1">
                                            <?= htmlspecialchars(ucfirst($status)) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted text-center mb-0">Nenhum usuário encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .dashboard-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background-color: #fff;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
</style>

