<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gerenciamento de Usuários</h2>
        <a href="/backend/usuario/criar" class="btn btn-success">Novo Usuario</a>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Tipo</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $usuario): ?>
            <tr>
                <th scope="row"><?php echo htmlspecialchars($usuario['id_usuario']); ?></th>
                <td><?php echo htmlspecialchars($usuario['nome_usuario']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email_usuario']); ?></td>
                <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                <td><?php echo htmlspecialchars($usuario['status_usuario']); ?></td>
                <td>
                                <a href="/backend/usuario/editar/<?= $usuario['id_usuario'] ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="/backend/usuario/excluir/<?= $usuario['id_usuario'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este usuario?');">Excluir</a>
                            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
</div>