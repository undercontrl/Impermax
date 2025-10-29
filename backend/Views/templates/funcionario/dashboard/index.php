<!-- Dashboard Premium do Funcionário -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

<div class="dashboard-func-premium">
    <!-- Header Premium com Saudação -->
    <div class="header-func-premium">
        <div class="header-content-func">
            <div class="greeting-func">
                <h1 class="title-func">
                    <span class="wave-func">👋</span>
                    <?= htmlspecialchars($saudacao ?? 'Olá') ?>, <span class="highlight-func"><?= htmlspecialchars($nomeUsuario); ?></span>!
                </h1>
                <p class="subtitle-func">
                    <i class="bi bi-calendar3"></i>
                    <?= htmlspecialchars($diaSemana ?? '') ?>, <?= htmlspecialchars($dataAtual ?? date('d/m/Y')) ?>
                    <span class="separator-func">•</span>
                    <i class="bi bi-clock"></i>
                    <?= htmlspecialchars($horaAtual ?? date('H:i')) ?>
                </p>
            </div>
            <div class="header-actions-func">
                <button class="btn-quick-action" onclick="window.location.href='/backend/agendamento/criar'" title="Novo Agendamento">
                    <i class="bi bi-plus-circle"></i>
                    <span>Novo Agendamento</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Cards de Métricas Principais -->
    <div class="metrics-grid-func">
        <!-- Card Hoje -->
        <a href="/backend/agendamento/listar" class="metric-card-func card-today">
            <div class="metric-blob-func"></div>
            <div class="metric-icon-func icon-today">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="metric-content-func">
                <span class="metric-label-func">Agendamentos Hoje</span>
                <h2 class="metric-value-func"><?= htmlspecialchars($totalHoje ?? 0) ?></h2>
                <p class="metric-desc-func">Atendimentos de hoje</p>
            </div>
        </a>

        <!-- Card Próximos 3 Dias -->
        <a href="/backend/agendamento/listar" class="metric-card-func card-upcoming">
            <div class="metric-blob-func"></div>
            <div class="metric-icon-func icon-upcoming">
                <i class="bi bi-calendar-range"></i>
            </div>
            <div class="metric-content-func">
                <span class="metric-label-func">Próximos 3 Dias</span>
                <h2 class="metric-value-func"><?= htmlspecialchars($proximos3Dias ?? 0) ?></h2>
                <p class="metric-desc-func">Agendamentos futuros</p>
            </div>
        </a>

        <!-- Card Pendências -->
        <a href="/backend/agendamento/listar" class="metric-card-func card-pending">
            <div class="metric-blob-func"></div>
            <div class="metric-icon-func icon-pending">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="metric-content-func">
                <span class="metric-label-func">Pendências</span>
                <h2 class="metric-value-func"><?= htmlspecialchars($pendencias ?? 0) ?></h2>
                <p class="metric-desc-func">Aguardando confirmação</p>
            </div>
        </a>

        <!-- Card Semana -->
        <a href="/backend/agendamento/listar" class="metric-card-func card-week">
            <div class="metric-blob-func"></div>
            <div class="metric-icon-func icon-week">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <div class="metric-content-func">
                <span class="metric-label-func">Esta Semana</span>
                <h2 class="metric-value-func"><?= htmlspecialchars($servicosSemana ?? 0) ?></h2>
                <p class="metric-desc-func">Serviços agendados</p>
            </div>
        </a>
    </div>

    <!-- Grid Principal: Agenda + Calendário -->
    <div class="main-grid-func">
        <!-- Agenda do Dia -->
        <div class="agenda-card-func">
            <div class="card-header-func">
                <div>
                    <h3 class="card-title-func">
                        <i class="bi bi-calendar-day"></i>
                        Agenda do Dia
                    </h3>
                    <p class="card-subtitle-func">
                        <?= count($agendaHoje ?? []) ?> agendamento(s) para hoje
                    </p>
                </div>
                <a href="/backend/agendamento/listar" class="btn-view-all-func">
                    <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
            <div class="card-body-func">
                <?php if (!empty($agendaHoje) && is_array($agendaHoje)): ?>
                    <div class="agenda-list-func">
                        <?php foreach($agendaHoje as $ag): ?>
                            <?php
                                $hora = date('H:i', strtotime($ag['data_solicitada']));
                                $status = strtolower($ag['status_agendamento']);
                                $statusClass = $status === 'realizada' ? 'status-done' : 
                                             ($status === 'agendada' ? 'status-scheduled' : 'status-pending');
                            ?>
                            <div class="agenda-item-func <?= $statusClass ?>">
                                <div class="agenda-time-func">
                                    <i class="bi bi-clock"></i>
                                    <?= htmlspecialchars($hora) ?>
                                </div>
                                <div class="agenda-details-func">
                                    <h4 class="agenda-client-func"><?= htmlspecialchars($ag['nome_cliente']) ?></h4>
                                    <p class="agenda-info-func">
                                        <i class="bi bi-envelope"></i> <?= htmlspecialchars($ag['email_cliente'] ?? 'Sem email') ?>
                                    </p>
                                </div>
                                <div class="agenda-status-func">
                                    <span class="badge-func badge-<?= $status ?>">
                                        <?= htmlspecialchars(ucfirst($status)) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state-func">
                        <i class="bi bi-calendar-x"></i>
                        <p>Nenhum agendamento para hoje</p>
                        <small>Aproveite para organizar as próximas tarefas!</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Calendário Semanal -->
        <div class="calendar-card-func">
            <div class="card-header-func">
                <div>
                    <h3 class="card-title-func">
                        <i class="bi bi-calendar-week"></i>
                        Calendário Semanal
                    </h3>
                    <p class="card-subtitle-func">Visão geral da semana</p>
                </div>
            </div>
            <div class="card-body-func">
                <?php if (!empty($calendarioSemanal) && is_array($calendarioSemanal)): ?>
                    <div class="calendar-week-func">
                        <?php foreach($calendarioSemanal as $data => $info): ?>
                            <?php
                                $isToday = $data === date('Y-m-d');
                                $countAgend = count($info['agendamentos']);
                            ?>
                            <div class="calendar-day-func <?= $isToday ? 'day-today' : '' ?>">
                                <div class="day-header-func">
                                    <span class="day-name-func"><?= htmlspecialchars($info['diaSemana']) ?></span>
                                    <span class="day-number-func"><?= htmlspecialchars($info['dia']) ?></span>
                                </div>
                                <div class="day-content-func">
                                    <?php if ($countAgend > 0): ?>
                                        <div class="day-badge-func">
                                            <i class="bi bi-circle-fill"></i>
                                            <?= $countAgend ?> <?= $countAgend === 1 ? 'agendamento' : 'agendamentos' ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="day-empty-func">Livre</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state-func">
                        <i class="bi bi-calendar"></i>
                        <p>Sem dados do calendário</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Grid Secundário: Próximos + Orçamentos -->
    <div class="secondary-grid-func">
        <!-- Próximos Agendamentos -->
        <div class="upcoming-card-func">
            <div class="card-header-func">
                <div>
                    <h3 class="card-title-func">
                        <i class="bi bi-calendar-plus"></i>
                        Próximos Agendamentos
                    </h3>
                    <p class="card-subtitle-func">Próximos 7 dias</p>
                </div>
            </div>
            <div class="card-body-func">
                <?php if (!empty($proximosAgendamentos) && is_array($proximosAgendamentos)): ?>
                    <div class="upcoming-list-func">
                        <?php foreach(array_slice($proximosAgendamentos, 0, 5) as $ag): ?>
                            <?php
                                $dataFormatada = date('d/m', strtotime($ag['data_solicitada']));
                                // Função para dia da semana abreviado
                                $dias = ['Sunday' => 'Dom', 'Monday' => 'Seg', 'Tuesday' => 'Ter', 
                                         'Wednesday' => 'Qua', 'Thursday' => 'Qui', 'Friday' => 'Sex', 
                                         'Saturday' => 'Sáb'];
                                $diaSemana = $dias[date('l', strtotime($ag['data_solicitada']))];
                                $status = strtolower($ag['status_agendamento']);
                            ?>
                            <div class="upcoming-item-func">
                                <div class="upcoming-date-func">
                                    <span class="date-day"><?= htmlspecialchars($dataFormatada) ?></span>
                                    <span class="date-weekday"><?= htmlspecialchars($diaSemana) ?></span>
                                </div>
                                <div class="upcoming-info-func">
                                    <h4><?= htmlspecialchars($ag['nome_cliente']) ?></h4>
                                    <span class="badge-func badge-small badge-<?= $status ?>">
                                        <?= htmlspecialchars(ucfirst($status)) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state-func">
                        <i class="bi bi-calendar-check"></i>
                        <p>Nenhum agendamento futuro</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Últimos Orçamentos -->
        <div class="orcamentos-card-func">
            <div class="card-header-func">
                <div>
                    <h3 class="card-title-func">
                        <i class="bi bi-file-earmark-text"></i>
                        Últimos Orçamentos
                    </h3>
                    <p class="card-subtitle-func"><?= htmlspecialchars($orcamentosAndamento ?? 0) ?> em andamento</p>
                </div>
                <a href="/backend/orcamento/listar" class="btn-view-all-func">
                    <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
            <div class="card-body-func">
                <?php if (!empty($ultimosOrcamentos) && is_array($ultimosOrcamentos)): ?>
                    <div class="orcamentos-list-func">
                        <?php foreach(array_slice($ultimosOrcamentos, 0, 5) as $orc): ?>
                            <?php
                                $status = strtolower($orc['status_orcamento'] ?? 'pendente');
                                $valor = number_format($orc['valor_orcamento'] ?? 0, 2, ',', '.');
                            ?>
                            <div class="orcamento-item-func">
                                <div class="orc-icon-func">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <div class="orc-info-func">
                                    <h4><?= htmlspecialchars($orc['cliente_nome'] ?? 'Cliente') ?></h4>
                                    <p class="orc-value-func">R$ <?= htmlspecialchars($valor) ?></p>
                                </div>
                                <span class="badge-func badge-<?= $status ?>">
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state-func">
                        <i class="bi bi-inbox"></i>
                        <p>Nenhum orçamento recente</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="charts-grid-func">
        <!-- Gráfico de Desempenho Semanal -->
        <div class="chart-card-func">
            <div class="chart-header-func">
                <div>
                    <h3 class="chart-title-func">
                        <i class="bi bi-graph-up"></i>
                        Desempenho Mensal
                    </h3>
                    <p class="chart-subtitle-func">Serviços concluídos por mês</p>
                </div>
            </div>
            <div class="chart-body-func">
                <canvas id="chartServicos"></canvas>
            </div>
        </div>

        <!-- Gráfico de Status -->
        <div class="chart-card-func">
            <div class="chart-header-func">
                <div>
                    <h3 class="chart-title-func">
                        <i class="bi bi-pie-chart"></i>
                        Distribuição por Status
                    </h3>
                    <p class="chart-subtitle-func">Visão geral dos agendamentos</p>
                </div>
            </div>
            <div class="chart-body-func">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
<script>
// Dados do PHP
const graficoServicos = <?= $graficoServicos ?? '[]' ?>;
const graficoStatus = <?= $graficoStatus ?? '{}' ?>;

// Configuração global
Chart.defaults.font.family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
Chart.defaults.color = '#64748b';

// Gráfico de Serviços (Barras)
if (document.getElementById('chartServicos')) {
    const ctxServicos = document.getElementById('chartServicos').getContext('2d');
    new Chart(ctxServicos, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'Serviços Concluídos',
                data: graficoServicos,
                backgroundColor: 'rgba(20, 135, 223, 0.8)',
                borderRadius: 8,
                barThickness: 24
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { precision: 0 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// Gráfico de Status (Doughnut)
if (document.getElementById('chartStatus')) {
    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    const statusColors = {
        'Pendente': '#f59e0b',
        'Agendada': '#3b82f6',
        'Realizada': '#22c55e',
        'Cancelada': '#ef4444'
    };
    
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: Object.keys(graficoStatus),
            datasets: [{
                data: Object.values(graficoStatus),
                backgroundColor: Object.keys(graficoStatus).map(k => statusColors[k] || '#94a3b8'),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15 }
                }
            },
            cutout: '65%'
        }
    });
}
</script>

<style>
:root {
    --color-primary: #5f7396;
    --color-accent: #1487df;
    --color-success: #22c55e;
    --color-warning: #f59e0b;
    --color-danger: #ef4444;
    --color-info: #3b82f6;
    --color-white: #ffffff;
    --color-bg: #f8fafc;
    --color-text: #1e293b;
    --color-text-light: #64748b;
    --color-text-muted: #94a3b8;
    --color-border: #e2e8f0;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s ease;
}

.dashboard-func-premium {
    max-width: 1600px;
    margin: 0 auto;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Header */
.header-func-premium {
    margin-bottom: 2rem;
}

.header-content-func {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.title-func {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-text);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.wave-func {
    display: inline-block;
    animation: wave-anim 2.5s ease-in-out infinite;
}

@keyframes wave-anim {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
}

.highlight-func {
    background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.subtitle-func {
    color: var(--color-text-light);
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.separator-func {
    color: var(--color-border);
}

.btn-quick-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.25rem;
    border-radius: var(--radius-sm);
    font-size: 0.9rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--color-accent), #0d6eab);
    color: var(--color-white);
    border: none;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(20, 135, 223, 0.25);
}

.btn-quick-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 135, 223, 0.35);
}

/* Metrics Grid */
.metrics-grid-func {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card-func {
    background: var(--color-white);
    border-radius: var(--radius-lg);
    padding: 1.75rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--color-border);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.metric-blob-func {
    position: absolute;
    top: -30px;
    right: -30px;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    opacity: 0;
    filter: blur(50px);
    transition: var(--transition);
}

.metric-card-func.card-today .metric-blob-func { background: var(--color-accent); }
.metric-card-func.card-upcoming .metric-blob-func { background: var(--color-success); }
.metric-card-func.card-pending .metric-blob-func { background: var(--color-warning); }
.metric-card-func.card-week .metric-blob-func { background: var(--color-info); }

.metric-card-func:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.metric-card-func:hover .metric-blob-func {
    opacity: 0.08;
}

.metric-icon-func {
    width: 56px;
    height: 56px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--color-white);
    box-shadow: var(--shadow-md);
    flex-shrink: 0;
}

.icon-today { background: linear-gradient(135deg, var(--color-accent), #0ea5e9); }
.icon-upcoming { background: linear-gradient(135deg, var(--color-success), #16a34a); }
.icon-pending { background: linear-gradient(135deg, var(--color-warning), #d97706); }
.icon-week { background: linear-gradient(135deg, var(--color-info), #2563eb); }

.metric-content-func {
    flex: 1;
}

.metric-label-func {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--color-text-light);
    margin-bottom: 0.5rem;
}

.metric-value-func {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-text);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.metric-desc-func {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    margin: 0;
}

/* Main Grid */
.main-grid-func {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Card Styles */
.agenda-card-func,
.calendar-card-func,
.upcoming-card-func,
.orcamentos-card-func,
.chart-card-func {
    background: var(--color-white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--color-border);
    overflow: hidden;
}

.card-header-func {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.75rem;
    border-bottom: 1px solid var(--color-border);
}

.card-title-func {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-text);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.card-subtitle-func {
    font-size: 0.875rem;
    color: var(--color-text-light);
    margin: 0;
}

.btn-view-all-func {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    color: var(--color-text-muted);
    transition: var(--transition);
    text-decoration: none;
    font-size: 1.25rem;
}

.btn-view-all-func:hover {
    background: var(--color-bg);
    color: var(--color-accent);
}

.card-body-func {
    padding: 1.5rem;
}

/* Agenda List */
.agenda-list-func {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.agenda-item-func {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    background: var(--color-bg);
    border-left: 3px solid var(--color-accent);
    transition: var(--transition);
}

.agenda-item-func.status-done {
    border-left-color: var(--color-success);
    opacity: 0.7;
}

.agenda-item-func.status-pending {
    border-left-color: var(--color-warning);
}

.agenda-item-func:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-sm);
}

.agenda-time-func {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    font-weight: 600;
    color: var(--color-primary);
    min-width: 60px;
}

.agenda-details-func {
    flex: 1;
}

.agenda-client-func {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 0.25rem;
}

.agenda-info-func {
    font-size: 0.8125rem;
    color: var(--color-text-muted);
    margin: 0;
}

/* Calendar Week */
.calendar-week-func {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.5rem;
}

.calendar-day-func {
    padding: 1rem 0.5rem;
    border-radius: var(--radius-sm);
    background: var(--color-bg);
    text-align: center;
    transition: var(--transition);
}

.calendar-day-func.day-today {
    background: linear-gradient(135deg, var(--color-accent), #0ea5e9);
    color: var(--color-white);
}

.calendar-day-func:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.day-header-func {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    margin-bottom: 0.75rem;
}

.day-name-func {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.day-number-func {
    font-size: 1.5rem;
    font-weight: 700;
}

.day-badge-func {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    background: var(--color-white);
    color: var(--color-accent);
    display: flex;
    align-items: center;
    gap: 0.25rem;
    justify-content: center;
}

.calendar-day-func.day-today .day-badge-func {
    background: rgba(255, 255, 255, 0.2);
    color: var(--color-white);
}

.day-empty-func {
    font-size: 0.75rem;
    color: var(--color-text-muted);
}

/* Secondary Grid */
.secondary-grid-func {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Upcoming List */
.upcoming-list-func {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.upcoming-item-func {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    background: var(--color-bg);
    transition: var(--transition);
}

.upcoming-item-func:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.upcoming-date-func {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem;
    border-radius: var(--radius-sm);
    background: var(--color-white);
    min-width: 60px;
    box-shadow: var(--shadow-sm);
}

.date-day {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-accent);
}

.date-weekday {
    font-size: 0.75rem;
    color: var(--color-text-muted);
    text-transform: uppercase;
}

.upcoming-info-func {
    flex: 1;
}

.upcoming-info-func h4 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 0.5rem;
}

/* Orçamentos List */
.orcamentos-list-func {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.orcamento-item-func {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    background: var(--color-bg);
    transition: var(--transition);
}

.orcamento-item-func:hover {
    background: #f1f5f9;
    transform: translateX(4px);
}

.orc-icon-func {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-sm);
    background: linear-gradient(135deg, var(--color-info), #2563eb);
    color: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.orc-info-func {
    flex: 1;
}

.orc-info-func h4 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 0.25rem;
}

.orc-value-func {
    font-size: 0.875rem;
    color: var(--color-success);
    font-weight: 600;
    margin: 0;
}

/* Badges */
.badge-func {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 500;
}

.badge-small {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.badge-pendente { background: #fef3c7; color: #92400e; }
.badge-agendada { background: #dbeafe; color: #1e40af; }
.badge-realizada { background: #dcfce7; color: #166534; }
.badge-cancelada { background: #fee2e2; color: #991b1b; }
.badge-em-andamento { background: #dbeafe; color: #1e40af; }
.badge-concluido { background: #dcfce7; color: #166534; }

/* Charts Grid */
.charts-grid-func {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.chart-header-func {
    padding: 1.75rem;
    border-bottom: 1px solid var(--color-border);
}

.chart-title-func {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-text);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.chart-subtitle-func {
    font-size: 0.875rem;
    color: var(--color-text-light);
    margin: 0;
}

.chart-body-func {
    padding: 1.5rem;
    height: 300px;
    position: relative;
}

/* Empty State */
.empty-state-func {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--color-text-muted);
}

.empty-state-func i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.empty-state-func p {
    font-size: 0.9375rem;
    margin: 0.5rem 0;
    font-weight: 500;
}

.empty-state-func small {
    font-size: 0.8125rem;
    color: var(--color-text-muted);
}

/* Responsive */
@media (max-width: 1200px) {
    .charts-grid-func {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .header-content-func {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-actions-func {
        width: 100%;
    }
    
    .btn-quick-action {
        width: 100%;
        justify-content: center;
    }
    
    .metrics-grid-func {
        grid-template-columns: 1fr;
    }
    
    .main-grid-func,
    .secondary-grid-func {
        grid-template-columns: 1fr;
    }
    
    .calendar-week-func {
        grid-template-columns: repeat(7, 1fr);
        gap: 0.25rem;
    }
    
    .calendar-day-func {
        padding: 0.75rem 0.25rem;
    }
    
    .day-name-func {
        font-size: 0.625rem;
    }
    
    .day-number-func {
        font-size: 1.125rem;
    }
    
    .day-badge-func {
        font-size: 0.625rem;
        padding: 0.125rem 0.25rem;
    }
    
    .title-func {
        font-size: 1.5rem;
    }
    
    .metric-value-func {
        font-size: 1.75rem;
    }
}

@media (max-width: 480px) {
    .agenda-item-func {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .agenda-time-func {
        flex-direction: row;
        min-width: auto;
    }
    
    .upcoming-item-func {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .calendar-week-func {
        display: flex;
        overflow-x: auto;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
    }
    
    .calendar-day-func {
        min-width: 80px;
    }
}

/* Animações de entrada */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.metric-card-func,
.agenda-card-func,
.calendar-card-func,
.upcoming-card-func,
.orcamentos-card-func,
.chart-card-func {
    animation: fadeInUp 0.5s ease-out;
}

/* Scrollbar customizada */
.calendar-week-func::-webkit-scrollbar {
    height: 6px;
}

.calendar-week-func::-webkit-scrollbar-track {
    background: var(--color-bg);
    border-radius: 10px;
}

.calendar-week-func::-webkit-scrollbar-thumb {
    background: var(--color-border);
    border-radius: 10px;
}

.calendar-week-func::-webkit-scrollbar-thumb:hover {
    background: var(--color-text-muted);
}
</style>