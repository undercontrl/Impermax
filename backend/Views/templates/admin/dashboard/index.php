<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Bem-vindo, <?= htmlspecialchars($nomeUsuario); ?></h2> 
        <span class="text-muted" style="font-size: 0.95rem;">
            <?= date('d/m/Y H:i') ?>
        </span>
    </div>

    <!-- 🔹 Cards de resumo -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm p-3 dashboard-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary-subtle text-primary me-3">
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
                    <div class="icon-circle bg-success-subtle text-success me-3">
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
                    <div class="icon-circle bg-info-subtle text-info me-3">
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
                    <div class="icon-circle bg-warning-subtle text-warning me-3">
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

    <!-- 🔹 Gráficos -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm p-4 grafico-card">
                <h5 class="text-primary fw-semibold mb-3">
                    <i class="bi bi-bar-chart"></i> Agendamentos por Mês
                </h5>
                <canvas id="graficoAgendamentos"></canvas>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm p-4 grafico-card">
                <h5 class="text-primary fw-semibold mb-3">
                    <i class="bi bi-pie-chart"></i> Distribuição de Status
                </h5>
                <div class="chart-wrapper">
                    <canvas id="graficoStatusAdmin"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Tabela de usuários -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Usuários Registrados</h5>
            <a href="/backend/usuarios" class="btn btn-light btn-sm">
                <i class="bi bi-eye"></i> Ver todos
            </a>
        </div>

        <div class="card-body">
            <?php if (!empty($usuarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
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

<!-- 🔹 Estilo -->
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
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .grafico-card {
        border-radius: 15px;
        background: #fff;
        min-height: 350px;
        max-height: 380px;
    }

    /* gráfico de pizza centralizado */
    .chart-wrapper {
        position: relative;
        width: 100%;
        max-width: 320px;
        height: 320px;
        margin: 0 auto;
    }

    canvas {
        display: block;
        margin: 0 auto;
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
    }

    @media (max-width: 992px) {
        .chart-wrapper {
            max-width: 280px;
            height: 280px;
        }
    }
</style>

<!-- 🔹 Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const corPrimaria = '#5f7396';
    const corRealizada = '#00700b';
    const corSecundaria = '#1487df';
    const corSucesso = '#ff0000';
    const corAlerta = '#f39c12';

    // Gráfico de barras - Agendamentos por mês
    const ctx1 = document.getElementById('graficoAgendamentos').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            datasets: [{
                label: 'Agendamentos',
                data: <?= $graficoAgendamentos ?? '[]' ?>,
                backgroundColor: corSecundaria,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: corPrimaria } },
                y: { grid: { color: '#eee' }, ticks: { color: corPrimaria } }
            }
        }
    });

    // Gráfico de pizza - Distribuição de status
    const dadosStatus = <?= $graficoStatusAdmin ?? '{}' ?>;
    const ctx2 = document.getElementById('graficoStatusAdmin').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: Object.keys(dadosStatus),
            datasets: [{
                data: Object.values(dadosStatus),
                backgroundColor: [corSecundaria, corSucesso, corAlerta, corRealizada],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            aspectRatio: 1,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: corPrimaria, boxWidth: 15 }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
});
</script>
