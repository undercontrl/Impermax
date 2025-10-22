<div>Excluir Usuário</div>

<div class="alert alert-danger">
    <h4>Confirmação de Exclusão</h4>
    <p>Tem certeza que deseja excluir o usuário:</p>
    <strong><?php echo htmlspecialchars($usuario['nome_usuario']); ?></strong>
    <br>
    <em>Email: <?php echo htmlspecialchars($usuario['email_usuario']); ?></em>
</div>

<form action="/backend/usuario/deletar/<?php echo $usuario['id_usuario']; ?>" method="post" style="display: inline;">
    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
    <button type="submit" class="btn btn-danger">Sim, Excluir</button>
</form>

<a href="/backend/usuario/listar" class="btn btn-secondary">Cancelar</a>