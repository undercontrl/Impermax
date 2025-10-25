<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Materiais</h2>
        <a href="/backend/material/criar" class="btn btn-success">Cadastrar Material</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Descrição</th>
                <th>Serviço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($materiais as $material): ?>
            <tr>
                <th scope="row"><?= htmlspecialchars($material['id_material']) ?></th>
                <td><?= htmlspecialchars($material['nome_material']) ?></td>
                <td><?= htmlspecialchars($material['qtd_material']) ?></td>
                <td><?= htmlspecialchars($material['descricao_material']) ?></td>
                <td><?= htmlspecialchars($material['nome_servico']) ?></td>
                <td style="white-space: nowrap;">
                    <a href="/backend/material/editar/<?= $material['id_material'] ?>" class="btn btn-sm btn-primary d-inline-block">Editar</a>
                    <a href="/backend/material/excluir/<?= $material['id_material'] ?>" class="btn btn-sm btn-danger d-inline-block"
                       onclick="return confirm('Tem certeza que deseja excluir este material?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>