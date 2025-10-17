<a href="/backend/avaliacao/criar" class="btn btn-success mb-2">Nova Avaliação</a>

<h3>Lista de Avaliações</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Descrição</th>
            <th>Nota</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($avaliacoes as $avaliacao): ?>
            <tr>
                <td><?= htmlspecialchars($avaliacao['id_avaliacao']); ?></td>
                <td><?= htmlspecialchars($avaliacao['nome_usuario']); ?></td>
                <td><?= htmlspecialchars($avaliacao['descricao_avaliacao']); ?></td>
                <td><?= htmlspecialchars($avaliacao['nota_avaliacao']); ?></td>
                <td><?= htmlspecialchars($avaliacao['status_avaliacao']); ?></td>
                <td>
                    <a href="/backend/avaliacao/editar/<?= $avaliacao['id_avaliacao']; ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="/backend/avaliacao/excluir/<?= $avaliacao['id_avaliacao']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Tem certeza que deseja excluir esta avaliação?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
