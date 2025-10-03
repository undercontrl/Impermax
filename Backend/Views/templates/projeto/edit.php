<div>Sou o edit</div>
<form method="POST" action="/backend/usuario/atualizar">
    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
    <div class="mb-3">
        <label for="nome_usuario" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="email_usuario" class="form-label">Email</label>
        <input type="email" class="form-control" id="email_usuario" name="email_usuario" value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="senha_usuario" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" required>
    </div>
    <div class="mb-3">
        <label for="tipo_usuario" class="form-label">Tipo</label>
        <select class="form-select" id="tipo_usuario" name="tipo_usuario" required>
            <option value="admin" <?php if($usuario['tipo_usuario'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if($usuario['tipo_usuario'] == 'user') echo 'selected'; ?>>User</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="status_usuario" class="form-label">Status</label>
        <select class="form-select" id="status_usuario" name="status_usuario" required>
            <option value="ativo" <?php if($usuario['status_usuario'] == 'ativo') echo 'selected'; ?>>Ativo</option>
            <option value="inativo" <?php if($usuario['status_usuario'] == 'inativo') echo 'selected'; ?>>Inativo</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Atualizar</button>