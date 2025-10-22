<div class="container mt-4">
    <h2>Editar Orçamento</h2>
    <form action="/backend/orcamento/atualizar/<?= $orcamento['id_orcamento'] ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select" required>
                <?php foreach ($usuarios as $cliente): ?>
                <option value="<?= $cliente['id_usuario'] ?>" 
                    <?= $orcamento['id_cliente'] == $cliente['id_usuario'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cliente['nome_usuario']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input type="text" class="form-control" name="descricao_orcamento" 
                   value="<?= htmlspecialchars($orcamento['descricao_orcamento']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status_orcamento" class="form-select" required>
                <option value="aprovado" <?= $orcamento['status_orcamento'] == 'aprovado' ? 'selected' : '' ?>>Aprovado</option>
                <option value="aguardando" <?= $orcamento['status_orcamento'] == 'aguardando' ? 'selected' : '' ?>>Aguardando</option>
                <option value="recusado" <?= $orcamento['status_orcamento'] == 'recusado' ? 'selected' : '' ?>>Recusado</option>
                <option value="em_analise" <?= $orcamento['status_orcamento'] == 'em_analise' ? 'selected' : '' ?>>Em Análise</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Data Solicitada</label>
            <input type="date" class="form-control" name="data_orcamento" 
                   value="<?= $orcamento['data_orcamento'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Valor (R$)</label>
            <input type="number" step="0.01" class="form-control" name="valor_orcamento" 
                   value="<?= htmlspecialchars($orcamento['valor_orcamento']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Total de Itens</label>
            <input type="number" class="form-control" name="total_item_orcamento" 
                   value="<?= htmlspecialchars($orcamento['total_item_orcamento']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="/backend/orcamento/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>