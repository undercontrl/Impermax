<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-list-task me-2"></i>Itens de Orçamento
        </h2>
        <a href="/backend/item_orcamento/criar" class="btn btn-success px-3 rounded-pill">
            <i class="bi bi-plus-circle me-1"></i> Novo Item
        </a>
    </div>

    <?php if (!empty($itens)): ?>
        <div class="table-responsive shadow-sm rounded-3 bg-white p-2">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Descrição</th>
                        <th>Metragem</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td class="text-center fw-semibold"><?= htmlspecialchars($item['id_item_orcamento']) ?></td>
                            <td><?= htmlspecialchars($item['nome_cliente'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($item['nome_servico'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($item['descricao_item_orcamento']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($item['metragem'] ?? '—') ?></td>
                            <td class="text-center">
                                <?php
                                    $status = strtolower($item['status_item_orcamento']);
                                    $classe = match ($status) {
                                        'ativo' => 'success',
                                        'inativo' => 'secondary',
                                        'pendente' => 'warning',
                                        default => 'dark'
                                    };
                                ?>
                                <span class="badge bg-<?= $classe ?> px-3 py-2 text-capitalize">
                                    <?= htmlspecialchars($status) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/backend/item_orcamento/editar/<?= $item['id_item_orcamento'] ?>" class="btn btn-sm btn-outline-primary rounded-pill me-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/backend/item_orcamento/excluir/<?= $item['id_item_orcamento'] ?>" class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center shadow-sm mt-4">
            Nenhum item de orçamento encontrado.
        </div>
    <?php endif; ?>
</div>

