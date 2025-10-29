<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Endereços</h2>
        <a href="/backend/endereco/criar" class="btn btn-success">Novo Endereço</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>CEP</th>
                <th>Logradouro</th>
                <th>Número</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($enderecos)): ?>
                <?php foreach ($enderecos as $endereco): ?>
                    <tr>
                        <td><?= htmlspecialchars($endereco['id_endereco'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['id_usuario'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['cep_endereco'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['logadouro_endereco'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['numero_endereco'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['bairro_endereco'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['cidade_endereco'] ?? '') ?></td>
                        <td><?= htmlspecialchars($endereco['uf_endereco'] ?? '') ?></td>
                        <td>
                            <a href="/backend/endereco/editar/<?= htmlspecialchars($endereco['id_endereco'] ?? '') ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="/backend/endereco/excluir/<?= htmlspecialchars($endereco['id_endereco'] ?? '') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este endereço?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center text-muted">Nenhum endereço cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
