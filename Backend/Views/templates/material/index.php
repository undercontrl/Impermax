<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Materiais</h2>
        <a href="/backend/material/criar" class="btn btn-success">Cadastrar Material</a>
    </div>

    <table class="table table-striped table-bordered">
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
                <th><?= htmlspecialchars($material['id_material']) ?></th>
                <td><?= htmlspecialchars($material['nome_material']) ?></td>
                <td><?= htmlspecialchars($material['qtd_material']) ?></td>
                <td><?= htmlspecialchars($material['descricao_material']) ?></td>
                <td><?= htmlspecialchars($material['nome_servico']) ?></td> <!-- ✅ NOME DO SERVIÇO -->
                <td>
                    <a href="/backend/material/editar/<?= $material['id_material'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="/backend/material/excluir/<?= $material['id_material'] ?>" class="btn btn-sm btn-danger" 
                       onclick="return confirm('Tem certeza que deseja excluir este material?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>