<!-- Dashboard Premium - Versão Corrigida -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

<div class="dashboard-wrapper-premium">
    <!-- Header Premium -->
    <div class="dashboard-header-premium">
        <div class="header-content-premium">
            <div class="greeting-section-premium">
                <h1 class="dashboard-title-premium">
                    <span class="wave-premium">👋</span> 
                    Bem-vindo, <span class="highlight-premium"><?= htmlspecialchars($nomeUsuario ?? 'Administrador'); ?></span>!
                </h1>
                <!-- <p class="dashboard-subtitle-premium">
                    <i class="bi bi-calendar3"></i>
                    <?php
                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf8', 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                        echo ucfirst(strftime('%A, %d de %B de %Y'));
                    ?>
                </p> -->
            </div>
            <div class="header-actions-premium">
                <form method="GET" class="periodo-selector-premium">
                    <select name="periodo" class="form-select-premium" onchange="this.form.submit()">
                        <option value="mes" <?= ($periodo ?? 'mes') === 'mes' ? 'selected' : '' ?>>Último Mês</option>
                        <option value="3meses" <?= ($periodo ?? '') === '3meses' ? 'selected' : '' ?>>Últimos 3 Meses</option>
                        <option value="ano" <?= ($periodo ?? '') === 'ano' ? 'selected' : '' ?>>Último Ano</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Cards de Métricas Premium -->
    <div class="metrics-grid-premium">
        <!-- Card Usuários -->
        <a href="/backend/usuario/listar" class="metric-card-link-premium">
            <div class="metric-card-premium card-primary">
                <div class="metric-blob-premium"></div>
                <div class="metric-header-premium">
                    <div class="metric-info-premium">
                        <span class="metric-label-premium">Total de Usuários</span>
                        <h2 class="metric-value-premium"><?= htmlspecialchars($totalUsuarios ?? 0); ?></h2>
                    </div>
                    <div class="metric-icon-premium icon-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="metric-footer-premium">
                    <?php
                        $userTrend = $estatisticas['usuarios']['tendencia'] ?? 'neutral';
                        $userPercent = $estatisticas['usuarios']['percentual'] ?? 0;
                        $userDiff = $estatisticas['usuarios']['diferenca'] ?? 0;
                        $trendIcon = $userTrend === 'up' ? 'arrow-up' : ($userTrend === 'down' ? 'arrow-down' : 'dash');
                        $trendSign = $userTrend === 'up' ? '+' : ($userTrend === 'down' ? '-' : '');
                    ?>
                    <div class="metric-trend-premium trend-<?= $userTrend ?>">
                        <i class="bi bi-<?= $trendIcon ?>"></i>
                        <span><?= $userPercent ?>%</span>
                    </div>
                    <span class="metric-comparison-premium">
                        <?= $trendSign ?><?= $userDiff ?> este período
                    </span>
                </div>
            </div>
        </a>

        <!-- Card Agendamentos -->
        <a href="/backend/agendamento/listar" class="metric-card-link-premium">
            <div class="metric-card-premium card-success">
                <div class="metric-blob-premium"></div>
                <div class="metric-header-premium">
                    <div class="metric-info-premium">
                        <span class="metric-label-premium">Agendamentos</span>
                        <h2 class="metric-value-premium"><?= htmlspecialchars($totalAgendamentos ?? 0); ?></h2>
                    </div>
                    <div class="metric-icon-premium icon-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
                <div class="metric-footer-premium">
                    <?php
                        $agendTrend = $estatisticas['agendamentos']['tendencia'] ?? 'neutral';
                        $agendPercent = $estatisticas['agendamentos']['percentual'] ?? 0;
                        $agendDiff = $estatisticas['agendamentos']['diferenca'] ?? 0;
                        $trendIcon = $agendTrend === 'up' ? 'arrow-up' : ($agendTrend === 'down' ? 'arrow-down' : 'dash');
                        $trendSign = $agendTrend === 'up' ? '+' : ($agendTrend === 'down' ? '-' : '');
                    ?>
                    <div class="metric-trend-premium trend-<?= $agendTrend ?>">
                        <i class="bi bi-<?= $trendIcon ?>"></i>
                        <span><?= $agendPercent ?>%</span>
                    </div>
                    <span class="metric-comparison-premium">
                        <?= $trendSign ?><?= $agendDiff ?> este período
                    </span>
                </div>
            </div>
        </a>

        <!-- Card Orçamentos -->
        <a href="/backend/orcamento/listar" class="metric-card-link-premium">
            <div class="metric-card-premium card-info">
                <div class="metric-blob-premium"></div>
                <div class="metric-header-premium">
                    <div class="metric-info-premium">
                        <span class="metric-label-premium">Orçamentos Ativos</span>
                        <h2 class="metric-value-premium"><?= htmlspecialchars($totalOrcamentos ?? 0); ?></h2>
                    </div>
                    <div class="metric-icon-premium icon-info">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                <div class="metric-footer-premium">
                    <?php
                        $orcTrend = $estatisticas['orcamentos']['tendencia'] ?? 'neutral';
                        $orcPercent = $estatisticas['orcamentos']['percentual'] ?? 0;
                        $orcDiff = $estatisticas['orcamentos']['diferenca'] ?? 0;
                        $trendIcon = $orcTrend === 'up' ? 'arrow-up' : ($orcTrend === 'down' ? 'arrow-down' : 'dash');
                        $trendSign = $orcTrend === 'up' ? '+' : ($orcTrend === 'down' ? '-' : '');
                    ?>
                    <div class="metric-trend-premium trend-<?= $orcTrend ?>">
                        <i class="bi bi-<?= $trendIcon ?>"></i>
                        <span><?= $orcPercent ?>%</span>
                    </div>
                    <span class="metric-comparison-premium">
                        <?= $trendSign ?><?= $orcDiff ?> este período
                    </span>
                </div>
            </div>
        </a>

        <!-- Card Contatos -->
        <a href="/backend/contato/listar" class="metric-card-link-premium">
            <div class="metric-card-premium card-warning">
                <div class="metric-blob-premium"></div>
                <div class="metric-header-premium">
                    <div class="metric-info-premium">
                        <span class="metric-label-premium">Novos Contatos</span>
                        <h2 class="metric-value-premium"><?= htmlspecialchars($totalContatos ?? 0); ?></h2>
                    </div>
                    <div class="metric-icon-premium icon-warning">
                        <i class="bi bi-chat-left-dots"></i>
                    </div>
                </div>
                <div class="metric-footer-premium">
                    <?php
                        $contTrend = $estatisticas['contatos']['tendencia'] ?? 'neutral';
                        $contPercent = $estatisticas['contatos']['percentual'] ?? 0;
                        $contDiff = $estatisticas['contatos']['diferenca'] ?? 0;
                        $trendIcon = $contTrend === 'up' ? 'arrow-up' : ($contTrend === 'down' ? 'arrow-down' : 'dash');
                        $trendSign = $contTrend === 'up' ? '+' : ($contTrend === 'down' ? '-' : '');
                    ?>
                    <div class="metric-trend-premium trend-<?= $contTrend ?>">
                        <i class="bi bi-<?= $trendIcon ?>"></i>
                        <span><?= $contPercent ?>%</span>
                    </div>
                    <span class="metric-comparison-premium">
                        <?= $trendSign ?><?= $contDiff ?> este período
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Seção de Gráficos -->
    <div class="charts-grid-premium">
        <!-- Gráfico de Tendência -->
        <div class="chart-card-premium">
            <div class="chart-header-premium">
                <div>
                    <h3 class="chart-title-premium">Tendência de Atividades</h3>
                    <p class="chart-subtitle-premium">Últimos 6 meses</p>
                </div>
                <div class="chart-legend-premium">
                    <span class="legend-item-premium">
                        <span class="legend-color-premium" style="background: #5f7396"></span>
                        Agendamentos
                    </span>
                    <span class="legend-item-premium">
                        <span class="legend-color-premium" style="background: #22c55e"></span>
                        Orçamentos
                    </span>
                    <span class="legend-item-premium">
                        <span class="legend-color-premium" style="background: #f59e0b"></span>
                        Contatos
                    </span>
                </div>
            </div>
            <div class="chart-body-premium">
                <canvas id="trendChartPremium"></canvas>
            </div>
        </div>

        <!-- Gráfico de Status -->
        <div class="chart-card-premium">
            <div class="chart-header-premium">
                <div>
                    <h3 class="chart-title-premium">Distribuição por Status</h3>
                    <p class="chart-subtitle-premium">Agendamentos do período</p>
                </div>
            </div>
            <div class="chart-body-premium">
                <canvas id="statusChartPremium"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabela de Usuários -->
    <div class="content-card-premium">
        <div class="card-header-premium">
            <div>
                <h3 class="card-title-premium">
                    <i class="bi bi-people-fill"></i>
                    Usuários Registrados
                </h3>
                <p class="card-subtitle-premium">Gerencie todos os usuários do sistema</p>
            </div>
            <a href="/backend/usuario/listar" class="btn-outline-premium">
                <i class="bi bi-eye"></i>
                <span>Ver Todos</span>
            </a>
        </div>
        <div class="card-body-premium">
            <?php if (!empty($usuarios) && is_array($usuarios)): ?>
            <div class="table-responsive-premium">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(array_slice($usuarios, 0, 5) as $usuario): ?>
                        <tr>
                            <td><span class="text-muted-premium">#<?= str_pad($usuario['id_usuario'], 3, '0', STR_PAD_LEFT) ?></span></td>
                            <td>
                                <div class="user-cell-premium">
                                    <div class="user-avatar-premium">
                                        <?= strtoupper(substr($usuario['nome_usuario'], 0, 1)) ?>
                                    </div>
                                    <div class="user-info-premium">
                                        <span class="user-name-premium"><?= htmlspecialchars($usuario['nome_usuario']) ?></span>
                                        <span class="user-meta-premium">Cadastrado</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-muted-premium"><?= htmlspecialchars($usuario['email_usuario']) ?></span></td>
                            <td><span class="badge-premium badge-secondary-premium"><?= htmlspecialchars(ucfirst($usuario['tipo_usuario'])) ?></span></td>
                            <td>
                                <?php
                                    $status = strtolower($usuario['status_usuario']);
                                    if ($status === 'ativo') {
                                        $badgeClass = 'badge-success-premium';
                                        $statusIcon = 'check-circle-fill';
                                    } elseif ($status === 'pendente') {
                                        $badgeClass = 'badge-warning-premium';
                                        $statusIcon = 'clock-fill';
                                    } else {
                                        $badgeClass = 'badge-secondary-premium';
                                        $statusIcon = 'x-circle-fill';
                                    }
                                ?>
                                <span class="badge-premium <?= $badgeClass ?>">
                                    <i class="bi bi-<?= $statusIcon ?>"></i>
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="/backend/usuario/editar/<?= $usuario['id_usuario'] ?>" class="btn-icon-premium" title="Ver detalhes">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/backend/usuario/editar/<?= $usuario['id_usuario'] ?>" class="btn-icon-premium" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state-premium">
                <i class="bi bi-inbox"></i>
                <p>Nenhum usuário encontrado</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
<script>
// Dados do PHP (com fallback)
const graficoTendenciaData = <?= isset($graficoTendencia) ? $graficoTendencia : '[]' ?>;
const graficoStatusData = <?= isset($graficoStatusAdmin) ? $graficoStatusAdmin : '[]' ?>;

// Verifica se Chart.js carregou
if (typeof Chart !== 'undefined') {
    // Configuração global
    Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
    Chart.defaults.color = '#64748b';

    // Gráfico de Tendência
    if (document.getElementById('trendChartPremium') && graficoTendenciaData.length > 0) {
        const trendCtx = document.getElementById('trendChartPremium').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: graficoTendenciaData.map(d => d.mes),
                datasets: [
                    {
                        label: 'Agendamentos',
                        data: graficoTendenciaData.map(d => d.agendamentos),
                        borderColor: '#5f7396',
                        backgroundColor: 'rgba(95, 115, 150, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },
                    {
                        label: 'Orçamentos',
                        data: graficoTendenciaData.map(d => d.orcamentos),
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    },
                    {
                        label: 'Contatos',
                        data: graficoTendenciaData.map(d => d.contatos),
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Gráfico de Status
    if (document.getElementById('statusChartPremium') && graficoStatusData.length > 0) {
        const statusCtx = document.getElementById('statusChartPremium').getContext('2d');
        const statusColors = {
            'Pendente': '#f59e0b',
            'Agendada': '#3b82f6',
            'Realizada': '#22c55e',
            'Cancelada': '#ef4444'
        };

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: graficoStatusData.map(d => d.status),
                datasets: [{
                    data: graficoStatusData.map(d => d.total),
                    backgroundColor: graficoStatusData.map(d => statusColors[d.status] || '#94a3b8'),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20 }
                    }
                },
                cutout: '65%'
            }
        });
    }
}
</script>

<style>
/* Reset e Variáveis */
.dashboard-wrapper-premium {
    max-width: 1600px;
    margin: 0 auto;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header */
.dashboard-header-premium {
    margin-bottom: 2rem;
}

.header-content-premium {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.greeting-section-premium {
    flex: 1;
}

.dashboard-title-premium {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.wave-premium {
    display: inline-block;
    animation: wave-animation 2.5s ease-in-out infinite;
}

@keyframes wave-animation {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
}

.highlight-premium {
    background: linear-gradient(135deg, #5f7396, #1487df);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.dashboard-subtitle-premium {
    color: #64748b;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.header-actions-premium {
    display: flex;
    gap: 1rem;
}

.form-select-premium {
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.65rem 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #1e293b;
    background: #ffffff;
    cursor: pointer;
    min-width: 180px;
}

.form-select-premium:focus {
    outline: none;
    border-color: #1487df;
    box-shadow: 0 0 0 3px rgba(20, 135, 223, 0.1);
}

/* Metrics Grid */
.metrics-grid-premium {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card-link-premium {
    text-decoration: none;
    color: inherit;
}

.metric-card-premium {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.metric-blob-premium {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    opacity: 0;
    filter: blur(60px);
    transition: opacity 0.3s ease;
}

.metric-card-premium.card-primary .metric-blob-premium { background: #5f7396; }
.metric-card-premium.card-success .metric-blob-premium { background: #22c55e; }
.metric-card-premium.card-info .metric-blob-premium { background: #3b82f6; }
.metric-card-premium.card-warning .metric-blob-premium { background: #f59e0b; }

.metric-card-premium:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.metric-card-premium:hover .metric-blob-premium {
    opacity: 0.08;
}

.metric-header-premium {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.metric-info-premium {
    flex: 1;
}

.metric-label-premium {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-bottom: 0.75rem;
}

.metric-value-premium {
    font-size: 2.25rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
}

.metric-icon-premium {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.metric-icon-premium.icon-primary { background: linear-gradient(135deg, #5f7396, #7a8db3); }
.metric-icon-premium.icon-success { background: linear-gradient(135deg, #22c55e, #16a34a); }
.metric-icon-premium.icon-info { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.metric-icon-premium.icon-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }

.metric-footer-premium {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
}

.metric-trend-premium {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.metric-trend-premium.trend-up { color: #22c55e; }
.metric-trend-premium.trend-down { color: #ef4444; }
.metric-trend-premium.trend-neutral { color: #94a3b8; }

.metric-comparison-premium {
    font-size: 0.875rem;
    color: #94a3b8;
}

/* Charts */
.charts-grid-premium {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.chart-card-premium {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
}

.chart-header-premium {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.chart-title-premium {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.chart-subtitle-premium {
    font-size: 0.875rem;
    color: #64748b;
}

.chart-legend-premium {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.legend-item-premium {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.legend-color-premium {
    width: 12px;
    height: 12px;
    border-radius: 3px;
}

.chart-body-premium {
    position: relative;
    height: 300px;
}

/* Table */
.content-card-premium {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-header-premium {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.75rem;
    border-bottom: 1px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 1rem;
}

.card-title-premium {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.card-subtitle-premium {
    font-size: 0.875rem;
    color: #64748b;
}

.btn-outline-premium {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.25rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    background: transparent;
    color: #1487df;
    border: 1.5px solid #1487df;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline-premium:hover {
    background: #1487df;
    color: #ffffff;
}

.card-body-premium {
    padding: 0;
}

.table-responsive-premium {
    overflow-x: auto;
}

.premium-table {
    width: 100%;
    border-collapse: collapse;
}

.premium-table thead {
    background: #f1f5f9;
}

.premium-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e2e8f0;
}

.premium-table td {
    padding: 1.25rem 1.5rem;
    font-size: 0.9rem;
    color: #1e293b;
    border-bottom: 1px solid #e2e8f0;
}

.premium-table tbody tr {
    transition: all 0.2s ease;
}

.premium-table tbody tr:hover {
    background: #f8fafc;
}

.premium-table tbody tr:last-child td {
    border-bottom: none;
}

.user-cell-premium {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar-premium {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5f7396, #1487df);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-info-premium {
    display: flex;
    flex-direction: column;
}

.user-name-premium {
    font-weight: 500;
    color: #1e293b;
}

.user-meta-premium {
    font-size: 0.8125rem;
    color: #94a3b8;
}

.text-muted-premium {
    color: #94a3b8;
}

.text-end {
    text-align: right;
}

/* Badges */
.badge-premium {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 500;
    letter-spacing: 0.025em;
}

.badge-success-premium {
    background: #dcfce7;
    color: #166534;
}

.badge-warning-premium {
    background: #fef3c7;
    color: #92400e;
}

.badge-secondary-premium {
    background: #e2e8f0;
    color: #475569;
}

/* Buttons */
.btn-icon-premium {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: #94a3b8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-icon-premium:hover {
    background: #f1f5f9;
    color: #1487df;
}

/* Empty State */
.empty-state-premium {
    text-align: center;
    padding: 3rem 1rem;
    color: #94a3b8;
}

.empty-state-premium i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.empty-state-premium p {
    font-size: 0.9375rem;
    margin: 0;
}

/* Responsive */
@media (max-width: 1200px) {
    .charts-grid-premium {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .header-content-premium {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-actions-premium {
        width: 100%;
    }

    .form-select-premium {
        width: 100%;
    }

    .metrics-grid-premium {
        grid-template-columns: 1fr;
    }

    .charts-grid-premium {
        grid-template-columns: 1fr;
    }

    .card-header-premium {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-outline-premium {
        width: 100%;
        justify-content: center;
    }

    .premium-table th,
    .premium-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.875rem;
    }

    .dashboard-title-premium {
        font-size: 1.5rem;
    }

    .metric-value-premium {
        font-size: 1.875rem;
    }
}

@media (max-width: 480px) {
    .chart-legend-premium {
        flex-direction: column;
        gap: 0.5rem;
    }

    .user-cell-premium {
        flex-direction: row;
    }
}