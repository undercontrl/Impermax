<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Avaliações</h2>
        <a href="/backend/avaliacao/criar" class="btn btn-success">Nova Avaliação</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
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
            <?php if (!empty($avaliacoes)): ?>
                <?php foreach ($avaliacoes as $av): ?>
                    <tr>
                        <td><?= htmlspecialchars($av['id_avaliacao']) ?></td>
                        <td><?= htmlspecialchars($av['nome_usuario'] ?? '') ?></td>
                        <td><?= htmlspecialchars($av['descricao_avaliacao']) ?></td>
                        <td><?= htmlspecialchars($av['nota_avaliacao']) ?></td>
                        <td><?= htmlspecialchars($av['status_avaliacao']) ?></td>
                        <td>
                            <a href="/backend/avaliacao/editar/<?= $av['id_avaliacao'] ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="/backend/avaliacao/excluir/<?= $av['id_avaliacao'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir esta avaliação?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Nenhuma avaliação encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
