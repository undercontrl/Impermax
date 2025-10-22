<div>Cadastrar Usuário</div>
<form action="/backend/usuario/atualizar/<?php echo $usuario['id_usuario']; ?>" method="post">
    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
    
    <label for="nome_usuario">Nome</label>
    <input type="text" 
           name="nome_usuario" 
           id="nome_usuario" 
           value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" 
           required>
    <br>
    
    <label for="email_usuario">Email</label>
    <input type="email" 
           name="email_usuario" 
           id="email_usuario" 
           value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>" 
           required>
    <br>
    
    <label for="senha_usuario">Nova Senha</label>
    <input type="password" 
           name="senha_usuario" 
           id="senha_usuario" >
    <br>
    
    <label for="tipo_usuario">Tipo</label>
    <select name="tipo_usuario" id="tipo_usuario" required>
        <option value="admin" <?php echo $usuario['tipo_usuario'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="funcionario" <?php echo $usuario['tipo_usuario'] === 'funcionario' ? 'selected' : ''; ?>>Funcionario</option>
        <option value="cliente" <?php echo $usuario['tipo_usuario'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
    </select>
    <br>
    
    <label for="status_usuario">Status</label>
    <select name="status_usuario" id="status_usuario" required>
        <option value="Ativo" <?php echo $usuario['status_usuario'] === 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
        <option value="Inativo" <?php echo $usuario['status_usuario'] === 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
    </select>
    <br>
    
    <button type="submit">Atualizar Usuário</button>
    <a href="/backend/usuario/listar">Cancelar</a>
</form>