<!-- <a href="/backend/usuario/criar">Cadastrar Usuario</a>
 
<div>Lista de Usuarios</div>
<table class="table">
    <thead>
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
        <?php // foreach($usuarios as $usuario): ?>
        <tr>
            <th scope="row"><?php // echo htmlspecialchars($usuario['id_usuario']); ?></th>
            <td><?php // echo htmlspecialchars($usuario['nome_usuario']); ?></td>
            <td><?php // echo htmlspecialchars($usuario['email_usuario']); ?></td>
            <td><?php // echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
            <td><?php // echo htmlspecialchars($usuario['status_usuario']); ?></td>
            <td>
               
                <a href="/backend/usuario/editar/{id}=<?php // echo $usuario['id_usuario']; ?>" class="btn btn-primary btn-sm">Editar</a>
 
                <a href="/usuario/excluir/<?php // echo $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
            </td>
        </tr>
        <?php // endforeach; ?>
    </tbody> -->





<a href="/backend/usuario/criar" class="btn btn-success mb-3">Cadastrar Usuário</a>

<div class="card">
  <div class="card-header">
    <h4>Lista de Usuários</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($usuarios as $usuario): ?>
        <tr class="<?php echo ($usuario['status_usuario'] == 'Ativo') ? 'table-success' : (($usuario['status_usuario'] == 'Inativo') ? 'table-warning' : 'table-danger'); ?>">
          <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
          <td><?php echo htmlspecialchars($usuario['nome_usuario']); ?></td>
          <td><?php echo htmlspecialchars($usuario['email_usuario']); ?></td>
          <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
          <td><?php echo htmlspecialchars($usuario['status_usuario']); ?></td>
          <td>
            <a href="/backend/usuario/editar/<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-primary">Editar</a>
            <a href="/usuario/excluir/<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


















