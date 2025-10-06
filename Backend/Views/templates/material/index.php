<a href="/backend/material/criar">Cadastrar Materiais</a>

<div>Lista de Materiais</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Descrição</th>
            <th scope="col">Id do Serviço</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($materiais as $material): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($material['id_material']); ?></th>
            <td><?php echo htmlspecialchars($material['nome_material']); ?></td>
            <td><?php echo htmlspecialchars($material['qtd_material']); ?></td>
            <td><?php echo htmlspecialchars($material['descricao_material']); ?></td>
            <td><?php echo htmlspecialchars($material['id_servico']); ?></td>
            <td>
                
                <a href="/backend/material/editar?id=<?php echo $material['id_material']; ?>" class="btn btn-primary btn-sm">Editar</a>

                <a href="/backend/material/excluir/<?php echo $material['id_material']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>