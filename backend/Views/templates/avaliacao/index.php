<a href="/backend/avaliacao/criar">Cadastrar Avaliação</a>
<div>Lista de avaliações</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Cliente</th>
            <th scope="col">Descrição</th>
            <th scope="col">Nota</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($avaliacoes as $avaliacao): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($avaliacao['id_avaliacao']); ?></th>
            <td><?php echo htmlspecialchars($avaliacao['id_cliente']); ?></td>
            <td><?php echo htmlspecialchars($avaliacao['descricao_avaliacao']); ?></td>
            <td><?php echo htmlspecialchars($avaliacao['nota_avaliacao']); ?></td>
            <td><?php echo htmlspecialchars($avaliacao['status_avaliacao']); ?></td>
            <td>
                <a href="/backend/avaliacao/editar/<?php echo $avaliacao['id_avaliacao']; ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="/avaliacao/excluir/<?php echo $avaliacao['id_avaliacao']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta avaliação?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
