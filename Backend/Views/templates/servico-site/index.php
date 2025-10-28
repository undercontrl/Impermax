<div class="container mt-4">
    <h2>Conteúdo do Site</h2>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="/backend/servico/listar">Serviços Internos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="/backend/servico-site/listar">Site</a>
        </li>
    </ul>

    <div class="d-flex justify-content-end mb-3">
        <a href="/backend/servico-site/criar" class="btn btn-success">+ Novo Serviço</a>
    </div>

    <table class="table table-striped">
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
            <?php foreach ($servicos as $servico): ?>
                <?php 
                    $isAtivo = strcasecmp($servico['status_servico'], 'Ativo') === 0;
                    $statusTexto = $isAtivo ? 'Ativo' : 'Inativo';
                    $badgeCor = $isAtivo ? 'bg-success' : 'bg-danger';
                    $botaoTexto = $isAtivo ? 'Desativar' : 'Ativar';
                    $botaoCor = $isAtivo ? 'btn-warning' : 'btn-success';
                ?>
                <tr>
                    <td><?= htmlspecialchars($servico['nome_servico']) ?></td>
                    <td><?= htmlspecialchars(substr($servico['descricao_servico'], 0, 80)) ?>...</td>
                    <td>
                        <?php if ($servico['foto_servico']): ?>
                            <img src="/backend/upload/<?= htmlspecialchars($servico['foto_servico']) ?>" 
                                 width="60" class="rounded" alt="Foto">
                        <?php else: ?>
                            <span class="text-muted">Sem foto</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?= $badgeCor ?>"><?= $statusTexto ?></span>
                    </td>
                    <td>
                        <a href="/backend/servico-site/editar/<?= $servico['id_servico'] ?>" 
                           class="btn btn-sm btn-primary">Editar</a>
                        <a href="/backend/servico-site/alternar/<?= $servico['id_servico'] ?>" 
                           class="btn btn-sm <?= $botaoCor ?>"
                           onclick="return confirm('<?= $botaoTexto ?> este serviço?')">
                           <?= $botaoTexto ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>