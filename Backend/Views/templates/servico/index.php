<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gerenciamento de Serviços</h2>
        <a href="/backend/servico/criar" class="btn btn-success">Novo Serviço</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Valor (R$)</th>
                <th scope="col">Foto</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($servicos as $servico): ?>
            <tr>
                <th scope="row"><?php echo htmlspecialchars($servico['id_servico']); ?></th>
                <td><?php echo htmlspecialchars($servico['nome_servico']); ?></td>
                <td><?php echo htmlspecialchars($servico['descricao_servico']); ?></td>
                <td>R$ <?php echo number_format($servico['valor_base_servico'], 2, ',', '.'); ?></td>
                <td><img src="/backend/upload/<?php echo htmlspecialchars($servico['foto_servico']); ?>" width="50" alt="Serviço"></td>
                <td><?php echo htmlspecialchars($servico['status_servico']); ?></td>
                <td>
                    <a href="/backend/servico/editar/<?php echo $servico['id_servico']; ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="/backend/servico/excluir/<?php echo $servico['id_servico']; ?>" class="btn btn-sm btn-danger" 
                       onclick="return confirm('Tem certeza que deseja excluir este serviço?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>