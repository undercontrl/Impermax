<div class="container mt-4">
    <h2>Cadastrar Projeto</h2>
    <form action="/backend/projeto/salvar" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="foto_antes_projeto" class="form-label">Foto Antes</label>
            <input type="file" class="form-control" name="foto_antes_projeto" id="foto_antes_projeto" accept="image/*" required>
        </div>
        
        <div class="mb-3">
            <label for="foto_depois_projeto" class="form-label">Foto Depois</label>
            <input type="file" class="form-control" name="foto_depois_projeto" id="foto_depois_projeto" accept="image/*" required>
        </div>
        
        <div class="mb-3">
            <label for="descricao_projeto" class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao_projeto" id="descricao_projeto" rows="4" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/backend/projeto/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>