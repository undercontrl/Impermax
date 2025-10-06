<a href="/backend/pagamento/criar">Cadastrar Pagamento</a>

<div>Lista de Pagamentos</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">ID Cliente</th>
            <th scope="col">Total</th>
            <th scope="col">Dinheiro</th>
            <th scope="col">credito</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($Pagamentos as $pagamento): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($pagamento['id_pagamento']); ?></th>
            <td><?php echo htmlspecialchars($pagamento['id_cliente']); ?></td>
            <td><?php echo htmlspecialchars($pagamento['total_devedor']); ?></td>
            <td><?php echo htmlspecialchars($pagamento['dinheiro']); ?></td>
            <td><?php echo htmlspecialchars($pagamento['credito']); ?></td>
            <td><?php echo htmlspecialchars($pagamento['debito']); ?></td>
            <td><?php echo htmlspecialchars($pagamento['pix']); ?></td>
            <td><?php echo htmlspecialchars($pagamento['status_pagamento']); ?></td>
            <td>
                
                <a href="/backend/pagamento/editar?id=<?php echo $pagamento['id_pagamento']; ?>" class="btn btn-primary btn-sm">Editar</a>

                <a href="/backend/pagamento/excluir/<?php echo $pagamento['id_pagamento']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>