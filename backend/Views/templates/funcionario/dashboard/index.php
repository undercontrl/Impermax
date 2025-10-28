<style>
    :root {
        --cor-primaria: #5f7396;
        --cor-secundaria: #1487df;
        --cor-clara: #ffffff;
        --cor-texto: #333;
        --cor-cinza: #a7a7a7;
        --cor-fundo: #f5f7fa;
        --cor-sucesso: #28a745;
        --cor-alerta: #f39c12;
    }

    body {
        background-color: var(--cor-fundo);
        color: var(--cor-texto);
        font-family: "Inter", sans-serif;
    }

    .dashboard-func {
        background-color: var(--cor-fundo);
        padding: 2rem;
        min-height: 100vh;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .dashboard-header h2 {
        color: var(--cor-primaria);
        font-weight: 700;
    }

    .dashboard-header p {
        color: var(--cor-cinza);
        font-size: 1rem;
    }

    /* 🔹 Cards */
    .dashboard-cards {
        display: flex;
        justify-content: center;
        align-items: stretch;
        gap: 1.8rem;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .dashboard-card-link {
        text-decoration: none;
        color: inherit;
        flex: 1 1 250px;
        max-width: 260px;
    }

    .dashboard-card {
        background: var(--cor-clara);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 1.8rem 1.2rem;
        text-align: center;
        transition: all 0.25s ease;
        height: 170px;
    }

    .dashboard-card i {
        font-size: 2.2rem;
        margin-bottom: 0.8rem;
    }

    .dashboard-card h4 {
        color: var(--cor-primaria);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.05rem;
    }

    .dashboard-card p {
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--cor-secundaria);
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(20, 135, 223, 0.2);
    }

    /* 🔹 Tabela */
    .table-dash {
        background: var(--cor-clara);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        margin-top: 2.5rem;
    }

    .table thead {
        background-color: var(--cor-primaria);
        color: #fff;
    }

    .status-badge {
        display: inline-block;
        padding: .3rem .75rem;
        border-radius: 12px;
        font-size: .85rem;
        font-weight: 500;
        color: #fff;
    }

    .status-agendada { background-color: var(--cor-secundaria); }
    .status-pendente { background-color: var(--cor-alerta); }
    .status-em-andamento, .status-confirmado { background-color: var(--cor-sucesso); }

    /* 🔹 Gráficos */
    .grafico-card {
        background: var(--cor-clara);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        height: 100%;
    }

    .grafico-card h5 {
        color: var(--cor-secundaria);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    canvas {
        width: 100% !important;
        height: auto !important;
        max-height: 280px;
    }

    @media (max-width: 992px) {
        .dashboard-cards {
            flex-direction: column;
            align-items: center;
        }

        .dashboard-card {
            width: 90%;
        }
    }
</style>

<div class="dashboard-func">
    <div class="dashboard-header text-center">
        <h2>Bem-vindo, <?= htmlspecialchars($nomeUsuario); ?></h2>
        <p class="text-muted">Acompanhe seus agendamentos, orçamentos e pendências abaixo</p>
    </div>

    <!-- 🔹 Cards -->
    <div class="dashboard-cards">
        <a href="/backend/agendamento/listar" class="dashboard-card-link">
            <div class="dashboard-card">
                <i class="bi bi-calendar-check text-primary"></i>
                <h4>Agendamentos de Hoje</h4>
                <p><?= $totalHoje ?? 0 ?></p>
            </div>
        </a>

        <a href="/backend/orcamento/listar" class="dashboard-card-link">
            <div class="dashboard-card">
                <i class="bi bi-file-earmark-text text-success"></i>
                <h4>Orçamentos em Andamento</h4>
                <p><?= $orcamentosAndamento ?? 0 ?></p>
            </div>
        </a>

        <a href="/backend/agendamento/listar" class="dashboard-card-link">
            <div class="dashboard-card">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                <h4>Pendências</h4>
                <p><?= $pendencias ?? 0 ?></p>
            </div>
        </a>

        <a href="/backend/orcamento/listar" class="dashboard-card-link">
            <div class="dashboard-card">
                <i class="bi bi-clipboard-data text-info"></i>
                <h4>Serviços Concluídos</h4>
                <p><?= $servicosConcluidos ?? 0 ?></p>
            </div>
        </a>
    </div>

    <!-- 🔹 Próximos Agendamentos -->
    <div class="table-dash mt-5">
        <h4 class="mb-3 text-primary ps-3 pt-3">Próximos Agendamentos</h4>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($proximosAgendamentos)): ?>
                    <?php foreach ($proximosAgendamentos as $ag): ?>
                        <tr>
                            <td><?= htmlspecialchars($ag['nome_cliente']) ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($ag['data_solicitada']))) ?></td>
                            <td>
                                <?php
                                $status = strtolower($ag['status_agendamento']);
                                $class = match($status) {
                                    'agendada' => 'status-agendada',
                                    'pendente' => 'status-pendente',
                                    'em andamento', 'confirmado' => 'status-em-andamento',
                                    default => ''
                                };
                                ?>
                                <span class="status-badge <?= $class ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center text-muted">Nenhum agendamento futuro encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- 🔹 Gráficos -->
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="grafico-card">
                <h5><i class="bi bi-bar-chart"></i> Serviços Concluídos por Mês</h5>
                <canvas id="graficoServicos"></canvas>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="grafico-card">
                <h5><i class="bi bi-pie-chart"></i> Distribuição de Status</h5>
                <canvas id="graficoStatus"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const corPrimaria = '#5f7396';
    const corSecundaria = '#1487df';
    const corSucesso = '#28a745';
    const corAlerta = '#f39c12';
    const corCinza = '#a7a7a7';

    // Gráfico de barras (dados reais)
    const ctx1 = document.getElementById('graficoServicos').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            datasets: [{
                label: 'Serviços Concluídos',
                data: <?= $graficoServicos ?? '[]' ?>,
                backgroundColor: corSecundaria,
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: corPrimaria } },
                y: { grid: { color: '#eee' }, ticks: { color: corPrimaria } }
            }
        }
    });

    // Gráfico de pizza (dados reais)
    const dadosStatus = <?= $graficoStatus ?? '{}' ?>;
    const ctx2 = document.getElementById('graficoStatus').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: Object.keys(dadosStatus),
            datasets: [{
                data: Object.values(dadosStatus),
                backgroundColor: [corSecundaria, corSucesso, corAlerta, corPrimaria],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { color: corPrimaria } }
            }
        }
    });
});
</script>
