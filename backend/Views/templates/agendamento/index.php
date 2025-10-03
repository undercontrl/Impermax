<a href="/backend/agendamento/criar">Cadastrar Agendamento</a>
<div>Lista de agendamentos</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">ID CLIENTE</th>
            <th scope="col">Data</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($agendamentos as $agendamento): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($agendamento['id_agendamento']); ?></th>
            <td><?php echo htmlspecialchars($agendamento['id_cliente']); ?></td>
            <td><?php echo htmlspecialchars($agendamento['data_solicitada']); ?></td>
            <td><?php echo htmlspecialchars($agendamento['status_agendamento']); ?></td>
            <td>
               
                <a href="/backend/agendamento/editar?id=<?php echo $agendamento['id_agendamento']; ?>" class="btn btn-primary btn-sm">Editar</a>
 
                <a href="/agendamento/excluir/<?php echo $agendamento['id_agendamento']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este agendamento?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>