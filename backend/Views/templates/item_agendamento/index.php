<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Itens de Agendamento</h2>
        <a href="/backend/item_agendamento/criar" class="btn btn-success">Novo Item</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Agendamento</th>
                <th>Serviço</th>
                <th>Valor Serviço</th>
                <th>Quantidade</th>
                <th>Total Item</th>
                <th>Responsável</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($itens)): ?>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id_item_agendamento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($item['id_agendamento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($item['id_servico'] ?? '') ?></td>
                        <td>R$ <?= number_format($item['valor_servico'] ?? 0, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($item['qtde_solicitada'] ?? '') ?></td>
                        <td>R$ <?= number_format($item['total_item'] ?? 0, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($item['id_responsavel'] ?? '') ?></td>
                        <td>
                            <a href="/backend/item_agendamento/editar/<?= htmlspecialchars($item['id_item_agendamento'] ?? '') ?>" 
                               class="btn btn-sm btn-primary">Editar</a>

                            <a href="/backend/item_agendamento/excluir/<?= htmlspecialchars($item['id_item_agendamento'] ?? '') ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este item?');">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Nenhum item de agendamento encontrado.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
