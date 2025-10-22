<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Agendamentos</h2>
        <a href="/backend/agendamento/criar" class="btn btn-success">Novo Agendamento</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data Solicitada</th>
                <th>Total (R$)</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($agendamentos)): ?>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <!--  -->
                    <tr>
                        <td><?= htmlspecialchars($agendamento['id_agendamento']) ?></td>
                        <td><?= htmlspecialchars($agendamento['nome_cliente'] ?? '') ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($agendamento['data_solicitada']))) ?></td>
                        <td>R$ <?= number_format($agendamento['total_agendamento'], 2, ',', '.') ?></td>
                        <td>
                            <?php
                                $status = strtolower(trim($agendamento['status_agendamento']));
                                $badgeClass = match ($status) {
                                    'realizada' => 'bg-success',
                                    'agendada'  => 'bg-primary',
                                    'pendente'  => 'bg-warning text-dark',
                                    'cancelada' => 'bg-danger',
                                    default     => 'bg-secondary'
                                };
                            ?>
                            <span class="badge <?= $badgeClass ?>" 
                                style="
                                    padding: 4px 8px; 
                                    font-size: 0.78rem; 
                                    border-radius: 6px; 
                                    font-weight: 500;
                                    text-transform: capitalize;
                                    letter-spacing: 0.3px;">
                                <?= htmlspecialchars($agendamento['status_agendamento']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="/backend/agendamento/editar/<?= $agendamento['id_agendamento'] ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="/backend/agendamento/excluir/<?= $agendamento['id_agendamento'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este agendamento?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Nenhum agendamento encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
