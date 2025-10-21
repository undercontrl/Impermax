<div class="container mt-4">
    <h2>Novo Material</h2>
    <form action="/backend/material/salvar" method="POST">
        <div class="mb-3">
            <label for="nome_material" class="form-label">Nome do Material</label>
            <input type="text" class="form-control" name="nome_material" required>
        </div>

        <div class="mb-3">
            <label for="qtd_material" class="form-label">Quantidade</label>
            <input type="number" class="form-control" name="qtd_material" required>
        </div>

        <div class="mb-3">
            <label for="descricao_material" class="form-label">Descrição</label>
            <input type="text" class="form-control" name="descricao_material" required>
        </div>

        <div class="mb-3">
            <label for="id_servico" class="form-label">Serviço</label>
            <select name="id_servico" class="form-select" required>
                <option value="">Selecione...</option>
                <?php foreach ($servicos as $servico): ?>
                <option value="<?= htmlspecialchars($servico['id_servico']) ?>">
                    <?= htmlspecialchars($servico['nome_servico']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Material</button>
        <a href="/backend/material/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>