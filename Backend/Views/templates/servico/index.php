<a href="/backend/servico/criar">Cadastrar Serviços</a>

<div>Lista de Serviços</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">valor</th>
            <th scope="col">foto</th>
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
            <td><?php echo htmlspecialchars($servico['valor_base_servico']); ?></td>
            <td><img src="<?php echo "/backend/upload/". htmlspecialchars($servico['foto_servico']); ?>" alt="imagem_servico" width="100px"></td>
            <td><?php echo htmlspecialchars($servico['status_servico']); ?></td>
            <td>
                
                <a href="/backend/servico/editar?id=<?php echo $servico['id_servico']; ?>" class="btn btn-primary btn-sm">Editar</a>

                <a href="/backend/servico/excluir/<?php echo $servico['id_servico']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>