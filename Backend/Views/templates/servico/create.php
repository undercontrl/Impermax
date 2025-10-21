<div class="container mt-4">
    <h2>Cadastrar Novo Serviço</h2>
    <form action="/backend/servico/salvar" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nome_servico" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome_servico" id="nome_servico" required>
        </div>
        
        <div class="mb-3">
            <label for="descricao_servico" class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao_servico" id="descricao_servico" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="valor_base_servico" class="form-label">Valor (R$)</label>
            <input type="number" step="0.01" class="form-control" name="valor_base_servico" id="valor_base_servico" required>
        </div>
        
        <div class="mb-3">
            <label for="foto_servico" class="form-label">Foto do Serviço</label>
            <input type="file" class="form-control" name="foto_servico" id="foto_servico" accept="image/*" required>
        </div>
        
        <div class="mb-3">
            <label for="status_servico" class="form-label">Status</label>
            <select name="status_servico" id="status_servico" class="form-select" disabled>
                <option value="Ativo" selected>Ativo</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar Serviço</button>
        <a href="/backend/servico/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>