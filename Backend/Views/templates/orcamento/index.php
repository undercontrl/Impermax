<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Orçamentos</h2>
        <a href="/backend/orcamento/criar" class="btn btn-success">Cadastrar Orçamento</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Data</th>
                <th>Valor (R$)</th>
                <th>Itens</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orcamentos as $orcamento): ?>
            <tr>
                <th><?= htmlspecialchars($orcamento['id_orcamento']) ?></th>
                <td><?= htmlspecialchars($orcamento['cliente_nome']) ?></td>  <!-- ✅ NOME -->
                <td><?= htmlspecialchars($orcamento['descricao_orcamento']) ?></td>
                <td>
                    <span class="badge 
                        <?= $orcamento['status_orcamento'] == 'aprovado' ? 'bg-success' : 
                           ($orcamento['status_orcamento'] == 'aguardando' ? 'bg-warning' : 
                           ($orcamento['status_orcamento'] == 'em_analise' ? 'bg-info' : 'bg-danger')) ?>">
                        <?= htmlspecialchars($orcamento['status_orcamento']) ?>
                    </span>
                </td>
                <td><?= date('d/m/Y', strtotime($orcamento['data_orcamento'])) ?></td>
                <td>R$ <?= number_format($orcamento['valor_orcamento'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($orcamento['total_item_orcamento']) ?></td>
                <td>
                    <a href="/backend/orcamento/editar/<?= $orcamento['id_orcamento'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="/backend/orcamento/excluir/<?= $orcamento['id_orcamento'] ?>" class="btn btn-sm btn-danger" 
                       onclick="return confirm('Tem certeza que deseja excluir este orçamento?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>