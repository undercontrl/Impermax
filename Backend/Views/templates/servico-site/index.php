<div class="container mt-4">
    <h2>Gerenciamento de Serviços</h2>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="/backend/servico/listar">Serviços Internos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="/backend/servico-site/listar">Conteúdo do Site</a>
        </li>
    </ul>

    <div class="d-flex justify-content-between mb-3">
        <h4>Conteúdo do Site</h4>
        <a href="/backend/servico/editar/novo" class="btn btn-success">+ Editar para Site</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($servicos as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['nome_servico']) ?></td>
                <td><?= htmlspecialchars(substr($s['descricao_servico'], 0, 80)) ?>...</td>
                <td>
                    <img src="/backend/upload/<?= htmlspecialchars($s['foto_servico']) ?>" 
                         width="60" class="rounded" alt="Foto">
                </td>
                <td>
                    <span class="badge <?= $s['status_servico'] === 'Ativo' ? 'bg-success' : 'bg-danger' ?>">
                        <?= $s['status_servico'] ?>
                    </span>
                </td>
                <td>
                    <a href="/backend/servico-site/editar/<?= $s['id_servico'] ?>" 
                       class="btn btn-sm btn-primary">Editar</a>
                    <a href="/backend/servico-site/alternar/<?= $s['id_servico'] ?>" 
                       class="btn btn-sm btn-warning"
                       onclick="return confirm('Alterar status para o site?')">
                       <?= $s['status_servico'] === 'Ativo' ? 'Desativar' : 'Ativar' ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>