<div class="container mt-4">
<h2>Editar Usuário</h2>
<form action="/backend/usuario/atualizar/<?php echo $usuario['id_usuario']; ?>" method="post">
    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
 
    <div class="mb-3">
    <label for="nome_usuario" class="form-label">Nome</label>
    <input type="text"
           name="nome_usuario"
           id="nome_usuario"
           class="form-control"
           value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>"
           required>
    </div>
 
    <div class="mb-3">
    <label for="email_usuario"  class="form-label">Email</label>
    <input type="email"
           name="email_usuario"
           id="email_usuario"
           class="form-control"
           value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>"
           required>
    </div>
 
    <div class="mb-3">
    <label for="senha_usuario" class="form-label">Nova Senha</label>
    <input type="password"
           name="senha_usuario"
           id="senha_usuario"
            class="form-control" >
    </div>
 
    <div class="mb-3">
    <label for="tipo_usuario" class="form-label">Tipo</label>
    <select name="tipo_usuario" id="tipo_usuario" class="form-select" required>
        <option value="admin" <?php echo $usuario['tipo_usuario'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="funcionario" <?php echo $usuario['tipo_usuario'] === 'funcionario' ? 'selected' : ''; ?>>Funcionario</option>
        <option value="cliente" <?php echo $usuario['tipo_usuario'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
    </select>
    </div>
 
 
    <div class="mb-3">
    <label for="status_usuario"class="form-label">Status</label>
    <select name="status_usuario" id="status_usuario" class="form-select" required>
        <option value="Ativo" <?php echo $usuario['status_usuario'] === 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
        <option value="Inativo" <?php echo $usuario['status_usuario'] === 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
    </select>
    </div>
   
    <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
    <a href="/backend/usuario/listar" class="btn btn-secondary">Cancelar</a>
</form>
</div>