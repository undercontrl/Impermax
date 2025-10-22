<div class="container mt-4">
    <h2>Cadastrar Novo Usuário</h2>
    <form action="/backend/usuario/salvar" method="post">
        <div class="mb-3">
            <label for="nome_usuario" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" required>
        </div>
        
        <div class="mb-3">
            <label for="email_usuario" class="form-label">Email</label>
            <input type="email" class="form-control" name="email_usuario" id="email_usuario" required>
        </div>
        
        <div class="mb-3">
            <label for="senha_usuario" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha_usuario" id="senha_usuario" required>
        </div>
        
        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-select" required>
                <option value="">Selecione o tipo</option>
                <option value="admin">Admin</option>
                <option value="funcionario">Funcionário</option>
                <option value="cliente">Cliente</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar Usuário</button>
        <a href="/backend/usuario/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>