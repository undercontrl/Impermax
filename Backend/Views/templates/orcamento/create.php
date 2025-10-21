<div class="container mt-4">
    <h2>Novo Orçamento</h2>
    <form action="/backend/orcamento/salvar" method="POST">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($usuarios as $cliente): ?>
                <option value="<?= htmlspecialchars($cliente['id_usuario']) ?>">
                    <?= htmlspecialchars($cliente['nome_usuario']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="descricao_orcamento" class="form-label">Descrição</label>
            <input type="text" class="form-control" name="descricao_orcamento" required>
        </div>

        <div class="mb-3">
            <label for="status_orcamento" class="form-label">Status</label>
            <select name="status_orcamento" class="form-select" required>
                <option value="aprovado">Aprovado</option>
                <option value="aguardando">Aguardando</option>
                <option value="recusado">Recusado</option>
                <option value="em_analise">Em Análise</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_orcamento" class="form-label">Data Solicitada</label>
            <input type="date" class="form-control" name="data_orcamento" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label for="valor_orcamento" class="form-label">Valor do Orçamento (R$)</label>
            <input type="number" step="0.01" class="form-control" name="valor_orcamento" required>
        </div>

        <div class="mb-3">
            <label for="total_item_orcamento" class="form-label">Total de Itens</label>
            <input type="number" class="form-control" name="total_item_orcamento" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Orçamento</button>
        <a href="/backend/orcamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
