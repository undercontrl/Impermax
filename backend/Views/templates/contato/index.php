<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Contatos</h2>
        <a href="/backend/contato/criar" class="btn btn-success">Novo Contato</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Assunto</th>
                <th>Status</th>
                <th>Data de Envio</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contatos)): ?>
                <?php foreach ($contatos as $contato): ?>
                    <tr>
                        <td><?= htmlspecialchars($contato['id_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['nome_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['telefone_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['email_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['assunto_contato']) ?></td>
                        <td><?= htmlspecialchars($contato['status_contato']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($contato['data_envio']))) ?></td>
                        <td>
                            <a href="/backend/contato/editar/<?= $contato['id_contato'] ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="/backend/contato/excluir/<?= $contato['id_contato'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza que deseja excluir este contato?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Nenhum contato encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
