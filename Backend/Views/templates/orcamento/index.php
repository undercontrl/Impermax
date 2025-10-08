<a href="/backend/orcamento/criar">Cadastrar Orçamento</a>

<div>Lista de Orcamento</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Cliente</th>
            <th scope="col">Descricao</th>
            <th scope="col">Status</th>
            <th scope="col">Data do Orçamento</th>
            <th scope="col">Valor do Orçamento</th>
            <th scope="col">Total de itens Solicitados</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orcamentos as $orcamento): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($orcamento['id_orcamento']); ?></th>
            <td><?php echo htmlspecialchars($orcamento['id_cliente']); ?></td>
            <td><?php echo htmlspecialchars($orcamento['descricao_orcamento']); ?></td>
            <td><?php echo htmlspecialchars($orcamento['status_orcamento']); ?></td>
            <td><?php echo htmlspecialchars($orcamento['data_orcamento']); ?></td>
            <td><?php echo htmlspecialchars($orcamento['valor_orcamento']); ?></td>
            <td><?php echo htmlspecialchars($orcamento['total_item_orcamento']); ?></td>
            <td>
                
                <a href="/backend/material/editar?id=<?php echo $orcamento['id_orcamento']; ?>" class="btn btn-primary btn-sm">Editar</a>

                <a href="/backend/material/excluir/<?php echo $orcamento['id_orcamento']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>