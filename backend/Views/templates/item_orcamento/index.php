<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Itens de Orçamento</h2>
        <a href="/backend/item_orcamento/criar" class="btn btn-success">Novo Item</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Orçamento</th>
                <th>Serviço</th>
                <th>Descrição</th>
                <th>Metragem</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($itens_orcamento)): ?>
                <?php foreach ($itens_orcamento as $item): ?>
                    <?php
                        $status = strtolower(trim($item['status_item_orcamento'] ?? ''));

                        $badgeClass = match ($status) {
                            'pendente'     => 'bg-warning text-dark', // amarelo
                            'em andamento' => 'bg-info text-dark',    // azul claro
                            'finalizado'   => 'bg-success',           // verde
                            'ativo'        => 'bg-primary',           // azul forte
                            default        => 'bg-secondary'          // cinza padrão
                        };
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id_item_orcamento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($item['id_orcamento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($item['id_servico'] ?? '') ?></td>
                        <td><?= htmlspecialchars($item['descricao_item_orcamento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($item['metragem'] ?? '') ?></td>
                        <td>
                            <span class="badge rounded-pill <?= $badgeClass ?>"
                                  style="padding: 4px 8px; font-size: .78rem; border-radius: 6px; font-weight: 500; letter-spacing:.3px;">
                                <?= htmlspecialchars($item['status_item_orcamento'] ?? '') ?>
                            </span>
                        </td>
                        <td>
                            <a href="/backend/item_orcamento/editar/<?= htmlspecialchars($item['id_item_orcamento']) ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="/backend/item_orcamento/excluir/<?= htmlspecialchars($item['id_item_orcamento']) ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este item?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">Nenhum item de orçamento encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
