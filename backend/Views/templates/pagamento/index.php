<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gerenciamento de Pagamentos</h2>
        <a href="/backend/pagamento/criar" class="btn btn-success">Novo Pagamento</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Total Dívida (R$)</th>
                <th scope="col">Dinheiro (R$)</th>
                <th scope="col">Débito (R$)</th>
                <th scope="col">Crédito (R$)</th>
                <th scope="col">Pix (R$)</th>
                <th scope="col">Total Pago (R$)</th>
                <th scope="col">Status</th>
                <th scope="col">Data</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($Pagamentos as $pagamento): ?>
            <tr>
                <th scope="row"><?= htmlspecialchars($pagamento['id_pagamento']) ?></th>
                <td><?= htmlspecialchars($pagamento['cliente_nome']) ?></td>
                <td><strong>R$ <?= number_format($pagamento['total_devedor'], 2, ',', '.') ?></strong></td>
                <td>R$ <?= number_format($pagamento['dinheiro'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($pagamento['debito'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($pagamento['credito'], 2, ',', '.') ?></td>
                <td>R$ <?= number_format($pagamento['pix'], 2, ',', '.') ?></td>
                <td><strong>R$ <?= number_format($pagamento['total_pago'], 2, ',', '.') ?></strong></td>
                <td>
                    <span class="badge 
                        <?= $pagamento['status_pagamento'] == 'pago' ? 'bg-success' : 
                           ($pagamento['status_pagamento'] == 'aberto' ? 'bg-warning' : 'bg-danger') ?>">
                        <?= htmlspecialchars($pagamento['status_pagamento']) ?>
                    </span>
                </td>
                <td>
                    <?= $pagamento['data_pagamento'] ? 
                        date('d/m/Y', strtotime($pagamento['data_pagamento'])) : 
                        'Sem data' ?>
                </td>
                <td>
                    <a href="/backend/pagamento/editar/<?= $pagamento['id_pagamento'] ?>" 
                       class="btn btn-sm btn-primary">Editar</a>
                    <a href="/backend/pagamento/excluir/<?= $pagamento['id_pagamento'] ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Tem certeza que deseja excluir este pagamento?');">
                       Excluir
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>