<div class="container mt-4">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Novo Serviço Interno</h2>
            <form action="/backend/servico/salvar" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nome do Serviço *</label>
                    <input type="text" name="nome_servico" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição *</label>
                    <textarea name="descricao_servico" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Valor Base (R$) *</label>
                    <input type="number" step="0.01" name="valor_base_servico" class="form-control" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="/backend/servico/listar" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>